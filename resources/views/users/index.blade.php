<x-app-layout :title="__('User administration')">
    <div class="mb-8 flex justify-end">
        <x-primary-button :href="route('users.create')">{{ __('Create user') }}</x-primary-button>
    </div>
    <x-table>
        <x-slot name="head">
            <x-table.heading>{{ __('Name') }}</x-table.heading>
            <x-table.heading>{{ __('Email') }}</x-table.heading>
            <x-table.heading>{{ __('Role') }}</x-table.heading>
            <x-table.heading>{{ __('Actions') }}</x-table.heading>
        </x-slot>
        <x-slot name="body">
            @foreach ($users as $user)
                <x-table.row>
                    <x-table.cell>{{ $user->name }}</x-table.cell>
                    <x-table.cell>{{ $user->email }}</x-table.cell>
                    <x-table.cell>{{ $user->role }}</x-table.cell>
                    <x-table.cell>
                        <a href="{{route("users.edit", $user->id)}}" class="text-indigo-600 underline">Edit</a>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
</x-app-layout>
