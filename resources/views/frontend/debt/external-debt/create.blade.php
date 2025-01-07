@extends('frontend.master')
@section('content')
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Create External Debt</h1>
        <p class="subtitle">Add a new external debt record with its details.</p>
        <form class="contact-form" method="post" action="{{ route('external.debt.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-column">
                    <label for="user_id" class="form-label">User</label>
                    <select id="user_id" name="user_id" class="form-input" required>
                        <option value="" disabled>Select a user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount"
                           class="form-input" required>
                </div>
                <div class="form-column">
                    <label for="recipient" class="form-label">Recipient</label>
                    <input type="text" id="recipient" name="recipient" placeholder="Recipient name"
                           class="form-input" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea id="reason" name="reason" placeholder="Reason for the debt"
                              class="form-input" rows="4" required></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="currency" class="form-label">Currency</label>
                    <select id="currency" name="currency" class="form-input" required>
                        @foreach ($currencies as $currency => $rate)
                            <option style="color: #131313" value="{{ $currency }}" data-rate="{{ $rate }}">
                                {{ $currency }} ({{ $rate }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="deduction_source" class="form-label">Select Deduction Source</label>
                    <select  id="deduction_source" name="deduction_source" class="form-input" required>
                        <option style="color: #131313" value="cash">Cash</option>
                            <option style="color: #131313" value="currency" data-id="">
                                محافظ
                            </option>
                    </select>
                </div>
            </div>

            <!-- هذا الجزء يجب إظهاره فقط إذا كان الخصم من العملة -->
            <div class="form-row" id="currency_selection" style="display: none;">
                <div class="form-column">
                    <label for="currency_id" class="form-label">Select Minus Currency for Deduction</label>
                    <select id="currency_id" name="currency_id" class="form-input">
                        @foreach ($minus as $currencyMinus)
                            <option value="{{ $currencyMinus->id }}">
                                {{ $currencyMinus->name }} ({{ $currencyMinus->amount }} {{ $currencyMinus->currency }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-row">
                <div class="form-column">
                    <label for="manual_deduction" class="form-label">Manual Deduction (Optional)</label>
                    <input type="number" id="manual_deduction" name="manual_deduction" placeholder="Enter manual exchange rate adjustment"
                           class="form-input" step="0.01">
                </div>
            </div>
            <button type="submit" class="submit-button">Create</button>
        </form>
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deductionSource = document.getElementById("deduction_source");
        const currencySelection = document.getElementById("currency_selection");

        // عند تغيير مصدر الخصم
        deductionSource.addEventListener("change", function() {
            if (deductionSource.value === "currency") {
                currencySelection.style.display = "block"; // إظهار اختيار العملة
            } else {
                currencySelection.style.display = "none"; // إخفاء اختيار العملة
            }
        });

        // إضافة شرط لإخفاء أو إظهار اختيار العملة عند تحميل الصفحة
        if (deductionSource.value === "currency") {
            currencySelection.style.display = "block";
        } else {
            currencySelection.style.display = "none";
        }
    });


</script>
