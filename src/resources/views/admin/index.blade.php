@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin">
    <div class="admin__heading">
        <div class="admin__title">
            <h2>Admin</h2>
    </div>

    <form class="admin__search" action="" method="get">
        <div class="admin__search-inner">
            <!--名前、アドレス検索-->
            <input class="admin__input admin__input--text" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください">
            <!--性別検索-->
            <select name="gender" id="gender" class="admin__select admin__select--gender">
                <option value="">性別</option>
                <option value="">全て</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
            <!--カテゴリ検索-->
            <select name="category" id="" class="admin__select admin__select--category">
                <option value="0">お問い合わせの種類</option>
                <option value="1">商品のお届けについて</option>
                <option value="2">商品の交換について</option>
                <option value="3">商品トラブル</option>
                <option value="4">ショップへのお問い合わせ</option>
                <option value="5">その他</option>
            </select>
            <!--日付検索-->
            <input class="admin__input admin__input--date" type="date" name="date" value="年/月/日" id="">
            <!--検索ボタン-->
            <button class="admin__button admin__button--search" type="submit">検索</button>
            <!--リセットボタン-->
            <button class="admin__button admin__button--reset" type="reset">リセット</button>
        </div>
    </form>

    <div class="admin__toolber">
        <a href="" class="admin__button admin__button--export">エクスポート</a>
        <nav class="admin__pagination">
            <!--リンク -->
            <p class="admin__pagination-page">
                < 1.2.3.4.5 >
            </p>
        </nav>
    </div>

    <div class="admin-table">
        <table class="admin-table__inner">
            <thead>
                <tr class="admin-table__row">
                    <th class="admin-table__header">お名前
                    </th>
                    <th class="admin-table__header">性別
                    </th>
                    <th class="admin-table__header">メールアドレス
                    </th>
                    <th class="admin-table__header">お問い合わせの種類
                    </th>
                    <th class="admin-table__header">
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr class="admin-table__row">
                    <td class="admin-table__item">山田 太郎
                    </td>
                    <td class="admin-table__item">男性
                    </td>
                    <td class="admin-table__item">test@example.com
                    </td>
                    <td class="admin-table__item">商品の交換について
                    </td>
                    <td class="admin-table__item">
                        <button class="admin-table__detail-button">詳細</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
