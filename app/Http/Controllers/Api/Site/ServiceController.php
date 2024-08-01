<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{


    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    public function getByVillage($village_id)
    {
        $services = Service::where('village_id', $village_id)->get();
        return response()->json($services);
    }
}
