<x-form-section submit="updatePassword">
    <x-slot name="title">
        <span style="color: white; font-size:24px;">{{ __('パスワードの更新') }}</span>
    </x-slot>

    <x-slot name="description">
        <span style="color: #FFF9BF; font-size:16px;">{{ __('新しいパスワードを入力してください') }}</span>
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('現在のパスワード') }}" />
            <x-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('新しいパスワード') }}" />
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('確認のため新しいパスワードを再入力してください') }}" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('保存されました') }}
        </x-action-message>

        <x-button>
            {{ __('保存') }}
        </x-button>
    </x-slot>
</x-form-section>