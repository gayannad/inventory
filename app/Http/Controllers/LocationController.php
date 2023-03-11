<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 4/11/18
 * Time: 2:02 PM
 */

namespace App\Http\Controllers;


use App\Location;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * location create ui
     */
    public function index()
    {
        return view('layouts.location.location');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * location save function
     */
    public function saveLocation(Request $request)
    {

        $user = Auth::user()->id;
        $this->validate($request, [
            'location_name' => 'required|string|max:100',
            'contact_person' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'telephone' => 'required|string|min:10',
            // 'email' => 'required|email|max:20'
        ]);

        $name = $request->input('location_name');
        $contact_person = $request->input('contact_person');
        $address = $request->input('address');
        $telephone = $request->input('telephone');
        $email = $request->input('email');
        $type = $request->input('type');

        $data = array(
            'name' => $name,
            'contact_person' => $contact_person,
            'address' => $address,
            'telephone' => $telephone,
            'email' => $email,
            'type' => $type
        );


        Location::saveLocation($data);
        return redirect()->back()->with('alert', 'Location successfully created!');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * function for location list
     */
    public function locationList()
    {
        $locations = Location::orderBy('id', 'desc')->paginate(10);
        return view('layouts.location.list', compact('locations'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * function for location search
     */
    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search != null) {
            $locations = Location::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(10);

            $locations->appends(array('search' => Input::get('search'),
            ));

            if (count($locations) > 0) {
                return view('layouts.location.list', compact('locations'));
            } else {
                return view('layouts.location.list')->withMessage(" No Results Found !");
            }
        }
        return redirect()->to('/location/index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * function for location update
     */
    public function updateLocation(Request $request)
    {
        $name = $request->input('name');
        $contact_person = $request->input('contact_person');
        $address = $request->input('address');
        $telephone = $request->input('telephone');
        $email = $request->input('email');
        $id = $request->input('id');

        $data = array(
            'name' => $name,
            'contact_person' => $contact_person,
            'telephone' => $telephone,
            'id' => $id,
            'address' => $address,
            'email' => $email
        );

        Location::updateLocation($data);
        return redirect()->back()->with('alert', 'Location successfully created!');
    }

    public function getLocations()
    {
        $location = Location::all('id', 'name');
        return $location;
    }

}