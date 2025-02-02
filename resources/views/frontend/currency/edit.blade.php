@extends('frontend.master')
@section('content')
<div class="form-wrapper_container" style="display: grid; justify-content:center; text-align:center;">
    <div class="form-wrapper">
        <h1 class="title">Edit Currency</h1>
        <p class="subtitle">Update the currency details.</p>
        <form class="contact-form" method="post" action="{{ route('currency.update', $currency->id) }}">
            @csrf
            <div class="form-row">
                <div class="form-column">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-input" required>
                        <option value="" disabled>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $currency->category_id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="name" class="form-label">Currency Name</label>
                    <input type="text" id="name" name="name" value="{{ $currency->name }}"
                           placeholder="Currency name" class="form-input" required>
                </div>
                <div class="form-column">
                    <label for="currency" class="form-label">Currency</label>
                    <select id="currency" name="currency" class="form-input" required>
                        @foreach ($currencies as $currencyCode => $rate)
                            <option style="color: #131313" value="{{ $currencyCode }}"
                                {{ $currencyCode == $currency->currency ? 'selected' : '' }}>
                                {{ $currencyCode }} ({{ $rate }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" id="amount" name="amount" value="{{ $currency->amount }}"
                           placeholder="Enter amount" class="form-input" required>
                </div>
            </div>
            <button type="submit" class="submit-button">Update</button>
        </form>
    </div>

    <div class="container">
        <div class="table-container">
            <h2 class="table-title">Transaction History</h2>
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>العملة التي تم شرائها </th>
                        <th>المبلغ من (العملة التي تم شرائها )</th>
                        <th>العملة الخاصة بك انت</th>
                        <th>المبلغ الذي دفعته انت</th>
                        <th>العملة التي استلمتها انت</th>
                        <th>المبلغ الذي استلمته انت</th>
                        <th>سعر الصرف الذي استلمته انت</th>
                        <th>نسبة الربح / الخسارة</th>
                        <th>الربح / الخسارة بالارقام</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{ $DataCurrencies->bank_amount }}</td>
                            <td>{{ $DataCurrencies->amount }}</td>
                            <td>{{ $DataCurrencies->currency }}</td>
                            <td>{{ $DataCurrencies->MRU }}</td>
                            <td>{{ $DataCurrencies->recipient_currency }}</td>
                            <td>{{ $DataCurrencies->recipient_amount }}</td>
                            <td>{{ $DataCurrencies->bank_recipient_amount }}</td>
                            @php
                            $ByPercent = floor(100 - ($DataCurrencies->MRU / $DataCurrencies->recipient_amount) * 100);
                            $ByNum = $DataCurrencies->recipient_amount - $DataCurrencies->MRU;
                        @endphp

                        <td
                            style="color: {{ $ByNum < 0 ? 'red' : 'green' }}">
                            {{ $ByNum }}
                        </td>
                        <td
                            style="color: {{ $ByPercent < 0 ? 'red' : 'green' }}">
                            {{ $ByPercent }}%
                        </td>


                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function updateCurrencyRates() {
        fetch('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/USD')
            .then(response => response.json())
            .then(data => {
                if (data && data.conversion_rates) {
                    const currencies = data.conversion_rates;
                    for (const currencyCode in currencies) {
                        const rateElement = document.getElementById('rate_' + currencyCode);
                        if (rateElement) {
                            rateElement.textContent = currencies[currencyCode];
                        }
                    }
                }
            })
            .catch(error => console.error('Error fetching currency rates:', error));
    }

    window.onload = function() {
        updateCurrencyRates();
        setInterval(updateCurrencyRates, 60000);
    }
</script>
<style>/* أسلوب عام للصفحة */
    /* حاوية الجدول */
    .table-container {
        width: 100%;
        max-width: 1200px; /* الحد الأقصى للعرض */
        padding: 20px;
        background-color: #333;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow-y: auto; /* تمكين التمرير الأفقي عند الحاجة */
        overflow-x: auto; /* تمكين التمرير الأفقي عند الحاجة */
    }

    /* عنوان الجدول */
    .table-title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #fff;
        font-weight: 600;
    }

    /* تنسيق الجدول */
    .transaction-table {
        width: 100%;
        border-collapse: collapse;
        color: #fff;
        table-layout: fixed; /* ضبط عرض الأعمدة بشكل ثابت */
    }

    /* تصميم العناوين والخلية */
    .transaction-table th,
    .transaction-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #444;
        word-wrap: break-word; /* لضمان عدم تكسر النص */
    }

    /* تأثير التمرير على الصفوف */
    .transaction-table tr:nth-child(even) {
        background-color: #444;
    }

    .transaction-table tr:hover {
        background-color: #555;
    }

    /* العناوين (Th) في الجدول */
    .transaction-table th {
        background-color: #007BFF;
        color: #fff;
        font-weight: bold;
    }

    /* تخصيص لون المعاملات حسب النوع */
    .transaction-type.purchase {
        color: #28a745; /* أخضر للشراء */
    }

    .transaction-type.sale {
        color: #dc3545; /* أحمر للبيع */
    }

    /* تنسيق النسبة المئوية للربح والخسارة */
    .profit-loss {
        font-weight: bold;
        font-size: 16px;
    }

    /* إضافة ميديا كويري لتحسين التفاعل على الشاشات الصغيرة */

    /* إذا كانت الشاشة أصغر من 1024px */
    @media (max-width: 1024px) {
        .transaction-table th, .transaction-table td {
            padding: 10px; /* تقليص الحواف في الجداول */
        }

        .table-title {
            font-size: 22px;
        }

        .transaction-table {
            font-size: 14px;
        }
        .table-container {
    overflow-x: auto;
    width: 350px;
    height: max-content;
}
    }

    /* إذا كانت الشاشة أصغر من 768px */
    @media (max-width: 768px) {
        .transaction-table th, .transaction-table td {
            padding: 8px;
        }

        .table-title {
            font-size: 20px;
        }

        .transaction-table {
            font-size: 12px;
        }
        .table-container {
    overflow-x: auto;
    width: 350px;
    height: max-content;
}
    }

    /* إذا كانت الشاشة أصغر من 480px */
    @media (max-width: 480px) {
        .container {
            padding: 0 10px; /* إضافة مسافة حول الحاوية */
        }

        .table-title {
            font-size: 18px;
        }

        .transaction-table th, .transaction-table td {
            padding: 6px;
            font-size: 12px;
        }

        .transaction-table {
            font-size: 10px; /* تقليص حجم النص بشكل أكبر */
        }
        .table-container {
    overflow-x: auto;
    width: 350px;
    height: max-content;
}
    }

    /* تحسين العرض على الشاشات الصغيرة */
    .table-container {
        overflow-x: auto; /* تمكين التمرير الأفقي عند الحاجة */
    }

    .transaction-table {
        min-width: 900px; /* عرض الحد الأدنى لجدول ليتناسب مع الشاشات الصغيرة */
    }
    </style>
@endsection
