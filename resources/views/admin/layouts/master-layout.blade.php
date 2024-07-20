<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? '' }} | {{ setting('site_title') }}</title>
    @include('admin.layouts.css')
</head>

<body x-data="tallTheme()" :class="{ 'dark': dark }" x-init="dark = getThemeFromLocalStorage()">
    <div
        class="printable flex h-screen bg-gray-100 dark:bg-gray-900 fixed w-full"
        :class="{ 'overflow-hidden': isSideMenuOpen }">

        <x-admin.components.side-bar />

        <div class="wd-block flex flex-col flex-1 w-full">

            <x-admin.components.nav-bar />

            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid py-6">

                    <div class="wd-block flex items-center justify-between">
                        <strong class="text-lg font-bold md:text-2xl dark:text-white">
                            @yield('page_title', '')
                        </strong>

                        {{ $actionButton ?? '' }}

                    </div>

                    <div class="w-full mb-8 {{ $pageContainerClasses }} rounded-lg shadow-xs py-4">
                        {{ $slot ?? '' }}
                        @yield('page')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('page_js')

    <x-notify-component />
    @include('admin.layouts.js')
</body>

</html>
