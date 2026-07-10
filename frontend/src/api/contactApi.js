/**
 * Laravel API との通信をまとめるファイル
 *
 * Blade版では <form action="/confirm" method="post"> がブラウザに送信を任せていました。
 * React版では JavaScript（fetch）が明示的に API を呼び出します。
 */

const API_BASE = import.meta.env.VITE_API_URL ?? 'http://localhost/api';

/**
 * お問い合わせ種別一覧を取得
 * Blade版: ContactController@index が $categories を view に渡していた部分
 */
export async function fetchCategories() {
  const response = await fetch(`${API_BASE}/categories`);

  if (!response.ok) {
    throw new Error('カテゴリの取得に失敗しました');
  }

  const json = await response.json();
  return json.data;
}

/**
 * お問い合わせを送信
 * Blade版: POST /confirm → POST /thanks の代わりに、1回の POST で保存
 *
 * @returns {{ success: true, message: string } | { success: false, errors: object }}
 */
export async function submitContact(formData) {
  const response = await fetch(`${API_BASE}/contacts`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    body: JSON.stringify(formData),
  });

  const json = await response.json();

  // バリデーションエラー（Laravel が 422 + errors を返す）
  if (response.status === 422) {
    return { success: false, errors: json.errors ?? {} };
  }

  if (!response.ok) {
    return {
      success: false,
      errors: { _form: [json.message ?? '送信に失敗しました'] },
    };
  }

  return { success: true, message: json.message };
}
