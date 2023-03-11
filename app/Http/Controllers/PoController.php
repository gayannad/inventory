<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 4/12/18
 * Time: 1:53 PM
 */

namespace App\Http\Controllers;


use App\PoHeader;
use App\PoModel;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * function for po create ui
     */
    public function index()
    {

        return view('layouts.po.po');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * function for po list
     */
    public function poList()
    {
        $pos = PoModel::getPoList();
        return view('layouts.po.list', compact('pos'));
    }

    /**
     * @param Request $request
     * @return mixed
     * function for get products to po create
     */
    public function getProductList(Request $request)
    {
        $search = $request->input('keyword');
        $supplier = $request->input('supplier');
        $products = Product::where('description', 'LIKE', "%{$search}%")->Where('supplier', $supplier)->limit(5)->get();
        return $products;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * function for po save
     */
    public function savePo(Request $request)
    {
        $user = Auth::user()->id;
        $location = Auth::user()->locid;

        $supplier = $request->input('supplier');
        $date_due = $request->input('date_due');
        $remark = $request->input('remark');

        $data = array(
            'supplier' => $supplier,
            'date_due' => $date_due,
            'remark' => $remark
        );

        $po_details = json_decode($request->input('item_in_cart'));
        $status = PoModel::savePo($data, $po_details, $user, $location);
        if ($status == 1) {
            return redirect()->back()->with('alert', 'Po Successfully Created !');
        } else {
            return redirect()->back()->with('alert', 'Error!');
        }


    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * function for po view
     */
    public function poView($id)
    {
        $po_details = PoModel::getPoDetails($id);
        return view('layouts.po.view', array('po_details' => $po_details));
    }


    /**
     * @param $po
     * @return \Illuminate\Http\RedirectResponse
     * function for approve po
     */
    public function approvePo($po)
    {
        $user = Auth::user()->id;
        $po_details = PoModel::getPoDetailsForMail($po);
        $supplier= $po_details[0]->supplier;
        $contact_person =$po_details[0]->contact_person;
        $email=$po_details[0]->email;
        $due_date=$po_details[0]->due_date;
        $location=$po_details[0]->location;
        $address=$po_details[0]->address;
        $telephone=$po_details[0]->telephone;

        PoModel::approvePo($po, $user);


        $data = array('contact_person'=>$contact_person, "body" => "Test mail",'po_details'=>$po_details,'due_date'=>$due_date,
            'location'=>$location,'address'=>$address,'telephone'=>$telephone);

        Mail::send('emails.mail', $data, function($message) use ($contact_person, $email) {
            $message->to($email, $contact_person)
                ->subject('Purchase Order');
            $message->from('blifeinternational@gmail.com','blifeinternational@gmail.com');
        });
        return redirect()->back()->with('alert', 'Po Successfully Approved !');
    }

    /**
     * @param $po
     * @return \Illuminate\Http\RedirectResponse
     * function for reject po
     */
    public function rejectPo($po)
    {
        $user = Auth::user()->id;
        PoModel::rejectPo($po, $user);
        return redirect()->back()->with('alert', 'Po Successfully Rejected !');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * function for search po  by po number
     */
    public function searchPo(Request $request)
    {
        $search = $request->input('search');

        if ($search != null) {
            $pos = PoModel::searchPo($search);
            if (count($pos) > 0) {
                return view('layouts.po.list', compact('pos'));
            } else {
                return view('layouts.po.list')->withMessage(" No Results Found !");
            }
        }
        return redirect()->to('/po/index');

    }

}

