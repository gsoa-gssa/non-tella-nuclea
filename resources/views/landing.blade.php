<x-frontend>

    <div class="tpnw-petition-header bg-accent">
            <div class="tpnw-petition-header__inner px-4 pt-8 md:pt-12 lg:pt-20 pb-24 md:pb-28 lg:pb-36  w-fit mx-auto max-w-7xl sm:px-6 lg:px-8 py-6">
                <x-petition-icon class="max-w-[369px] w-full mb-2 mx-auto" />
                <h2 class="text-center text-xl md:text-2xl lg:text-3xl">{{__("Taten statt Worte:")}}</h2>
                <h1 class="tpnw-title text-center text-3xl md:text-4xl lg:text-5xl">{{__("Atomwaffenverbot jetzt!")}}</h1>
            </div>
        </div>
    </div>

    <div class="tpnw-petition-cta -mt-8 md:-mt-12 lg:-mt-16">
        <div class="tpnw-petition-cta__container px-2 md:px-4">
            <div class="tpnw-petition__container__inner max-w-[793px] mx-auto bg-white p-4 md:p-8 lg:p-10">
                <div class="tp-petition-cta__container__inner__content">
                    <p class="text-3xl font-bold">{{__("Mit der Atomwaffenverbotsinitiative fordern wir den Bundesrat auf, dem Atomwaffenverbotsvertrag beizutreten und die humanitäre Verantwortung der Schweiz wahrnehmen. Sei dabei!")}}</p>
                    <div class="mt-2 md:mt-4">
                        <x-form />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tpnw-petition-text px-2 md:px-4 py-8">
        <div class="tpnw-petition-text__content max-w-[793px] mx-auto text-white text-2xl">
            {!!
                view("text." . app()->getLocale())
            !!}
            <div class="mt-12">
                <h2 class="tpnw-title text-xl md:text-2xl lg:text-3xl">{{__("Unterstützer*innen:")}}</h2>
                <x-supporter-organisations />
            </div>
        </div>
    </div>
</x-frontend>
