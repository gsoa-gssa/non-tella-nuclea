@php
    $formID = \Str::uuid();
@endphp
<div class="petition-supporter-form">
    <form
        action="{{route('supporters.store')}}"
        method="post"
        class="petition-supporter-form__form"
        onsubmit="var _paq = window._paq = window._paq || []; _paq.push(['trackEvent', 'Form', 'Submit', '{{config('petition')->key}}']);"
    >
        @if ($errors->any())
            <div class="petition-input-group petition-input-group__fullwidth">
                <p class="petition-input-group__error !text-base">
                    {{__("There was an error with your submission. Please check the form and try again.")}}
                </p>
            </div>
        @endif
        @csrf
        <div class="petition-input-group petition-input-group__fullwidth petition-input-group__signatureCountFields p-4 bg-black text-accent">
            <label for="{{$formID}}-signatureCount" class="!text-lg font-extrabold uppercase">{{config("petition")->signatureCountFields->label->{app()->getLocale()} }}</label>
            <div class="petition-input-group__signatureCountFields__options">
                @foreach(config("petition")->signatureCountFields->options as $option)
                    <div class="petition-input-group__signatureCountFields__options__option">
                        <input
                            type="radio"
                            name="data[signatureCount]"
                            id="{{$formID}}-signatureCount-{{$option->value}}"
                            value="{{$option->value}}"
                            required
                            data-helper="{{ $option->helper->{app()->getLocale()} }}"
                            @if(old("data.signatureCount") == $option->value) checked @endif
                        >
                        <label for="{{$formID}}-signatureCount-{{$option->value}}">{{$option->label->{app()->getLocale()} }}</label>
                    </div>
                @endforeach
            </div>
            <p class="text-[0.8rem] mt-4" id="pledge-helper">{{ config("petition")->signatureCountFields->default->{app()->getLocale()} }}</p>
        </div>
        @foreach (config("petition")->datafields as $item)
            <x-dynamic-component :component="'form.input-'.$item->type" :item="$item" :formID="$formID" />
        @endforeach
        <div class="petition-input-group petition-input-group__fullwidth">
            <input
                type="checkbox"
                name="optin"
                id="{{$formID}}-optin"
                value="1"
                @if (config("petition")->optin->checked) checked @endif
            >
            <label
                for="{{$formID}}-optin"
            >
                {!!config("petition")->optin->{app()->getLocale()} !!}
            </label>
        </div>
        @if(config("petition")->publication->status === true)
            <div class="petition-input-group petition-input-group__fullwidth">
                <input
                    type="checkbox"
                    name="public"
                    id="{{$formID}}-publication"
                    value="1"
                    @if (config("petition")->publication->checked) checked @endif
                >
                <label
                    for="{{$formID}}-publication"
                >
                    {!!config("petition")->publication->langs->{app()->getLocale()} !!}
                </label>
            </div>
        @endif
        @if (strpos(request()->getQueryString(), "stored_") !== false)
            @php
                $stored_params = array_filter(request()->all(), function($key) {
                    return strpos($key, "stored_") !== false;
                }, ARRAY_FILTER_USE_KEY);
            @endphp
            @foreach ($stored_params as $key => $value)
                <input type="hidden" name="data[{{str_replace("stored_", "", $key)}}]" value="{{$value}}">
            @endforeach
        @endif
        <div class="petition-input-group petition-input-group__fullwidth">
            <button type="submit" class="petition-supporter-form__submit">
                {{__("Sign the petition")}}
            </button>
        </div>
        <input type="hidden" name="configuration" value="{{config("petition")->key}}">
        <input type="hidden" name="data[locale]" value="{{app()->getLocale()}}">
        <input type="hidden" name="data[stage]" value="pledge">
    </form>
</div>

@if ($errors->any())

    <script>
        window.addEventListener('load', function() {
            window.scrollTo({
                left: 0,
                top: document.querySelector('.petition-input-group__error').offsetTop - 100,
                behavior: 'smooth'
            });
        });
    </script>

@endif
