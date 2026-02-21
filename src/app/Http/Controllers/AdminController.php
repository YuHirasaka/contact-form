<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
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
}
