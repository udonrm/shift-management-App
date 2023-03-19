<x-action-section>
    <x-slot name="title">
        <span style="color: white; font-size:24px;">{{ __('2段階認証') }}</span>
    </x-slot>

    <x-slot name="description">
        <span style="color: #FFF9BF; font-size:16px;">{{ __('安全のため2段階認証を有効にすることができます') }}</span>
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
            @if ($showingConfirmation)
            {{ __('2段階認証が有効になりました') }}
            @else
            {{ __('2段階認証が有効になりました') }}
            @endif
            @else
            {{ __('2段階認証は現在無効になっています') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('2段階認証が有効になると、認証時に安全なランダムなトークンを入力するよう求められます。このトークンは、お使いのスマートフォンのGoogle Authenticatorアプリから取得できます。') }}
            </p>
        </div>

        @if ($this->enabled)
        @if ($showingQrCode)
        <div class="mt-4 max-w-xl text-sm text-gray-600">
            <p class="font-semibold">
                @if ($showingConfirmation)
                {{ __('2段階認証を有効にするために、お使いのスマートフォンの認証アプリを使って以下のQRコードをスキャンするか、設定キーを入力して生成されたOTPコードを提供してください。') }}
                @else
                {{ __('2段階認証が有効になりました。以下のQRコードをスマートフォンの認証アプリでスキャンするか、設定キーを入力してください。') }}
                @endif
            </p>
        </div>

        <div class="mt-4">
            {!! $this->user->twoFactorQrCodeSvg() !!}
        </div>

        <div class="mt-4 max-w-xl text-sm text-gray-600">
            <p class="font-semibold">
                {{ __('設定キー') }}: {{ decrypt($this->user->two_factor_secret) }}
            </p>
        </div>

        @if ($showingConfirmation)
        <div class="mt-4">
            <x-label for="code" value="{{ __('Code') }}" />

            <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric" autofocus autocomplete="one-time-code" wire:model.defer="code" wire:keydown.enter="confirmTwoFactorAuthentication" />

            <x-input-error for="code" class="mt-2" />
        </div>
        @endif
        @endif

        @if ($showingRecoveryCodes)
        <div class="mt-4 max-w-xl text-sm text-gray-600">
            <p class="font-semibold">
                {{ __('これらのリカバリーコードを安全に保存してください。2段階認証デバイスが紛失した場合に、アカウントへのアクセスを回復するために使用することができます。') }}
            </p>
        </div>

        <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
            @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
            <div>{{ $code }}</div>
            @endforeach
        </div>
        @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
            <x-confirms-password wire:then="enableTwoFactorAuthentication">
                <x-button type="button" wire:loading.attr="disabled">
                    {{ __('有効にする') }}
                </x-button>
            </x-confirms-password>
            @else
            @if ($showingRecoveryCodes)
            <x-confirms-password wire:then="regenerateRecoveryCodes">
                <x-secondary-button class="mr-3">
                    {{ __('リカバリーコードを更新する') }}
                </x-secondary-button>
            </x-confirms-password>
            @elseif ($showingConfirmation)
            <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                <x-button type="button" class="mr-3" wire:loading.attr="disabled">
                    {{ __('確認') }}
                </x-button>
            </x-confirms-password>
            @else
            <x-confirms-password wire:then="showRecoveryCodes">
                <x-secondary-button class="mr-3">
                    {{ __('リカバリーコードを表示する') }}
                </x-secondary-button>
            </x-confirms-password>
            @endif

            @if ($showingConfirmation)
            <x-confirms-password wire:then="disableTwoFactorAuthentication">
                <x-secondary-button wire:loading.attr="disabled">
                    {{ __('戻る') }}
                </x-secondary-button>
            </x-confirms-password>
            @else
            <x-confirms-password wire:then="disableTwoFactorAuthentication">
                <x-danger-button wire:loading.attr="disabled">
                    {{ __('無効にする') }}
                </x-danger-button>
            </x-confirms-password>
            @endif

            @endif
        </div>
    </x-slot>
</x-action-section>