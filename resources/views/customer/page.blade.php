@extends('customer.layouts.master-one-col')

@section('head-tag')
<title>{{ $page->title }}</title>
@endsection


@section('content')
    <!--page title start-->
    @foreach ($about_banners as $about_banner)
    <section class="section-gap section-top bg-gray text-center">
        <div class="hero-img bg-overlay" data-overlay="2" style="background-image: url({{ asset($about_banner->image) }});"></div>
        <div class="container">
            <div class="row justify-content-md-center align-items-center text-white py-lg-5">
                <div class="col-md-7">
                    <!-- heading -->
                    <h2 class="">
                        درباره ما
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <div class="section-gap">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-4">
                    <h6>درباره ما</h6>
                    <h2 class="mb-4">ما یک شرکت فروش چند جانبه مستقر در اصفهان هستیم</h2>
                    <p class="text-muted">   {!! $page->body  !!}</p>

                </div>
                <div class="col-sm-8">
                    <img style="width: 300px;height: 200px" src="{{ asset($about_banner->image) }}" alt="">
                </div>

            </div>
        </div>
    </div>
    @endforeach
    <!--about us end-->

{{--        {!! $page->body  !!}--}}


@endsection



