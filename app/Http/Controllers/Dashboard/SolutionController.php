<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SolutionRequest;
use App\Repositories\Contract\SolutionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SolutionController extends Controller
{
    protected $solutionRepo;

    public function __construct(SolutionRepositoryInterface $solutionRepo)
    {
        $this->solutionRepo = $solutionRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solutions = $this->solutionRepo->getAll();

        return view('dashboard.solutions.index', compact('solutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.solutions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolutionRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('solutions');
        }

        $solution = $this->solutionRepo->create($data);

        if ($solution) {
            return redirect()->route('admin.solutions.index')->with('success', __('models.added_success'));
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
        $solution = $this->solutionRepo->findOne($id);

        if ($solution) {
            return view('dashboard.solutions.edit', compact('solution'));
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
    public function update(SolutionRequest $request, $id)
    {
        $solution = $this->solutionRepo->findOne($id);

        $data = $request->except('_token', '_method');

        if ($request->hasFile('image')) {

            Storage::delete($solution->image);

            $data['image'] = $request->file('image')->store('solutions');
        } else {

            $data['image'] = $solution->image;
        }

        $solution->update($data);

        if ($solution) {
            return redirect()->route('admin.solutions.index')->with('success', __('models.update_success'));
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
        $solution = $this->solutionRepo->findOne($request->id);

        if ($solution->image) {
            Storage::delete($solution->image);
        }

        $solution->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
