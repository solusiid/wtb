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

class SellerController extends Controller {
	public function showRequestSeller() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Logs';
            $data['page'] = 'content.seller.seller-request';
            return view('template.content')->with($data);
        }
    }

    public function showOfferSeller() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'System Log';
            $data['page'] = 'content.seller.seller-offer';
            return view('template.content')->with($data);
        }
    }
    
    public function showreqoff($param) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            if($param == 'seller-off') {
            	$data['page_name'] = 'Add Seller Offer';
            	$data['path_name'] = 'Seller Offer';
            	$data['param'] = $param;
                $data['page'] = 'content.seller.add-seller-offer';
                return view('template.content')->with($data);
            }
        }
    }
    
    public function showsellerdetail($param, $id) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            if($param == 'seller-off') {
            	$data['page_name'] = 'Edit Seller Offer';
            	$data['path_name'] = 'Seller Offer';
            	$data['param'] = $param;
            	$data['offer_data'] = DB::table('tbl_r_req_off')->where('id', $id)->first();
                $data['page'] = 'content.seller.edit-seller-offer';
                return view('template.content')->with($data);
            }
        }
    }
}