@extends('frontend.master')
@section('content')
<div class="home">
    <div class="home_container">
        <div class="home_content">
            <div class="home_data">
                <div class="home_header">
                    <div class="home_calender_box" style="display: flex;flex-wrap:wrap;gap:1rem">
                        <h2>Good Morning <span>{{ auth()->check() ? auth()->user()->name : 'User' }}</span>👋</h2>
                        <a href="{{ route('coins.index') }}">
                            <div class="home_calender">
                                <h3>العملات</h3>
                            </div>
                        </a>
                        <a href="#">
                        <div class="home_calender">
                            <h3>الامانات</h3>
                        </div>
                        </a>
                        <a href="{{ route('external.debt') }}">
                            <div class="home_calender">
                                <h3>ديون خارجية</h3>
                            </div>
                        </a>
                        <a href="{{ route('internal.debt') }}">
                            <div class="home_calender">
                                <h3>ديون داخلية</h3>
                            </div>
                        </a>
                        <a href="{{ route('trusts.index') }}">
                            <div class="home_calender">
                                <h3>الامانات(استلام شخصي)</h3>
                            </div>
                        </a>
                        <a href="{{ route('trusts.index') }}">
                            <div class="home_calender">
                                <h3>الامانات(امانة)</h3>
                            </div>
                        </a>
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
                            <a href="{{ route('users.edit', ['id' => auth()->user()->id]) }}">
                            <div class="analytics_description">
                                <h3>Cash</h3>
                                <p>{{ auth()->check() ? auth()->user()->currency  : '' }} : <span> {{ auth()->check() ? auth()->user()->cash  : '' }}</span></p>
                            </div>
                        </a>
                        </div>
                        @foreach ($currencies as $currency)
                        <div class="analytics_bg">
                            <a href="{{ route('currency.edit', ['currencyId' => $currency->id]) }}">
                                <div class="analytics_description">
                                    <h3>{{ $currency->name }}</h3>
                                    <p>{{ $currency->currency }}: <span> {{$currency->amount}}</span></p>
                                    <p style="padding: 10px 20px; border:1px solid white;"><a style="color: white;" href="{{ route('currency.delete',['currencyId' => $currency->id]) }}">مسح</a></span></p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    <a href="{{ route('currency.create') }}">
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
                    <h2>الاقسام</h2>
                </div>
                <div class="subcategories_bg">
                    @foreach ($categories as $category)
                    <div class="subcategories_description">
                        <a href="#">
                            <h3 style="color: white;font-size:1.2rem;">{{ $category->title }}</h3>
                            <h3 style="font-size:.8rem;">{{ $category->description }}</h3>
                        </a>
                    </div>
                    @endforeach
                    <div style="text-align: center" class="subcategories_description">
                            <a href="{{ route('category.create') }}">
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
