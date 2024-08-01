<?php

namespace App\Http\Controllers;
use App\Models\Trip;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $column = [
        'name',
        'location',
        'price',
        'start_date',
        'end_date',
        'duration',
        'desc',
     ];
     public function create ()
     {
        return view('dashboard.trips.search');
     }
    public function search (Request $request)
    {

        $from = $request->input('from');
        $to = $request->input('to');
        $date = $request->input('date');

        // Perform the search query
        $trips = Trip::query();

        if ($from) {
            $trips->where('from', 'LIKE', "%{$from}%");
        }

        if ($to) {
            $trips->where('to', 'LIKE', "%{$to}%");
        }

        if ($date) {
            $trips->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date);
        }

        $trips = $trips->get();

        return view('dashboard.trips.searchResult', compact('trips'));
    }
}