<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getGenderLabelAttribute()
    {
        return [
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        ][$this->gender] ?? '';
    } //性別の数値（1・2・3）を「男性・女性・その他」という文字列に変換しています。[$this->gender]で配列から該当する値を取得し、?? ''で存在しない値だった場合は空文字を返すようにしています。

    public function scopeKeywordSearch($query, $keyword)
    {
        $keyword = trim((string) $keyword); // キーワードをトリムして余分な余白を削除
        if ($keyword === '') return $query;

        $isExact = preg_match('/^"(.*)"$/u', $keyword, $m) === 1; // キーワードが引用符で囲まれているかどうかをチェック
        $term = $isExact ? $m[1] : $keyword; // キーワードが引用符で囲まれている場合は引用符を削除

        $termNoSpace = str_replace(['', ' '], '', $term); // キーワードから余分な余白を削除

        return $query->where(function ($q) use ($isExact, $term, $termNoSpace) {
            if ($isExact) {
                $q->where('last_name', $term) // 姓を完全一致するものを検索
                ->orWhere('first_name', $term) // 名を完全一致するものを検索
                ->orWhere('email', $term) // メールを完全一致するものを検索
                ->orWhereRaw("CONCAT(last_name, first_name) = ?", [$termNoSpace]); // 姓と名を結合して完全一致するものを検索
            } else {
                $q->where('last_name', 'LIKE', "%{$term}%") // 姓を部分一致するものを検索
                ->orWhere('first_name', 'LIKE', "%{$term}%") // 名を部分一致するものを検索
                ->orWhere('email', 'LIKE', "%{$term}%") // メールを部分一致するものを検索
                ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$termNoSpace}%"]); // 姓と名を結合して部分一致するものを検索
            }
        });
    }
}
