<?php

namespace App\Http\Requests;

use App\Profession;
use App\Role;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'bio' => 'required',
            'twitter' => ['nullable', 'present', 'url'],
            'profession_id' => [
                'nullable',
                'required_if:newProfession,null',
                'present',
                Rule::exists('professions', 'id')
                    ->whereNull('deleted_at')
            ],
            'newProfession' => [
                'required_if:profession_id,null',
                'present',
                'unique:professions,title'
            ],
            'skills' => [
                'array',
                Rule::exists('skills', 'id')
            ],
            'role' => [
                'nullable',
                Rule::in(Role::getList())
            ],
            'state' => [
                Rule::in(['active', 'inactive'])
            ],
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'El campo nombre es obligatorio',
            'last_name.required' => 'El campo apellidos es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
            'profession_id.required_if' => 'El campo profesion es obligatorio',
            'newProfession.required_if' => 'El campo profesion es obligatorio',

        ];
    }
    public function createUser()
    {
        DB::transaction(function () {
            $user = User::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
                'role' => $this->role ?? 'user',
                'state' => $this->state,
            ]);

            if($this->newProfession && $this->profession_id == null){
                $profession= factory(Profession::class)->create([
                    'title'=>$this->newProfession
                ]);
            }

            $user->profile()->create([
                'bio' => $this->bio,
                'twitter' => $this->twitter,
                'profession_id' => $this->profession_id ?? $profession->id ,
            ]);

            $user->skills()->attach($this->skills ?? []);
        });
    }
}
