@extends('frontend.master')

@section('content')
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Create Currency</h1>
        <p class="subtitle">Add a new currency with its details.</p>
        <form class="contact-form" method="post" action="{{ route('currency.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-column">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-input" required>
                        <option value="" disabled>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="name" class="form-label">Currency Name</label>
                    <input type="text" id="name" name="name" placeholder="Currency name"
                           class="form-input" required>
                </div>
                <div class="form-column">
                    <label for="currency" class="form-label">Currency</label>
                    <select id="currency" name="currency" class="form-input" required>
                        @foreach ($currencies as $currency => $rate)
                            <option style="color: #131313" value="{{ $currency }}">
                                {{ $currency }} ({{ $rate }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- إضافة حقل MRU غير قابل للتغيير -->
            <div class="form-row">
                <div class="form-column">
                    <label for="mru" class="form-label">MRU (Fixed)</label>
                    <input type="text" id="mru" name="mru" class="form-input" value="MRU" disabled>
                </div>
            </div>
            <!-- إضافة حقل Recipient Amount -->
            <div class="form-row">
                <div class="form-column">
                    <label for="recipient_amount" class="form-label">Recipient Amount</label>
                    <input type="number" id="recipient_amount" name="recipient_amount" placeholder="Enter recipient amount"
                           class="form-input" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="manual_exchange_rate">Manual Exchange Rate (optional)</label>
                        <input
                        type="number"
                        class="form-control"
                        id="manual_exchange_rate"
                        name="manual_exchange_rate"
                        value="{{ old('manual_exchange_rate', $currency->manual_exchange_rate ?? '') }}"
                        placeholder="Enter Manual Exchange Rate"
                        step="any">
                                        </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount"
                           class="form-input" required>
                </div>
            </div>
            <button type="submit" class="submit-button">Create</button>
        </form>
    </div>
</div>
@endsection
