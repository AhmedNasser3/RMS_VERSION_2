@extends('frontend.master')

@section('content')
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Edit External Debt</h1>
        <p class="subtitle">Modify the details of this external debt record.</p>
        <form class="contact-form" method="post" action="{{ route('external.debt.update', $debt->id) }}">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-column">
                    <label for="user_id" class="form-label">User</label>
                    <select id="user_id" name="user_id" class="form-input" required>
                        <option value="" disabled>Select a user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $debt->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount"
                           class="form-input" value="{{ $debt->amount }}" required>
                </div>
                <div class="form-column">
                    <label for="recipient" class="form-label">Recipient</label>
                    <input type="text" id="recipient" name="recipient" placeholder="Recipient name"
                           class="form-input" value="{{ $debt->recipient }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea id="reason" name="reason" placeholder="Reason for the debt"
                              class="form-input" rows="4" required>{{ $debt->reason }}</textarea>
                </div>
            </div>
            <button type="submit" class="submit-button">Update</button>
        </form>
    </div>
</div>
@endsection
