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
                    <a href="#">
                        <div class="analytics_bg">
                            <div class="analytics_description">
                                <h3>Cash</h3>
                                <p>EGP : <span> 3000</span></p>
                            </div>
                        </a>
                        </div>
                    <div class="analytics_bg">
                        <a href="#">
                        <div class="analytics_description">
                            <h3>Bank</h3>
                            <p>USD : <span> 500</span></p>
                        </div>
                    </a>
                    </div>

                                        <div class="analytics_bg">
                                            <a href="#">
                        <div class="analytics_description">
                            <h3>Cash</h3>
                            <p>MRO : <span> 4250</span></p>
                        </div>
                    </a>
                    </div>

                                        <div class="analytics_bg">
                                            <a href="#">
                        <div class="analytics_description">
                            <h3>Cash</h3>
                            <p>EURO : <span> 700</span></p>
                        </div>
                    </a>
                    </div>

                                        <div class="analytics_bg">
                                            <a href="#">
                        <div class="analytics_description">
                            <h3>Cash</h3>
                            <p>L.E : <span> 10000</span></p>
                        </div>
                    </a>
                    </div>
                                            <a href="#">
                    <div class="analytics_bg" >
                        <div class="analytics_description">
                            <h3 ><i class="fa-solid fa-plus"></i></h3>
                                    <p style="color: rgb(255, 226, 203)">ADD <br> ACCOUNTS</p>
                                </div>
                            </div>
                        </a>
                        </div>
                    </div>
        </div>
    </div>
    <hr style="margin: 5% 0 0 0">
</div>
{{-- subcategories --}}
<div class="subcategories">
    <div class="subcategories_container">
        <div class="subcategories_content">
            <div class="subcategories_data">
                <div class="subcategories_title">
                    <h2>Categories</h2>
                </div>
                <div class="subcategories_bg">
                    <div class="subcategories_description">
                            <a href="#">
                            <h2>Payments</h2>
                            <h3>Bank Payments</h3>
                        </a>
                    </div>
                    <div class="subcategories_description">
                            <a href="#">
                            <h2>Payments</h2>
                            <h3>Bank Payments</h3>
                        </a>
                    </div>
                    <div class="subcategories_description">
                            <a href="#">
                            <h2>Payments</h2>
                            <h3>Bank Payments</h3>
                        </a>
                    </div>
                    <div class="subcategories_description">
                            <a href="#">
                            <h2>Payments</h2>
                            <h3>Bank Payments</h3>
                        </a>
                    </div>
                    <div class="subcategories_description">
                            <a href="#">
                            <h2>Payments</h2>
                            <h3>Bank Payments</h3>
                        </a>
                    </div>
                    <div class="subcategories_description">
                            <a href="#">
                            <h2>Payments</h2>
                            <h3>Bank Payments</h3>
                        </a>
                    </div>
                    <div class="subcategories_description">
                            <a href="#">
                            <h2>Payments</h2>
                            <h3>Bank Payments</h3>
                        </a>
                    </div>
                    <div style="text-align: center" class="subcategories_description">
                            <a href="#">
                            <h2 style="color: #3d3d3d"><i class="fa-solid fa-plus"></i></h2>
                            <h3 style="color: white;font-size:1.2rem">Create</h3>
                        </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
