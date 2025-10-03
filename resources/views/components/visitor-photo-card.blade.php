<div class="block bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
    <!-- Photo Container -->
    <div class="relative w-full aspect-square bg-gray-100 dark:bg-gray-700">
        <div class="w-full h-full flex items-center justify-center">
            <svg class="w-20 h-20 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
    </div>

    <!-- Visitor Info -->
    <div class="p-4">
        <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $name }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400">ID: {{ $visitorId }}</p>
    </div>
</div>
</a>