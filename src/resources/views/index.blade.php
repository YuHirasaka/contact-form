@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>お問い合わせ</h2>
    </div>
    <form action="/contacts/confirm" class="form" method="POST">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">必須</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" placeholder="テスト太郎" value="{{ old('name') }}"/>
                </div>
                <div class="form__error">
                    <!-- エラーメッセージが入ります -->
                        @error('name')
                        {{ $message }}
                        @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">必須</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="test@example.com"  value="{{ old('email') }}"/>
                </div>
                <div class="form__error">
                    <!-- エラーメッセージが入ります -->
                        @error('email')
                        {{ $message }}
                        @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">必須</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="tel" name="tel" placeholder="09012345678" value="{{ old('tel') }}"/>
                </div>
                <div class="form__error">
                    <!-- エラーメッセージが入ります -->
                        @error('tel')
                        {{ $message }}
                        @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="content" id="" placeholder="資料をいただきたいです"></textarea>
                </div>
            </div>
        </div>
        <div class="form__button">
            <button type="submit" class="form__button-submit">送信</button>
        </div>
    </form>
</div>
@endsection