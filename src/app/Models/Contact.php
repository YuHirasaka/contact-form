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
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        $keyword = trim((string) $keyword);
        if ($keyword === '') return $query;

        $isExact = preg_match('/^"(.*)"$/u', $keyword, $m) === 1;
        $term = $isExact ? $m[1] : $keyword;

        $termNoSpace = str_replace(['', ' '], '', $term);

        return $query->where(function ($q) use ($isExact, $term, $termNoSpace) {
            if ($isExact) {
                $q->where('last_name', $term)
                ->orWhere('first_name', $term)
                ->orWhere('email', $term)
                ->orWhereRaw("CONCAT(last_name, first_name) = ?", [$termNoSpace]);
            } else {
                $q->where('last_name', 'LIKE', "%{$term}%")
                ->orWhere('first_name', 'LIKE', "%{$term}%")
                ->orWhere('email', 'LIKE', "%{$term}%")
                ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$termNoSpace}%"]);
            }
        });
    }
}
