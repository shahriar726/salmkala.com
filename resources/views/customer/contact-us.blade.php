@extends('customer.layouts.master-one-col')

@section('head-tag')
    <title>ارتباط با ما</title>
    <link rel="stylesheet" href="{{ asset('customer-assets/main.css') }}">
@endsection


@section('content')
    <!--page title start-->
    <section class="section-gap section-top bg-gray text-center">
        <div class="hero-img bg-navy-overlay" data-overlay="8" style="background-image: url(assets/img/contact-banner.jpg);"></div>
        <div class="container">
            <div class="row justify-content-md-center align-items-center text-white py-lg-5">
                <div class="col-md-7">
                    <!-- heading -->
                    <h2 class="">
                        تماس با ما
                    </h2>
                </div>
            </div>
        </div>
    </section>
    <!--page title end-->
    <!--intro start-->
    <div class="section-gap">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center mt-5 mb-4" style="text-align: center">
                <div class="col-md-6 mb-lg-5 mb-4">
                    <h2 class="mb-4">ما اینجا هستیم تا به شما کمک کنیم</h2>
                    <p class="text-muted">ما همیشه در کنار مشتریان خود هستیم و به خود می بالیم که مشتریان چون شما داریم!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="blurb blurb-border mb-4">
                        <i class="vl-building text-primary"></i>
                        <h6 class="mb-3">اصفهان</h6>
                        <p>چهارباغ    </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blurb blurb-border mb-4">
                        <i class="vl-envelop2 text-primary"></i>
                        <h6 class="mb-3">آدرس ایمیل </h6>
                        <p>shahriair.vaez@gmail.com</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blurb blurb-border mb-4">
                        <i class="vl-chat text-primary"></i>
                        <h6 class="mb-3">تلفن </h6>
                        <p>09162942830 </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--intro end-->





@endsection
