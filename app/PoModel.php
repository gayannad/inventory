<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Exception;

class PoModel extends Model
{
    public static function savePo($data, $po_details, $user, $location)
    {


        try {

            if (!empty($po_details)) {

                DB::beginTransaction();

                $po_header = new PoHeader();
                $po_header->location = $location;
                $po_header->supplier = $data['supplier'];
                $po_header->due_date = $data['date_due'];
                $po_header->status = PENDING_PO;
                $po_header->user_created = $user;
                $po_header->remark = $data['remark'];
                $po_header->save();

                $po_header_id = $po_header->id;

                foreach ($po_details as $po_detail) {

                    $podetail = new PoDetail();
                    $podetail->po_header = $po_header_id;
                    $podetail->item_code = $po_detail->id;
                    $podetail->cost_price = $po_detail->cost_price;
                    $podetail->qty = $po_detail->qty;
                    $podetail->save();
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

    public static function getPoList()
    {
        $pos = DB::table('po_header')
            ->leftJoin('suppliers', 'po_header.supplier', '=', 'suppliers.id')
            ->leftJoin('users', 'po_header.user_created', '=', 'users.id')
            ->select('po_header.id', 'po_header.created_at', 'po_header.status', 'suppliers.comapany_name', 'users.first_name as name')
            ->orderByDesc('po_header.id')
            ->paginate(10);
        return $pos;
    }

    public static function getPoDetails($id)
    {

        $po_header = DB::table('po_header')
            ->leftJoin('suppliers', 'po_header.supplier', '=', 'suppliers.id')
            ->leftJoin('users as u', 'po_header.user_created', '=', 'u.id')
            ->leftJoin('users as um', 'po_header.user_modified', '=', 'um.id')
            ->leftJoin('locations', 'po_header.location', '=', 'locations.id')
            ->select('po_header.id', 'po_header.status', 'po_header.created_at', 'po_header.status', 'po_header.due_date',
                'suppliers.comapany_name', 'suppliers.contact_person', 'suppliers.telephone', 'suppliers.email', 'u.first_name as name', 'um.first_name as muser',
                'locations.name as location', 'locations.address as laddress', 'locations.telephone as ltelephone',
                'locations.email as lemail', 'locations.contact_person as lcontact_person')
            ->orderByDesc('po_header.id')->where('po_header.id', $id)->get();

        $po_details = DB::table('po_header')
            ->join('po_detail', 'po_header.id', '=', 'po_detail.po_header')
            ->leftJoin('products', 'po_detail.item_code', '=', 'products.id')
            ->select('po_detail.item_code',
                'po_detail.qty', 'products.description', 'products.cost_price')->where('po_detail.po_header', $id)->get();

        $po_header['details'] = $po_details;
        return $po_header;

    }

    public static function approvePo($po, $user)
    {
        DB::table('po_header')->where('id', $po)->update(array('status' => APPROVED_PO, 'user_modified' => $user));

    }

    public static function rejectPo($po, $user)
    {
        DB::table('po_header')->where('id', $po)->update(array('status' => REJECTED_PO, 'user_modified' => $user));

    }

    public static function searchPo($search)
    {
        $pos = DB::table('po_header')
            ->leftJoin('suppliers', 'po_header.supplier', '=', 'suppliers.id')
            ->leftJoin('users', 'po_header.user_created', '=', 'users.id')
            ->select('po_header.id', 'po_header.created_at', 'po_header.status', 'suppliers.comapany_name', 'users.first_name')
            ->where('po_header.id', $search)
            ->paginate(10);
        return $pos;
    }

    public static function getPoDetailsForMail($po){
        $pos = DB::table('po_header as p')
            ->leftJoin('locations as l', 'p.location', '=', 'l.id')
            ->join('po_detail as pd', 'p.id', '=', 'pd.po_header')
            ->join('products as pr', 'pd.item_code', '=', 'pr.id')
            ->join('suppliers as s', 'p.supplier', '=', 's.id')
            ->select('pd.po_header', 'p.created_at as date', 'l.name as location', 'pr.description', 'pd.qty'
                , 'pr.cost_price', 'pr.selling_price','s.comapany_name as supplier','s.contact_person','s.email','p.due_date','l.address','l.telephone')
            ->where('pd.po_header', $po)
            ->get();

        return $pos;
    }

}
