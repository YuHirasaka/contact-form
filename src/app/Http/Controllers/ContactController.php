<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;


class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category')->get();
        $categories = Category::all();

        return view('contact.index', compact('contacts','categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->validated();

        $contact['tel_joined'] = implode('', $contact['tel']);

        $genderLabels = [
            1=>'男性',
            2=>'女性',
            3=>'その他',
        ];

        $contact['gender_label'] = $genderLabels[$contact['gender']] ?? '';

        $category = Category::find($contact['category_id']);

        return view('contact.confirm',compact('contact', 'category'));
    }

    public function store(Request $request)
    {
        if ($request->input('action') === 'back') {
        return redirect()->route('contact.index')
        ->withInput();
        }

        $contact = $request->all();

        $contact['tel'] = implode('', $contact['tel']);

        Contact::create($contact);

        return redirect()->route('contact.thanks');
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}
