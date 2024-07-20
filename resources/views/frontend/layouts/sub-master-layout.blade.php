<x-frontend.layouts.master-layout :title="$pageTitle" :description="$pageDescription">
    <div class="inner-section">
        <section class="vender-product-management-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="vender-product-management vendor-portal-wrap div-flex">
                            <div class="vender-menu vendor-aside">
                                <div class="vender-menu vendor-aside">
                                    <x-menu :name="$menuName" current="{{ request()->route()->getName() }}">
                                        @foreach ($component->items as $item)
                                            <a class="nav-link 
                                                @if ($item->isActive($component->attributes->get('current'))) active @endif" href="{{ route($item->route) }}">
                                                <img src="/frontend/images/{{ $item->icon }}.svg" alt="">
                                                {{ $item->name }}
                                                @if ($item->name == __('global.your.messages'))
                                                    <x-message-read-notification />
                                                @endif
                                            </a>
                                        @endforeach
                                    </x-menu>
                                </div>
                            </div>
                            {{ $slot ?? '' }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-frontend.layouts.master-layout>
