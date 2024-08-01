@component('mail::message')

{{ __('models.reply_from') . ' ' . getSetting('main_name', app()->getLocale()) }}

@component('mail::panel')
    {{ $data }}
@endcomponent
@endcomponent
