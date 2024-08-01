<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Trip;
class TripController extends Controller
{

    private $column = [
       'name',
       'from',
       'to',
       'price',
       'start_date',
       'end_date',
       'duration',
       'desc',
       'passengers'
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
    public function store(Request $request)
    {
        $data = $request->only($this->column);
        Trip::create($data);
        return redirect('trips');
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
    public function update(Request $request, $id)
    {
        $data = $request->only($this->column);
        Trip::where('id',$id)->update($data);
        return redirect('trips');

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