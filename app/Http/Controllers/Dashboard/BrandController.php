<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandRequest;
use App\Repositories\Contract\BrandRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    protected $brandRepo;

    public function __construct(BrandRepositoryInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brandRepo->getWhere([['type', 'brand']]);

        return view('dashboard.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('brands');
        }

        $data['type'] = 'brand';

        $brand = $this->brandRepo->create($data);

        if ($brand) {
            return redirect()->route('admin.brands.index')->with('success', __('models.added_success'));
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
        $brand = $this->brandRepo->findOne($id);

        if ($brand) {
            return view('dashboard.brands.edit', compact('brand'));
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
    public function update(BrandRequest $request, $id)
    {
        $brand = $this->brandRepo->findOne($id);

        $data = $request->except('_token', '_method');

        if ($request->hasFile('image')) {

            Storage::delete($brand->image);

            $data['image'] = $request->file('image')->store('brands');
        } else {

            $data['image'] = $brand->image;
        }

        $brand->update($data);

        if ($brand) {
            return redirect()->route('admin.brands.index')->with('success', __('models.update_success'));
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
        $brand = $this->brandRepo->findOne($request->id);

        if ($brand->image) {
            Storage::delete($brand->image);
        }

        $brand->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
