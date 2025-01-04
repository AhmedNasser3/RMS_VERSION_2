@extends('frontend.master')
@section('content'){{-- boxes --}}
<div class="analytics" style="min-height: 100vh;">
    <div class="analytics_container">
        <div class="analytics_content">
            <div class="analytics_data">
                <div class="analytics_title">
                    <h2>التحويلات</h2>
                </div>
                <div class="analytics_boxes">
                        @foreach ($externalDebts as $externalDebt)
                        <div class="analytics_bg">
                            <a href="">
                                <div class="analytics_description">
                                    <h3>دين خارجي</h3>
                                    <p>{{ $externalDebt->currency }}: <span> {{$externalDebt->amount}}</span></p>
                                    <p><span>{{ $externalDebt->reason }}</span>:السبب</p>
                                    <p><span>{{ $externalDebt->recipient }}</span>:المستلم</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    <a href="{{ route('external.debt.create') }}">
                    <div class="analytics_bg" >
                        <div class="analytics_description">
                            <h3 ><i class="fa-solid fa-plus"></i></h3>
                                    <p style="color: rgb(255, 226, 203)">ADD <br> ACCOUNTS</p>
                                </div>
                            </div>
                        </a>
                        </div>
                    </div>
        </div>
    </div>
    <hr style="margin: 5% 0 0 0">
</div>
@extends('frontend.master')
@section('content')
<div class="analytics" style="min-height: 100vh;">
    <div class="analytics_container">
        <div class="analytics_content">
            <div class="analytics_data">
                <div class="analytics_title">
                    <h2>Analytics</h2>
                </div>

                <div class="table-container">
                    <h2 class="table-title">External Debts</h2>
                    <table class="transaction-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Currency</th>
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Recipient</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($externalDebts as $index => $externalDebt)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $externalDebt->currency }}</td>
                                    <td>{{ $externalDebt->amount }}</td>
                                    <td>{{ $externalDebt->reason }}</td>
                                    <td>{{ $externalDebt->recipient }}</td>
                                    <td>
                                        <a href="{{ route('external.debt.edit', $externalDebt->id) }}" class="action-link">Edit</a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="analytics_boxes">
                    <a href="{{ route('external.debt.create') }}">
                        <div class="analytics_bg">
                            <div class="analytics_description">
                                <h3><i class="fa-solid fa-plus"></i></h3>
                                <p style="color: rgb(255, 226, 203)">ADD <br> ACCOUNTS</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <hr style="margin: 5% 0 0 0">
</div>

<style>
    .table-container {
        width: 100%;
        max-width: 1200px;
        padding: 20px;
        background-color: #333;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        overflow-x: auto;
    }

    .table-title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #fff;
        font-weight: 600;
    }

    .transaction-table {
        width: 100%;
        border-collapse: collapse;
        color: #fff;
        table-layout: auto;
    }

    .transaction-table th,
    .transaction-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #444;
        word-wrap: break-word;
    }

    .transaction-table th {
        background-color: #007BFF;
        color: #fff;
        font-weight: bold;
    }

    .transaction-table tr:nth-child(even) {
        background-color: #444;
    }

    .transaction-table tr:hover {
        background-color: #555;
    }

    .action-link {
        color: #28a745;
        text-decoration: none;
    }

    .action-link:hover {
        text-decoration: underline;
    }

    .action-button {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .action-button:hover {
        background-color: #c82333;
    }

    .analytics_boxes {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .analytics_bg {
        width: 200px;
        height: 100px;
        background-color: #007BFF;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        margin: 10px;
    }

    .analytics_description {
        text-align: center;
    }
</style>
@endsection

@endsection
