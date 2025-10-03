<div class="flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
    <!-- Photo Container -->
    <div class="relative w-full aspect-[3/4] bg-gray-100 dark:bg-gray-700">
        <img 
            src="{{ $photoUrl }}" 
            alt="{{ $name }}"
            class="w-full h-full object-cover"
        >
        @if($attributes->has('editable'))
        <button 
            class="absolute bottom-2 right-2 p-2 bg-white dark:bg-gray-800 rounded-full shadow-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            title="Edit photo"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>
        @endif
    </div>

    <!-- Visitor Info -->
    <div class="p-4 text-center">
        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $name }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400">ID: {{ $visitorId }}</p>
    </div>
</div>