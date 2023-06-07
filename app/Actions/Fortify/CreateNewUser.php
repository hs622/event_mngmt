<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    protected $messages = [
        'name.required'     => 'Please provide your full name.',
        'email.unique'      => 'Email already taken.',
        'email.regex'       => 'We accept "iqra.edu.pk" email address.',
        'role.required'     => 'Please select the role for the account.'
    ];

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'regex:/^\w+@iqra.edu.pk\$/i', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'integer'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], $this->messages)->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->roles()->attach($input['role']);
        return $user;
    }
}
