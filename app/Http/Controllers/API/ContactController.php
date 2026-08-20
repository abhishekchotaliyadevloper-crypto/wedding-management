<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\ContactModel;

class ContactController extends Controller
{
    public function index()
    {
        $contact = ContactModel::first();

        if (!$contact) {
            $contact = ContactModel::create([]);
        }

        return response()->json($contact);
    }

    public function update(ContactRequest $request)
    {
        $contact = ContactModel::first();

        if (!$contact) {
            $contact = new ContactModel();
        }

        $contact->fill($request->validated());
        $contact->save();

        return response()->json([
            'message' => 'Contact information updated successfully.',
            'contact' => $contact,
        ]);
    }
}
