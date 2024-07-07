<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'vendor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validator->errors()], 422);
        }

        if(Product::where('name',$request->name)->first()){
            return response()->json(['status'=>'Error','message'=>'This product already exists.'], 422);
        }

        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => '1',
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json(['status' => 'Error', 'message' => 'Internal server error.'], 500);
        }

        return response()->json(['status' => 'Success', 'message' => $product->name . ' has been stored successfully.'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
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
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
