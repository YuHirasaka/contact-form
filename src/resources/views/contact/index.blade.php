@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h1>Contact</h1>
    </div>
    <form action="/confirm" class="form" method="post" novalidate>
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__field form__field--name">
                    <div class="form__item">
                        <input class="form__item-input" type="text" name="last_name" placeholder="例:山田" value="{{ old('last_name') }}">
                        <div class="form__error">
                            @error('last_name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form__item">
                        <input class="form__item-input" type="text" name="first_name" placeholder="例:太郎" value="{{ old('first_name') }}">
                        <div class="form__error">
                            @error('first_name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__radio">
                    <label class="form__radio-item">
                        <input  type="radio" name="gender" value="1" {{ old('gender') == 1 ? 'checked' : '' }}>男性
                    </label>
                    <label class="form__radio-item">
                        <input type="radio" name="gender" value="2" {{ old('gender') == 2 ? 'checked' : '' }}>女性
                    </label>
                    <label class="form__radio-item">
                        <input type="radio" name="gender" value="3" {{ old('gender') == 3 ? 'checked' : '' }}>その他
                    </label>
                </div>
                <div class="form__error">
                    @error('gender')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__item">
                    <input class="form__item-input" type="email" name="email" placeholder="例:test@example.com" value="{{ old('email') }}">
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__field form__field--tel">
                    <input class="form__item-input" type="tel" inputmode="numeric" name="tel[]" placeholder="080" value="{{ old('tel.0') }}">
                    <span class="form__sep">-</span>
                    <input class="form__item-input" type="tel" inputmode="numeric" name="tel[]" placeholder="1234" value="{{ old('tel.1') }}">
                    <span class="form__sep">-</span>
                    <input class="form__item-input" type="tel" inputmode="numeric" name="tel[]" placeholder="5678" value="{{ old('tel.2') }}">
                </div>
                <div class="form__error">
                    @error('tel.*')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__item">
                    <input class="form__item-input" type="text" name="address" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
                </div>
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__item">
                    <input class="form__item-input" type="text" name="building" placeholder="例:千駄ヶ谷マンション101" value="{{ old('building') }}">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__item form__item--select">
                    <select name="category_id" class="form__item-select">
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>選択してください</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('category_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__item">
                    <textarea class="form__item-textarea" name="detail" id="" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                </div>
                <div class="form__error">
                    @error('detail')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__actions">
            <button type="submit" class="form__button form__button--submit">確認画面</button>
        </div>
    </form>
</div>
@endsection