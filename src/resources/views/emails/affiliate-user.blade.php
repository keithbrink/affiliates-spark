@component('mail::message')
# Affiliate Account Approved

Congratulations, your affiliate account with {{ config('app.name') }} has been approved. It's great to be working with you.

You can now access your affiliate dashboard at the following URL:

[{{url('/affiliates')}}]({{url('/affiliates')}})

Your login information is:

- **Username:** {{$user_email}}
- **Password:** {{$password}}

Note that it is a good security practice to change your password when you first login.

If you have any questions, don't hesistate to reach out!

Thanks,<br>
{{ config('app.name') }}
@endcomponent