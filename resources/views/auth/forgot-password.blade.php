<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="w-40">
                <x-authentication-card-logo />
            </div>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('ご入力いただいたメールアドレス宛てに新しいパスワードの設定リンクを送付します。') }}
        </div>

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('メールアドレス') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('送信') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>