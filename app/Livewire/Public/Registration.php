<?php

namespace App\Livewire\Public;

use App\Enums\ParticipantStatus;
use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\Edition;
use App\Models\Organization;
use App\Models\ParticipantDocument;
use App\Models\ParticipantProfile;
use App\Models\Registration as RegistrationModel;
use App\Models\Skill;
use App\Models\User;
use App\Services\DocumentVerificationService;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.public')]
class Registration extends Component
{
    use WithFileUploads;

    public int $step = 1;

    // Selected Role: SPEAKER, VISITOR, EXPERT
    public string $role = 'SPEAKER';

    public mixed $countryId = null;
    public bool $isAlgeria = true;
    public bool $isArabicCountry = true;

    // Step 1: Personal Info & Role
    public string $firstNameAr = '';
    public string $lastNameAr = '';
    public string $firstNameLatin = '';
    public string $lastNameLatin = '';
    public string $dateOfBirth = '';
    public string $gender = 'male';
    public string $email = '';
    public string $phone = '';

    // Step 2: Professional Details & Domain
    public string $organizationName = '';
    public string $jobTitle = '';
    public string $presentationTopic = '';
    public mixed $skillId = null;

    // Step 3: Identity Documents & Official Photo
    public mixed $photoFile = null;
    public string $identificationType = 'national_id';
    public string $nationalId = '';
    public string $passportNumber = '';
    public mixed $nationalIdFile = null;
    public mixed $passportFile = null;

    // Success Output
    public string $registrationNumber = '';
    public string $verificationToken = '';
    public bool $isSubmitted = false;

    public bool $isOpen = false;

    public function mount(): void
    {
        $status = \App\Models\GlobalSetting::getByKey('public_registration_open', '0');
        $this->isOpen = ($status === '1');

        $algeria = Country::where('iso2', 'DZ')->first();
        if ($algeria) {
            $this->countryId = $algeria->id;
            $this->isAlgeria = true;
            $this->isArabicCountry = true;
        } else {
            $first = Country::where('is_active', true)->first();
            $this->countryId = $first?->id;
        }
        $this->dateOfBirth = date('Y-m-d', strtotime('-30 years'));
    }

    public function updatedRole(string $val): void
    {
        if ($val !== 'EXPERT') {
            $this->skillId = null;
        }
    }

    public function updatedCountryId(mixed $val): void
    {
        $arabicIsos = ['DZ', 'TN', 'MA', 'EG', 'LY', 'MR', 'SD', 'DJ', 'KM', 'SO'];
        $country = Country::find($val);
        $this->isAlgeria = $country ? (bool) $country->is_algeria : false;
        $this->isArabicCountry = $country ? in_array($country->iso2, $arabicIsos) : true;
        $this->identificationType = $this->isAlgeria ? 'national_id' : 'passport';
    }

    public function getPhonePlaceholderProperty(): string
    {
        $country = Country::find($this->countryId);
        $locale = app()->getLocale();
        if (!$country) {
            return $locale === 'fr' ? 'Ex: 0550123456 ou +213550123456' : ($locale === 'en' ? 'Ex: 0550123456 or +213550123456' : 'مثال: 0550123456 أو +213550123456');
        }

        $code = $country->phone_code ?: ($country->is_algeria ? '+213' : '');
        return match($country->iso2) {
            'DZ' => $locale === 'fr' ? 'Ex: 0550123456 ou +213550123456' : ($locale === 'en' ? 'Ex: 0550123456 or +213550123456' : 'مثال: 0550123456 أو +213550123456'),
            'TN' => "{$code} 20 123 456",
            'MA' => "{$code} 6 12 34 56 78",
            'EG' => "{$code} 10 1234 5678",
            default => !empty($code) ? "Ex: {$code} 55 000 0000" : 'مثال: 0550000000 / +213'
        };
    }

