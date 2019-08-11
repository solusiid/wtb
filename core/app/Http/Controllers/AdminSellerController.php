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

class AdminSellerController extends Controller {
	public function showAllReqOff() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'All Request & Offers';
            $data['page'] = 'content.admin-seller.all-req-off';
            return view('template.content')->with($data);
        }
    }

    public function showSetting() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $data['page_name'] = 'Setting Admin Seller';
            $data['category'] = DB::table('tbl_m_subcat')->get();
            $data['brand'] = DB::table('tbl_m_merk')->get();
            $data['page'] = 'content.admin-seller.setting';
            return view('template.content')->with($data);
        }
    }

    public function showAccountDetail($id) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $data['page_name'] = 'Account Detail';
            $data['page'] = 'content.admin-seller.account-detail-admin';
            return view('template.content')->with($data);
        }
    }
}