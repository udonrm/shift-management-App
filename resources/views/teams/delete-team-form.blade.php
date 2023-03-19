<x-action-section>
    <x-slot name="title">
        <span style="color: white; font-size:24px;">{{ __('チームを削除する') }}</span>
    </x-slot>

    <x-slot name="description">
        <span style="color: #FFF9BF;">{{ __('削除を実行後に情報の復元はできません') }}</span>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('チームを削除するとすべての情報が失われます') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('削除') }}
            </x-danger-button>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <x-confirmation-modal wire:model="confirmingTeamDeletion">
            <x-slot name="title">
                {{ __('本当に削除しますか？') }}
            </x-slot>

            <x-slot name="content">
                {{ __('削除するとこのチームに関するすべての情報が失われます') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('戻る') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteTeam" wire:loading.attr="disabled">
                    {{ __('削除する') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-action-section>