<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandRequest;
use App\Repositories\Contract\BrandRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
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
        $partners = $this->brandRepo->getWhere([['type', 'partner']]);

        return view('dashboard.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.partners.create');
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
            $data['image'] = $request->file('image')->store('partners');
        }

        if ($request->hasFile('media')) {
            $data['media'] = $request->file('media')->store('partners');
        }

        $data['type'] = 'partner';

        $partner = $this->brandRepo->create($data);

        if ($partner) {
            return redirect()->route('admin.partners.index')->with('success', __('models.added_success'));
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
        $partner = $this->brandRepo->findOne($id);

        if ($partner) {
            return view('dashboard.partners.edit', compact('partner'));
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
        $partner = $this->brandRepo->findOne($id);

        $data = $request->except('_token', '_method');

        if ($request->hasFile('image')) {

            Storage::delete($partner->image);

            $data['image'] = $request->file('image')->store('partners');
        } else {

            $data['image'] = $partner->image;
        }

        if ($request->hasFile('media')) {

            Storage::delete($partner->media);

            $data['media'] = $request->file('media')->store('partners');
        } else {

            $data['media'] = $partner->media;
        }

        $partner->update($data);

        if ($partner) {
            return redirect()->route('admin.partners.index')->with('success', __('models.update_success'));
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
        $partner = $this->brandRepo->findOne($request->id);

        if ($partner->image) {
            Storage::delete($partner->image);
        }

        $partner->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
