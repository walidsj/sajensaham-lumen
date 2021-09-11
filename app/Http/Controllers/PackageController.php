<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

/** 
 *? Naming convention: index [GET], show [GET], store [POST], update [PUT], destroy [DELETE]
 *  https://stackoverflow.com/questions/59014483/laravel-best-naming-convention-for-controller-method-and-route
 */

class PackageController extends Controller
{
    /**
     ** Retrieve all of data packages.
     * 
     * @return void
     */

    public function index()
    {
        $packages = Package::all();

        return response()->json([
            'message' => 'Packages found.',
            'data' => $packages
        ]);
    }

    /**
     ** Get an package data.
     * 
     * @param id
     * @return void
     */

    public function show($id)
    {
        $package = Package::findOrFail($id);

        return response()->json([
            'message' => 'A package found.',
            'data' => $package
        ]);
    }

    /**
     ** Add an new package.
     * 
     * @return void
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required|numeric',
            'title' => 'required|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'status' => 'in:active,inactive'
        ]);

        $package = Package::create($request->all());

        return response()->json([
            'message' => 'Package successfully added.',
            'data' => $package
        ]);
    }

    /**
     ** Update an new package.
     * 
     * @return void
     */

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'course_id' => 'numeric',
            'title' => 'max:255',
            'price' => 'numeric',
            'duration' => 'numeric',
            'status' => 'in:active,inactive'
        ]);

        $package = Package::findOrFail($id);
        $package->update($request->all());

        return response()->json([
            'message' => 'Package successfully updated.',
            'data' => $package
        ]);
    }

    /**
     ** Destroy an package data.
     * 
     * @param id
     * @return void
     */

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete($id);

        return response()->json([
            'message' => 'Package successfully deleted.',
            'data' => $package
        ]);
    }
}
