<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SectorRequest;
use App\Repositories\Contract\SectorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectorController extends Controller
{
    protected $sectorRepo;

    public function __construct(SectorRepositoryInterface $sectorRepo)
    {
        $this->sectorRepo = $sectorRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectors = $this->sectorRepo->getAll();

        return view('dashboard.sectors.index', compact('sectors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.sectors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectorRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sectors');
        }

        $sector = $this->sectorRepo->create($data);

        if ($sector) {
            return redirect()->route('admin.sectors.index')->with('success', __('models.added_success'));
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
        $sector = $this->sectorRepo->findOne($id);

        if ($sector) {
            return view('dashboard.sectors.edit', compact('sector'));
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
    public function update(SectorRequest $request, $id)
    {
        $sector = $this->sectorRepo->findOne($id);

        $data = $request->except('_token', '_method');

        if ($request->hasFile('image')) {

            Storage::delete($sector->image);

            $data['image'] = $request->file('image')->store('sectors');
        } else {

            $data['image'] = $sector->image;
        }

        $sector->update($data);

        if ($sector) {
            return redirect()->route('admin.sectors.index')->with('success', __('models.update_success'));
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
        $sector = $this->sectorRepo->findOne($request->id);

        if ($sector->image) {
            Storage::delete($sector->image);
        }

        $sector->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }
}
