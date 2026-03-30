@component('mail::message')

	Dear {{$user->name}},

	Thanks for signing up a K-Shala account with your email {{$user->email}}.
	Now you can use K-Shala for Course and Test.
	Support Center: {{ env('SUPPORT_URL') }}

We are happy to have you on board,<br>
{{env('APP_NAME', 'Laravel')}} Team
@endcomponent
