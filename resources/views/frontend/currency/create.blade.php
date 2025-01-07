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

<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Create Currency</h1>
        <p class="subtitle">Add a new currency with its details.</p>
        <form class="contact-form" method="post" action="{{ route('currency.store') }}">
            @csrf

            <div class="form-row">
                <div class="form-column">
                    <label for="category_id" class="form-label">الاقسام</label>
                    <select id="category_id" name="category_id" class="form-input" required>
                        <option value="" >اختر قسم</option>
                        @foreach ($categories as $category)
                            <option style="color: #131313" value="{{ $category->id }}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- المبالغ -->
            <div class="form-row">
                <div class="form-column">
                    <label for="name" class="form-label">اسم هذه الفاتورة</label>
                    <input type="text" id="name" name="name" placeholder="Currency name" class="form-input" required>
                </div>
                <div class="form-column">
                    <label for="recipient_amount" class="form-label">المبلغ المستلم (الخانة الاولي)</label>
                    <input type="number" id="recipient_amount" name="recipient_amount" placeholder="Enter recipient amount" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="bank_recipient_amount" class="form-label">سعر الصرف المستلم</label>
                    <input type="number" id="bank_recipient_amount" name="bank_recipient_amount" placeholder="Enter recipient amount" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="amount" class="form-label">المبلغ المراد شرائه من العملة (الخانة الثانية)</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount" class="form-input" required readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="manual_exchange_rate" class="form-label">سعر الصرف الذي تريده</label>
                    <input type="number" id="manual_exchange_rate" name="manual_exchange_rate" placeholder="Enter Manual Exchange Rate" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="egp" class="form-label">egp (الخانة الثالثة)</label>
                    <input type="number" id="egp" name="egp" class="form-input" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="sale_exchange_rate" class="form-label">سعر صرف البياع</label>
                    <input type="number" id="sale_exchange_rate" name="sale_exchange_rate" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="usd_amount" class="form-label">المبلغ بالدولار (الخانة الرابعة)</label>
                    <input type="number" id="usd_amount" name="usd_amount" class="form-input" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="mohamed_exchange_rate" class="form-label">سعر الصرف باللؤية الي استاذ محمد هيدفعه</label>
                    <input type="number" id="mohamed_exchange_rate" name="mohamed_exchange_rate" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <label for="mru" class="form-label">المبلغ الذي ستحوله انت (الخانة الخامسة)</label>
                    <input type="number" id="mru" name="mru" class="form-input" readonly>
                </div>
            </div>

            <!-- المكسب -->
            <div class="form-row">
                <div class="form-column">
                    <label for="profit" class="form-label">المكسب</label>
                    <input type="number" id="profit" name="profit" class="form-input" readonly>
                </div>
            </div>

            <div class="form-column">
                <label for="currency" class="form-label">العملة التي ستحولها لشراء المبلغ المطلوب</label>
                <select id="currency" name="currency" class="form-input" required>
                    @foreach ($currencies as $currency => $rate)
                        <option style="color: #131313" value="{{ $currency }}">
                            {{ $currency }} ({{ $rate }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-column">
                <label for="recipient_currency" class="form-label">العملة المستلمة</label>
                <select id="recipient_currency" name="recipient_currency" class="form-input" required>
                    @foreach ($currencies as $currency => $rate)
                        <option style="color: #131313" value="{{ $currency }}">
                            {{ $currency }} ({{ $rate }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="submit-button">Create</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const recipientAmount = document.getElementById('recipient_amount');
    const bankRecipientAmount = document.getElementById('bank_recipient_amount');
    const amount = document.getElementById('amount');
    const manualExchangeRate = document.getElementById('manual_exchange_rate');
    const egp = document.getElementById('egp');
    const saleExchangeRate = document.getElementById('sale_exchange_rate');
    const usdAmount = document.getElementById('usd_amount');
    const mohamedExchangeRate = document.getElementById('mohamed_exchange_rate');
    const mru = document.getElementById('mru');
    const profit = document.getElementById('profit');

    function updateCalculations() {
        let recipientAmountVal = parseFloat(recipientAmount.value) || 0;
        let bankRecipientAmountVal = parseFloat(bankRecipientAmount.value) || 1;
        let manualExchangeRateVal = parseFloat(manualExchangeRate.value) || 1;
        let saleExchangeRateVal = parseFloat(saleExchangeRate.value) || 1;
        let mohamedExchangeRateVal = parseFloat(mohamedExchangeRate.value) || 1;

        // حساب المبلغ المراد شرائه من العملة
        let calculatedAmount = recipientAmountVal / bankRecipientAmountVal;
        amount.value = calculatedAmount.toFixed(2);

        // حساب الـEGP
        let egpValue = calculatedAmount * manualExchangeRateVal;
        egp.value = egpValue.toFixed(2);

        // حساب المبلغ بالدولار
        let usdAmountVal = egpValue / saleExchangeRateVal;
        usdAmount.value = usdAmountVal.toFixed(2);

        // حساب المبلغ الذي ستحوله
        let mruVal = usdAmountVal * mohamedExchangeRateVal;
        mru.value = mruVal.toFixed(2);

        // حساب المكسب
        let profitVal = recipientAmountVal - mruVal;
        profit.value = profitVal.toFixed(2);
    }

    // إضافة حدث التغيير لجميع الحقول
    recipientAmount.addEventListener('input', updateCalculations);
    bankRecipientAmount.addEventListener('input', updateCalculations);
    manualExchangeRate.addEventListener('input', updateCalculations);
    saleExchangeRate.addEventListener('input', updateCalculations);
    mohamedExchangeRate.addEventListener('input', updateCalculations);
});
</script>
@endsection
