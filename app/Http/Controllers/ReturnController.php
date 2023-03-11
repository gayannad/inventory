<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductModel;
use App\ReturnDetail;
use App\ReturnHeader;
use App\StockModel;
use App\Supplier;
use App\SupplierModel;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function newReturn()
    {
        return view('return.new_return');
    }

    //function for get product list into return note create
    public function getProductList(Request $request)
    {
        $search = $request->input('keyword');
        $supplier = $request->input('supplier');
        $products1 = Product::where('supplier', $supplier)->limit(5)->get();
        if (isset($search)) {
            $products = $products1->where('description', 'LIKE', "%{$search}%")
                ->orWhere('barcode', 'LIKE', "%{$search}%")
                ->limit(5)
                ->get();
            return $products;
        }
        return $products1;
    }

    //function for save return
    public function saveReturn(Request $request)
    {
        $return_details = json_decode($request->input('item_in_cart'));

        try {
            if (!empty($return_details)) {
                $return_header = ReturnHeader::create([
                    'supplier' => $request->supplier,
                    'remarks' => $request->remarks,
                    'total_cost' => floatval(preg_replace('/[^\d\.]/', '', $request->total_cost)),
                    'status' => ReturnHeader::RETURN_PENDING,
                ]);

                $return_header_id = $return_header->id;

                foreach ($return_details as $return_detail) {
                    ReturnDetail::create([
                        'srn_no' => $return_header_id,
                        'product' => $return_detail->id,
                        'qty' => $return_detail->qty,
                        'cost_price' => $return_detail->cost_price,
                        'sell_price' => $return_detail->sell_price
                    ]);
                }
                return redirect()->back()->with('alert', 'Return Note successfully created');
            } else {
                return redirect()->back()->with('Error');
            }
        } catch (Exception $e) {
            return false;
        }
    }

    //function for get return list
    public function srns()
    {
        $suppliers = Supplier::all();
        $srns = ReturnHeader::orderBy('id', 'desc')->paginate(10);
        return view('return.return_list', compact('srns','suppliers'));
    }

    //function for view return
    public function viewReturn($srn)
    {
        $srns = ReturnHeader::findOrFail($srn);
        return view('return.return_view', compact('srns'));
    }

    //function for approve return and update stock
    public function approveSrn($srn)
    {
        $srns = ReturnHeader::findOrFail($srn);

        foreach ($srns->details as $srn) {
            $stock = StockModel::where('product', $srn->product)->first();

            if ($stock) {
                StockModel::findOrFail($stock->id)->update([
                    'qty' => $stock->qty - $srn->qty
                ]);
                $srns->update([
                    'status' => ReturnHeader::RETURN_APPROVED
                ]);
            }
        }
        return redirect()->back()->with('alert', 'Return Note successfully approved');
    }

    //function for reject return
    public function rejectSrn($srn)
    {
        $srns = ReturnHeader::findOrFail($srn);

        $srns->update([
            'status' => ReturnHeader::RETURN_REJECTED
        ]);
        return redirect()->back()->with('alert', 'Return Note successfully rejected');
    }

    //function for search return note
    public function searchSrn(Request $request)
    {
        $search = $request->input('search');

        $srns = ReturnHeader::with('details');

        if ($request->search){
            $srns->where('id',$search);
        }
        if ($request->created_at){
            $srns->where('created_at','LIKE',"%{$request->created_at}%");
        }
        if ($request->supplier){
            $srns->where('supplier',$request->supplier);
        }
        if ($request->options){
            $srns->where('status',$request->options);
        }
        $srns = $srns->paginate(10);
        $suppliers = Supplier::all();
        return view('return.return_list',compact('srns','suppliers'));
    }
}
