<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreUnitRequest;
use App\Http\Requests\Dashboard\UpdateUnitRequest;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\UnitImage;
use App\Models\village;
use Illuminate\Support\Facades\Storage;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('images')->get();
        return view('dashboard.units.index', compact('units'));
    }

    public function create()
    {
        $villages=village::get();
        return view('dashboard.units.create',compact('villages'));
    }

    public function store(StoreUnitRequest $request)
    {
        $unit = Unit::create($request->all());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('units', 'public');
                $unit->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.units.index')->with('success', 'Unit created successfully.');
    }


    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $villages=village::get();
        return view('dashboard.units.edit', compact('unit', 'villages'));
    }

    public function update(UpdateUnitRequest $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());

        if ($request->hasFile('images')) {
            // Delete existing images
            foreach ($unit->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
            // Upload new images
            foreach ($request->file('images') as $image) {
                $path = $image->store('units', 'public');
                $unit->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.units.index')->with('success', 'Unit updated successfully.');
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        // Delete associated images
        foreach ($unit->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        $unit->delete();

        return redirect()->route('admin.units.index')->with('success', 'Unit deleted successfully.');
    }
}
