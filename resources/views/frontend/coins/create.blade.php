@extends('frontend.master')

@section('content')
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Edit Coin</h1>
        <p class="subtitle">Update the coin details and price.</p>
        <form class="contact-form" method="post" action="{{ route('coins.update', $coin->id) }}">
            @csrf
            @method('PUT') <!-- لتحديد نوع الطلب PUT للتحديث -->

            <div class="form-row">
                <div class="form-column">
                    <label for="coin" class="form-label">Select Coin</label>
                    <select name="coin_id" id="coin" class="form-input" required>
                        @foreach($allCoins as $availableCoin)
                            <option value="{{ $availableCoin->id }}"
                                @if($availableCoin->id == $coin->id) selected @endif>
                                {{ $availableCoin->name }} ({{ $availableCoin->symbol }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="name" class="form-label">Coin Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $coin->name) }}" placeholder="Enter coin name" class="form-input" required>
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
                    <label for="price" class="form-label">Coin Price</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $coin->price) }}" placeholder="Enter coin price" class="form-input" step="0.01" min="0" required>
                </div>
            </div>

            <button type="submit" class="submit-button">Update Coin</button>
        </form>
    </div>
</div>
@endsection
