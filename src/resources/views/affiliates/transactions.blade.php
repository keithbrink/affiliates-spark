@extends('affiliates-spark::affiliates.layouts.master')

@section('sub-content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">Transactions</div>

            <div class="card-body">
                <table class="table table-borderless m-b-none">
                    <thead>
                        <th>Transaction Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </thead>

                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr class="{{$transaction->amount < 0 ? 'danger' : 'success'}}">
                            <td>
                                <div class="btn-table-align">
                                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->toDateString() }}
                                </div>
                            </td>
                            <td>
                                <div class="btn-table-align">
                                    {{ $transaction->type }}
                                </div>
                            </td>
                            <td>
                                <div class="btn-table-align">
                                    {{ $transaction->amount }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
