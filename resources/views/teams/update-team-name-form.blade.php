<x-form-section submit="updateTeamName">
    <x-slot name="title">
        <span style="color: white; font-size:24px;">{{ __('チーム名') }}</span>
    </x-slot>

    <x-slot name="description">
        <span style="color: #FFF9BF; font-size:16px;"> {{ __('チーム名とオーナー情報') }}</span>
    </x-slot>

    <x-slot name="form">
        <!-- Team Owner Information -->
        <div class="col-span-6">
            <x-label value="{{ __('オーナー') }}" />

            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}" alt="{{ $team->owner->name }}">

                <div class="ml-4 leading-tight">
                    <div class="text-gray-900">{{ $team->owner->name }}</div>
                    <div class="text-gray-700 text-sm">{{ $team->owner->email }}</div>
                </div>
            </div>
        </div>

        <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('チーム名') }}" />

            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" :disabled="! Gate::check('update', $team)" />

            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('保存されました') }}
        </x-action-message>

        <x-button>
            {{ __('保存') }}
        </x-button>
    </x-slot>
    @endif
</x-form-section>