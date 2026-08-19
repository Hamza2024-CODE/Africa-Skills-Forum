<?php

namespace App\Livewire\Auth;

use App\Models\DelegationMember;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class ForgotPassword extends Component
{
    public int $step = 1; // 1: Verify identity, 2: New password, 3: Success
    public string $identifier = '';
    public ?int $userId = null;
    public string $userName = '';
    public string $userMaskedEmail = '';

    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        if ($this->step === 1) {
            return [
                'identifier' => 'required|string|min:4',
            ];
        }

        return [
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    protected function messages(): array
    {
        $locale = app()->getLocale();
        return [
            'identifier.required' => $locale === 'fr' 
                ? 'Veuillez saisir votre numéro NIN ou passeport.' 
                : ($locale === 'en' 
                    ? 'Please enter your NIN or Passport number.' 
                    : 'يرجى إدخال رقم التعريف الوطني (NIN) أو رقم جواز السفر.'),
            'identifier.min' => $locale === 'fr' 
                ? 'Le numéro d\'identification est trop court.' 
                : ($locale === 'en' 
                    ? 'Identification number is too short.' 
                    : 'رقم الهوية أدخلته غير مكتمل.'),
            'password.required' => $locale === 'fr' 
                ? 'Le nouveau mot de passe est requis.' 
                : ($locale === 'en' 
                    ? 'New password is required.' 
                    : 'كلمة المرور الجديدة مطلوبة.'),
            'password.min' => $locale === 'fr' 
                ? 'Le mot de passe doit contenir au moins 6 caractères.' 
                : ($locale === 'en' 
                    ? 'Password must be at least 6 characters.' 
                    : 'يجب أن تتكون كلمة المرور من 6 أحرف/أرقام على الأقل.'),
            'password.confirmed' => $locale === 'fr' 
                ? 'Les mots de passe ne correspondent pas.' 
                : ($locale === 'en' 
                    ? 'Passwords do not match.' 
                    : 'تأكيد كلمة المرور غير مطابقة.'),
        ];
    }

    public function verifyIdentity()
    {
        $this->step = 1;
        $this->validate([
            'identifier' => 'required|string|min:4',
        ]);

        $clean = strtoupper(trim($this->identifier));
        $cleanNoSpaces = preg_replace('/\s+/', '', $clean);

        $throttleKey = 'forgot-pw|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $msg = app()->getLocale() === 'fr'
                ? "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes."
                : (app()->getLocale() === 'en'
                    ? "Too many attempts. Please try again in {$seconds} seconds."
                    : "محاولات كثيرة جداً. يرجى المحاولة بعد {$seconds} ثانية.");
            $this->addError('identifier', $msg);
            return;
        }

        $user = null;

        // 1. ParticipantProfile search (national_id or passport_number)
        $profile = ParticipantProfile::where('national_id', $cleanNoSpaces)
            ->orWhere('national_id', $clean)
            ->orWhere('passport_number', $cleanNoSpaces)
            ->orWhere('passport_number', $clean)
            ->first();

        if ($profile && $profile->user_id) {
            $user = User::find($profile->user_id);
        }

        // 2. DelegationMember search (nin_number or passport_number)
        if (!$user) {
            $member = DelegationMember::where('nin_number', $cleanNoSpaces)
                ->orWhere('nin_number', $clean)
                ->orWhere('passport_number', $cleanNoSpaces)
                ->orWhere('passport_number', $clean)
                ->first();

            if ($member && $member->user_id) {
                $user = User::find($member->user_id);
            }
        }

        // 3. Fallback: Registration lookup
        if (!$user) {
            $reg = Registration::where('registration_number', $clean)
                ->orWhere('uuid', $clean)
                ->first();
            if ($reg && $reg->participant?->user_id) {
                $user = User::find($reg->participant->user_id);
            }
        }

        if (!$user) {
            RateLimiter::hit($throttleKey, 60);
            $errorMsg = app()->getLocale() === 'fr'
                ? 'Aucun compte trouvé avec ce numéro (NIN ou Passeport).'
                : (app()->getLocale() === 'en'
                    ? 'No account found matching this NIN or Passport number.'
                    : 'لم يتم العثور على أي حساب يطابق رقم التعريف الوطني (NIN) أو رقم جواز السفر المدخل.');
            $this->addError('identifier', $errorMsg);
            return;
        }

        RateLimiter::clear($throttleKey);

        $this->userId = $user->id;
        $this->userName = $user->name;
        
        // Mask email for privacy (e.g. a***b@gmail.com)
        $email = $user->email ?? '';
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $parts = explode('@', $email);
            $namePart = $parts[0];
            $domainPart = $parts[1];
            $maskedName = strlen($namePart) > 2 
                ? substr($namePart, 0, 2) . str_repeat('*', max(1, strlen($namePart) - 3)) . substr($namePart, -1)
                : substr($namePart, 0, 1) . '*';
            $this->userMaskedEmail = $maskedName . '@' . $domainPart;
        } else {
            $this->userMaskedEmail = $email;
        }

        $this->step = 2;
    }

    public function resetPassword()
    {
        if ($this->step !== 2 || !$this->userId) {
            $this->step = 1;
            return;
        }

        $this->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::find($this->userId);
        if (!$user) {
            $this->addError('password', app()->getLocale() === 'fr' ? 'Utilisateur introuvable.' : 'المستخدم غير موجود.');
            $this->step = 1;
            return;
        }

        $user->password = Hash::make($this->password);
        $user->must_change_password = false;
        $user->save();

        $this->step = 3;
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
