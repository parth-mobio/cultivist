<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\customer;
use Illuminate\Support\Facades\Mail;
use App\PatientDocument;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use DB;
use Hash;
use Validator;


class customerController extends Controller {

 

    public function index() {
        $datas = customer::OrderBY('id', 'desc')
                ->get();

        $this->data['datas'] = $datas;       

        return view('admin.customer.index', $this->data);
    }

    public function edit($id)
    {
        $edit = customer::where('id',$id)->first();
        return view('admin.customer.edit',compact('edit'));
    }

    public function destroy($id)
    {
        customer::where('id',$id)->delete();
       return redirect('customer')->with('success','Customer deleted successfully');
    }
}
