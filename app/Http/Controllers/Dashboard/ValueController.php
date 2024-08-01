<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ValueRequest;
use App\Repositories\Contract\ValueRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ValueController extends Controller
{
    protected $valueRepo;

    public function __construct(ValueRepositoryInterface $valueRepo)
    {
        $this->valueRepo = $valueRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = $this->valueRepo->getAll();

        return view('dashboard.values.index', compact('values'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.values.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValueRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('values');
        }

        $value = $this->valueRepo->create($data);

        if ($value) {
            return redirect()->route('admin.values.index')->with('success', __('models.added_success'));
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
        $value = $this->valueRepo->findOne($id);

        if ($value) {
            return view('dashboard.values.edit', compact('value'));
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
    public function update(ValueRequest $request, $id)
    {
        $value = $this->valueRepo->findOne($id);

        $data = $request->except('_token', '_method');

        if ($request->hasFile('image')) {

            Storage::delete($value->image);

            $data['image'] = $request->file('image')->store('values');
        } else {

            $data['image'] = $value->image;
        }

        $value->update($data);

        if ($value) {
            return redirect()->route('admin.values.index')->with('success', __('models.update_success'));
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
        $value = $this->valueRepo->findOne($request->id);

        if ($value->image) {
            Storage::delete($value->image);
        }

        $value->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
