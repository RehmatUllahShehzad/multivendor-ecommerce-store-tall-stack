@extends('frontend.layouts.master')

@section('meta_title', $page->title)
@section('meta_description', $page->short_description)

@push('page_css')
    <style>
        {!! $page->getCss() !!}
    </style>
@endpush

@section('page')
    {!! $page->getHtml() !!}

    @if ($page->isHomePage())
        <livewire:frontend.home.location-popup />
    @endif
    
@endsection
