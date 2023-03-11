<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 4/12/18
 * Time: 10:37 AM
 */

namespace App\Http\Controllers;


use App\Brand;
use App\Category;
use App\Product;
use App\Supplier;
use App\TaxProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * function for product create ui
     */
    public function index()
    {
        $supplier = $this->getSupplierList();
        return view('layouts.product.product', compact('supplier'));
    }


    /**
     * @return static
     * function for get suppliers to product create
     */
    public function getSupplierList()
    {
        $supplier = Supplier::all('id', 'comapany_name')->where('status', 0);
        return $supplier;

    }

    /**
     * @param Request $request
     * function for category save
     */
    public function categorySave(Request $request)
    {
        $category = $request['category_name'];
        Category::saveCategory($category);
    }

    /**
     * @return static
     * function for get categories to product create
     */
    public function getCategoryList()
    {
        $category = Category::all('id', 'category')->where('status', 0);
        return $category;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * function for get tax profiles to product create
     */
    public function getTaxProfiles()
    {
        $tax_profile = TaxProfile::all('id','value');
        return $tax_profile;
    }

    /**
     * @param Request $request
     * function for brand save
     */
    public function brandSave(Request $request)
    {
        $brand = $request['brand_name'];
        Brand::brandSave($brand);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * function for get brands to product create
     */
    public function getBrandList()
    {
        $brand = Brand::all('id', 'brand');
        return $brand;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * function for product create
     */
   public function saveProduct(Request $request)
    {

        $this->validate($request,[
            'description'=> 'required|string|max:100',
            'cost_price'=> 'required|numeric',
            'selling_price'=> 'required|numeric',

        ]);

        $barcode = $request->input('barcode');
        $description = $request->input('description');
        $category = $request->input('category');
        $brand = $request->input('brand');
        $supplier = $request->input('supplier');
        $cost_price = $request->input('cost_price');
        $selling_price = $request->input('selling_price');
//        $tax = $request->input('tax');
        $file = $request['image'];

//        $tax_info = TaxProfile::getTaxValue($tax);
//        $tax_value= $tax_info->value;

        $data = array(
            'barcode' => $barcode,
            'description' => $description,
            'category' => $category,
            'brand' => $brand,
            'supplier' => $supplier,
            'cost_price' => $cost_price,
            'selling_price' => $selling_price,
//            'tax' => $tax,
//            'tax_value' => $tax_value
        );
        Product::saveProduct($data, $file);
        return redirect()->back()->with('alert', 'Product Successfully Created !');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * function for product list
     */
    public function productList()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        $suppliers = $this->getSupplierList();
        $categories = $this->getCategoryList();
        $brands = $this->getBrandList();
        return view('layouts.product.list', compact('products', 'suppliers', 'categories', 'brands'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * function for product search
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        if ($search != null) {
            $products = Product::where('description', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(10);
            $products->appends(array('search' => Input::get('search'),));
            $suppliers = $this->getSupplierList();
            $categories = $this->getCategoryList();
            $brands = $this->getBrandList();
            if (count($products) > 0) {
                return view('layouts.product.list', compact('products', 'suppliers', 'categories', 'brands'));
            } else {
                return view('layouts.product.list')->withMessage(" No Results Found !");
            }
        }
        return redirect()->to('/product/list');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * function for product update
     */
    public function updateProduct(Request $request)
    {
        $barcode = $request->input('barcode');
        $description = $request->input('description');
        $category = $request->input('category');
        $brand = $request->input('brand');
        $supplier = $request->input('supplier');
        $cost_price = $request->input('cost_price');
        $selling_price = $request->input('selling_price');
        $tax = $request->input('tax');
        $id = $request->input('id');


        $file = $request['image'];
        $data = array(
            'barcode' => $barcode,
            'description' => $description,
            'category' => $category,
            'brand' => $brand,
            'supplier' => $supplier,
            'cost_price' => $cost_price,
            'selling_price' => $selling_price,
            'id' => $id,
            'tax' => $tax
        );

        Product::updateProduct($data, $file);
        return redirect()->back()->with('alert', 'Product Successfully Updated !');
    }


}