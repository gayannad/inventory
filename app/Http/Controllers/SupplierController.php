<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 4/12/18
 * Time: 12:21 PM
 */

namespace App\Http\Controllers;


use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SupplierController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /*
     * function for supplier create ui
     */
    public function index()
    {
        return view('layouts.supplier.supplier');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * function for supplier save
     *
     */
    public function saveSupplier(Request $request)
    {

        $this->validate($request, [
            'company_name' => 'required|string|max:100',
            'contact_person' => 'required|string|max:100',
            'telephone' => 'required|string|max:10',
            // 'fax' => 'required|string|max:10',
            // 'mobile' => 'required|string|max:10',
            // 'email' => 'required|email|unique:users'
        ]);

        $company = $request->input('company_name');
        $contact_person = $request->input('contact_person');
        $telephone = $request->input('telephone');
        $fax = $request->input('fax');
        $mobile = $request->input('mobile');
        $email = $request->input('email');
        $category = $request->input('category');

        $data = array(
            'company' => $company,
            'contact_person' => $contact_person,
            'telephone' => $telephone,
            'fax' => $fax,
            'mobile' => $mobile,
            'email' => $email,
            'category' => $category
        );

        Supplier::saveSupplier($data);
        return redirect()->back()->with('alert', 'Supplier successfully created!');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * function for supplier list
     */
    public function supplierList()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->paginate(10);
        return view('layouts.supplier.list', compact('suppliers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        if ($search != null) {
            $suppliers = Supplier::where('comapany_name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(10);

            $suppliers->appends(array('search' => Input::get('search'),
            ));

            if (count($suppliers) > 0) {
                return view('layouts.supplier.list', compact('suppliers'));
            } else {
                return view('layouts.supplier.list')->withMessage(" No Results Found !");
            }
        }
        return redirect()->to('/supplier/index');
    }

    /**
     * @return static
     * function for get all suppliers
     */
    public function getSupplierList()
    {
        $supplier = Supplier::all('id', 'comapany_name')->where('status', 0);
        return $supplier;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * function for supplier update
     */
    public function updateSupplier(Request $request)
    {
        $company = $request->input('name');
        $contact_person = $request->input('contact_person');
        $telephone = $request->input('telephone');
        $fax = $request->input('fax');
        $mobile = $request->input('mobile');
        $email = $request->input('email');
        $id = $request->input('id');

        $data = array(
            'company' => $company,
            'contact_person' => $contact_person,
            'telephone' => $telephone,
            'fax' => $fax,
            'mobile' => $mobile,
            'id' => $id,
            'email' => $email
        );

        Supplier::updateSupplier($data);
        return redirect()->back()->with('alert', 'Supplier successfully created!');
    }
}