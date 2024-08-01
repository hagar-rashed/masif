<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\ReplyContact;
use App\Repositories\Contract\ContactRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        $contacts = $this->contactRepository->getAll();

        return view('dashboard.contact.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = $this->contactRepository->findOne($id);

        if ($contact) {
            return view('dashboard.contact.show', compact('contact'));
        } else {
            return view('dashboard.error');
        }
    }

    public function deleteMsg(Request $request)
    {
        $contact = $this->contactRepository->findOne($request->id);

        if ($contact->file) {
            Storage::delete($contact->file);
        }

        $contact->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }

    public function showReplyForm($id)
    {
        $contact = $this->contactRepository->findOne($id);

        return \view('dashboard.contact.reply', \compact('contact'));
    }

    public function sendReply(Request $request)
    {
        $contact = $this->contactRepository->getWhere(['email' => $request->email])->first();

        if ($contact) {

            $data = $request->input('reply');

            Mail::to($contact->email)->send(new ReplyContact($data));

            return redirect()->route('admin.contacts.show', $contact->id)->with('success', __('models.sent_reply'));
        }
    }
}
