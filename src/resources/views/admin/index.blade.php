@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin">
    <div class="admin__heading">
        <div class="admin__title">
            <h1>Admin</h1>
        </div>
    </div>

    <form class="admin__search" action="/search" method="get">
        <div class="admin__search-inner">
            <input class="admin__input admin__input--text"
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="名前やメールアドレスを入力してください">
            <div class="select-wrapper">
                <select name="gender" class="admin__select admin__select--gender">
                    <option value="" disabled {{ request()->has('gender') ? '' : 'selected'}}>
                    性別
                    </option>
                    <option value="all" {{ request('gender') === 'all' ? 'selected' : '' }}>全て</option>
                    <option value="1" {{ request('gender') == 1 ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ request('gender') == 2 ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ request('gender') == 3 ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div class="select-wrapper">
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
            </div>
            <div class="select-wrapper">
                <input class="admin__input admin__input--date"
                        type="date"
                        name="date"
                        value="{{ request('date') }}">
            </div>
            <button class="admin__button admin__button--search" type="submit">検索</button>
            <a class="admin__button admin__button--reset" href="/reset">リセット</a>
        </div>
    </form>

    <div class="admin__toolbar">
        <a href="{{ route('admin.export', request()->except('page')) }}" class="admin__button--export">エクスポート</a>
        <nav class="admin__pagination">
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
        <div class="modal js-modal" aria-hidden="true"> <!-- aria-hidden="true"はモーダルウィンドウが非表示の場合に設定されます。-->
            <div class="modal__overlay js-close-modal"></div>
            <div class="modal__panel" role="dialog" aria-modal="true"> <!-- aria-modal="true"はモーダルウィンドウが表示されている場合に設定されます。-->
                <button type="button" class="modal__close js-close-modal" aria-label="閉じる">×</button> <!-- aria-label="閉じる"はモーダルウィンドウを閉じるボタンにアクセシビリティラベルを設定しています。-->
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
                        <button type="submit" class="modal__delete">
                        削除
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script> //モーダルウィンドウの操作を行うためのJavaScriptコードです。
        document.addEventListener('DOMContentLoaded', () => {
        const modal = document.querySelector('.js-modal'); //モーダルウィンドウの要素を取得しています。
        if (!modal) return;

        const openButtons = document.querySelectorAll('.js-open-modal'); //モーダルウィンドウを開くボタンの要素を取得しています。
        const closeButtons = document.querySelectorAll('.js-close-modal'); //モーダルウィンドウを閉じるボタンの要素を取得しています。

        const setText = (selector, text) => { //モーダルウィンドウのテキストを設定するための関数です。
            const el = modal.querySelector(selector);
            if (el) el.textContent = text ?? '';
        }; //el.textContent = text ?? '';はテキストを設定するためのコードです。?? ''はテキストが存在しない場合は空文字を返すようにしています。

        const setVal = (selector, val) => { //モーダルウィンドウの値を設定するための関数です。
            const el = modal.querySelector(selector);
            if (el) el.value = val ?? '';
        }; //el.value = val ?? '';は値を設定するためのコードです。?? ''は値が存在しない場合は空文字を返すようにしています。

        const openModal = (btn) => { //モーダルウィンドウを開くための関数です。
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
        }; // modal.classList.add('is-open') と modal.setAttribute('aria-hidden', 'false') はモーダルウィンドウを表示するためのコードです。

        const closeModal = () => { //モーダルウィンドウを閉じるための関数です。
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        }; //modal.classList.remove('is-open');はモーダルウィンドウを非表示にするためのコードです。

        openButtons.forEach(btn => btn.addEventListener('click', () => openModal(btn))); //openModal(btn)はモーダルウィンドウを開くための関数です。
        closeButtons.forEach(btn => btn.addEventListener('click', closeModal)); //closeModal()はモーダルウィンドウを閉じるための関数です。

        document.addEventListener('keydown', (e) => { //エスケープキーを押した場合にモーダルウィンドウを閉じるためのコードです。
            if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
        }); //e.key === 'Escape' && modal.classList.contains('is-open')はエスケープキーを押した場合にモーダルウィンドウを閉じるためのコードです。
        });
        </script>
    </div>
</div>
@endsection
