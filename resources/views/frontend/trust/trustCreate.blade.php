@extends('frontend.master')

@section('content')
@if ($errors->any())
<div class="error-message" style="color: red; margin-bottom: 20px;">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="form-wrapper_container">
    <div class="form-wrapper">
        <h1 class="title">Create Trust</h1>
        <p class="subtitle">Add a new trust with its details.</p>
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
<div class="form-wrapper_container" style="display: grid; justify-content:center; text-align:center;">
    <h1 class="title"><a href="">انشيئ امانة شخضية اخري</a></h1>
<div class="table-container">
<h2 class="table-title">Transaction History</h2>
<table class="transaction-table">
    <thead>
        <tr>
            <th>العملة</th>
            <th>المبلغ</th>
            <th>سعر الشراء</th>
            <th>الوصف</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $trust)
            <tr>
                <td>{{ $trust->currency }}</td>
                <td>{{ $trust->amount }}</td>
                <td>{{ $trust->buy_amount }}</td>
                <td>{{ $trust->desc }}</td>
            </tr>
            @endforeach
    </tbody>
</table>
</div>
</div>
@endsection
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
