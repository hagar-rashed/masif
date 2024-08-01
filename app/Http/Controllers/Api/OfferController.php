<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OffersResource;
use App\Models\Offer;
use Exception;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function showOffers(){
        try{
            $offers = OffersResource::collection(Offer::all());
            return response()->json($offers);
        }catch(Exception $e){
            return response()->json([
                'status' => 'Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
