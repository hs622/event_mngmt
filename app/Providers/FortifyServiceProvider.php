<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\ValidatedInput;

class FortifyServiceProvider extends ServiceProvider
{
    protected $messages = [
        'role'  => 'Role not assigned yet, please contact to admin'
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
    
            if ($user 
                && Hash::check($request->password, $user->password) 
                && !$user->roles->isEmpty()) {
                    return $user;
            }
            
            auth()->logout();
            return session()->flash('role', true);
        });

        Fortify::loginView(function () {

            if(session()->has('role') && session()->get('role')) {
                return redirect()->route('login')->withErrors($this->messages);
            }
            return view('auth.login');
        });
    }
}
