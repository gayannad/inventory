<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 4/11/18
 * Time: 9:47 AM
 */

namespace App\Http\Controllers;


use App\Location;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * function for user craete ui
     */
    public function index()
    {
        return View('layouts.user.user');

    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * function for logout user
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * function for access denied page
     */
    public function accessDenied()
    {
        return View('layouts.access_denied');
    }


    /**
     * @param Request $request
     * function for get user
     */
    public function getUser(Request $request)
    {
        $user = User::getUser(1);
        $request->session()->put('user', 'user');

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * function for user create
     */
    public function saveUser(Request $request)
    {

         $this->validate($request, [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            // 'mobile' => 'required|string|max:10|min:10',
            'username' => 'required|unique:users',
            'location' => 'required|string|max:1',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->locid = $request->input('location');
        $user->status = Auth::user()->id;
        $user->password = Hash::make($request->input('password'));

        $user->save();
        $id = $user->id;

        $file = $request['image'];
        if ($file != null) {
            $p = $user->first_name;
            $file_extension = $file->getClientOriginalExtension();
            $file_name = $p . '.' . $file_extension;

            $data = array(
                'img_url' => $file_name,
                'id' => $id

            );
            User::updateUserImage($data);
            $destinationPath = 'uploads/users';
            $file->move($destinationPath, $file_name);
        }

        $user->roles()->attach(Role::where('name', 'User')->first());
//        Auth::login($user);

        return redirect()->back()->with('alert', 'User successfully created!');
    }

    public function userList()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('layouts.user.list', compact('users'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search != null) {
            $users = User::where('first_name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(10);

            $users->appends(array('search' => Input::get('search'),
            ));

            if (count($users) > 0) {
                return view('layouts.user.list', compact('users'));
            } else {
                return view('layouts.user.list')->withMessage(" No Results Found !");
            }
        }
        return redirect()->to('/user/list');
    }

    public function updateUser(Request $request)
    {


        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $id = $request->input('id');

        $data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'id' => $id
        );

        User::updateUser($data);
        return redirect()->back()->with('alert', 'User successfully updated!');
    }

    public function createRole()
    {
        return view('layouts.user.role');
    }

    public function saveRole(Request $request)
    {
        $role = $request->input('role_name');
        $description = $request->input('description');
        Role::saveRole($role, $description);
        return redirect()->back()->with('alert', 'Role successfully created!');
    }

    public function roleList()
    {
        $roles = Role::all();
        return view('layouts.user.role_list', compact('roles'));
    }

    public function permission()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('layouts.user.permission', compact('users'));
    }

   public function assignRoles(Request $request)
    {
        $user = User::where('username', $request['username'])->first();
        $user->roles()->detach();
        if ($request['role_admin']) {
            $user->roles()->attach(Role::where('name', 'admin')->first());
        }
        if ($request['role_manager']) {
            $user->roles()->attach(Role::where('name', 'manager')->first());
        }
        if ($request['role_user']) {
            $user->roles()->attach(Role::where('name', 'user')->first());
        }

        return redirect()->back()->with('alert', 'User permission updated!');
    }

    public function searchUserForRole(Request $request)
    {
        $search = $request->input('search');

        if ($search != null) {
            $users = User::where('first_name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(10);

            $users->appends(array('search' => Input::get('search'),));

            if (count($users) > 0) {
                return view('layouts.user.permission', compact('users'));
            } else {
                return view('layouts.user.permission')->withMessage(" No Results Found !");
            }
        }
        return redirect()->to('/user/permission');
    }

    public function userProfile()
    {
        return view('layouts.user.profile');
    }

    public function updateProfile()
    {

    }

    public function getLocations()
    {
        $location= Location::all('id','name');
        return $location;
    }

    public function users(){
        $users = Role::users();

        var_dump($users);
        exit();
    }
}

