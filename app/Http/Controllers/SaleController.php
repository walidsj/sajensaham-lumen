<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

/** 
 *? Naming convention: index [GET], show [GET], store [POST], update [PUT], destroy [DELETE]
 *  https://stackoverflow.com/questions/59014483/laravel-best-naming-convention-for-controller-method-and-route
 */

class SaleController extends Controller
{
    /**
     ** Retrieve all of data sales.
     * 
     * @return void
     */

    public function index()
    {
        $sales = Sale::all();

        return response()->json([
            'message' => 'Sales found.',
            'data' => $sales
        ]);
    }

    /**
     ** Get an sale data.
     * 
     * @param id
     * @return void
     */

    public function show($id)
    {
        $sale = Sale::findOrFail($id);

        return response()->json([
            'message' => 'A sale found.',
            'data' => $sale
        ]);
    }

    /**
     ** Add an new sale.
     * 
     * @return void
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'package_id' => 'required|numeric',
            'marketing_id' => 'required|numeric',
            'paid_status' => 'in:paid,unpaid',
            'paid_at' => 'date_format:Y-m-dTH:i', // https://stackoverflow.com/questions/50502693/value-of-datetime-input-field-can-not-pass-validation
            'confirm_status' => 'in:confirmed,unconfirmed',
            'paid_img' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $sale = Sale::create($request->all());

        return response()->json([
            'message' => 'Sale successfully added.',
            'data' => $sale
        ]);
    }

    /**
     ** Update an new sale.
     * 
     * @return void
     */

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'numeric',
            'package_id' => 'numeric',
            'marketing_id' => 'numeric',
            'paid_status' => 'in:paid,unpaid',
            'paid_at' => 'date_format:Y-m-dTH:i', // https://stackoverflow.com/questions/50502693/value-of-datetime-input-field-can-not-pass-validation
            'confirm_status' => 'in:confirmed,unconfirmed',
            'paid_img' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update($request->all());

        return response()->json([
            'message' => 'Sale successfully updated.',
            'data' => $sale
        ]);
    }

    /**
     ** Destroy an sale data.
     * 
     * @param id
     * @return void
     */

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete($id);

        return response()->json([
            'message' => 'Sale successfully deleted.',
            'data' => $sale
        ]);
    }
}
