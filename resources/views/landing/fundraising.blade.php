<x-frontend>

    <div class="tpnw-petition-header bg-accent">
            <div class="tpnw-petition-header__inner px-4 pt-4 md:pt-8 lg:pt-12 pb-18 md:pb-24 lg:pb-28  w-fit mx-auto max-w-7xl sm:px-6 lg:px-8 py-6">
                <x-petition-icon class="max-w-[369px] w-full mb-2 mx-auto" />
                <h2 class="text-center text-xl md:text-2xl lg:text-3xl">{{__("visual.subtitle")}}</h2>
                <h1 class="tpnw-title text-center text-3xl md:text-4xl lg:text-5xl">{{__("Atomwaffenverbot jetzt!")}}</h1>
            </div>
        </div>
    </div>

    <div class="tpnw-petition-cta -mt-14 md:-mt-16 lg:-mt-24">
        <div class="tpnw-petition-cta__container px-2 md:px-4">
            <div class="tpnw-petition__container__inner max-w-[690px] mx-auto bg-white p-4 md:p-8 lg:p-10 relative">
                <p class="text-3xl font-bold mb-4">{{__("fundraising.thanks")}}</p>
                <x-progressBar.bar :donationAmount="$rnw->sum" :donationPercent="$rnw->percentage"/>
                @php
                    $availableLanguages = ["de", "fr"];
                    $language = in_array(app()->getLocale(), $availableLanguages) ? app()->getLocale() : "fr";
                @endphp
                <div class="mx-auto max-w-[620px] mt-6">
                    <div class="dds-widget-container" data-widget="lema"></div>
                </div>
                <script language="javascript" src="https://widget.raisenow.com/widgets/lema/gsoas-948f/js/dds-init-widget-{{$language}}.js" type="text/javascript"></script>
                <script type="text/javascript">
                window.rnwWidget = window.rnwWidget || {};
                window.rnwWidget.configureWidget = function(options) {
                    options.defaults['stored_campaign_name'] = 'tpnw_tagesanzeiger';
                    options.defaults['stored_campaign_configuration'] = '{{config("petition")->key}}';
                };
                </script>
            </div>
        </div>
    </div>

</x-frontend>
