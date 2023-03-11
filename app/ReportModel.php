<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportModel extends Model
{

    public static function stockReport($locid)
    {
        $stocks = DB::table('location_stock as l')
            ->leftJoin('products as p', 'l.product', '=', 'p.id')
            ->leftJoin('brands as b', 'p.brand', '=', 'b.id')
            ->leftJoin('categories as c', 'p.category', '=', 'c.id')
            ->select('p.id', 'p.description', 'l.qty', 'b.brand', 'c.category')
            ->where('l.location', $locid)
            ->where('l.qty', '>', 0)
            ->get();

        return $stocks;
    }

    public static function searchStock($locid, $search)
    {
        $stocks = DB::table('location_stock as l')
            ->leftJoin('products as p', 'l.product', '=', 'p.id')
            ->select('p.id', 'p.description', 'p.selling_price', 'p.cost_price', 'l.qty')
            ->where('l.location', $locid)
            ->where('p.description', 'LIKE', '%' . $search . '%')
            ->get();
        return $stocks;
    }

    public static function poReport($locid, $from, $to)
    {
        $pos = DB::table('po_header as p')
            ->leftJoin('locations as l', 'p.location', '=', 'l.id')
            ->join('po_detail as pd', 'p.id', '=', 'pd.po_header')
            ->join('products as pr', 'pd.item_code', '=', 'pr.id')
            ->select('pd.po_header', 'p.created_at as date', 'l.name as location', 'pr.description', 'pd.qty', 'pr.cost_price', 'pr.selling_price')
            ->where('p.location', $locid)
            ->whereBetween('p.created_at', [$from, $to])
            ->get();

        return $pos;
    }

    public static function grnReport($locid, $from, $to)
    {
        $grns = DB::table('grn_header as gh')
            ->join('grn_detail as gd', 'gh.id', '=', 'gd.grn_no')
            ->join('products as p', 'gd.product', '=', 'p.id')
            ->select('gd.grn_no', 'gh.created_at as date', 'gd.qty', 'p.description', 'p.cost_price', 'p.selling_price')
            ->where('gh.location', $locid)
            ->whereBetween('gh.created_at', [$from, $to])
            ->get();

        return $grns;
    }

    public static function gtnReport($locid, $from, $to)
    {
        $grns = DB::table('gtn_header as gh')
            ->join('gtn_detail as gd', 'gh.id', '=', 'gd.gtn_no')
            ->join('products as p', 'gd.product', '=', 'p.id')
            ->select('gd.gtn_no', 'gh.created_at as date', 'gd.qty', 'p.description', 'p.cost_price', 'p.selling_price')
            ->where('gh.source_location', $locid)
            ->whereBetween('gh.created_at', [$from, $to])
            ->get();

        return $grns;
    }

    public static function salesReport($locid, $from, $to)
    {
        $sales = DB::table('invoice_header as i')
            ->join('invoice_detail as id', 'i.id', '=', 'id.invoice')
            ->join('products as p', 'id.product', '=', 'p.id')
            ->select('id.invoice', 'i.created_at as date', 'id.qty', 'p.description', 'id.cost_price', 'id.selling_price', 'i.nic')
            ->where('i.location', $locid)
            ->where('i.status', '=', ACTIVE)
            ->whereBetween('i.created_at', [$from, $to])
            ->get();

        return $sales;
    }

    public static function valuationReport($locid)
    {
        $stocks = DB::select('select p.id,p.description,p.selling_price,p.cost_price,sum(l.qty) as qty,b.brand,c.category
                      from location_stock l
                      left join products p on l.product = p.id
                      left join brands b on p.brand = b.id
                      left join categories c on p.category = c.id
                      where l.location = ? and l.qty >0 group by l.product', [$locid]);

        return $stocks;
    }

    public static function stockBySupplier($locid)
    {
        $stocks = DB::select('select  p.id,p.description,p.selling_price,p.cost_price,l.qty ,b.brand,c.category ,s.comapany_name as supplier
                      from location_stock l 
                      left join products p on l.product = p.id
                      left join brands b on p.brand = b.id
                      left join categories c on p.category = c.id
                      left join suppliers s on p.supplier = s.id
                      where l.location = ?  order by p.supplier', [$locid]);
        return $stocks;
    }

    public static function searchStockBySuppllier($locid, $supplier)
    {
        $stocks = DB::select('select  p.id,p.description,p.selling_price,p.cost_price,l.qty ,b.brand,c.category ,s.comapany_name as supplier
                      from location_stock l 
                      left join products p on l.product = p.id
                      left join brands b on p.brand = b.id
                      left join categories c on p.category = c.id
                      left join suppliers s on p.supplier = s.id
                      where l.location = ? and p.supplier = ?', [$locid, $supplier]);
        return $stocks;

    }

    public static function searchStockByLocation($locid)
    {
        $stocks = DB::select('select  p.id,p.description,p.selling_price,p.cost_price,l.qty ,b.brand,c.category ,s.comapany_name as supplier,lo.name as location
                      from location_stock l 
                      left join products p on l.product = p.id
                      left join brands b on p.brand = b.id
                      left join categories c on p.category = c.id
                      left join suppliers s on p.supplier = s.id
                      left join locations lo on l.location = lo.id
                      where l.location = ?', [$locid]);
        return $stocks;

    }

    public static function salesByProduct($locid, $from, $to)
    {

        $sales = DB::select('select id.product,p.description,sum(id.qty) as qty
                    from invoice_header i
                    inner join invoice_detail id on i.id = id.invoice
                    inner join products p on id.product = p.id
                    where i.location = ? and i.status = ? and i.created_at between ? and ? group by id.product order by qty desc', [$locid, ACTIVE_INVOICE, $from . " 00:00:00", $to . " 23:59:59"]);

        return $sales;
    }

    public static function salesBySupplier($locid, $supplier, $from, $to)
    {

        $sales = DB::select('select id.invoice,id.product,p.description,id.qty
                    from invoice_header i
                    inner join invoice_detail id on i.id = id.invoice
                    inner join products p on id.product = p.id
                    where i.location = ? and i.status = ? and i.created_at between ? and ? and p.supplier = ?', [$locid, ACTIVE_INVOICE, $from . " 00:00:00", $to . " 23:59:59", $supplier]);
        return $sales;
    }

    public static function getLocation($location){
        $location = DB::select('select name as location from locations l where l.id = ?', [$location]);
        return $location;
    }

}
