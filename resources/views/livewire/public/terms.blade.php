<div class="py-16 bg-[#F4F7FC]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-md border border-slate-200/80 space-y-6">
            <div class="border-b border-slate-100 pb-6">
                <h1 class="text-3xl font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Conditions d\'Utilisation' : (app()->getLocale() === 'en' ? 'Terms & Conditions' : 'شروط وأحكام الاستخدام') }}</h1>
                <p class="text-xs text-slate-500 mt-2">WorldSkills Algeria — Terms & Conditions</p>
            </div>
            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed">
                {!! nl2br(e($content)) !!}
            </div>
        </div>
    </div>
</div>
