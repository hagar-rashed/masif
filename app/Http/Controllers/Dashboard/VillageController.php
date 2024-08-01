<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\VillageRequest;
use App\Repositories\Contract\VallageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageController extends Controller
{
    protected $vallageRepo;

    public function __construct(VallageRepositoryInterface $vallageRepo)
    {
        $this->vallageRepo = $vallageRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $villages = $this->vallageRepo->getAll();

        return view('dashboard.vallages.index', compact('villages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.vallages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VillageRequest $request)
    {
        $data = $request->all();

        $vallage = $this->vallageRepo->create($data);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vallages', 'public');
                $vallage->images()->create([
                    'path' => $path,
                ]);
            }
        }
        if ($vallage) {
            return redirect()->route('admin.villages.index')->with('success', __('models.added_success'));
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
        $village = $this->vallageRepo->findOne($id);

        if ($village) {
            return view('dashboard.vallages.edit', compact('village'));
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
    public function update(VillageRequest $request, $id)
    {
        $village = $this->vallageRepo->findOne($id);

        $data = $request->except('_token', '_method');

        $village->update($data);

        if ($request->hasFile('images')) {
            // Delete existing images
            foreach ($village->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
            // Upload new images
            foreach ($request->file('images') as $image) {
                $path = $image->store('villages', 'public');
                $village->images()->create([
                    'path' => $path,
                ]);
            }
        }

        if ($village) {
            return redirect()->route('admin.villages.index')->with('success', __('models.update_success'));
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
        $village = $this->vallageRepo->findOne($request->id);

        // Delete associated images
        foreach ($village->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $village->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
