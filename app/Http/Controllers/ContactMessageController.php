<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        return view('dashboard.contact.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if (!$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    
        return view('dashboard.contact.show', compact('message'));
    }
    

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()
            ->route('dashboard.contact.index')
            ->with('success', 'تم حذف الرسالة بنجاح');
    }
}
