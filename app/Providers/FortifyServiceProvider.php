<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request)
            {
                $user = User::where('email', $request->email)->first();

                if (
                    $user &&
                    Hash::check($request->password, $user->password) &&
                    $user->hasRole('Administrador')
                ) {                    
                    return redirect('/dashboard');
                }
                if (
                    $user &&
                    Hash::check($request->password, $user->password) &&
                    $user->hasRole('Asistente')
                ) {                    
                    return redirect('/dashboard');
                }
                if (
                    $user &&
                    Hash::check($request->password, $user->password) &&
                    $user->hasRole('Jefe de Producción')
                ) {                    
                    return redirect('/control');
                }
                if (
                    $user &&
                    Hash::check($request->password, $user->password) &&
                    $user->hasRole('Cliente')
                ) {                    
                    return redirect('/dashboard-cliente');
                }

                return redirect('/');
            }
        });
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

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
