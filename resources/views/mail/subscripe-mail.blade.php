@component('mail::message')

@component('mail::panel')
    {{ $data['message'] }}
@endcomponent

@component('mail::button', ['url' => $data['link']])
{{ $data['name'] }}
@endcomponent

@endcomponent
