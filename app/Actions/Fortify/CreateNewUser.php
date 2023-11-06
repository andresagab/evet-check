<?php

namespace App\Actions\Fortify;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:30', Rule::unique(User::class)],
            /*'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],*/
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        # create user
        $user = User::create([
            'name' => $input['name'],
            'code' => $input['code'],
            # 'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->addRole($input['role']);

        $permissions = Permission::query()->pluck('id')->toArray();

        $user->syncPermissions($permissions);

        return $user;
    }
}
