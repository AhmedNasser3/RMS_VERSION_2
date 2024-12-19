@extends('frontend.master')
@section('content')
{{--  table  --}}
<div class="form-wrapper_container">
<div class="form-wrapper">
    <h1 class="title">Create Currency</h1>
    <p class="subtitle">Add a new currency to manage your transactions.</p>
    <form class="contact-form" method="post" action="{{ route('currency.store') }}">
        @csrf
        <div class="form-row">
            <div class="form-column">
                <label for="category_id" class="form-label">Category</label>
                <select id="category_id" name="category_id" class="form-input" required>
                    <option value="" disabled selected>Select a category</option>
                    {{-- Assuming $categories is passed to the view --}}
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" style="color: #131313">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-column">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" placeholder="Currency name" class="form-input" required>
            </div>
            <div class="form-column">
                <label for="currency" class="form-label">Currency</label>
                <input type="text" id="currency" name="currency" placeholder="Currency type (e.g., USD)" class="form-input" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-column">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" id="amount" name="amount" placeholder="Enter amount" class="form-input" required>
            </div>
        </div>
        <button type="submit" class="submit-button">Submit</button>
    </form>
</div>
</div>
@endsection
