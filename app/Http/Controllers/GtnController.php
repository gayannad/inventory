<?php

namespace App\Http\Controllers;

use App\GtnModel;
use App\Location;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GtnController extends Controller
{

    public function index()
    {
        return view('layouts.gtn.create');
    }

    public function getProductList()
    {
        $locid = Auth::user()->locid;
        $products = GtnModel::getProducts($locid);
        return $products;
    }

    public function saveGtn(Request $request)
    {
        $user = Auth::user()->id;
        $location = Auth::user()->locid;
        $destination = $request->input('destination');
        $remark = $request->input('remark');

        $gtn_details = json_decode($request->input('item_in_cart'));
        $status = GtnModel::saveGtn($user, $location, $destination, $remark, $gtn_details);


        if ($status == 1) {
            return redirect()->back()->with('alert', 'Gtn Successfully created');
        } else {
            return redirect()->back()->with('alert', 'Error!');
        }

    }

    public function gtnList()
    {
        $locid = Auth::user()->locid;
        $gtns = GtnModel::gtnList($locid);
        return view('layouts.gtn.list', compact('gtns'));
    }

    public function searchGtn(Request $request)
    {
        $search = $request->input('search');
        if ($search != null) {
            $gtns = GtnModel::searchGtn($search);
            if (count($gtns) > 0) {
                return view('layouts.gtn.list', compact('gtns'));
            } else {
                return view('layouts.gtn.list')->withMessage("No Results Found");
            }
        } else {
            return redirect()->to('/gtn/list');
        }
    }

    public function gtnView($id)
    {
        $gtn_details = GtnModel::getGtnDetails($id);
        return view('layouts.gtn.view', array('gtn_details' => $gtn_details));
    }

    public function approveGtn($gtn)
    {
        GtnModel::approveGtn($gtn);
        return redirect()->back()->with('alert', 'Gtn Approved !');
    }

    public function rejectGtn($gtn)
    {
        GtnModel::rejectGtn($gtn);
        return redirect()->back()->with('alert', 'Gtn Rejected !');
    }

    public function getLocations()
    {
        $locid = Auth::user()->locid;
        $location = Location::all('id', 'name')->whereNotIn('id', $locid);
        return $location;
    }
}
