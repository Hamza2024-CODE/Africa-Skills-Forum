<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#0B2A6F]">
                {{ app()->getLocale() === 'fr' ? 'Foire Aux Questions (FAQ)' : (app()->getLocale() === 'en' ? 'Frequently Asked Questions (FAQ)' : 'الأسئلة الشائعة وإجابات الاستفسارات المتكررة') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Réponses aux questions les plus fréquentes concernant les inscriptions et les règlements.' : (app()->getLocale() === 'en' ? 'Answers to the most frequent questions regarding registration, skills and rules.' : 'إليك إجابات لأهم الأسئلة المتعلقة بالتسجيل، التخصصات، والشروط.') }}
            </p>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Qui peut s\'inscrire et participer au Forum Africa Skills Forum ?' : (app()->getLocale() === 'en' ? 'Who can register and participate in Africa Skills Forum?' : 'من يمكنه التسجيل والمشاركة في منتدى المهارات الإفريقية Africa Skills Forum؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'L\'inscription est ouverte aux délégués, experts, jeunes talents et délégations africaines partenaires.' : (app()->getLocale() === 'en' ? 'Registration is open to African delegates, experts, skilled youth, and partner national delegations.' : 'يتاح التسجيل لجميع المتربصين والخبراء والشباب والوفود الوطنية الإفريقية الشريكة، وفقاً للشروط والاعتمادات الرسمية للمنتدى.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Quels sont les documents d\'identité requis (NIN / Passeport) ?' : (app()->getLocale() === 'en' ? 'What are the required ID documents (NIN / Passport)?' : 'ما هي الوثائق المطلوبة للمشارك الجزائري والمشارك الأجنبي؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Les candidats algériens doivent fournir le NIN à 18 chiffres. Les candidats internationaux doivent fournir un numéro de passeport valide.' : (app()->getLocale() === 'en' ? 'Algerian candidates provide an 18-digit National ID (NIN). International candidates provide a valid 18-digit Passport number.' : 'المشارك الجزائري يلتزم برقم بطاقة التعريف الوطنية (18 رقماً). أما المشارك الأجنبي فيلتزم بتقديم رقم جواز السفر الساري المفعول.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Qu\'est-ce que le Forum des Politiques Africaines des Compétences 2026 et qui l\'organise ?' : (app()->getLocale() === 'en' ? 'What is Africa’s Skills Policy Forum 2026 and who co-organizes it?' : 'ما هو منتدى السياسات الأفريقية للمهارات 2026 ومن المشرف على تنظيمه؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' 
                        ? 'Le Forum est co-organisé par le Ministère de la Formation et de l\'Enseignement Professionnels d\'Algérie et la Commission de l\'Union Africaine, constituant le principal événement politique de haut niveau tenu en marge de WorldSkills Algeria 2026 les 16-17 Novembre 2026.' 
                        : (app()->getLocale() === 'en' 
                            ? 'The African Skills Policy Forum is co-organized by Algeria\'s Ministry of Vocational Training and Education and the African Union Commission, serving as the principal high-level political event held alongside WorldSkills Algeria 2026 on 16-17 November 2026.' 
                            : 'يُنظَّم منتدى السياسات الأفريقية للمهارات بشراكة بين وزارة التكوين والتعليم المهنيين بالجزائر ومفوضية الاتحاد الأفريقي يومي 16-17 نوفمبر 2026، ليكون الحدث السياسي الرفيع المستوى الرئيسي المنعقد على هامش أولمبياد المهن الجزائر 2026.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Quels sont les 5 objectifs stratégiques du Forum ?' : (app()->getLocale() === 'en' ? 'What are the 5 core strategic objectives of the Forum?' : 'ما هي الأهداف الاستراتيجية الـ 5 الرئيسية للمنتدى؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' 
                        ? '1. Mettre en œuvre la Stratégie Continentale d\'EFTP (2025–34). 2. Créer une plateforme structurée d\'échange d\'expériences. 3. Adopter la Déclaration sur les compétences de demain. 4. Renforcer les partenariats bilatéraux & multilatéraux. 5. Déployer un programme de renforcement des capacités des jeunes.' 
                        : (app()->getLocale() === 'en' 
                            ? '1. Advance Continental TVET Strategy (2025–34). 2. Create a structured TVET exchange platform. 3. Adopt Declaration on Skills for Tomorrow. 4. Strengthen bilateral & multilateral partnerships. 5. Deliver a youth capacity-building programme.' 
                            : '1. النهوض بتنفيذ الاستراتيجية القارية للتكوين المهني (2025–2034). 2. إنشاء منصة منظمة لتبادل التجارب الناجحة. 3. اعتماد إعلان مهارات المستقبل. 4. تعزيز الشراكات الثنائية والمتعددة الأطراف. 5. تنفيذ برنامج لبناء قدرات الشباب الأفريقي.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Peut-on modifier la spécialité après soumission ?' : (app()->getLocale() === 'en' ? 'Can the skill discipline be changed after submission?' : 'هل يمكن تعديل التخصص بعد إرسال الطلب؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Les données sont verrouillées après soumission. Toute modification nécessite l\'approbation de l\'administrateur de la délégation.' : (app()->getLocale() === 'en' ? 'Data is locked upon submission. Modifications require approval from the delegation administrator.' : 'يتم تجميد البيانات الحساسة بعد إرسال الطلب، ويمكن طلب إعادة الفتح عبر مسؤول الوفد أو Admin المنصة عند وجود مبرر مقبول.') }}
                </p>
            </div>
        </div>

    </div>
</div>
