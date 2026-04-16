@extends('admin.guest')

@section('title', 'PrintPro - Digital Printing & Ecommerce')

@section('content')
    @include('partials.home.hero')
    @include('partials.home.about')
    @include('partials.home.products')
    @include('partials.home.member')
    @include('partials.home.portfolio')
    @include('partials.home.services')
    @include('partials.home.faq')
@endsection