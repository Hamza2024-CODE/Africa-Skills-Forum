<?php

namespace App\Livewire\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Login extends Component
{
    public $loginInput = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'loginInput' => 'required|string',
        'password'   => 'required|min:6',
    ];

    protected $messages = [
        'loginInput.required' => 'يرجى إدخال البريد الإلكتروني أو اسم المستخدم.',
        'password.required'   => 'يرجى إدخال كلمة المرور.',
        'password.min'        => 'كلمة المرور يجب أن تتكون من 6 أحرف/أرقام على الأقل.',
    ];

    public function login()
    {
        $this->validate();

        $input = trim($this->loginInput);
        $throttleKey = Str::lower($input) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('loginInput', app()->getLocale() === 'fr' 
                ? "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes." 
                : (app()->getLocale() === 'en' 
                    ? "Too many login attempts. Please try again in {$seconds} seconds." 
                    : "محاولات دخول كثيرة جداً. يرجى المحاولة بعد {$seconds} ثانية."));
            return;
        }

        // Find user by email or by username/name (e.g. admin, dz.admin, media, viewer)
        $user = User::where('email', $input)
                    ->orWhere('name', $input)
                    ->orWhere('email', 'like', $input . '@%')
                    ->first();

        if ($user && Hash::check($this->password, $user->password)) {
            Auth::login($user, $this->remember);
            RateLimiter::clear($throttleKey);
            session()->regenerate();

            if ($user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::NATIONAL_ADMIN->value)) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole(RoleEnum::MEDIA_MANAGER->value)) {
                return redirect()->route('admin.media.dashboard');
            } elseif ($user->hasRole(RoleEnum::EXECUTIVE_VIEWER->value)) {
                return redirect()->route('executive.dashboard');
            } elseif ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
                return redirect()->route('country.dashboard');
            } elseif ($user->hasRole(RoleEnum::ORGANIZATION_ADMIN->value)) {
                return redirect()->route('organization.dashboard');
            } elseif ($user->hasRole(RoleEnum::JUDGE->value) || $user->hasRole(RoleEnum::EXPERT->value)) {
                return redirect()->route('judge.dashboard');
            }

            return redirect()->route('participant.dashboard');
        }

        RateLimiter::hit($throttleKey, 60);

        $this->addError('loginInput', app()->getLocale() === 'fr' 
            ? 'Identifiants incorrects.' 
            : (app()->getLocale() === 'en' 
                ? 'Invalid login credentials.' 
                : 'اسم المستخدم/البريد الإلكتروني أو كلمة المرور غير صحيحة.'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
