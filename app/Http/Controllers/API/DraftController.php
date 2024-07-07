<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AssignCustomer;
use App\Models\Draft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DraftController extends Controller
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
        $authUser = Auth::user();
        $data['draft'] = AssignCustomer::with(['draft.productPrice.product', 'draft.productPrice.variant', 'assignCustomer'])
            ->where('vendor_id', $authUser->vendor_id)
            ->select(['id', 'vendor_id', 'customer_id'])
            ->get();

        return response()->json(['status' => 'Success', 'message' => $data], 200);
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
            'customer_id' => 'required|numeric',
            'bill.*.product_price_id' => 'required|numeric',
            'bill.*.quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validator->errors()], 422);
        }

        $authUser = Auth::user();
        $assignCustomer = AssignCustomer::where('vendor_id', $authUser->vendor_id)->where('customer_id', $request->customer_id)->first();

        $bills = $request->bill;
        $bulkDraft = [];

        foreach ($bills as $item) {
            $productPriceId = $item['product_price_id'];
            $quantity = $item['quantity'];
            $found = false;

            foreach ($bulkDraft as &$draft) {
                if ($draft['product_price_id'] == $productPriceId) {
                    $draft['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $bulkDraft[] = [
                    'assign_customer_id' => $assignCustomer->id,
                    'product_price_id' => $productPriceId,
                    'quantity' => $quantity,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        unset($draft);

        $existDraft = Draft::where('assign_customer_id', $assignCustomer->id)->get();
        if (!$existDraft->isEmpty()) {
            foreach ($existDraft as $key => $item) {
                if ($item->product_price_id == $bulkDraft[$key]['product_price_id']) {
                    $itemquantity = $item->quantity + $bulkDraft[$key]['quantity'];
                    $item->update(['quantity' => $itemquantity]);
                    unset($bulkDraft[$key]);
                } else {
                    Draft::insert($bulkDraft);
                }
            }
        } else {
            Draft::insert($bulkDraft);
        }

        $data['draft'] = Draft::with('assignCustomer.assignCustomer', 'productPrice.product', 'productPrice.variant')->where('assign_customer_id', $assignCustomer->id)->get();

        return response()->json(['status' => 'Success', 'message' => $data], 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    /**
     * Clear the draft of the customer by setting the status to 0
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clearDraft(Request $request)
    {
        $authUser = Auth::user();
        $assignCustomer = AssignCustomer::where('vendor_id', $authUser->vendor_id)->where('customer_id', $request->customer_id)->first();
        $customerName = $assignCustomer->assignCustomer->name;

        $drafts = Draft::where('assign_customer_id', $assignCustomer->customer_id)->get();
        $idsToDelete = [];

        if ($drafts->isNotEmpty()) {
            $idsToDelete = $drafts->pluck('id')->toArray();
        }

        $deleted = Draft::whereIn('id', $idsToDelete)->forcedelete();

        if ($deleted) {
            return response()->json(['status' => 'Success', 'message' => 'The draft for ' . $customerName . ' has been cleared successfully.'], 200);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'The draft for ' . $customerName . ' was unable to be cleared. Please try again.'], 500);
        }
    }
}
