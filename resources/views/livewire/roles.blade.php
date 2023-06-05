
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-action-section>
        <x-slot name="title">
            {{ __('Create new role') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Create a new role for a user.') }}
        </x-slot>
        
        <x-slot name="content">
            <div class="max-w-xl text-sm text-gray-600">
                {{ __('Create a new role for the user in the admin system and empower them with enhanced privileges and responsibilities.') }}
            </div>

            <div class="mt-5">
                <x-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                    {{ __('Create New Role') }}
                </x-button>
            </div>

            <!-- Delete User Confirmation Modal -->

            {{-- creatingNewForUser --}}
            <x-dialog-modal wire:model="confirmingUserDeletion">
                <x-slot name="title">
                    {{ __('Create Role') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                    <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                        <x-input type="password" class="mt-1 block w-3/4"
                                    autocomplete="current-password"
                                    placeholder="{{ __('Password') }}"
                                    x-ref="password"
                                    wire:model.defer="password"
                                    wire:keydown.enter="deleteUser" />

                        <x-input-error for="password" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </x-slot>
            </x-dialog-modal>
        </x-slot>

    </x-action-section>
</div>