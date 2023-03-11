<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{

    public function index()
    {
        return view('layouts.invoice.create');
    }

    public function getProductList()
    {
        $locid = Auth::user()->locid;
        $products = Invoice::getProducts($locid);
        return $products;
    }

    public function saveInvoice(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            // 'nic' => 'required|string',
            'address' => 'required|string',
            'mobile' => 'required|string|max:10|min:10'
        ]);

        $name = $request->input('name');
        $nic = $request->input('nic');
        $address = $request->input('address');
        $mobile = $request->input('mobile');
        $locid = Auth::user()->locid;

        $data = array(
            'name' => $name,
            'nic' => $nic,
            'address' => $address,
            'mobile' => $mobile
        );

        $invoice_details = json_decode($request->input('item_in_cart'));

        if (sizeof($invoice_details) > 0) {
            Invoice::saveInvoice($locid, $data, $invoice_details);
            return redirect()->back()->with('alert', 'Invoice Successfully Created !');
        } else {
            return redirect()->back()->with('alert', 'Error Creating Invoice !');
        }
    }

    public function invoiceList()
    {
        $locid = Auth::user()->locid;
        $invoices = Invoice::getInvoiceList($locid);
        return view('layouts.invoice.list', compact('invoices'));
    }

    public function viewInvoice($id)
    {
        $invoice_details = Invoice::getInvoiceDetails($id);

        return view('layouts.invoice.view', compact('invoice_details'));
    }


    public function voidInvoice($id)
    {
        Invoice::voidInvoice($id);
        return redirect()->back()->with('alert','Invoice Cancelled !');
    }
}
