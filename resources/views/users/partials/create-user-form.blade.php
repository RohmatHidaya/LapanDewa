
<x-modal name="create-user" :show="$errors->any()" focusable>
        <form method="post" action="{{ route('users.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Create New User') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="name" :value="__('Name')" />

                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Username') }}"
                    :value="old('name')"
                    required
                />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            
            <div class="mt-6">
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('test@example.com') }}"
                    :value="old('email')"
                    required
                />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div class="mt-6">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('password') }}"
                    required
                />
            
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="password" :value="__('Confirm Password')" />

                <x-text-input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('password Confirmation') }}"
                    required
                />
            
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            

            <div class="mt-6">
                <x-input-label for="role" :value="__('Role')" />

                <x-text-input
                    id="role"
                    name="role"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Default User') }}"
                    :value="old('role')"
                    required
                />

                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Create User') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>