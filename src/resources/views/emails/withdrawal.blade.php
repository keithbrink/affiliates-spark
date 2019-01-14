@component('mail::message')
# Affiliate Withdrawal Request

@component('mail::table')
| User Email      | Amount Requested | Paypal Email     |
| --------------- |:----------------:| ----------------:|
| {{$user_email}} | {{$amount}}      | {{$paypal_email}}|
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent