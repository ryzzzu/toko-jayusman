@props(['branchWarning' => false])

@if($branchWarning)
    <x-ui.alert type="warning" class="mb-6">
        Akun Anda belum terhubung ke cabang. Hubungi Pak Jayusman untuk penugasan cabang.
    </x-ui.alert>
@endif
