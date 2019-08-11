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

class CoreController extends Controller {
	public function showDashboard() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Dashboard';
            $data['page'] = 'content.dashboard';
            return view('template.content')->with($data);
        }
    }

    public function showLogin() {
        return view('template.login')->with('data', 'dashboard');
    }

    public function showMerk() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Brand';
            $data['page'] = 'content.master.merk-item';
            return view('template.content')->with($data);
        }
    }

    public function showModel() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Model';
            $data['page'] = 'content.master.model-item';
            return view('template.content')->with($data);
        }
    }

    public function showType() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Type';
            $data['page'] = 'content.master.type-item';
            return view('template.content')->with($data);
        }
    }

    public function showMainCat() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Main Category';
            $data['page'] = 'content.master.main-category';
            return view('template.content')->with($data);
        }
    }

    public function showCat() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Sub Category';
            $data['page'] = 'content.master.cat-item';
            return view('template.content')->with($data);
        }
    }

    public function showPayment() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Payment Method';
            $data['page'] = 'content.master.payment-item';
            return view('template.content')->with($data);
        }
    }

    public function showTenor() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Tenor';
            $data['page'] = 'content.master.tenor-item';
            return view('template.content')->with($data);
        }
    }

    public function showCity() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'City';
            $data['page'] = 'content.master.city';
            return view('template.content')->with($data);
        }
    }
    
    public function showDetailParam($param, $id) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
        	$data['page_name'] = 'Edit ' .strtoupper($param);
            $data['page'] = 'content.master.detail';
            if($param == 'mcategory') {
                $data_file = DB::table('tbl_m_category')->where('id', $id)->first();
                $data['id_nya'] = $data_file->id;
        	    $data['path_name'] = 'Main Category';
                $data['name_nya'] = $data_file->name_cat;
            } else if($param == 'category') {
                $data_file = DB::table('tbl_m_subcat')->where('id', $id)->first();
                $data['id_nya'] = $data_file->id;
        	    $data['path_name'] = 'Category';
                $data['parent'] = DB::table('tbl_m_category')->get();
                $data['parent_id'] = $data_file->id_cat;
                $data['name_nya'] = $data_file->name_sub_cat;
            } else if($param == 'brand') {
                $data_file = DB::table('tbl_m_merk')->where('id', $id)->first();
                $data['id_nya'] = $data_file->id;
        	    $data['path_name'] = 'Brand';
                $data['parent'] = DB::table('tbl_m_subcat')->get();
                $data['parent_id'] = $data_file->id_cat;
                $data['name_nya'] = $data_file->name_merk;
            } else if($param == 'model') {
                $data_file = DB::table('tbl_m_model')->where('id', $id)->first();
                $data['id_nya'] = $data_file->id;
        	    $data['path_name'] = 'Model';
                $data['parent'] = DB::table('tbl_m_merk')->get();
                $data['parent_id'] = $data_file->id_merk;
                $data['name_nya'] = $data_file->name_model;
            } else if($param == 'type') {
                $data_file = DB::table('tbl_m_type')->where('id', $id)->first();
                $data['id_nya'] = $data_file->id;
        	    $data['path_name'] = 'Type';
                $data['parent'] = DB::table('tbl_m_model')->get();
                $data['parent_id'] = $data_file->id_model;
                $data['name_nya'] = $data_file->name_type;
            } else if($param == 'payment') {
                $data_file = DB::table('tbl_m_payment')->where('id', $id)->first();
                $data['id_nya'] = $data_file->id;
        	    $data['path_name'] = 'Payment Method';
                $data['name_nya'] = $data_file->payment_name;
            } else if($param == 'tenor') {
                $data_file = DB::table('tbl_m_tenor')->where('id', $id)->first();
                $data['id_nya'] = $data_file->id;
        	    $data['path_name'] = 'Tenor';
                $data['name_nya'] = $data_file->tenor;
            } else if($param == 'city') {
                $data_file = DB::table('tbl_m_kota')->where('id', $id)->first();
                $data['id_nya'] = $data_file->id;
        	    $data['path_name'] = 'City';
                $data['name_nya'] = $data_file->name_kota;
            }
            $data['param_nya'] = $param;
            return view('template.content')->with($data);
        }
    }
    
    public function showTambahData($id) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            if($id == 'category') {
                $data['path_name'] = 'Sub Category';
            } else if($id == 'brand') {
                $data['path_name'] = 'Brand';
            } else if($id == 'model') {
                $data['path_name'] = 'Model';
            } else if($id == 'type') {
                $data['path_name'] = 'Type';
            } else if($id == 'mcategory') {
                $data['path_name'] = 'Main Category';
            } else if($id == 'city') {
                $data['path_name'] = 'City';
            }
        	$data['page_name'] = 'Tambah Data';
        	$data['param'] = $id;
        	$data['model'] = DB::table('tbl_m_model')->get();
        	$data['merk'] = DB::table('tbl_m_merk')->get();
        	$data['category'] = DB::table('tbl_m_subcat')->get();
        	$data['mcategory'] = DB::table('tbl_m_category')->get();
            $data['page'] = 'content.master.tambah-data';
            return view('template.content')->with($data);
        }
    }
}