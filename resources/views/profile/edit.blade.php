<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Profil Akun</h1>
    </x-slot>

    <div class="mx-auto max-w-3xl space-y-6">
        <x-ui.card>
            @include('profile.partials.update-profile-information-form')
        </x-ui.card>
        <x-ui.card>
            @include('profile.partials.update-password-form')
        </x-ui.card>
        <x-ui.card>
            @include('profile.partials.delete-user-form')
        </x-ui.card>
    </div>
</x-app-layout>
