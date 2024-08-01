<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use Illuminate\Http\Request;
use App\Models\Trip;
class TripController extends Controller
{

    private $column = [
       'name_ar',
       'name_en',
       'location_ar',
       'location_en',
       'desc_ar',
       'desc_en',
       'price',
       'start_date',
       'end_date',
       'duration',
    ];
    public function index()
    {
        $trips = Trip::get();
        return view('dashboard.trips.index', compact('trips'));
    }

    public function create()
    {
        return view('dashboard.trips.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TripRequest $request)
    {
        $data = $request->only($this->column);
        Trip::create($data);
        return redirect('tripIndex');
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
        $trip = Trip::findOrFail($id);
        return view('dashboard.trips.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TripRequest $request, $id)
    {
        $data = $request->only($this->column);
        Trip::where('id',$id)->update($data);
        return redirect('tripIndex');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      //  Trip::where("id",$id)->delete();
      Trip::destroy($id);
        return redirect('tripIndex');
    }
}