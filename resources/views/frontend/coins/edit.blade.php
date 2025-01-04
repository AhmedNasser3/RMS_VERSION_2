@extends('frontend.master')

@section('content')
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Edit Coin</h1>
        <p class="subtitle">Update the coin details and price.</p>
        <form class="contact-form" method="post" action="{{ route('coins.update', $coin->id) }}">
            @csrf
            @method('PUT') <!-- تحديد نوع الطلب PUT للتحديث -->

            <div class="form-row">
                <div class="form-column">
                    <label for="name" class="form-label">Coin Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $coin->name) }}" placeholder="Enter coin name" class="form-input" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $coin->full_name) }}" placeholder="Enter full name of the coin" class="form-input" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="symbol" class="form-label">Coin Symbol</label>
                    <input type="text" id="symbol" name="symbol" value="{{ old('symbol', $coin->symbol) }}" placeholder="Enter coin symbol" class="form-input" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $coin->price) }}" placeholder="Enter coin price" class="form-input" step="0.01" min="0">
                    @if(!$coin->price)
                        <small class="form-text">Price will be fetched from API if not provided.</small>
                    @endif
                </div>
            </div>
            <button type="submit" class="submit-button">Update Coin</button>
        </form>
    </div>
</div>
@endsection
