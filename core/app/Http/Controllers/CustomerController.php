<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Validator;
use Input;
use Hash;
use Crypt;
use Session;
use App;

class CustomerController extends Controller {
	public function showCustomerReq() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Customer Request';
            $data['page'] = 'content.customer.customer-req';
            return view('template.content')->with($data);
        }
    }

	public function showCustomerOff() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Customer Offers';
            $data['page'] = 'content.customer.customer-off';
            return view('template.content')->with($data);
        }
    }

    public function showConfirmDP() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Confirmation DP';
            $data['page'] = 'content.customer.confirm-dp';
            return view('template.content')->with($data);
        }
    }

    public function showNotificationUser() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Notification User';
            $data['page'] = 'content.customer.notification';
            return view('template.content')->with($data);
        }
    }
    
    public function showsellerdetail($id) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            	$data['page_name'] = 'Edit Customer';
            	$data['path_name'] = 'Customer';
            	$data['detail_data '] = DB::table('tbl_m_user')->where('id', $id)->first();
                $data['page'] = 'content.customer.edit-profile';
                return view('template.content')->with($data);
        }
    }
}