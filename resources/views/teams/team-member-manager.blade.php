<div>
    @if (Gate::check('addTeamMember', $team))
    <x-section-border />

    <!-- Add Team Member -->
    <div class="mt-10 sm:mt-0">
        <x-form-section submit="addTeamMember">
            <x-slot name="title">
                <span style="color: white; font-size:24px;">{{ __('メンバーを追加する') }}</span>
            </x-slot>

            <x-slot name="description">
                <span style="color: #FFF9BF; font-size:16px;">{{ __('新しいメンバーをチームに追加して権限を与えます') }}</span>
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    <div class="max-w-xl text-sm text-gray-600">
                        {{ __('追加したいメンバーのメールアドレスを入力してください') }}
                    </div>
                </div>

                <!-- Member Email -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="email" value="{{ __('メールアドレス') }}" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="addTeamMemberForm.email" />
                    <x-input-error for="email" class="mt-2" />
                </div>

                <!-- Role -->
                @if (count($this->roles) > 0)
                <div class="col-span-6 lg:col-span-4">
                    <x-label for="role" value="{{ __('権限') }}" />
                    <x-input-error for="role" class="mt-2" />

                    <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                        @foreach ($this->roles as $index => $role)
                        <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 {{ $index > 0 ? 'border-t border-gray-200 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}" wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                            <div class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-600 {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                        {{ $role->name }}
                                    </div>

                                    @if ($addTeamMemberForm['role'] == $role->key)
                                    <svg class="ml-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @endif
                                </div>

                                <!-- Role Description -->
                                <div class="mt-2 text-xs text-gray-600 text-left">
                                    {{ $role->description }}
                                </div>
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
            </x-slot>

            <x-slot name="actions">
                <x-action-message class="mr-3" on="saved">
                    {{ __('招待が送信されました') }}
                </x-action-message>

                <x-button>
                    {{ __('追加') }}
                </x-button>
            </x-slot>
        </x-form-section>
    </div>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
    <x-section-border />

    <!-- Team Member Invitations -->
    <div class="mt-10 sm:mt-0">
        <x-action-section>
            <x-slot name="title">
                <span style="color: white; font-size:24px;">{{ __('招待を送信済みのメンバー') }}</span>
            </x-slot>

            <x-slot name="description">
                <span style="color: #FFF9BF; font-size:16px;">{{ __('招待を送信済みのメンバーリストです。招待が承諾されるとチームに新しく追加されます') }}</span>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    @foreach ($team->teamInvitations as $invitation)
                    <div class="flex items-center justify-between">
                        <div class="text-gray-600">{{ $invitation->email }}</div>

                        <div class="flex items-center">
                            @if (Gate::check('removeTeamMember', $team))
                            <!-- Cancel Team Invitation -->
                            <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                {{ __('取り消す') }}
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </x-slot>
        </x-action-section>
    </div>
    @endif

    @if ($team->users->isNotEmpty())
    <x-section-border />

    <!-- Manage Team Members -->
    <div class="mt-10 sm:mt-0">
        <x-action-section>
            <x-slot name="title">
                <span style="color: white; font-size:24px;">{{ __('メンバー') }}</span>
            </x-slot>

            <x-slot name="description">
                <span style="color: #FFF9BF; font-size:16px;">{{ __('現在このチームに所属しているメンバーの一覧です') }}</span>
            </x-slot>

            <!-- Team Member List -->
            <x-slot name="content">
                <div class="space-y-6">
                    @foreach ($team->users->sortBy('name') as $user)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                            <div class="ml-4">{{ $user->name }}</div>
                        </div>

                        <div class="flex items-center">
                            <!-- Manage Team Member Role -->
                            @if (Gate::check('addTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                            <button class="ml-2 text-sm text-gray-400 underline" wire:click="manageRole('{{ $user->id }}')">
                                {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                            </button>
                            @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                            <div class="ml-2 text-sm text-gray-400">
                                {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                            </div>
                            @endif

                            <!-- Leave Team -->
                            @if ($this->user->id === $user->id)
                            <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="$toggle('confirmingLeavingTeam')">
                                {{ __('退会') }}
                            </button>

                            <!-- Remove Team Member -->
                            @elseif (Gate::check('removeTeamMember', $team))
                            <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                {{ __('追放') }}
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </x-slot>
        </x-action-section>
    </div>
    @endif

    <!-- Role Management Modal -->
    <x-dialog-modal wire:model="currentlyManagingRole">
        <x-slot name="title">
            {{ __('権限を変更する') }}
        </x-slot>

        <x-slot name="content">
            <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                @foreach ($this->roles as $index => $role)
                <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 {{ $index > 0 ? 'border-t border-gray-200 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}" wire:click="$set('currentRole', '{{ $role->key }}')">
                    <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                        <!-- Role Name -->
                        <div class="flex items-center">
                            <div class="text-sm text-gray-600 {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                {{ $role->name }}
                            </div>

                            @if ($currentRole == $role->key)
                            <svg class="ml-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @endif
                        </div>

                        <!-- Role Description -->
                        <div class="mt-2 text-xs text-gray-600">
                            {{ $role->description }}
                        </div>
                    </div>
                </button>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ __('戻る') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="updateRole" wire:loading.attr="disabled">
                {{ __('保存する') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Leave Team Confirmation Modal -->
    <x-confirmation-modal wire:model="confirmingLeavingTeam">
        <x-slot name="title">
            {{ __('本当に退会しますか？') }}
        </x-slot>

        <x-slot name="content">
            {{ __('この操作は取り消せません') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                {{ __('戻る') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="leaveTeam" wire:loading.attr="disabled">
                {{ __('退会') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Remove Team Member Confirmation Modal -->
    <x-confirmation-modal wire:model="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('本当に追放しますか？') }}
        </x-slot>

        <x-slot name="content">
            {{ __('追放後、再度チームに追加することは可能です。') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ __('戻る') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ __('追放') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>