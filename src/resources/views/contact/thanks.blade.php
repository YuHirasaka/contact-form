@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<section class="thanks">
    <div class="thanks__bg">
        <h1>Thank you</h1>
    </div>

    <div class="thanks__content">
        <p class="thanks__message">
            お問い合わせありがとうございました
        </p>
        <a href="/" class="thanks__btn">HOME</a>
    </div>
</section>
@endsection