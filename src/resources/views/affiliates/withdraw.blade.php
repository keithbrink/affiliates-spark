@extends('affiliates-spark::affiliates.layouts.master')

@section('sub-content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">Withdraw Funds</div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header text-center">Current Balance</div>
                        <div class="card-body text-center">
                            <div style="font-size: 24px;">
                                {{$balance}}
                            </div>
                        </div>
                    </div>
                </div>
                @isset($errors)
                @if ($errors->all())
                <div class="col-md-12">
                    <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                        <br>
                    @endforeach
                    </div>
                </div>
                @endif
                @endisset                            
                @if (session()->has('withdrawal_message'))
                <div class="col-md-12">
                    <div class="alert alert-success">                                
                        {{ session('withdrawal_message') }}
                    </div>
                </div>
                @endif
                <p>All withdrawal requests will be processed within 2 business days. Thank you for your partnership!</p>
                <form method="POST">
                    <div class="form-group" style="width:30%">
                        <label for="withdrawalAmount">Withdrawal Amount</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">{{ \Symfony\Component\Intl\Currencies::getSymbol(strtoupper(config('cashier.currency')), config('cashier.currency_locale')) }}</span>
                            </div>
                            <input type="number" name="amount" class="form-control" id="withdrawalAmount" placeholder="Amount" aria-describedby="basic-addon1">
                            <small id="amountHelp" class="form-text text-muted">The minimum withdrawal amount is {{ \Symfony\Component\Intl\Currencies::getSymbol(strtoupper(config('cashier.currency')), config('cashier.currency_locale')) }}10.</small>                        </div>
                    </div>
                    
                    <div class="form-group" style="width:50%">
                        <label for="paypalEmail">Paypal Email</label>
                        <input type="email" class="form-control" id="paypalEmail" name="paypalEmail" placeholder="Email">
                        <small class="form-text text-muted">The email address you would like to withdraw to.</small>
                    </div>
                    <button type="submit" class="btn btn-default">Withdraw</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
