@extends('frontend.master')
@section('content')
<div class="home">
    <div class="home_container">
        <div class="home_content">
            <div class="home_data">
                <div class="home_header">
                    <div class="home_calender_box">
                        <h2>Good Morning <span>{{ auth()->check() ? auth()->user()->name : 'User' }}</span>👋</h2>
                        <div class="home_calender">
                            <h3>Month</h3>
                            <i class="fa-solid fa-arrow-down-long"></i>                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- boxes --}}
<div class="analytics">
    <div class="analytics_container">
        <div class="analytics_content">
            <div class="analytics_data">
                <div class="analytics_title">
                    <h2>Analytics</h2>
                </div>
                <div class="analytics_boxes">
                    <div class="analytics_bg">
                        <div class="analytics_description">
                            <h3>Cash</h3>
                            <p>EGP : 3000</p>
                        </div>
                    </div>
                    <div class="analytics_bg">
                        <div class="analytics_description">
                            <h3>Bank</h3>
                            <p>USD : 500</p>
                        </div>
                    </div>
                    <div class="analytics_bg">
                        <div class="analytics_description">
                            <h3>Cash</h3>
                            <p>MRO : 4250</p>
                        </div>
                    </div>
                    <div class="analytics_bg">
                        <div class="analytics_description">
                            <h3>Cash</h3>
                            <p>EURO : 700</p>
                        </div>
                    </div>
                    <div class="analytics_bg">
                        <div class="analytics_description">
                            <h3>Cash</h3>
                            <p>L.E : 10000</p>
                        </div>
                    </div>
                    <div class="analytics_bg">
                        <div class="analytics_description">
                            <h3 >
                                <a href="#">
                                    <i class="fa-solid fa-plus"></i></h3>
                                </a>
                            <p>ADD <br> ACCOUNTS</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
