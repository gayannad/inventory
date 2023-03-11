<?php

namespace App;

use     Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Exception;

class GrnModel extends Model
{

    public static function saveGrn($user, $location, $data, $grn_details)
    {
        try {
            if (!empty($grn_details)) {
                DB::beginTransaction();

                $grn_header = new GrnHeader();
                $grn_header->location = $location;
                $grn_header->supplier = $data['supplier'];
                $grn_header->invoice = $data['invoice'];
                $grn_header->status = PENDING_GRN;
                $grn_header->grn_type = GRN_TYPE_DIRECT;
                $grn_header->tax_status = $data['tax_status'];
                $grn_header->created_by = $user;
                $grn_header->remarks = $data['remark'];
                $grn_header->save();

                $grn_no = $grn_header->id;

                foreach ($grn_details as $grn_detail) {

                    $grndetail = new GrnDetail();
                    $grndetail->grn_no = $grn_no;
                    $grndetail->product = $grn_detail->id;
                    $grndetail->qty = $grn_detail->qty;
                    $grndetail->price_cost_with_tax = $grn_detail->cost_price;
                    $grndetail->price_cost_without_tax = $grn_detail->cost_price;
                    $grndetail->price_selling_with_tax = $grn_detail->selling_price;
                    $grndetail->price_selling_without_tax = $grn_detail->selling_price;
                    $grndetail->save();

                }
                DB::commit();
            } else {
                return false;
            }

        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    public static function getGrnList($locid)
    {
        $grns = DB::table('grn_header as gh')
            ->leftJoin('locations as l', 'gh.location', '=', 'l.id')
            ->select('gh.id', 'l.name', 'gh.created_at as date', 'gh.status', 'gh.grn_type')->where('gh.location', '=', $locid)
            ->orderByDesc('gh.id')
            ->paginate(10);
        return $grns;
    }

    public static function getGrnDetails($id)
    {
        $grn_header = DB::table('grn_header as gh')
            ->leftJoin('suppliers as s', 'gh.supplier', '=', 's.id')
            ->leftJoin('users as uc', 'gh.created_by', '=', 'uc.id')
            ->leftJoin('users as ua', 'gh.authorized_or_reject_by', '=', 'ua.id')
            ->leftJoin('locations as l', 'gh.location', '=', 'l.id')
            ->select('gh.id', 'gh.status', 'gh.created_at', 'gh.authorized_or_reject_timestamp', 'gh.invoice',
                'gh.remarks', 's.comapany_name', 'l.name as location', 'uc.first_name as user_created', 'ua.first_name as user_authorized')
            ->orderByDesc('gh.id')->where('gh.id', $id)->get();

        $grn_details = DB::table('grn_detail as gd')
            ->leftJoin('products as p', 'gd.product', '=', 'p.id')
            ->select('gd.product', 'gd.qty', 'p.description', 'gd.price_cost_with_tax as cost_price')
            ->where('gd.grn_no', $id)->get();

        $grn_header['details'] = $grn_details;
        return $grn_header;
    }

    public static function approveGrn($grn, $location)
    {
        $grn_details = DB::table('grn_detail as gd')
            ->select('gd.product', 'gd.qty')->where('gd.grn_no', $grn)->get();

        foreach ($grn_details as $grn_detail) {

            $product = $grn_detail->product;
            $qty = $grn_detail->qty;

            if (StockModel::stockAvailable($location, $product, STOCK_TYPE_USEBLE) == true) {
                StockModel::updateStock(STOCK_PLUS, $location, $product, STOCK_TYPE_USEBLE, $qty);
            } else {
                StockModel::addStock($location, $product, STOCK_TYPE_USEBLE, $qty);
            }

            BinCard::addBinCardRecord($location, DOCUMENT_TYPE_GRN, $grn, $product, $qty);

        }
        DB::table('grn_header')->where('id', $grn)->update(array('status' => APPROVED_GRN));
    }

    public static function rejectGrn($grn)
    {
        DB::table('grn_header')->where('id', $grn)->update(array('status' => REJECTED_GRN));
    }

    public static function searchGrn($search)
    {
        $grns = DB::table('grn_header as g')
            ->leftJoin('suppliers as s', 'g.supplier', '=', 's.id')
            ->leftJoin('users as u', 'g.created_by', '=', 'u.id')
            ->leftJoin('locations as l', 'g.location', '=', 'l.id')
            ->select('g.id', 'l.name', 'g.created_at as date', 'g.status', 'g.grn_type')->where('g.id', $search)->paginate(10);
        return $grns;
    }


    public static function loadGtns($locid)
    {
        $gtn_header = DB::select('select gh.id as gtn_no,gh.source_location as locid,l.name as location 
                          from gtn_header gh 
                          left join locations l on gh.source_location = l.id 
                          where gh.destination_location = ? and gh.status_received != ?', [$locid, GTN_RECEIVED]);

        $gtn_header_array = json_decode(json_encode($gtn_header), true);

        $grn_array = array();

        foreach ($gtn_header_array as $header) {

            $gtn = $header['gtn_no'];

            $gtn_detail = DB::select('select g.product,p.description,g.qty,g.price_cost_with_tax as cost_price,g.price_selling_with_tax as selling_price 
                              from gtn_detail g 
                              inner join products p on g.product = p.id 
                              where g.gtn_no = ?', [$gtn]);

            $gtn_detail_array = json_decode(json_encode($gtn_detail), true);
            $header['details'] = $gtn_detail_array;

            array_push($grn_array, $header);

        }
        return $grn_array;
    }

    /**
     * @param $user
     * @param $location
     * @param $data
     * gtn to grn
     */
    public static function acceptGtn($user, $location, $data)
    {
        $gtn = $data->gtn_no;

        try {
            DB::beginTransaction();
            $gtn_header = DB::select('select *
                          from gtn_header gh 
                          left join locations l on gh.source_location = l.id 
                          where gh.id = ?', [$gtn]);

            $gtn__array = json_decode(json_encode($gtn_header), true);

            if ($gtn__array > 0) {

                $grn_header = new GrnHeader();
                $grn_header->location = $location;
                $grn_header->supplier = null;
                $grn_header->invoice = null;
                $grn_header->status = APPROVED_GRN;
                $grn_header->grn_type = GRN_TYPE_GTN;
                $grn_header->tax_status = null;
                $grn_header->created_by = $user;
                $grn_header->remarks = null;
                $grn_header->save();

                $grn_no = $grn_header->id;

                $gtn_detail = DB::select('select 
                              g.product,p.description,
                              g.qty,g.price_cost_with_tax as cost_price,
                              g.price_selling_with_tax as selling_price 
                              from gtn_detail g 
                              inner join products p on g.product = p.id 
                              where g.gtn_no = ?', [$gtn]);

                $gtn_details = json_decode(json_encode($gtn_detail), true);

                foreach ($gtn_details as $gtn_detail) {

                    $grndetail = new GrnDetail();
                    $grndetail->grn_no = $grn_no;
                    $grndetail->product = $gtn_detail['product'];
                    $grndetail->qty = $gtn_detail['qty'];
                    $grndetail->price_cost_with_tax = $gtn_detail['cost_price'];
                    $grndetail->price_cost_without_tax = $gtn_detail['cost_price'];
                    $grndetail->price_selling_with_tax = $gtn_detail['selling_price'];
                    $grndetail->price_selling_without_tax = $gtn_detail['selling_price'];
                    $grndetail->save();

                    $product = $gtn_detail['product'];
                    $qty = $gtn_detail['qty'];

                    if (StockModel::stockAvailable($location, $product, STOCK_TYPE_USEBLE) == true) {
                        StockModel::updateStock(STOCK_PLUS, $location, $product, STOCK_TYPE_USEBLE, $qty);
                    } else {
                        StockModel::addStock($location, $product, STOCK_TYPE_USEBLE, $qty);
                    }

                    BinCard::addBinCardRecord($location, DOCUMENT_TYPE_GRN, $grn_no, $product, $qty);
                }
                DB::table('gtn_header')->where('id', $gtn)->update(array('status_received' => GTN_RECEIVED));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
