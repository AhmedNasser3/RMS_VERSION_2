@extends('frontend.master')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<!-- Create Trust Form -->
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">انشاء امانة شخصية</h1>
        <form class="contact-form" method="post" action="{{ route('trusts.store') }}">
            @csrf
            <!-- User ID -->
            <div class="form-row">
                <div class="form-column">
                    <input type="text" id="user_id" hidden value="{{ auth()->user()->id }}" name="user_id" class="form-input" required>
                </div>
            </div>

            <!-- Amount -->
            <div class="form-row">
                <div class="form-column">
                    <label for="amount" class="form-label">المبلغ</label>
                    <input type="text" id="amount" name="amount" placeholder="Enter amount" class="form-input" required>
                </div>
            </div>

            <!-- Currency -->
            <div class="form-row">
                <div class="form-column">
                    <label for="currency" class="form-label">العملة</label>
                    <select id="currency" name="currency" class="form-input" required>
                        <option value="">Select Currency</option>
                        @foreach ($currencies as $currency => $rate)
                            <option style="color: #131313" value="{{ $currency }}">{{ $currency }} ({{ $rate }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Buy Amount -->
            <div class="form-row">
                <div class="form-column">
                    <label for="buy_amount" class="form-label">سعر الشراء</label>
                    <input type="text" id="buy_amount" name="buy_amount" placeholder="Enter buy amount" class="form-input" required>
                </div>
            </div>

            <!-- Description -->
            <div class="form-row">
                <div class="form-column">
                    <label for="desc" class="form-label">الوصف</label>
                    <textarea id="desc" name="desc" placeholder="Enter description" class="form-input"></textarea>
                </div>
            </div>
            <!-- Submit Button -->
            <div class="form-row">
                <div class="form-column">
                    <button type="submit" class="submit-button">انشيئ </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
