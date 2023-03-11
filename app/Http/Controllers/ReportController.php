<?php

namespace App\Http\Controllers;

use App\BinCard;
use App\Location;
use App\ReportModel;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Khill\Lavacharts\Lavacharts;

class ReportController extends Controller
{
    public function index()
    {
        return view('layouts.reports.index');
    }

    public function stockReport()
    {
        $locid = Auth::user()->locid;
        $stocks = ReportModel::stockReport($locid);

        return view('layouts.reports.stock', compact('stocks'));

    }

    public function search(Request $request)
    {
        $locid = Auth::user()->locid;
        $search = $request->input('search');
        if ($search != null) {
            $stocks = ReportModel::searchStock($locid, $search);
            return view('layouts.reports.stock', compact('stocks'));
        } else {
            $stocks = ReportModel::stockReport($locid);
            return view('layouts.reports.stock', compact('stocks'));
        }

    }

    public function downloadPDF()
    {
        $locid = Auth::user()->locid;
        $stocks = ReportModel::stockReport($locid);
        $pdf = PDF::loadView('layouts.reports.stockpdf', compact('stocks'));
        return $pdf->download('stock.pdf');
    }


    public function poReport(Request $request)
    {
        $locid = Auth::user()->locid;
        $from = $request->input('from');
        $to = $request->input('to');
        $pos = ReportModel::poReport($locid, $from, $to);
        return view('layouts.reports.po_report', compact('pos'));
    }

    public function grnReport(Request $request)
    {
        $locid = Auth::user()->locid;
        $from = $request->input('from');
        $to = $request->input('to');
        $grns = ReportModel::grnReport($locid, $from, $to);
        return view('layouts.reports.grn_report', compact('grns'));
    }

    public function gtnReport(Request $request)
    {
        $locid = Auth::user()->locid;
        $from = $request->input('from');
        $to = $request->input('to');
        $gtns = ReportModel::gtnReport($locid, $from, $to);
        return view('layouts.reports.gtn_report', compact('gtns'));
    }

    public function salesReport(Request $request)
    {
        $locid = Auth::user()->locid;
        $from = $request->input('from');
        $to = $request->input('to');
        $sales = ReportModel::salesReport($locid, $from, $to);
        return view('layouts.reports.sale_report', compact('sales'));
    }

    public function binCard(Request $request)
    {
        $locid = Auth::user()->locid;
        $product = $request->input('product');
        $bins = BinCard::getBinCardDetail($locid, $product);
        return view('layouts.reports.bin_card', compact('bins'));
    }

    public function valuationReport(Request $request)
    {
        $locid = Auth::user()->locid;
        $valuations = ReportModel::valuationReport($locid);
        return view('layouts.reports.valuation', compact('valuations'));
    }

    public function stockBySuppllier()
    {
        $locid = Auth::user()->locid;
        $stocks = ReportModel::stockBySupplier($locid);
        return view('layouts.reports.stock_supplier', compact('stocks'));
    }

    public function searchStockBySuppllier(Request $request)
    {
        $locid = Auth::user()->locid;
        $supplier = $request->input('supplier');
        if ($supplier != null) {
            $stocks = ReportModel::searchStockBySuppllier($locid, $supplier);
            return view('layouts.reports.stock_supplier', compact('stocks'));
        } else {
            $stocks = ReportModel::searchStockBySuppllier($locid, $supplier);
            return view('layouts.reports.stock_supplier', compact('stocks'));
        }
    }

    public function stockByLocation(Request $request)
    {
        $location = '';

        $locations = $this->getLocationList();

        if ($location != null) {
            $location = $request->input('location');
            $loc = ReportModel::getLocation($location);
            $stocks = ReportModel::searchStockByLocation($location);
            return view('layouts.reports.stock_location', array('stocks'=>$stocks,'location'=>$location,'loc'=>$loc));
        } else {
            $location = Auth::user()->locid;
            $stocks = ReportModel::searchStockByLocation($location);
            $loc = ReportModel::getLocation($location);
            return view('layouts.reports.stock_location', array('stocks'=>$stocks,'location'=>$location,'loc'=>$loc));
        }
    }


//    public function stockByLocation(Request $request)
//    {
//        $location = '';
//
//        $locations = $this->getLocationList();
//
//        if ($location != null) {
//            $location = $request->input('location');
////            $loc = ReportModel::getLocation($location);
//            $stocks = ReportModel::searchStockByLocation($location);
//            return view('layouts.reports.stock_location', array('stocks'=>$stocks,'location'=>$location,'locations'=>$locations));
//        } else {
//            $location = Auth::user()->locid;
//            $stocks = ReportModel::searchStockByLocation($location);
//            $loc = ReportModel::getLocation($location);
//            return view('layouts.reports.stock_location', array('stocks'=>$stocks,'location'=>$location,'loc'=>$loc));
//        }
//    }

    public function salesByProduct(Request $request)
    {
        $locid = Auth::user()->locid;
        $from = $request->input('from');
        $to = $request->input('to');
        $sales = ReportModel::salesByProduct($locid, $from, $to);
        return view('layouts.reports.sale_product', compact('sales'));
    }

    public function salesBySupplier(Request $request)
    {
        $locid = Auth::user()->locid;
        $from = $request->input('from');
        $to = $request->input('to');
        $supplier = $request->input('supplier');
        $sales = ReportModel::salesBySupplier($locid,$supplier, $from, $to);
        return view('layouts.reports.sale_supplier',compact('sales'));
    }

    public function getLocationList()
    {
        $location = Location::all('id', 'name');
        return $location;

    }

}
