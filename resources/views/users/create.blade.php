<x-layout.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="mb-8">
        <div class="max-w-4xl mx-auto space-y-6">
            
            <!-- Page Header -->
            <x-ui.page-header 
                title="Create User" 
                description="Add a new user to the system"
                :back-url="route('users.index')"
                back-label="Back to Users"
            />

            <!-- Form Card -->
            <x-ui.card>
                <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                    @csrf

                    <!-- Basic Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <x-ui.input
                                    id="name"
                                    name="name"
                                    type="text"
                                    label="Full Name"
                                    placeholder="Enter full name"
                                    :value="old('name')"
                                    :error="$errors->first('name')"
                                    required
                                />
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <x-ui.input
                                    id="email"
                                    name="email"
                                    type="email"
                                    label="Email Address"
                                    placeholder="user@example.com"
                                    :value="old('email')"
                                    :error="$errors->first('email')"
                                    required
                                />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-ui.input
                                    id="password"
                                    name="password"
                                    type="password"
                                    label="Password"
                                    placeholder="••••••••"
                                    :error="$errors->first('password')"
                                    required
                                />
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <x-ui.input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    label="Confirm Password"
                                    placeholder="••••••••"
                                    required
                                />
                            </div>

                        </div>
                    </div>

                    <!-- Roles Section -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">User Roles</h3>
                        <div class="space-y-3">
                            @forelse($roles as $role)
                                <label class="flex items-start p-4 bg-gray-50 dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition-colors duration-200">
                                    <input 
                                        type="checkbox" 
                                        name="roles[]" 
                                        value="{{ $role->id }}"
                                        class="mt-1 w-4 h-4 text-primary-600 bg-white border-gray-300 rounded focus:ring-primary-500 focus:ring-2"
                                        {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                                    >
                                    <div class="ml-3 flex-1">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $role->name }}</span>
                                        @if($role->permissions->count() > 0)
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $role->permissions->count() }} permissions
                                            </p>
                                        @endif
                                    </div>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">No roles available. Please create roles first.</p>
                            @endforelse
                        </div>
                        @error('roles')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button type="button" variant="outline" onclick="window.location.href='{{ route('users.index') }}'">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </x-slot>
                            Create User
                        </x-ui.button>
                    </div>

                </form>
            </x-ui.card>

        </div>
    </div>
</x-layout.app>
