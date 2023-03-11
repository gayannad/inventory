<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Exception;

class GtnModel extends Model
{

    /**
     * @param $locid
     * @return \Illuminate\Support\Collection
     */
    public static function getProducts($locid)
    {
        $products = DB::table('location_stock as l')
            ->join('products as p', 'l.product', '=', 'p.id')
            ->select('p.description', 'p.cost_price', 'p.selling_price', 'l.qty as stock', 'p.id')
            ->where('l.location', $locid)->where('qty', '>', 0)->get();
        return $products;
    }

    public static function saveGtn($user, $location, $destination, $remark, $gtn_details)
    {

        try {
            if (!empty($gtn_details)){
                DB::beginTransaction();

                $gtn_header = new GtnHeader();
                $gtn_header->source_location = $location;
                $gtn_header->destination_location = $destination;
                $gtn_header->status = PENDING_GTN;
                $gtn_header->status_received = PENDING_GTN;
                $gtn_header->remarks = $remark;
                $gtn_header->created_by = $user;
                $gtn_header->save();

                $gtn_no = $gtn_header->id;

                foreach ($gtn_details as $gtn_detail) {
                    $gtndetail = new GtnDetail();
                    $gtndetail->gtn_no = $gtn_no;
                    $gtndetail->product = $gtn_detail->id;
                    $gtndetail->qty = $gtn_detail->qty;
                    $gtndetail->price_cost_with_tax = $gtn_detail->cost_price;
                    $gtndetail->price_cost_without_tax = $gtn_detail->cost_price;
                    $gtndetail->price_selling_with_tax = $gtn_detail->selling_price;
                    $gtndetail->price_selling_without_tax = $gtn_detail->selling_price;

                    $gtndetail->save();
                    StockModel::updateStock(
                        STOCK_MINUS,
                        $location,
                        $gtn_detail->id,
                        STOCK_TYPE_USEBLE,
                        $gtn_detail->qty);
                }

                DB::commit();
            }else{
                return false;
            }
        } catch (Exception  $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    public static function gtnList($locid)
    {
        $gtns = DB::table('gtn_header as gh')
            ->leftJoin('locations as l', 'gh.destination_location', '=', 'l.id')
            ->select('gh.id', 'l.name as destination', 'gh.created_at as date', 'gh.status')->where('gh.source_location', $locid)
            ->orderByDesc('gh.id')->paginate(10);
        return $gtns;
    }

    public static function searchGtn($search)
    {
        $gtns = DB::table('gtn_header as g')
            ->leftJoin('locations as ls', 'g.source_location', '=', 'ls.id')
            ->leftJoin('locations as ld', 'g.destination_location', '=', 'ld.id')
            ->leftJoin('users as uc', 'g.created_by', '=', 'uc.id')
            ->leftJoin('users as ua', 'g.authorized_or_reject_by', '=', 'ua.id')
            ->select('g.id', 'ls.name as source', 'ld.name as destination', 'g.created_at as date',
                'uc.first_name as user_created', 'ua.first_name as user_approved', 'g.status')
            ->where('g.id', $search)
            ->paginate(10);
        return $gtns;
    }

    public static function getGtnDetails($gtn)
    {
        $gtn_header = DB::table('gtn_header as g')
            ->leftJoin('locations as ls', 'g.source_location', '=', 'ls.id')
            ->leftJoin('locations as ld', 'g.destination_location', '=', 'ld.id')
            ->leftJoin('users as uc', 'g.created_by', '=', 'uc.id')
            ->leftJoin('users as ua', 'g.authorized_or_reject_by', '=', 'ua.id')
            ->select('g.id', 'ls.name as source', 'ld.name as destination', 'g.created_at as date',
                'uc.first_name as user_created', 'ua.first_name as user_approved', 'g.status', 'g.remarks')
            ->where('g.id', $gtn)->get();

        $gtn_details = DB::table('gtn_detail as gd')
            ->leftJoin('products as p', 'gd.product', '=', 'p.id')
            ->select('gd.product', 'gd.qty', 'p.description', 'gd.price_cost_with_tax as cost_price')
            ->where('gd.gtn_no', $gtn)->get();

        $gtn_header['details'] = $gtn_details;
        return $gtn_header;
    }

    public static function approveGtn($gtn)
    {
        $gtn_details = DB::table('gtn_detail as gd')
            ->leftJoin('gtn_header as gh', 'gd.gtn_no', '=', 'gh.id')
            ->select('gd.product', 'gd.qty', 'gh.destination_location as destination', 'gh.source_location as source')
            ->where('gd.gtn_no', $gtn)->get();


        foreach ($gtn_details as $gtn_detail) {
            $product = $gtn_detail->product;
            $qty = $gtn_detail->qty;
            $destination = $gtn_detail->destination;
            $source = $gtn_detail->source;

            if (StockModel::stockAvailable($destination, $product, STOCK_TYPE_USEBLE) == true) {
                // StockModel::updateStock(STOCK_PLUS, $destination, $product, STOCK_TYPE_USEBLE, $qty);
            } else {
                StockModel::addStock($destination, $product, STOCK_TYPE_USEBLE, $qty);
            }

            BinCard::addBinCardRecord($source, DOCUMENT_TYPE_GTN, $gtn, $product, $qty);
        }
        DB::table('gtn_header')->where('id', $gtn)->update(array('status' => APPROVED_GTN));
    }

    public static function rejectGtn($gtn)
    {
        $gtn_details = DB::table('gtn_detail as gd')
            ->leftJoin('gtn_header as gh', 'gd.gtn_no', '=', 'gh.id')
            ->select('gd.product', 'gd.qty', 'gh.destination_location as destination', 'gh.source_location as source')
            ->where('gd.gtn_no', $gtn)->get();

        foreach ($gtn_details as $gtn_detail) {
            $product = $gtn_detail->product;
            $qty = $gtn_detail->qty;
            $location = $gtn_detail->source;

            if (StockModel::stockAvailable($location, $product, STOCK_TYPE_USEBLE) == true) {
                StockModel::updateStock(STOCK_PLUS, $location, $product, STOCK_TYPE_USEBLE, $qty);
            } else {
                StockModel::addStock($location, $product, STOCK_TYPE_USEBLE, $qty);
            }
        }
        DB::table('gtn_header')->where('id', $gtn)->update(array('status' => REJECTED_GTN));
    }
}
