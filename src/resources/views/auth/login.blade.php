@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">
    <div class="auth__heading">
        <div class="auth__title">
            <h2>Login</h2>
        </div>
    </div>
    <div class="auth-card">
        <form action="/login" class="auth-form" method="">
            @csrf
            <div class="auth-form__group">
                <span class="auth-form__label">メールアドレス</span>
                <div class="auth-form__content">
                    <div class="auth-form__input">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="例:text@example.com">
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
                <div class="auth-form__group-content">
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
                    ログイン
                </button>
            </div>
        </form>
    </div>
@endsection