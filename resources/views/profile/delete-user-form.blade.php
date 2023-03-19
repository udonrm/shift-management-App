<x-action-section>
    <x-slot name="title">
        <span style="color: white; font-size:24px;">{{ __('アカウントを削除する') }}</span>
    </x-slot>

    <x-slot name="description">
        <span style="color: #FFF9BF; font-size:16px;">{{ __('削除を実行後に情報の復元はできません') }}</span>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('アカウントを削除するとすべての情報が失われます') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('削除') }}
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('本当に削除しますか？') }}
            </x-slot>

            <x-slot name="content">
                {{ __('削除するとこのアカウントに関するすべての情報が失われます') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4" autocomplete="current-password" placeholder="{{ __('パスワードを入力してください') }}" x-ref="password" wire:model.defer="password" wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('戻る') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('削除') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>