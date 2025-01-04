@extends('frontend.master')
@section('content')
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Edit User</h1>
        <p class="subtitle">Update User Details.</p>
        <form class="contact-form" method="post" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-column">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        placeholder="Enter user name"
                        class="form-input"
                        required>
                </div>
                <div class="form-column">
                    <label for="cash" class="form-label">Cash</label>
                    <input
                        type="number"
                        step="0.01"
                        id="cash"
                        name="cash"
                        value="{{ old('cash', $user->cash) }}"
                        placeholder="Enter cash amount"
                        class="form-input"
                        required>
                </div>
            </div>
            <div class="form-column">
                <label for="currency" class="form-label">Currency</label>
                <select id="currency" name="currency" class="form-input" required>
                    @foreach($currencies as $currency => $rate)
                        <option style="color: #131313" value="{{ $currency }}" {{ old('currency', $user->currency) == $currency ? 'selected' : '' }}>
                            {{ $currency }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="submit-button">Update</button>
        </form>
    </div>
</div>
@endsection
