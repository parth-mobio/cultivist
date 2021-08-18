<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Input\Input;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function Remove($id) {
        User::where('id', $id)->delete();
        Session::flash('message', 'Admin deleted successfully!!');
        Session::flash('alert-class', 'alert-danger');
        return redirect('users');
    }

    public function index() {
        $datas = User::orderBy('id', 'desc')
                ->get();
        $this->data['datas'] = $datas;
        return view('admin.user.index', $this->data);
    }

    public function add() {
        return view('admin.user.add');
    }

    public function Insert(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|string|unique:users,email',
            'name' => 'required',
            'password' => 'required',
            'cpassword' => 'required',
            'phone' => 'required',
        //    'role' => 'required',
            'image' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
        ]);

        $file = $request->file('image');
        if (isset($file) && !empty($file)) {
            $file = time() . "_" . $file->getClientOriginalName();
            $destinationPath = public_path() . '/uploads/admin/';
            if (!is_dir($destinationPath)) :
                mkdir($destinationPath, 0777);
                chmod($destinationPath, 0777);
            endif;
            $request->image->move($destinationPath, $file);
        } else {
            $file = '';
        }
        $data = new User;

        $data['password'] = Hash::make($request->password);
        $data['name'] = $request->name;

        $data['email'] = $request->email;
        $data['contact'] = $request->phone;
        $data['image'] = $file;
        $data['country'] = $request->country;
        $data['city'] = $request->city;
        $data['address'] = $request->address;
        $data['zipcode'] = $request->zipcode;
    //    $data['role'] = $request->role;
        $data['status'] = $request->status;
        $data['updated_at'] = NOW();
        $data['created_at'] = NOW();

        $data->save();
        Session::flash('message', 'Admin Created successfully!!');
        Session::flash('alert-class', 'alert-success');
        return redirect('users');
    }

    public function update($id) {
        $this->data['edit'] = User::where('id', '=', $id)->first();

        return view('admin.user.edit', $this->data);
    }

    public function Update_($id, Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|string|unique:users,email,' . $id,
            'name' => 'required',
            'phone' => 'required',
        //    'role' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
        ]);


        $user_data = User::where('id', '=', $id)->first();


        $file = $request->file('image');
        if (isset($file) && !empty($file)) {
            $file = time() . "_" . $file->getClientOriginalName();
            $destinationPath = public_path() . '/uploads/admin/';
            if (!is_dir($destinationPath)) :
                mkdir($destinationPath, 0777);
                chmod($destinationPath, 0777);
            endif;
            $request->image->move($destinationPath, $file);
        } else {
            $file = $user_data->image;
        }



        $category = new User;

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['contact'] = $request->phone;
        $data['image'] = $file;
        $data['country'] = $request->country;
        $data['city'] = $request->city;
        $data['address'] = $request->address;
        $data['zipcode'] = $request->zipcode;
    //    $data['role'] = $request->role;
        $data['status'] = $request->status;
        $data['updated_at'] = NOW();


        User::where('id', '=', $id)->update($data);
        Session::flash('message', 'Admin updated successfully!!');
        Session::flash('alert-class', 'alert-success');
        return redirect('users');
    }
    public function my_profile($id)
    {
        $this->data['edit'] = User::where('id', '=', $id)->first();

        return view('admin.user.myprofile', $this->data);   
    }

    public function updateStatus(Request $request) {
        $id = $request->id;
        $date = User::find($id);
        $date->status = $request->status;
        $date->updated_at = NOW();
        $date->update();
        $resp = array("status" => 1, "message" => "successfully update status");
        echo json_encode($resp);
        exit;
    }

    public function change_password($id)
    {
        return view('admin.user.change_password',compact('id'));
    }

    public function update_password(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required',
            'retype_password' => 'required|same:password',
            
        ]);
        $data['id'] = $id;
        $data['password'] = Hash::make($request->password);

        user::where('id','=',$id)->update($data);

        Auth::guard('web')->logout();
        $request->session()->regenerate();
        return redirect('login');        


    }

}
