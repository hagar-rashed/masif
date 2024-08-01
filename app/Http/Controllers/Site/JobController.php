<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\JobApplicationRequest;
use App\Repositories\Contract\JobVacancyRepositoryInterface;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $jobRepo;

    public function __construct(JobVacancyRepositoryInterface $jobRepo)
    {
        $this->jobRepo = $jobRepo;
    }

    public function index()
    {
        $jobs = $this->jobRepo->getAll();

        return view('site.jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = $this->jobRepo->findOne($id);

        return view('site.jobs.show', compact('job'));
    }

    public function apply($id)
    {
        $job = $this->jobRepo->findOne($id);

        return view('site.jobs.apply', compact('job'));
    }

    public function submitJobApplication(JobApplicationRequest $request, $id)
    {
        $job = $this->jobRepo->findOne($id);

        $data = $request->except('_token');

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('job-applications');
        }

        $job->jobApplications()->create($data);

        return redirect()->route('site.jobs.show', $id)->with('success', __('models.job_success'));
    }

    public function internships()
    {
        return view('site.internships.index');
    }
}
