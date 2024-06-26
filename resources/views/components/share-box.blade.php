<div class="petition-share mt-6 gap-2 bg-accent p-4 md:p-6" id="share">
    <h2 class="tpnw-title text-center text-3xl md:text-5xl text-black mb-4 md:mb-6">{{__("Teile unser Anliegen!")}}</h2>
    <div class="petition-share__grid grid md:grid-cols-2 gap-2">
        <input
            type="hidden"
            name="shareText"
            value="{{config("petition")->share->text->{app()->getLocale()} }}"
        >
        <input
            @php
                $url = config("petition")->share->link->{app()->getLocale()};
                if (config("petition")->type == "sourcebased") {
                    $url .= "?src=" . config("petition")->source;
                }
            @endphp
            type="hidden"
            name="shareUrl"
            value="{{$url}}"
        >
        <a class="share-button" data-share-type="whatsapp">{{__("Auf WhatsApp teilen")}}</a>
        <a class="share-button" data-share-type="twitter">{{__("Auf Twitter teilen")}}</a>
        <a class="share-button" data-share-type="facebook">{{__("Auf Facebook teilen")}}</a>
        <a class="share-button" data-share-type="email">{{__("Per E-Mail teilen")}}</a>
    </div>
</div>
