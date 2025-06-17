<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf

                        <!-- Service Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Service Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>

                        <!-- Duration -->
                        <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duration (minutes)')" />
                            <x-text-input id="duration" name="duration" type="number" class="mt-1 block w-full" :value="old('duration')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button onclick="window.history.back()" type="button" class="mr-3">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Create Service') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 