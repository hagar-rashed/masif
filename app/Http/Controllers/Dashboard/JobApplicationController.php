<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\JobApplicationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    protected $jobApplicationRepo;

    public function __construct(JobApplicationRepositoryInterface $jobApplicationRepo)
    {
        $this->jobApplicationRepo = $jobApplicationRepo;
    }

    public function index()
    {
        $applications = $this->jobApplicationRepo->getAll();

        return view('dashboard.job-applications.index', compact('applications'));
    }

    public function deleteMsg(Request $request)
    {
        $application = $this->jobApplicationRepo->findOne($request->id);

        if ($application->file) {
            Storage::delete($application->file);
        }

        $application->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
