@component('mail::message')
{{ __(':team チームに招待されました!', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('アカウントをお持ちでない場合は、以下のボタンをクリックして作成できます。アカウントを作成した後、このメールの承諾ボタンをクリックして、チームに参加することができます') }}

@component('mail::button', ['url' => route('register')])
{{ __('アカウントを作成する') }}
@endcomponent

{{ __('アカウントを作成済みの場合、以下のボタンをクリックしてチームに参加してください') }}

@else
{{ __('ボタンをクリックしてチームに参加してください') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('チームに参加する') }}
@endcomponent

{{ __('このメールに心当たりがない場合このメールは無視してください') }}
@endcomponent