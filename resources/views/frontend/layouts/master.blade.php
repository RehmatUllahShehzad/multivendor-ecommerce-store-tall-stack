<!DOCTYPE html>
<html lang="en">

<head>
    <title> @yield('meta_title', $title ?? '') | {{ setting('site_title') }} </title>

    <meta charset="UTF-8">
    <meta name="author" content="{{ setting('site_title') }}">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <meta name="description" content="@yield('description', $description ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $keywords ?? '')">
    <meta property="og:title" content="@yield('meta_title', $title ?? '') | {{ setting('site_title') }}">
    <meta property="og:description" content=@yield('meta_description')>
    <meta property="og:image" content="{{ setting('fullImage') }}">
    <meta property="og:url" content="@yield('url', request()->url())">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ setting('twitter_url') }}">
    <meta name="twitter:description" content="@yield('description')">
    <meta name="twitter:image" content="{{ setting('fullImage') }}">

    @include('frontend.layouts.css')
    @stack('page_css')
    @livewireStyles

</head>

<body>
    <div class="main-site">
        <!-- header  -->
        @include('frontend.layouts.header')
        <!-- header  -->

        <div class="clearfix"></div>

        <div class="inner-section">

            @yield('page')
            {{ $slot ?? '' }}
        </div>

        <div class="clearfix"></div>

        @include('frontend.layouts.footer')
    </div>
    @include('frontend.layouts.js')
    @livewireScripts
    @include('frontend.layouts.livewirejs')
    @include('frontend.layouts.toastr-events')
    @stack('page_js')
    <script>
         Livewire.hook('message.processed', function(){
            $('.phone_number, .mask_us_phone').trigger('input');
            $('.card_number, .mask_us_credit_card').trigger('input');
        });
    </script>
</body>

</html>
