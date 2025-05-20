<x-mail::message>
# {{$user->first_name}}, recovery your password!

<p>
This is your password recovery CODE:
</p>
<div class="" style="display: flex; justify-content:center; align-items:center; padding: 8px 12px; border:1px solid #f2f2f2e3;margin:10px 0 10px 0;font-size: large; font-weight: bold;">
{{$code}}
</div>
<p>
This code will expire in 5 minutes.
</p>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
