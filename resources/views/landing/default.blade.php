<x-frontend>

    <div class="tpnw-petition-header bg-accent">
            <div class="tpnw-petition-header__inner px-4 pt-4 md:pt-8 lg:pt-12 pb-20 md:pb-24 lg:pb-28  w-fit mx-auto max-w-7xl sm:px-6 lg:px-8">
                <x-petition-icon class="max-w-[369px] w-full mb-2 mx-auto" />
                <h2 class="text-center text-xl md:text-2xl lg:text-3xl">{{__("visual.subtitle")}}</h2>
                <h1 class="tpnw-title text-center text-3xl md:text-4xl lg:text-5xl">{{__("Atomwaffenverbot jetzt!")}}</h1>
            </div>
        </div>
    </div>

    <div class="tpnw-petition-cta -mt-14 md:-mt-16 lg:-mt-20">
        <div class="tpnw-petition-cta__container px-2 md:px-4">
            <div class="tpnw-petition__container__inner max-w-[690px] mx-auto bg-white relative">
                <img src="{{asset('images/mockup_tagi_header.png')}}" alt="Landing Mockup" class="w-full" />
                <div class="p-4 md:p-6">
                    <div class="tp-petition-cta__container__inner__content">
                        <p class="text-3xl font-bold">{{__("pledge.lead")}}</p>
                        <x-progressBar.bar :donationAmount="$rnw->sum" :donationPercent="$rnw->percentage"/>
                        <p class="text-2xl mt-6">{!!__("pledge.lead.cta")!!}</p>
                        <div class="mt-6">
                            <a href="/fundraising?rnw-amount=10000" class="w-full flex justify-center items-center font-bold uppercase bg-black text-accent text-2xl md:text-3xl py-1 px-6">
                                {{__("pledge.lead.button")}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tpnw-petition-text px-2 md:px-4 pt-8 text-white">
        <div class="tpnw-petition-text__content max-w-[690px] mx-auto text-2xl">
            {!! __("content.para.1") !!}
        </div>
    </div>
    {{-- <div class="tpnw-petition-text text-white">
        <div class="tpnw-petition-text__mockup__wrapper mt-12 md:mt-16">
            <div class="tpnw-petition-text__mockup max-w-[1038px] mx-auto px-4 md:px-8">
                <img src="{{asset('images/mockup_tagi.png')}}" alt="Landing Mockup" class="w-full" />
            </div>
        </div>
        <div class="tpnw-petition-text__mockup__description max-w-[1038px] mx-auto mt-2 px-4 md:px-8">
            <p class="text-sm">{!! __("content.imagedesc", ["missing" => number_format($rnw->missing, 0, ",", "'")]) !!}</p>
        </div>
    </div> --}}
    <div class="tpnw-petition-text px-2 md:px-4 text-white">
        <div class="tpnw-petition-text__content max-w-[690px] mx-auto text-2xl mt-4">
            {!! __("content.para.2") !!}
        </div>
        <div class="tpnw-petition-text__content max-w-[690px] mx-auto my-6 md:my-12">
            <a href="/fundraising" class="w-fit mx-auto flex justify-center items-center font-bold uppercase bg-accent text-black text-2xl md:text-3xl py-1 px-6">
                {{__("content.buttons.1")}}
            </a>
        </div>
        <div class="tpnw-petition-text__content max-w-[690px] mx-auto text-2xl">
            {!! __("content.para.3") !!}
        </div>
        <div class="tpnw-petition-text__content max-w-[690px] mx-auto mt-8 mb-20 md:mb-40">
            <div class="grid md:grid-cols-2 gap-x-4 gap-y-4">
                <a href="/fundraising?rnw-amount=2500" class="w-full mx-auto flex justify-center items-center font-bold uppercase bg-accent text-black text-2xl py-1 px-6">
                    {{__("content.buttons.25")}}
                </a>
                <a href="/fundraising?rnw-amount=5000" class="w-full mx-auto flex justify-center items-center font-bold uppercase bg-accent text-black text-2xl py-1 px-6">
                    {{__("content.buttons.50")}}
                </a>
                <a href="/fundraising?rnw-amount=10000" class="w-full mx-auto flex justify-center items-center font-bold uppercase bg-accent text-black text-2xl py-1 px-6">
                    {{__("content.buttons.100")}}
                </a>
                <a href="/fundraising?rnw-amount=25000" class="w-full mx-auto flex justify-center items-center font-bold uppercase bg-accent text-black text-2xl py-1 px-6">
                    {{__("content.buttons.250")}}
                </a>
                <a target="https://api.whatsapp.com/send?text=Hey!%20%E2%98%9D%F0%9F%8F%BC%0A%0ADie%20Atomwaffenverbots-Initiative%20(https://atomwaffenverbot.ch/)%20ist%20in%20vollem%20Gange!%20Doch%20sie%20braucht%20Unterst%C3%BCtzung:%20Noch%20dieses%20Jahr%20sollen%20in%20einer%20Ausgabe%20des%20Tagesanzeigers%20Unterschriftenb%C3%B6gen%20beigelegt%20werden,%20sodass%20fast%20100%27000%20Abonnent*in%20die%20Botschaft%20nach%20Hause%20erhalten!%20%F0%9F%97%9E%F0%9F%93%9D%20Damit%20das%20m%C3%B6glich%20wird,%20braucht%20es%20deine%20Unterst%C3%BCtzung.%20Hilft%20mit,%20um%20das%20Vorhaben%20zu%20finanzieren%20%F0%9F%92%B5:%20https://jetzt.atomwaffenverbot.ch/%0A%0AJeder%20Beitrag%20z%C3%A4hlt!%20Teile%20diesen%20Aufruf%20in%20deinem%20Umfeld%20und%20hilft%20mit,%20dass%20die%20Schweiz%20endlich%20dem%20Atomwaffenverbotsvertrag%20beitritt!%20%F0%9F%92%AA%F0%9F%8F%BC" href="/fundraising" class="w-full mx-auto flex justify-center items-center font-bold uppercase bg-highlight text-white text-2xl py-1 px-6">
                    {{__("content.buttons.share.whatsapp")}}
                </a>
                <a target="_blank" href="mailto:?subject=Hilfst%20du%20auch%20mit%3F&body=Hallo%0D%0A%0D%0ADie%20Atomwaffenverbots-Initiative%20(https%3A%2F%2Fatomwaffenverbot.ch%2F)%20ist%20in%20vollem%20Gange!%20Doch%20sie%20braucht%20Unterst%C3%BCtzung%3A%20Noch%20dieses%20Jahr%20sollen%20in%20einer%20Ausgabe%20des%20Tages-Anzeigers%20Unterschriftenb%C3%B6gen%20beigelegt%20werden%2C%20sodass%20die%20fast%20100'000%20Abonnent*in%20die%20Botschaft%20nach%20Hause%20erhalten!%20Damit%20das%20m%C3%B6glich%20wird%2C%20braucht%20es%20deine%20Unterst%C3%BCtzung%3A%20Hilft%20mit%2C%20um%20das%20Vorhaben%20zu%20finanzieren%3A%20https%3A%2F%2Fjetzt.atomwaffenverbot.ch%2F%0D%0A%0D%0AJeder%20Beitrag%20z%C3%A4hlt!%20Teile%20diesen%20Aufruf%20in%20deinem%20Umfeld%20und%20hilft%20mit%2C%20dass%20die%20Schweiz%20endlich%20dem%20Atomwaffenverbotsvertrag%20beitritt!%0D%0A%0D%0ALieber%20Gruss%0D%0A" class="w-full mx-auto flex justify-center items-center font-bold uppercase bg-highlight text-white text-2xl py-1 px-6">
                    {{__("content.buttons.share.email")}}
                </a>
            </div>
    </div>
</x-frontend>
