@extends('frontend.master')
@section('content'){{-- boxes --}}
<div class="analytics" style="min-height: 100vh;">
    <div class="analytics_container">
        <div class="analytics_content">
            <div class="analytics_data">
                <div class="analytics_title">
                    <h2>Internal Debt Analytics</h2>
                </div>
                <div class="analytics_boxes">

                    @foreach ($internalDebts as $internalDebt)
                    <div class="analytics_bg">
                        <a href="">
                            <div class="analytics_description">
                                <h3>دين داخلي</h3>
                                <p>{{ $internalDebt->currency }}: <span> {{$internalDebt->amount}}</span></p>
                                <p><span>{{ $internalDebt->reason }}</span>:السبب</p>
                                <p><span>{{ $internalDebt->recipient }}</span>:المستلم</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <a href="{{ route('internal.debt.create') }}">
                    <div class="analytics_bg">
                        <div class="analytics_description">
                            <h3 ><i class="fa-solid fa-plus"></i></h3>
                                    <p style="color: rgb(255, 226, 203)">ADD <br> INTERNAL DEBT</p>
                                </div>
                            </div>
                        </a>
                        </div>
                    </div>
        </div>
    </div>
    <hr style="margin: 5% 0 0 0">
</div>
@endsection
