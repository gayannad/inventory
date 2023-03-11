<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class Invoice extends Model
{
    public static function saveInvoice($locid, $data, $details)
    {
        try {
            DB::beginTransaction();

            $invoice_header = new InvoiceHeader();
            $invoice_header->location = $locid;
            $invoice_header->customer_name = $data['name'];
            $invoice_header->nic = $data['nic'];
            $invoice_header->address = $data['address'];
            $invoice_header->mobile = $data['mobile'];
            $invoice_header->status = ACTIVE;
            $invoice_header->save();

            $inv_id = $invoice_header->id;

            foreach ($details as $detail) {

                $invoice_detail = new InvoiceDetail();
                $invoice_detail->invoice = $inv_id;
                $invoice_detail->product = $detail->id;
                $invoice_detail->selling_price = $detail->selling_price;
                $invoice_detail->cost_price = $detail->selling_price;
                $invoice_detail->qty = $detail->qty;
                $invoice_detail->save();

                StockModel::updateStock(
                    STOCK_MINUS,
                    $locid,
                    $detail->id,
                    STOCK_TYPE_USEBLE,
                    $detail->qty
                );
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public static function getProducts($locid)
    {
        $products = DB::table('location_stock as l')
            ->join('products as p', 'l.product', '=', 'p.id')
            ->select('p.description', 'p.cost_price', 'p.selling_price', 'l.qty as stock', 'p.id')
            ->where('l.location', $locid)->where('qty', '>', 0)->get();
        return $products;
    }

    public static function getInvoiceList($locid)
    {
        $invoices = DB::table('invoice_header as i')
            ->leftJoin('locations as l', 'i.location', '=', 'l.id')
            ->select('i.id', 'l.name', 'i.created_at as date', 'i.status')
            ->where('i.location', $locid)
            ->orderByDesc('i.id')
            ->paginate(10);

        return $invoices;
    }


    public static function getInvoiceDetails($id)
    {
        $inv_header = DB::table('invoice_header as i')
            ->leftJoin('locations as l', 'i.location', '=', 'l.id')
            ->select('i.id as invoice', 'i.customer_name', 'i.id', 'i.nic', 'i.address', 'i.mobile', 'i.status', 'i.created_at as date')
            ->where('i.id', $id)
            ->get();

        $inv_details = DB::table('invoice_detail as id')
            ->leftJoin('products as p', 'id.product', '=', 'p.id')
            ->select('id.product', 'id.qty', 'id.selling_price', 'p.description')
            ->where('id.invoice', $id)
            ->get();

        $inv_header['details'] = $inv_details;
        return $inv_header;
    }

    public static function voidInvoice($id)
    {

        $inv_details = DB::table('invoice_detail as id')
            ->leftJoin('invoice_header as i', 'id.invoice', '=', 'i.id')
            ->select('id.product', 'id.qty', 'i.location')
            ->where('id.invoice', $id)
            ->get();

        foreach ($inv_details as $inv_detail) {
            $product = $inv_detail->product;
            $qty = $inv_detail->qty;
            $location = $inv_detail->location;

            if (StockModel::stockAvailable($location, $product, STOCK_TYPE_USEBLE) == true) {
                StockModel::updateStock(STOCK_PLUS, $location, $product, STOCK_TYPE_USEBLE, $qty);
            } else {
                StockModel::addStock($location, $product, STOCK_TYPE_USEBLE, $qty);
            }
        }

        DB::update('UPDATE invoice_header SET status = ? WHERE id = ?', array(VOID_INVOICE, $id));
    }
}
