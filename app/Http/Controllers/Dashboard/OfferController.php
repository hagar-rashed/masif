<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationToAllUsers;
use App\Models\Offer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        return view('dashboard.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('dashboard.offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'offer_price' => 'required|',
            'trip_id' => 'required',
        ]);
        try {
            $offer = Offer::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'offer_price' => $request->offer_price,
                'trip_id' => $request->trip_id,
            ]);
            SendNotificationToAllUsers::dispatch($offer);
            return redirect()->route('admin.offers.index')->with(['message' => 'Add Success']);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->route('admin.offers.index')->with(['message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        return view('dashboard.offers.edit', compact('offer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $offer = Offer::findOrFail($id);
        try {
            $offer->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            return redirect()->route('admin.offers.index')->with(['message' => 'Edit Success']);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->route('admin.offers.index')->with(['message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            Offer::findOrFail($id)->delete();
            return redirect()->route('admin.offer.index');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->route('admin.offers.index')->with(['message' => $e->getMessage()]);
        }
    }

    public function getNotifications(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications;
        if ($notifications->isEmpty()) {
            return response()->json(['message' => 'No notifications found'], 404);
        }
        return response()->json($notifications);
        //don't forget to use => php artisan queue:work  
        //to send a notification
    }

    public function markAsRead(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();
        return response()->json(['message' => 'Notifications marked as read']);
    }
}
