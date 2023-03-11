<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $location = Auth::user()->locid;
        $users = DB::table('users')->count('id');
        $locations = DB::table('locations')->count('id');
        $suppliers = DB::table('suppliers')->count('id');
        $products = DB::table('products')->count('id');
        $pos = DB::table('po_header')->where('status', '=', PENDING_PO)->count('id');
        $grns = DB::table('grn_header')->where('status', '=', PENDING_GRN)->count('id');
        $gtns = DB::table('gtn_header')->where('destination_location', '=', $location)
                    ->where('status_received', '=', PENDING_GTN)->count('id');

        $invoices = DB::table('invoice_header')->where('status', '=', 0)->count('id');

        $returns = DB::table('stock_return')->where('status', '=', PENDING_RN)->count('id');
        return view('home', array('users' => $users, 'locations' => $locations, 'suppliers' => $suppliers,
            'products' => $products, 'pos' => $pos, 'grns' => $grns, 'gtns' => $gtns, 'invoices' => $invoices, 'returns' => $returns));
    }


}
