<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\QRCodeRequest;
use App\Models\QRCode as QRCodeModel; // Rename to avoid confusion
use Illuminate\Http\Request;
use QrCode; // QrCode facade

class QRCodeController extends Controller
{
    public function index()
    {
        $qrcodes = QRCodeModel::all(); // Use QRCodeModel instead of QRCode
        return view('dashboard.qrcodes.index', compact('qrcodes'));
    }

    public function create()
    {
        return view('dashboard.qrcodes.create');
    }
    
    

    // Create a new QR code record
    public function store(QRCodeRequest $request)
    {
    // Create a new QR code record
    $qrCode = new QRCodeModel($request->except('duration')); // Exclude duration field

    // Calculate the duration
    $startingDate = new \DateTime($request->input('starting_date'));
    $expirationDate = new \DateTime($request->input('expiration_date'));
    $duration = $expirationDate->diff($startingDate)->days;
    $qrCode->duration = $duration;

    $qrCode->code = \Str::random(10); // Generate a unique code

    // Handle file upload for photo
    // if ($request->hasFile('photo')) {
    //     $path = $request->file('photo')->store('photos', 'public');
    //     $qrCode->photo = $path;
    // }
    $qrCode->save();

    // Generate QR code image data
    $qrCodeImage = \QrCode::format('png')->size(300)->generate(route('admin.qrcodes.show', $qrCode->id));

    // Define the path to save the QR code image
    $qrPath = 'qrcodes/' . $qrCode->code . '.png';

    // Save the QR code image data to the public disk
    \Storage::disk('public')->put($qrPath, $qrCodeImage);

    // Save the QR code image path to the database
    $qrCode->qr_code = $qrPath;
    $qrCode->save();

    return redirect()->route('admin.qrcodes.index')->with('success', 'QR Code created successfully.');
    }

    public function edit($id)
    {
        $qrcode = QRCodeModel::find($id);


        // Generate the QR code image
        // $qrcodeData = QrCode::size(200)->generate($qrcode->data); // Adjust the `data` attribute as per your model

        return view('dashboard.qrcodes.edit', compact('qrcode'));
    }

    public function update(QRCodeRequest $request, $id)
    {
        $qrcode = QRCodeModel::findOrFail($id);
      //$qrcode->fill($request->all());
    //    $qrcode = $request->validated();
        $qrcode->fill($request->except('duration'));

       // Calculate the duration
        $startingDate = new \DateTime($request->input('starting_date'));
        $expirationDate = new \DateTime($request->input('expiration_date'));
        $duration = $expirationDate->diff($startingDate)->days;
        $qrcode->duration = $duration;

        if ($request->hasFile('qr_code')) {
            // Delete old qr_code if exists
            if ($qrcode->qr_code) {
                \Storage::disk('public')->delete($qrcode->qr_code);
            }

            // Store new qr_code
            $path = $request->file('qr_code')->store('qrcodes', 'public');
            $qrcode->qr_code = $path;
        }

        $qrcode->update();

        return redirect()->route('admin.qrcodes.index')->with('success', __('models.qrcode_updated'));
    }

    public function destroy($id)
    {
        $qrcode = QRCodeModel::findOrFail($id);
        $qrcode->delete();
        
        return redirect()->route('admin.qrcodes.index')->with('success', 'QR Code deleted successfully.');
    }
}
