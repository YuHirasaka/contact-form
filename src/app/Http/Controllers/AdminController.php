<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::with('category')->paginate(7);

        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $query = Contact::with('category');

        $query->keywordSearch($request->input('keyword'));

        if ($request->filled('gender') && $request->gender !== 'all'){
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->paginate(7)->withQueryString();

        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    public function reset()
    {
        return redirect()->route('admin.index');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'contact_id' => ['required', 'integer', 'exists:contacts,id'],
        ]);

        Contact::where('id', $request->contact_id)->delete();

        return back();
    }

    public function export(Request $request)
    {
        $query = Contact::with('category');

        $query->keywordSearch($request->input('keyword'));

        if ($request->filled('gender') && $request->gender !== 'all'){
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $fileName = 'contacts_' . now()->format('Ymd_His') . '.csv' ;

        $headers = [
            'Content-Type' => 'text/csv; charset=SJIS-win',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        return response()->streamDownload(function() use ($query) {
            $handle = fopen('php://output', 'w');

            $header = ['ID', '性', '名', '性別', 'メールアドレス', '電話番号', '住所', '建物名','カテゴリ', 'お問い合わせ内容', '登録日時'];
            mb_convert_variables('SJIS-win', 'UTF-8', $header);
            fputcsv($handle, $header);

            $query->orderByDesc('created_at')
                ->chunk(100, function($contacts) use ($handle) {
                    foreach ($contacts as $c) {
                        $row = [
                            $c->id,
                            $c->last_name,
                            $c->first_name,
                            $c->gender_label ??$c->gender,
                            $c->email,
                            $c->tel,
                            $c->address,
                            $c->building,
                            optional($c->category)->content,
                            $c->detail,
                            optional($c->created_at)->format('Y-m-d H:i:s'),
                        ];

                        mb_convert_variables('SJIS-win', 'UTF-8', $row); //CSVファイルの文字コードをShift_JISに変換しています。
                        fputcsv($handle, $row);
                    }
                });

            fclose($handle);
        }, $fileName, $headers);
    }
}
