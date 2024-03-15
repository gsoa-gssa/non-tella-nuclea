<x-app-layout :title="__('Supporters')">
    <x-card-container>
        {{ __("Export supporters") }}
        <form action="{{route("supporters.export")}}" method="POST" class="petition-backend-form">
            @csrf
            <div class="mt-2">
                <x-input-label for="configurations[]" :value="__('Select configurations')"/>
                <div class="flex gap-4 mt-1">
                    @php
                        if (auth()->user()->isAdmin()) {
                            $configurations = \App\Models\Configuration::all();
                        } else {
                            $configurations = auth()->user()->configurations();
                        }
                    @endphp
                    @foreach ($configurations as $item)
                        <div class="flex-2">
                            <input type="checkbox" id="configurations-{{$item->id}}" name="configurations[]" value="{{$item->key}}">
                            <label for="configurations-{{$item->id}}">{{$item->key}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-2">
                <x-input-label for="format" :value="__('Format')"/>
                <select id="format" name="format" class="mt-1 block w-full" required>
                    <option value="xlsx">{{__("Excel")}}</option>
                    <option value="csv">{{__("CSV")}}</option>
                    <option value="json">{{__("JSON")}}</option>
                </select>
            </div>
            <div class="mt-6">
                <x-primary-button>{{ __('Export') }}</x-primary-button>
            </div>
        </form>
    </x-card-container>
</x-app-layout>
