<?php

namespace App\Http\Controllers;


use App\{Http\Requests\CreateUserRequest, Http\Requests\UpdateUserRequest, Profession, Skill, Sortable, User};


class UserController extends Controller
{
	 
	 public function index(Sortable $sortable)
    {
        $users = User::query()
					->with('team','skills','profile.profession')
					->withLastLogin()
					->onlyTrashedIf(request() ->routeIs('user.trashed'))
           ->when(request('team'), function ($query, $team) {
                if ($team === 'with_team') {
                    $query->has('team');
                } elseif ($team === 'without_team') {
                    $query->doesntHave('team');
                }
            })
					->applyFilters()
					->orderBy('created_at', 'desc')
					->paginate();
	 
	 //dd($users);
			 $sortable->appends($users->parameters());
	 

		return view('users.index', [
			'users' => $users,
			'view' => request() -> routeIs('user.trashed') ?  'trash' : 'index',
			'skills' => Skill::orderBy('name')->get(),
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
        return redirect()->route('user');
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
        return redirect()->route('user.trashed');
    }

    public function trash(User $user)
    {
  
        $user->delete();
        return redirect()->route('user');

    }
   
}