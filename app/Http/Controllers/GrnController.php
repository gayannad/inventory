<?php

namespace App\Http\Controllers;

use App\GrnModel;
use App\Product;
use App\StockModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrnController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * grn create ui
     */
    public function index()
    {
        return view('layouts.grn.grn');
    }


    /**
     * @param Request $request
     * @return mixed
     * for product search in grn
     */
    public function getProductList(Request $request)
    {
        $search = $request->input('keyword');
        $products = Product::where('description', 'LIKE', "%{$search}%")->orWhere('barcode', 'LIKE', "%{$search}%")->limit(5)->get();
        return $products;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * grn save function
     */
    public function saveGrn(Request $request)
    {
        $user = Auth::user()->id;
        $location = Auth::user()->locid;

        $supplier = $request->input('supplier');
        $invoice = $request->input('invoice');
        $tax_status = $request->input('tax_status');
        $remark = $request->input('remark');

        $data = array(
            'supplier' => $supplier,
            'invoice' => $invoice,
            'tax_status' => $tax_status,
            'remark' => $remark,
        );

        $grn_details = json_decode($request->input('item_in_cart'));
        $status = GrnModel::saveGrn($user, $location, $data, $grn_details);


        if ($status == 1) {
            return redirect()->route('stockuser')->with('alert', 'Successfully Saved !');
        } else {
            return redirect()->back()->with('alert', 'Error!');
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * function for grn list
     */
    public function grnList()
    {
        $locid = Auth::user()->locid;
        $grns = GrnModel::getGrnList($locid);

        return view('layouts.grn.list', compact('grns'));
    }

    public function grnView($id)
    {
        $grn_details = GrnModel::getGrnDetails($id);
        return view('layouts.grn.view', array('grn_details' => $grn_details));
    }

    public function test()
    {
        GrnModel::approveGrn(6);
//        var_dump($a);
//        exit();
    }

    public function approveGrn($grn)
    {
        $user = Auth::user()->id;
        $location = Auth::user()->locid;
        GrnModel::approveGrn($grn, $location);
        return redirect()->back()->with('alert', 'Grn Approved !');
    }

    public function rejectGrn($grn)
    {
        GrnModel::rejectGrn($grn);
        return redirect()->back()->with('alert', 'Grn Rejected !');
    }

    public function searchGrn(Request $request)
    {
        $search = $request->input('search');

        if ($search != null) {
            $grns = GrnModel::searchGrn($search);

            if (count($grns) > 0) {
                return view('layouts.grn.list', compact('grns'));
            } else {
                return view('layouts.grn.list')->withMessage("No Results Found");
            }
        }
        return redirect()->to('/grn/list');
    }

    public function loadGtns()
    {
        $locid = Auth::user()->locid;
        $data = GrnModel::loadGtns($locid);
        echo json_encode($data);
    }

    public function acceptGtn()
    {
        $user = Auth::user()->id;
        $location = Auth::user()->locid;
        $data = json_decode(json_encode($_POST));
        GrnModel::acceptGtn($user, $location, $data);
        return redirect()->back()->with('alert', 'Grn Successfully Created !');
    }

}
