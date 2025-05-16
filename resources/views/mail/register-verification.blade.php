<x-mail::message>
# {{$user->first_name}}, your registration needs confirmation.

You created an account in {{config('app.name')}} and you need to confirm the registration of your account, for this, click the button below or copy the paste the verification address in your browser.

<x-mail::button :url="route('auth.verify', ['hash' => $tokenCheck->token])">
Confirm registration
</x-mail::button>

{{route('auth.verify', ['hash' => $tokenCheck->token])}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
