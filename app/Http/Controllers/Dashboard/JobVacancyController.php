<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\JobVacancyRequest;
use App\Repositories\Contract\JobVacancyRepositoryInterface;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    protected $jobVacancyRepo;

    public function __construct(JobVacancyRepositoryInterface $jobVacancyRepo)
    {
        $this->jobVacancyRepo = $jobVacancyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = $this->jobVacancyRepo->getAll();

        return view('dashboard.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobVacancyRequest $request)
    {
        $data = $request->all();

        $job = $this->jobVacancyRepo->create($data);

        if ($job) {
            return redirect()->route('admin.jobs.index')->with('success', __('models.added_success'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإضافة');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = $this->jobVacancyRepo->findOne($id);

        if ($job) {
            return view('dashboard.jobs.edit', compact('job'));
        } else {
            return view('dashboard.error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobVacancyRequest $request, $id)
    {
        $job = $this->jobVacancyRepo->findOne($id);

        $data = $request->except('_token', '_method');

        $job->update($data);

        if ($job) {
            return redirect()->route('admin.jobs.index')->with('success', __('models.update_success'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التعديل');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $job = $this->jobVacancyRepo->findOne($request->id);

        $job->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
