<x-frontend>
    <div class="tpnw-petition-header bg-accent px-4 py-8 md:py-10 lg:py-12">
        <h1 class="tpnw-title text-center text-3xl md:text-4xl lg:text-5xl">{{__("Unterstütze uns mit deiner Spende!")}}</h1>
    </div>
    <div class="tpnw-petition-text px-2 md:px-4 py-8">
        <div class="tpnw-petition-text__content max-w-[793px] mx-auto text-white text-2xl">
            <p class="mt-4">{{__("Deine Spende hilft uns, unsere Arbeit für eine friedlichere Welt fortzusetzen.")}}</p>
            <div class="tpnw-petition-text__content__donate bg-white mt-16 p-4 md:p-6 text-black">
                @php
                    $availableLanguages = ["de", "fr"];
                    $language = in_array(app()->getLocale(), $availableLanguages) ? app()->getLocale() : "fr";
                @endphp
                <div id="root">
                </div>
                <script language="javascript" src="https://widget.raisenow.com/widgets/lema/gsoas-948f/js/dds-init-widget-{{$language}}.js" type="text/javascript"></script>
                <script type="text/javascript">
                window.rnwWidget = window.rnwWidget || {};
                window.rnwWidget.configureWidget = function(options) {
                    options.defaults['stored_campaign_name'] = 'tpnw_pledge';
                    options.defaults['stored_campaign_configuration'] = '{{config("petition")->key}}';
                };
                </script>
                <div class="dds-widget-container" data-widget="lema"></div>
            </div>
        </div>
    </div>
</x-frontend>
