@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">
    <div class="auth__heading">
        <div class="auth__title">
            <h1>Register</h1>
        </div>
    </div>
    <div class="auth-card">
        <form action="/register" class="auth-form" method="post" novalidate>
            @csrf
            <div class="auth-form__group">
                <span class="auth-form__label">お名前</span>
                <div class="auth-form__content">
                    <div class="auth-form__input">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="例：山田　太郎">
                    </div>
                    <div class="auth-form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="auth-form__group">
                <span class="auth-form__label">メールアドレス</span>
                <div class="auth-form__content">
                    <div class="auth-form__input">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="例:test@example.com">
                    </div>
                    <div class="auth-form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="auth-form__group">
                <span class="auth-form__label">パスワード</span>
                <div class="auth-form__content">
                    <div class="auth-form__input">
                        <input type="password" name="password" placeholder="例:coachtech1106">
                    </div>
                    <div class="auth-form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="auth-form__button">
                <button class="auth-form__button--submit">
                    登録
                </button>
            </div>
        </form>
    </div>
@endsection