    public function nextStep()
    {
        /** @var DocumentVerificationService $docVerifier */
        $docVerifier = app(DocumentVerificationService::class);
        $locale = app()->getLocale();

        if ($this->step === 1) {
            $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            $phoneRegex = $this->isAlgeria 
                ? '/^(?:(?:\+?213|00213|0)[567][0-9]{8})$/'
                : '/^(?:\+|00)?[0-9]{6,15}$/';

            $rules = [
                'role'             => ['required', 'in:SPEAKER,VISITOR,EXPERT'],
                'countryId'        => ['required', 'exists:countries,id'],
                'firstNameLatin'   => ['required', 'min:2', 'regex:/^[a-zA-Z\s\-\'\`\À-ÿ]+$/'],
                'lastNameLatin'    => ['required', 'min:2', 'regex:/^[a-zA-Z\s\-\'\`\À-ÿ]+$/'],
                'email'            => ['required', 'email', 'regex:' . $emailRegex],
                'phone'            => ['required', 'regex:' . $phoneRegex],
                'dateOfBirth'      => ['required', 'date'],
                'organizationName' => ['required', 'string', 'min:2'],
                'jobTitle'         => ['required', 'string', 'min:2'],
            ];

            if ($this->role === 'EXPERT') {
                $rules['skillId'] = ['required', 'exists:skills,id'];
            }

            if ($this->isArabicCountry) {
                $rules['firstNameAr'] = ['required', 'min:2', 'regex:/^[\x{0600}-\x{06FF}\s\-]+$/u'];
                $rules['lastNameAr']  = ['required', 'min:2', 'regex:/^[\x{0600}-\x{06FF}\s\-]+$/u'];
            }

            $this->validate($rules, [
                'role.required'             => $locale === 'fr' ? 'Veuillez sélectionner votre qualité/rôle.' : ($locale === 'en' ? 'Please select your role.' : 'يرجى اختيار صفة التسجيل.'),
                'countryId.required'        => $locale === 'fr' ? 'Veuillez sélectionner le pays de la délégation.' : ($locale === 'en' ? 'Please select delegation country.' : 'يرجى اختيار دولة الوفد المشارك.'),
                'firstNameAr.required'      => $locale === 'fr' ? 'Le prénom en arabe est requis.' : ($locale === 'en' ? 'First name in Arabic is required.' : 'الاسم الشخصي بالعربية مطلوب.'),
                'lastNameAr.required'       => $locale === 'fr' ? 'Le nom en arabe est requis.' : ($locale === 'en' ? 'Last name in Arabic is required.' : 'اللقب العائلي بالعربية مطلوب.'),
                'firstNameLatin.required'  => $locale === 'fr' ? 'Le prénom en latin est requis.' : ($locale === 'en' ? 'First name in Latin is required.' : 'الاسم بالفرنسية/اللاتينية مطلوب.'),
                'lastNameLatin.required'   => $locale === 'fr' ? 'Le nom en latin est requis.' : ($locale === 'en' ? 'Last name in Latin is required.' : 'اللقب بالفرنسية/اللاتينية مطلوب.'),
                'email.required'            => $locale === 'fr' ? 'L\'adresse email est requise.' : ($locale === 'en' ? 'Email address is required.' : 'البريد الإلكتروني مطلوب.'),
                'phone.required'            => $locale === 'fr' ? 'Le numéro de téléphone est requis.' : ($locale === 'en' ? 'Phone number is required.' : 'رقم الهاتف مطلوب.'),
                'dateOfBirth.required'      => $locale === 'fr' ? 'La date de naissance est requise.' : ($locale === 'en' ? 'Date of birth is required.' : 'تاريخ الميلاد مطلوب.'),
                'organizationName.required' => $locale === 'fr' ? 'Le nom de l\'établissement est requis.' : ($locale === 'en' ? 'Organization name is required.' : 'اسم المؤسسة / الهيئة مطلوب.'),
                'jobTitle.required'         => $locale === 'fr' ? 'Le titre professionnel est requis.' : ($locale === 'en' ? 'Job title is required.' : 'الصفة المهنية / المسمى الوظيفي مطلوب.'),
                'skillId.required'          => $locale === 'fr' ? 'Veuillez sélectionner votre domaine d\'expertise.' : ($locale === 'en' ? 'Please select domain of expertise.' : 'يرجى اختيار مجال التخصص والخبرة للخبير المحكّم.'),
            ]);

            // Uniqueness Check for Email and Phone
            $check = $docVerifier->checkIdentityUniqueness(null, null, $this->email, $this->phone);
            if (!$check['is_valid']) {
                foreach ($check['errors'] as $field => $msg) {
                    if ($field === 'email') $this->addError('email', $msg);
                    if ($field === 'phone') $this->addError('phone', $msg);
                }
                return;
            }
        }

        $this->step = 2;
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submitRegistration()
    {
        /** @var DocumentVerificationService $docVerifier */
        $docVerifier = app(DocumentVerificationService::class);
        $locale = app()->getLocale();

        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $phoneRegex = $this->isAlgeria 
            ? '/^(?:(?:\+?213|00213|0)[567][0-9]{8})$/'
            : '/^(?:\+|00)?[0-9]{6,15}$/';

        $rules = [
            'role'             => ['required', 'in:SPEAKER,VISITOR,EXPERT'],
            'countryId'        => ['required', 'exists:countries,id'],
            'firstNameLatin'   => ['required', 'min:2', 'regex:/^[a-zA-Z\s\-\'\`\À-ÿ]+$/'],
            'lastNameLatin'    => ['required', 'min:2', 'regex:/^[a-zA-Z\s\-\'\`\À-ÿ]+$/'],
            'email'            => ['required', 'email', 'regex:' . $emailRegex],
            'phone'            => ['required', 'regex:' . $phoneRegex],
            'dateOfBirth'      => ['required', 'date'],
            'organizationName' => ['required', 'string', 'min:2'],
            'jobTitle'         => ['required', 'string', 'min:2'],
            'photoFile'        => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];

        if ($this->role === 'EXPERT') {
            $rules['skillId'] = ['required', 'exists:skills,id'];
        }

        if ($this->isArabicCountry) {
            $rules['firstNameAr'] = ['required', 'min:2', 'regex:/^[\x{0600}-\x{06FF}\s\-]+$/u'];
            $rules['lastNameAr']  = ['required', 'min:2', 'regex:/^[\x{0600}-\x{06FF}\s\-]+$/u'];
        }

        if ($this->isAlgeria) {
            $rules['nationalId'] = ['required', 'regex:/^[0-9]{18}$/'];
        } else {
            $rules['passportNumber'] = ['required', 'string', 'min:5', 'max:18'];
        }

        $messages = [
            'role.required'             => $locale === 'fr' ? 'Veuillez sélectionner votre qualité/rôle.' : ($locale === 'en' ? 'Please select your role.' : 'يرجى اختيار صفة التسجيل.'),
            'countryId.required'        => $locale === 'fr' ? 'Veuillez sélectionner le pays de la délégation.' : ($locale === 'en' ? 'Please select delegation country.' : 'يرجى اختيار دولة الوفد المشارك.'),
            'firstNameAr.required'      => $locale === 'fr' ? 'Le prénom en arabe est requis.' : ($locale === 'en' ? 'First name in Arabic is required.' : 'الاسم الشخصي بالعربية مطلوب.'),
            'lastNameAr.required'       => $locale === 'fr' ? 'Le nom en arabe est requis.' : ($locale === 'en' ? 'Last name in Arabic is required.' : 'اللقب العائلي بالعربية مطلوب.'),
            'firstNameLatin.required'  => $locale === 'fr' ? 'Le prénom en latin est requis.' : ($locale === 'en' ? 'First name in Latin is required.' : 'الاسم بالفرنسية/اللاتينية مطلوب.'),
            'lastNameLatin.required'   => $locale === 'fr' ? 'Le nom en latin est requis.' : ($locale === 'en' ? 'Last name in Latin is required.' : 'اللقب بالفرنسية/اللاتينية مطلوب.'),
            'email.required'            => $locale === 'fr' ? 'L\'adresse email est requise.' : ($locale === 'en' ? 'Email address is required.' : 'البريد الإلكتروني مطلوب.'),
            'phone.required'            => $locale === 'fr' ? 'Le numéro de téléphone est requis.' : ($locale === 'en' ? 'Phone number is required.' : 'رقم الهاتف مطلوب.'),
            'dateOfBirth.required'      => $locale === 'fr' ? 'La date de naissance est requise.' : ($locale === 'en' ? 'Date of birth is required.' : 'تاريخ الميلاد مطلوب.'),
            'organizationName.required' => $locale === 'fr' ? 'Le nom de l\'établissement est requis.' : ($locale === 'en' ? 'Organization name is required.' : 'اسم المؤسسة / الهيئة مطلوب.'),
            'jobTitle.required'         => $locale === 'fr' ? 'Le titre professionnel est requis.' : ($locale === 'en' ? 'Job title is required.' : 'الصفة المهنية / المسمى الوظيفي مطلوب.'),
            'skillId.required'          => $locale === 'fr' ? 'Veuillez sélectionner votre domaine d\'expertise.' : ($locale === 'en' ? 'Please select domain of expertise.' : 'يرجى اختيار مجال التخصص والخبرة للخبير المحكّم.'),
            'photoFile.required'        => $locale === 'fr' ? 'Veuillez charger votre photo officielle.' : ($locale === 'en' ? 'Please upload your official photo.' : 'يرجى تحميل الصورة الشخصية الرسمية المعتمدة على الشارة.'),
            'nationalId.required'       => $locale === 'fr' ? 'Le numéro NIN (18 chiffres) est requis.' : ($locale === 'en' ? 'NIN number (18 digits) is required.' : 'رقم التعريف الوطني (18 رقماً) مطلوب.'),
            'nationalId.regex'          => $locale === 'fr' ? 'Le numéro NIN doit comporter exactement 18 chiffres.' : ($locale === 'en' ? 'NIN must be exactly 18 digits.' : 'يجب أن يتكون رقم بطاقة التعريف الوطنية (NIN) من 18 رقماً بالضبط.'),
            'passportNumber.required'   => $locale === 'fr' ? 'Le numéro de passeport est requis.' : ($locale === 'en' ? 'Passport number is required.' : 'رقم جواز السفر مطلوب.'),
        ];

        $this->validate($rules, $messages);

        // Check Email and Phone Uniqueness
        $check = $docVerifier->checkIdentityUniqueness(null, null, $this->email, $this->phone);
        if (!$check['is_valid']) {
            foreach ($check['errors'] as $field => $msg) {
                if ($field === 'email') $this->addError('email', $msg);
                if ($field === 'phone') $this->addError('phone', $msg);
            }
            return;
        }

        // Check Identity Uniqueness
        $checkIdent = $docVerifier->checkIdentityUniqueness(
            $this->isAlgeria ? $this->nationalId : null,
            !$this->isAlgeria ? $this->passportNumber : null
        );
        if (!$checkIdent['is_valid']) {
            foreach ($checkIdent['errors'] as $field => $msg) {
                if ($field === 'nin') $this->addError('nationalId', $msg);
                if ($field === 'passport') $this->addError('passportNumber', $msg);
            }
            return;
        }

        // Store Photo
        $photoPath = null;
        $photoHash = null;
        if ($this->photoFile) {
            $photoHash = $docVerifier->calculateFileHash($this->photoFile);
            $photoPath = $this->photoFile->store('participants/photos', 'public');
        }

        // Store Identity Files
        $nationalIdPdfPath = null;
        if ($this->nationalIdFile) {
            $nationalIdPdfPath = $this->nationalIdFile->store('participants/documents', 'public');
        }
        $passportPdfPath = null;
        if ($this->passportFile) {
            $passportPdfPath = $this->passportFile->store('participants/documents', 'public');
        }

        $docFile = $this->isAlgeria ? $this->nationalIdFile : $this->passportFile;
        $docHash = $docFile ? $docVerifier->calculateFileHash($docFile) : null;

        // Map chosen role to Spatie Role
        $spatieRole = match($this->role) {
            'SPEAKER' => 'SPEAKER',
            'EXPERT'  => 'EXPERT',
            default   => 'PARTICIPANT',
        };

        // Create User Account
        $user = User::firstOrCreate(
            ['email' => $this->email],
            [
                'name'        => trim(($this->firstNameAr ?: $this->firstNameLatin) . ' ' . ($this->lastNameAr ?: $this->lastNameLatin)),
                'country_id'  => $this->countryId,
                'avatar_path' => $photoPath,
                'password'    => \Illuminate\Support\Facades\Hash::make('password123'),
                'locale'      => app()->getLocale(),
            ]
        );

        if ($photoPath && empty($user->avatar_path)) {
            $user->update(['avatar_path' => $photoPath, 'country_id' => $this->countryId]);
        }

        if (!$user->hasRole($spatieRole)) {
            try {
                $user->assignRole($spatieRole);
            } catch (\Throwable $e) {
                // fallback role
            }
        }
        if (!$user->hasRole('PARTICIPANT')) {
            try {
                $user->assignRole('PARTICIPANT');
            } catch (\Throwable $e) {
                // fallback role
            }
        }

        // Create Participant Profile
        $profile = ParticipantProfile::create([
            'user_id'         => $user->id,
            'first_name_ar'   => !empty(trim($this->firstNameAr ?? '')) ? $this->firstNameAr : $this->firstNameLatin,
            'last_name_ar'    => !empty(trim($this->lastNameAr ?? '')) ? $this->lastNameAr : $this->lastNameLatin,
            'first_name_fr'   => $this->firstNameLatin,
            'last_name_fr'    => $this->lastNameLatin,
            'first_name_en'   => $this->firstNameLatin,
            'last_name_en'    => $this->lastNameLatin,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'gender'          => $this->gender,
            'date_of_birth'   => $this->dateOfBirth,
            'national_id'     => $this->isAlgeria ? $this->nationalId : null,
            'passport_number' => !$this->isAlgeria ? $this->passportNumber : null,
            'photo_hash'      => $photoHash,
            'document_hash'   => $docHash,
        ]);

        $activeEdition = Edition::where('is_active', true)->first();

        // Create Registration Record
        $reg = RegistrationModel::create([
            'participant_id' => $profile->id,
            'edition_id'     => $activeEdition?->id,
            'country_id'     => $this->countryId,
            'skill_id'       => !empty($this->skillId) ? (int)$this->skillId : null,
            'status'         => ParticipantStatus::PENDING,
            'submitted_at'   => now(),
        ]);

        // Attach Documents
        if ($nationalIdPdfPath) {
            ParticipantDocument::create([
                'registration_id' => $reg->id,
                'document_type'   => 'national_id',
                'file_path'       => $nationalIdPdfPath,
                'original_name'   => $this->nationalIdFile ? $this->nationalIdFile->getClientOriginalName() : basename($nationalIdPdfPath),
                'mime_type'       => $this->nationalIdFile ? $this->nationalIdFile->getClientMimeType() : 'application/pdf',
                'file_size'       => $this->nationalIdFile ? $this->nationalIdFile->getSize() : 0,
            ]);
        }

        if ($passportPdfPath) {
            ParticipantDocument::create([
                'registration_id' => $reg->id,
                'document_type'   => 'passport',
                'file_path'       => $passportPdfPath,
                'original_name'   => $this->passportFile ? $this->passportFile->getClientOriginalName() : basename($passportPdfPath),
                'mime_type'       => $this->passportFile ? $this->passportFile->getClientMimeType() : 'application/pdf',
                'file_size'       => $this->passportFile ? $this->passportFile->getSize() : 0,
            ]);
        }

        $this->registrationNumber = $reg->registration_number;
        $this->verificationToken = $reg->verification_token ?? bin2hex(random_bytes(16));
        $this->isSubmitted = true;
    }

    public function render()
    {
        $countries = Country::where('is_active', true)->orderBy('name_ar')->get();
        $skills = Skill::where('is_active', true)->orderBy('sort_order')->get();

        return view('livewire.public.registration', [
            'countries' => $countries,
            'skills'    => $skills,
        ]);
    }
}
