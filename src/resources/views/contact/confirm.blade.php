@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/confirm.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="confirm__content">
    <div class="confirm__heading">
        <h1>Confirm</h1>
    </div>
    <form action="/thanks" class="form" method="POST">
        @csrf
        <div class="confirm-table">
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text confirm-table__name">
                        <span class="confirm-table__value">
                            {{ $contact['last_name']}}
                        </span>
                        <span class="confirm-table__value">
                            {{ $contact['first_name']}}
                        </span>
                        <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
                        <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        <span class="confirm-table__value">
                            {{ $contact['gender_label'] }}
                        </span>
                        <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        <span class="confirm-table__value">
                            {{ $contact['email'] }}
                        </span>
                        <input type="hidden" name="email" value="{{ $contact['email'] }}">
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__text">
                        <span class="confirm-table__value">
                            {{ $contact['tel_joined'] }}
                        </span>
                        @foreach ($contact['tel'] as $i => $part)
                            <input type="hidden" name="tel[{{ $i }}]" value="{{ $part }}">
                        @endforeach
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        <span class="confirm-table__value">
                            {{ $contact['address' ]}}
                        </span>
                        <input type="hidden" name="address" value="{{ $contact['address']}}">
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        <span class="confirm-table__value">
                            {{ $contact['building' ]}}
                        </span>
                        <input type="hidden" name="building" value="{{ $contact['building']}}">
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">
                        <span class="confirm-table__value">
                            {{ $category->content }}
                        </span>
                        <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ内容</th>
                    <td class="confirm-table__text">
                        <span class="confirm-table__value">
                            {!! nl2br(e($contact['detail'])) !!}
                        </span>
                        <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
                    </td>
                </tr>
            </table>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit" name="action" value="submit">送信</button>
            <button class="form__button-back" type="submit" name="action" value="back">修正</button>
        </div>
    </form>
</div>
@endsection
