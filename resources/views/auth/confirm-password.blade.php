<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="w-40">
                <x-authentication-card-logo />
            </div>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('続行する前にパスワードを確認してください') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-label for="password" value="{{ __('パスワード') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('確認') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>