@extends('affiliates-spark::affiliates.layouts.master')

@section('sub-content')
<div class="row">
    <!-- Monthly Recurring Revenue -->
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header text-center">Affiliate Instructions</div>

            <div class="card-body text-center">
                @include('affiliates-spark::affiliates.instructions')
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Monthly Recurring Revenue -->
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header text-center">Monthly Recurring Revenue</div>

            <div class="card-body text-center">
                <div style="font-size: 24px;">
                    {{$monthly_recurring}}
                </div>
            </div>
        </div>
    </div>

    <!-- Yearly Recurring Revenue -->
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header text-center">Yearly Recurring Revenue</div>

            <div class="card-body text-center">
                <div style="font-size: 24px;">
                    {{$yearly_recurring}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Total Volume -->
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header text-center">Total Referrals</div>

            <div class="card-body text-center">
                <span style="font-size: 24px;">
                    {{$referral_count}}
                </span>
            </div>
        </div>
    </div>

    <!-- Total Trial Users -->
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header text-center">Free Plan Users</div>

            <div class="panel-body text-center">
                <span style="font-size: 24px;">
                    {{$free_users}}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Subscribers Per Plan -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">Subscribers</div>

            <div class="card-body">
                <table class="table table-borderless m-b-none">
                    <thead>
                        <th>Name</th>
                        <th>Subscribers</th>
                    </thead>

                    <tbody>
                        @foreach($plans as $plan => $count)
                        <tr>
                            <!-- Plan Name -->
                            <td>
                                <div class="btn-table-align">
                                    {{ $plan }}
                                </div>
                            </td>

                            <!-- Subscriber Count -->
                            <td>
                                <div class="btn-table-align">
                                    {{ $count }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
