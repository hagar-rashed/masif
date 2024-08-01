<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\ContactRequest;
use App\Repositories\Contract\ContactRepositoryInterface;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function showForm()
    {
        return view('site.contact');
    }

    public function sendContact(ContactRequest $request)
    {

        $data = $request->except('_token', 'surname', 'firstname');

        $data['fullname'] = $request->firstname . ' ' . $request->surname;

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('contacts');
        }

        $this->contactRepository->create($data);

        return redirect()->back()->with('success', __('models.message_success'));
    }
}
