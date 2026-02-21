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
    </div>

    <form class="admin__search" action="/search" method="get">
        <div class="admin__search-inner">
            <!--名前、アドレス検索-->
            <input class="admin__input admin__input--text"
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="名前やメールアドレスを入力してください">
            <!--性別検索-->
            <select name="gender" class="admin__select admin__select--gender">
                <option value="" disabled {{ request()->has('gender') ? '' : 'selected'}}>
                性別
                </option>
                <option value="all" {{ request('gender') === 'all' ? 'selected' : '' }}>全て</option>
                <option value="1" {{ request('gender') == 1 ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender') == 2 ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender') == 3 ? 'selected' : '' }}>その他</option>
            </select>
            <!--カテゴリ検索-->
            <select name="category_id" class="admin__select admin__select--category">
                <option value="" disabled {{ request()->has('category_id') ? '' : 'selected' }}>お問い合わせの種類</option>
                <option value="all" {{ request('category_id') === 'all' ? 'selected' : '' }}>全て</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
                @endforeach
            </select>
            <!--日付検索-->
            <input class="admin__input admin__input--date"
                    type="date"
                    name="date"
                    value="(( request('date') }}">
            <!--検索ボタン-->
            <button class="admin__button admin__button--search" type="submit">検索</button>
            <!--リセットボタン-->
            <a class="admin__button admin__button--reset" href="/reset">リセット</a>
        </div>
    </form>

    <div class="admin__toolber">
        <a href="" class="admin__button admin__button--export">エクスポート</a>
        <nav class="admin__pagination">
            <!--リンク -->
            <div class="admin__pagination-page">
                {{ $contacts->links() }}
            </div>
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
            @foreach ($contacts as $contact)
            <tbody>
                <tr class="admin-table__row">
                    <td class="admin-table__item">
                        {{ $contact->last_name }}
                        {{ $contact->first_name }}
                    </td>
                    <td class="admin-table__item">{{ $contact->gender_label }}
                    </td>
                    <td class="admin-table__item">{{ $contact->email }}
                    </td>
                    <td class="admin-table__item">{{ $contact->category->content }}
                    </td>
                    <td class="admin-table__item">
                        <button class="admin-table__detail-button js-open-modal"
                        data-id="{{ $contact->id }}"
                        data-name="{{ $contact->last_name }} {{ $contact->first_name}}"
                        data-gender="{{ $contact->gender_label }}"
                        data-email="{{ $contact->email }}"
                        data-tel="{{ $contact->tel }}"
                        data-address="{{ $contact->address }}"
                        data-building="{{ $contact->building }}"
                        data-category="{{ $contact->category->content }}"
                        data-detail="{{ $contact->detail }}"
                        >詳細</button>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
        <div class="modal js-modal" aria-hidden="true">
            <div class="modal__overlay js-close-modal"></div>
            <div class="modal__panel" role="dialog" aria-modal="true">
                <button type="button" class="modal__close js-close-modal" aria-label="閉じる">×</button>
                <dl class="modal__list">
                    <div class="modal__row">
                        <dt class="modal__term">お名前</dt>
                        <dd class="modal__desc js-modal-name"></dd>
                    </div>
                    <div class="modal__row">
                        <dt class="modal__term">性別</dt>
                        <dd class="modal__desc js-modal-gender"></dd>
                    </div>
                    <div class="modal__row">
                        <dt class="modal__term">メールアドレス</dt>
                        <dd class="modal__desc js-modal-email"></dd>
                    </div>
                    <div class="modal__row">
                        <dt class="modal__term">電話番号</dt>
                        <dd class="modal__desc js-modal-tel"></dd>
                    </div>
                    <div class="modal__row">
                        <dt class="modal__term">住所</dt>
                        <dd class="modal__desc js-modal-address"></dd>
                    </div>
                    <div class="modal__row">
                        <dt class="modal__term">建物名</dt>
                        <dd class="modal__desc js-modal-building"></dd>
                    </div>
                    <div class="modal__row">
                        <dt class="modal__term">お問い合わせの種類</dt>
                        <dd class="modal__desc js-modal-category"></dd>
                    </div>
                    <div class="modal__row modal__row--detail">
                        <dt class="modal__term">お問い合わせ内容</dt>
                        <dd class="modal__desc modal__desc--detail js-modal-detail"></dd>
                    </div>
                </dl>
                <div class="modal__actions">
                    <form action="/delete" method="post">
                        @csrf
                        <input type="hidden" name="contact_id" class="js-modal-contact-id">
                        <button type="submit" class="modal__delete"
                                onclick="return confirm('このデータを削除しますか？');">
                        削除
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
        const modal = document.querySelector('.js-modal');
        if (!modal) return;

        const openButtons = document.querySelectorAll('.js-open-modal');
        const closeButtons = document.querySelectorAll('.js-close-modal');

        const setText = (selector, text) => {
            const el = modal.querySelector(selector);
            if (el) el.textContent = text ?? '';
        };

        const setVal = (selector, val) => {
            const el = modal.querySelector(selector);
            if (el) el.value = val ?? '';
        };

        const openModal = (btn) => {
            setText('.js-modal-name', btn.dataset.name);
            setText('.js-modal-gender', btn.dataset.gender);
            setText('.js-modal-email', btn.dataset.email);
            setText('.js-modal-tel', btn.dataset.tel);
            setText('.js-modal-address', btn.dataset.address);
            setText('.js-modal-building', btn.dataset.building);
            setText('.js-modal-category', btn.dataset.category);
            setText('.js-modal-detail', btn.dataset.detail);
            setVal('.js-modal-contact-id', btn.dataset.id);

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
        };

        const closeModal = () => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        };

        openButtons.forEach(btn => btn.addEventListener('click', () => openModal(btn)));
        closeButtons.forEach(btn => btn.addEventListener('click', closeModal));

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
        });
        });
        </script>
    </div>
</div>
@endsection
