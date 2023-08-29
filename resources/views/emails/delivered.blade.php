@component('mail::message')
# Your Package Has Been Delivered

Hello {{ $product->user->name }},

Your package with tracking number {{ $product->tracking_number }} has been delivered.

Thank you for using our services.

@component('mail::button', ['url' => url('/')])
Visit Our Website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
