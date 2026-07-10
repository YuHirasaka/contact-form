<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

/**
 * 【API専用コントローラー】
 *
 * Blade版の ContactController とは役割が違います。
 * - return view() の代わりに return response()->json() でデータだけ返す
 * - 画面遷移（redirect）ではなく、HTTPステータスコードで成功/失敗を伝える
 */
class ContactApiController extends Controller
{
    /**
     * お問い合わせ種別の一覧を返す（Reactのセレクトボックス用）
     *
     * Blade版では ContactController@index が $categories を view に渡していました。
     * API版では JSON で同じデータを返します。
     */
    public function categories()
    {
        $categories = Category::all(['id', 'content']);

        return response()->json([
            'data' => $categories,
        ]);
    }

    /**
     * お問い合わせを保存する
     *
     * Blade版の store() + confirm() の「保存部分」に相当します。
     * 確認画面は後回しのため、入力 → 即保存の流れにしています。
     */
    public function store(ContactRequest $request)
    {
        // ContactRequest でバリデーション済みのデータだけ取得
        $validated = $request->validated();

        // DBには電話番号を1つの文字列で保存（Blade版 store() と同じ処理）
        $validated['tel'] = implode('', $validated['tel']);

        Contact::create($validated);

        return response()->json([
            'message' => 'お問い合わせを受け付けました',
        ], 201);
    }
}
