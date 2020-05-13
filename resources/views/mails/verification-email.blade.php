@component('mail::message')
    # Verification Email

    Verification Email

    @component('mail::button', ['url' => $url])
        Verification Email
    @endcomponent

    Thanks
    {{ config('app.name') }}
@endcomponent
