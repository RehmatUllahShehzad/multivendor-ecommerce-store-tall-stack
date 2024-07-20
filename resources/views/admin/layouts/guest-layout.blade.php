<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ setting('site_title') }}</title>
    @include('admin.layouts.css')
</head>

<body x-data="tallTheme()" :class="{ 'dark': dark }" x-init="dark = getThemeFromLocalStorage()">

    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">

        <div class="flex-1 h-full max-w-lg mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="flex items-center justify-center p-6 sm:p-12 w-full">
                    {{ $slot ?? '' }}
                    @yield('page')
                </div>
            </div>
        </div>
    </div>

    <x-notify-component />
    @include('admin.layouts.js')
</body>

</html>
