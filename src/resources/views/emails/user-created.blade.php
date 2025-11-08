@component('mail::message')

Olá {{ $userName }}, seja Bem-vindo(a)!

@component('mail::button', ['url' => 'https://youtube.com'])
    Acessar
@endComponent

@endComponent