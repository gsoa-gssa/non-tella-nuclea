<x-app-layout :title="__('Create user')">
    <x-card-container>
        <div class="max-w-xl">
            <form action="{{route("users.store")}}" method="POST" class="petition-backend-form" x-data="{role:'user'}">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div class="mt-6">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                <div class="mt-6">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    <p class="text-sm mt-2">{{__("When left empty, users are prompted to set a new password when they log in for the first time.")}}</p>
                </div>
                <div class="mt-6">
                    <x-input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="mt-1 block w-full" required x-model="role">
                        <option value="user">{{__("User")}}</option>
                        <option value="admin">{{__("Admin")}}</option>
                    </select>
                </div>
                <div class="mt-6" x-show="role === 'user'">
                    <x-input-label for="configurations[]" :value="__('Select configurations')"/>
                    <div class="flex gap-4 mt-1">
                        @foreach (\App\Models\Configuration::all() as $configuration)
                            <div class="flex gap-2">
                                <input type="checkbox" id="configurations-{{$configuration->id}}" name="configurations[]" value="{{$configuration->id}}">
                                <label for="configurations-{{$configuration->id}}">{{$configuration->key}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-6">
                    <x-primary-button>{{ __('Create user') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-card-container>
</x-app-layout>
