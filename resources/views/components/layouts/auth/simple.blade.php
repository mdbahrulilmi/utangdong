<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-gradient-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="flex min-h-screen items-center justify-center px-4 py-10">
            <div class="w-full max-w-sm space-y-6">
                <!-- Logo -->
                <div class="flex justify-center">
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center justify-center">
                        <x-app-logo-icon class="size-10 text-black dark:text-white" />
                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <!-- Auth content -->
                <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-lg p-6 sm:p-8 space-y-6">
                    {{ $slot }}
                </div>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
