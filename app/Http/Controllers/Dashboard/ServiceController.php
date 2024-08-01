<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ServiceRequest;
use App\Repositories\Contract\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    protected $serviceRepo;

    public function __construct(ServiceRepositoryInterface $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->serviceRepo->getAll();

        return view('dashboard.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services');
        }

        $service = $this->serviceRepo->create($data);

        if ($service) {
            return redirect()->route('admin.services.index')->with('success', __('models.added_success'));
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
        $service = $this->serviceRepo->findOne($id);

        if ($service) {
            return view('dashboard.services.edit', compact('service'));
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
    public function update(ServiceRequest $request, $id)
    {
        $service = $this->serviceRepo->findOne($id);

        $data = $request->except('_token', '_method');

        if ($request->hasFile('image')) {

            Storage::delete($service->image);

            $data['image'] = $request->file('image')->store('services');
        } else {

            $data['image'] = $service->image;
        }

        $service->update($data);

        if ($service) {
            return redirect()->route('admin.services.index')->with('success', __('models.update_success'));
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
        $service = $this->serviceRepo->findOne($request->id);

        if ($service->image) {
            Storage::delete($service->image);
        }

        $service->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
