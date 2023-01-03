<?php

namespace App\Http\Controllers;


use App\{Http\Requests\CreateUserRequest,
	Http\Requests\UpdateUserRequest,
	Profession,
	Skill,
	Sortable,
	User,
	UserFilter,
	UserProfile};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    public function index(UserFilter  $userFilter, Sortable  $sortable)
    {
        $users = User::query()
						->when(request() -> routeIs('users.trashed'), function ($q){
							 $q -> onlyTrashed();
						})
            ->with('team','skills','profile.profession')
            ->when(request('team'), function ($query, $team) {	//comprueba una condición
                if ($team === 'with_team') {
                    $query->has('team');
                } elseif ($team === 'without_team') {
                    $query->doesntHave('team');
                }
            })
						->filterBy($userFilter, request()->all(['state', 'role', 'search', 'skills', 'from', 'to']))
						->when(request('order'), function($q){
							$q ->orderBy(request('order'), request('direction', 'asc'));	//direction no es obligatorio el orden (asc/desc)
						}, function($q){
							 $q ->orderByDesc('created_at');		//si no existe el metodo order lo ordena por fecha
						})	//primer parametro comprueba, si existe se ejecuta y si no ejecuta otra cosa
            ->paginate();


        $users->appends($userFilter->valid());
	 
			 $sortable ->setCurrentOrder(request('order'), request('direction'));	//ya tiene en cuenta el parametro a traves de URL

		return view('users.index', [
			'users' => $users,
			'view' => request() -> routeIs('users.trashed') ?  'trash' : 'index',
			'skills' => Skill::orderBy('name')->get(),
			'states' => trans('users.filters.states'),
			'checkedSkills' => collect(request('skills')),
			 'sortable' => $sortable,
		]);
    }

    public function show(User $user)
    {
        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }
        return view('users.show', compact('user'));
    }

    protected function form($view, User $user)
    {
        return view($view, [
            'user'=>$user,
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function create()
    {
        return $this->form('users.create', new User);
    }

    public function store(CreateUserRequest $request)
    {   $request-> createUser();
        return redirect()->route('users');
    }

    public function edit(User $user)
    {
        return $this->form('users.edit', $user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->route('user.show', $user);
    }
    public function destroy($id)
    {
        $user = User::onlyTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $user->forceDelete();
        return redirect()->route('users.trashed');
    }

    public function trash(User $user)
    {
        $user->profile()->delete();
        $user->delete();
        return redirect()->route('users');

    }
   
}