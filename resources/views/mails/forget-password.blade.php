@component('mail::message')
    # forget password

    Reset Password

    @component('mail::button', ['url' => $url])
        Link Reset
    @endcomponent

    Thanks
    {{ config('app.name') }}
@endcomponent
