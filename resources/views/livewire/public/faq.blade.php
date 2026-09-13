<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#0B2A6F]">
                {{ app()->getLocale() === 'pt' ? (__('الأسئلة الشائعة وإجابات الاستفسارات المتكررة') !== 'الأسئلة الشائعة وإجابات الاستفسارات المتكررة' ? __('الأسئلة الشائعة وإجابات الاستفسارات المتكررة') : 'Frequently Asked Questions (FAQ)') : (polyTrans('الأسئلة الشائعة وإجابات الاستفسارات المتكررة', 'Foire Aux Questions (FAQ)', 'Frequently Asked Questions (FAQ)')) }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'pt' ? (__('إليك إجابات لأهم الأسئلة المتعلقة بالتسجيل، التخصصات، والشروط.') !== 'إليك إجابات لأهم الأسئلة المتعلقة بالتسجيل، التخصصات، والشروط.' ? __('إليك إجابات لأهم الأسئلة المتعلقة بالتسجيل، التخصصات، والشروط.') : 'Answers to the most frequent questions regarding registration, skills and rules.') : (polyTrans('إليك إجابات لأهم الأسئلة المتعلقة بالتسجيل، التخصصات، والشروط.', 'Réponses aux questions les plus fréquentes concernant les inscriptions et les règlements.', 'Answers to the most frequent questions regarding registration, skills and rules.')) }}
            </p>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ polyTrans('من يمكنه التسجيل والمشاركة في منتدى السياسات الأفريقية للمهارات؟', 'Qui peut s\'inscrire et participer au Forum des Politiques Africaines des Compétences ?', 'Who can register and participate in African Skills Policy Forum?') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ polyTrans('يتاح التسجيل لجميع المتربصين والخبراء والشباب والوفود الوطنية الإفريقية الشريكة، وفقاً للشروط والاعتمادات الرسمية للمنتدى.', 'L\'inscription est ouverte aux délégués, experts, jeunes talents et délégations africaines partenaires.', 'Registration is open to African delegates, experts, skilled youth, and partner national delegations.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ polyTrans('ما هي الوثائق المطلوبة للمشارك الجزائري والمشارك الأجنبي؟', 'Quels sont les documents d\'identité requis (NIN / Passeport) ?', 'What are the required ID documents (NIN / Passport)?') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'pt' ? (__('المشارك الجزائري يلتزم برقم بطاقة التعريف الوطنية (18 رقماً). أما المشارك الأجنبي فيلتزم بتقديم رقم جواز السفر الساري المفعول.') !== 'المشارك الجزائري يلتزم برقم بطاقة التعريف الوطنية (18 رقماً). أما المشارك الأجنبي فيلتزم بتقديم رقم جواز السفر الساري المفعول.' ? __('المشارك الجزائري يلتزم برقم بطاقة التعريف الوطنية (18 رقماً). أما المشارك الأجنبي فيلتزم بتقديم رقم جواز السفر الساري المفعول.') : 'Algerian candidates provide an 18-digit National ID (NIN). International candidates provide a valid 18-digit Passport number.') : (polyTrans('المشارك الجزائري يلتزم برقم بطاقة التعريف الوطنية (18 رقماً). أما المشارك الأجنبي فيلتزم بتقديم رقم جواز السفر الساري المفعول.', 'Les candidats algériens doivent fournir le NIN à 18 chiffres. Les candidats internationaux doivent fournir un numéro de passeport valide.', 'Algerian candidates provide an 18-digit National ID (NIN). International candidates provide a valid 18-digit Passport number.')) }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ polyTrans('ما هو منتدى السياسات الأفريقية للمهارات 2026 ومن المشرف على تنظيمه؟', 'Qu\'est-ce que le Forum des Politiques Africaines des Compétences 2026 et qui l\'organise ?', 'What is Africa’s Skills Policy Forum 2026 and who co-organizes it?') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ polyTrans('يُنظَّم منتدى السياسات الأفريقية للمهارات بشراكة بين وزارة التكوين والتعليم المهنيين بالجزائر ومفوضية الاتحاد الأفريقي أيام 16-18 نوفمبر 2026، ليكون الحدث السياسي الرفيع المستوى الرئيسي المنعقد على هامش أولمبياد المهن الجزائر 2026.', 'Le Forum est co-organisé par le Ministère de la Formation et de l\'Enseignement Professionnels d\'Algérie et la Commission de l\'Union Africaine, constituant le principal événement politique de haut niveau tenu en marge de WorldSkills Algeria 2026 les 16-18 Novembre 2026.', 'The African Skills Policy Forum is co-organized by Algeria\'s Ministry of Vocational Training and Education and the African Union Commission, serving as the principal high-level political event held alongside WorldSkills Algeria 2026 on 16-18 November 2026.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'pt' ? (__('ما هي الأهداف الاستراتيجية الـ 5 الرئيسية للمنتدى؟') !== 'ما هي الأهداف الاستراتيجية الـ 5 الرئيسية للمنتدى؟' ? __('ما هي الأهداف الاستراتيجية الـ 5 الرئيسية للمنتدى؟') : 'What are the 5 core strategic objectives of the Forum?') : (polyTrans('ما هي الأهداف الاستراتيجية الـ 5 الرئيسية للمنتدى؟', 'Quels sont les 5 objectifs stratégiques du Forum ?', 'What are the 5 core strategic objectives of the Forum?')) }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ polyTrans('1. النهوض بتنفيذ الاستراتيجية القارية للتكوين المهني (2025–2034). 2. إنشاء منصة منظمة لتبادل التجارب الناجحة. 3. اعتماد إعلان مهارات المستقبل. 4. تعزيز الشراكات الثنائية والمتعددة الأطراف. 5. تنفيذ برنامج لبناء قدرات الشباب الأفريقي.', '1. Mettre en œuvre la Stratégie Continentale d\'EFTP (2025–34). 2. Créer une plateforme structurée d\'échange d\'expériences. 3. Adopter la Déclaration sur les compétences de demain. 4. Renforcer les partenariats bilatéraux & multilatéraux. 5. Déployer un programme de renforcement des capacités des jeunes.', '1. Advance Continental TVET Strategy (2025–34). 2. Create a structured TVET exchange platform. 3. Adopt Declaration on Skills for Tomorrow. 4. Strengthen bilateral & multilateral partnerships. 5. Deliver a youth capacity-building programme.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'pt' ? (__('هل يمكن تعديل التخصص بعد إرسال الطلب؟') !== 'هل يمكن تعديل التخصص بعد إرسال الطلب؟' ? __('هل يمكن تعديل التخصص بعد إرسال الطلب؟') : 'Can the skill discipline be changed after submission?') : (polyTrans('هل يمكن تعديل التخصص بعد إرسال الطلب؟', 'Peut-on modifier la spécialité après soumission ?', 'Can the skill discipline be changed after submission?')) }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ polyTrans('يتم تجميد البيانات الحساسة بعد إرسال الطلب، ويمكن طلب إعادة الفتح عبر مسؤول الوفد أو Admin المنصة عند وجود مبرر مقبول.', 'Les données sont verrouillées après soumission. Toute modification nécessite l\'approbation de l\'administrateur de la délégation.', 'Data is locked upon submission. Modifications require approval from the delegation administrator.') }}
                </p>
            </div>
        </div>

    </div>
</div>
