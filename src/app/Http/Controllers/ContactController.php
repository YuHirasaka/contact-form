<?php

namespace App\Http\Controllers;

use App\Http\requests\ContactRequest;
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
        $tel =  $request->input('phone1') .
                $request->input('phone2') .
                $request->input('phone3');

        $request->merge(['tel' => $tel]);

        $contact = $request->only(['last_name','first_name', 'gender','email', 'tel', 'address','building', 'category_id','detail']);

        $category = Category::find($contact['category_id']);

        return view('contact.confirm',compact('contact', 'category'));
    }

    public function store(ContactRequest $request)
    {
        $contact = $request->only(['last_name','first_name', 'gender','email', 'tel', 'address','building', 'category_id','detail']);

        Contact::create($contact);

        return redirect()->route('contact.thanks');
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}
