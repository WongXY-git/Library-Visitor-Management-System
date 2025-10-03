<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Visitor Details') }}
            </h2>
            <div class="flex space-x-4">
                <x-secondary-button wire:click="$dispatch('backToDashboard')">
                    {{ __('Back to Dashboard') }}
                </x-secondary-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Success Message -->
                    @if (session()->has('message'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Photo Section -->
                        <div class="relative">
                            <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                                @if($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" 
                                         alt="{{ $name }}" 
                                         class="w-full h-full object-cover">
                                @elseif($visitor->photo_path)
                                    <img src="{{ Storage::url($visitor->photo_path) }}" 
                                         alt="{{ $name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            @if($isEditing)
                                <div class="mt-4">
                                    <input type="file" wire:model="photo" class="hidden" id="photo">
                                    <x-secondary-button onclick="document.getElementById('photo').click()">
                                        {{ __('Change Photo') }}
                                    </x-secondary-button>
                                </div>
                            @endif
                        </div>

                        <!-- Details Section -->
                        <div>
                            <form wire:submit="save">
                                <div class="space-y-6">
                                    <!-- Name -->
                                    <div>
                                        <x-input-label for="name" value="Name" />
                                        @if($isEditing)
                                            <x-text-input wire:model="name" type="text" class="mt-1 block w-full" required />
                                        @else
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $name }}</p>
                                        @endif
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <!-- Card Number -->
                                    <div>
                                        <x-input-label for="cardNo" value="Card Number" />
                                        @if($isEditing)
                                            <x-text-input wire:model="cardNo" type="text" class="mt-1 block w-full" required />
                                        @else
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $cardNo }}</p>
                                        @endif
                                        <x-input-error :messages="$errors->get('cardNo')" class="mt-2" />
                                    </div>

                                    <!-- Unique ID -->
                                    <div>
                                        <x-input-label for="uniqueId" value="Unique ID" />
                                        @if($isEditing)
                                            <x-text-input wire:model="uniqueId" type="text" class="mt-1 block w-full" />
                                        @else
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $uniqueId ?? 'Not set' }}</p>
                                        @endif
                                        <x-input-error :messages="$errors->get('uniqueId')" class="mt-2" />
                                    </div>

                                    <!-- Remarks -->
                                    <div>
                                        <x-input-label for="remarks" value="Remarks" />
                                        @if($isEditing)
                                            <x-textarea wire:model="remarks" class="mt-1 block w-full" rows="3" />
                                        @else
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $remarks ?? 'No remarks' }}</p>
                                        @endif
                                        <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex justify-end space-x-4">
                                        @if($isEditing)
                                            <x-secondary-button type="button" wire:click="cancel">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>
                                            <x-primary-button type="submit">
                                                {{ __('Save') }}
                                            </x-primary-button>
                                        @else
                                            <x-danger-button type="button" 
                                                           wire:click="delete"
                                                           wire:confirm="Are you sure you want to delete this visitor?">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                            <x-primary-button type="button" wire:click="startEdit">
                                                {{ __('Edit') }}
                                            </x-primary-button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>