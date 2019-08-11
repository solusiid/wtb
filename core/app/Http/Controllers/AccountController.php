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

class AccountController extends Controller {
	public function showUserGrade() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                foreach ($p['account'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '9') {
                        $data['page_name'] = 'User Grade';
                        $data['page'] = 'content.account.user-grade';
                        return view('template.content')->with($data);
                    }
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }

	public function showCustomer() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                foreach ($p['account'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '10') {
                        $data['page_name'] = 'Customer';
                        $data['page'] = 'content.account.customer';
                        return view('template.content')->with($data);
                    }
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }

	public function showSellerAdm() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                foreach ($p['account'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '11') {
                        $data['page_name'] = 'Seller Admin';
                        $data['page'] = 'content.account.seller-admin';
                        return view('template.content')->with($data);
                    }  
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }

	public function showSeller() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                foreach ($p['account'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '12') {
                        $data['page_name'] = 'Seller';
                        $data['page'] = 'content.account.seller';
                        return view('template.content')->with($data);
                    }
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }

	public function showAdmin() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                foreach ($p['account'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '9') {
                        $data['page_name'] = 'Admin Level';
                        $data['page'] = 'content.account.admin';
                        return view('template.content')->with($data);
                    }
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }

    public function showAccountDetail($param, $id) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                if($param == 'user-account') {
                    $data['page_name'] = 'Edit Account Detail';
                    $data['path_name'] = 'User Account';
                    $data['param'] = $param;
                    $data['id_user'] = $id;
                    $data['data_user'] = DB::table('tbl_m_user')->where('id', $id)->first();
                    $data['user_level'] = DB::table('tbl_m_grade_admin')->where('grade_stat', '1')->get();
                    $data['page'] = 'content.account.account-detail';
                    return view('template.content')->with($data);
                } else if($param == 'user-grade') {
                    $data['page_name'] = 'Edit User Level';
                    $data['path_name'] = 'User Level';
                    $data['param'] = $param;
                    $data['id_user'] = $id;
                    $data['data_user_level'] = DB::table('tbl_m_grade_admin')->where('id', $id)->first();
                    $data['user_level'] = DB::table('tbl_m_menu')->where('menu_cat', 'MASTER')->get();
                    $data['user_level1'] = DB::table('tbl_m_menu')->where('menu_cat', 'ACCOUNT')->get();
                    $data['user_level2'] = DB::table('tbl_m_menu')->where('menu_cat', 'REQUEST')->get();
                    $data['user_level3'] = DB::table('tbl_m_menu')->where('menu_cat', 'SYSTEM')->get();
                    $data['page'] = 'content.account.account-detail';
                    return view('template.content')->with($data);
                } else if($param == 'cutomer') {
                    $data['page_name'] = 'Edit Customer';
                    $data['path_name'] = 'Customer';
                    $data['param'] = $param;
                    $data['id_user'] = $id;
                    $data['data_user'] = DB::table('tbl_m_user')->where('id', $id)->first();
                    $data['page'] = 'content.account.account-detail';
                    return view('template.content')->with($data);
                } else if($param == 'seller-adm') {
                    $data['page_name'] = 'Edit Seller Admin';
                    $data['path_name'] = 'Seller Admin';
                    $data['param'] = $param;
                    $data['id_user'] = $id;
                    $data['data_user'] = DB::table('tbl_m_user')->where('id', $id)->first();
                    $data['page'] = 'content.account.account-detail';
                    return view('template.content')->with($data);
                } else if($param == 'seller') {
                    $data['page_name'] = 'Edit Seller';
                    $data['path_name'] = 'Seller';
                    $data['param'] = $param;
                    $data['id_user'] = $id;
                    $data['data_user'] = DB::table('tbl_m_user')->where('id', $id)->first();
                    $data['seller_adm'] = DB::table('tbl_m_user')->where('id_grade', '3')->get();
                    $data['page'] = 'content.account.account-detail';
                    return view('template.content')->with($data);
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }
    
    public function showUserDetail($id) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                foreach ($p['account'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '10') {
                        $data['page_name'] = 'Edit Grade';
                        $data['detail_data'] = DB::table('tbl_m_grade_admin')->where('id', $id)->first();
                        $data['page'] = 'content.account.grade-detail';
                        return view('template.content')->with($data);
                    }
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }

    public function showAddMember($type) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                if($type == 'user-grade') {
                    $data['page_name'] = 'Add User Level';
                    $data['path_name'] = 'User Level';
                    $data['type'] = $type;
                    $data['user_level'] = DB::table('tbl_m_menu')->where('menu_cat', 'MASTER')->get();
                    $data['user_level1'] = DB::table('tbl_m_menu')->where('menu_cat', 'ACCOUNT')->get();
                    $data['user_level2'] = DB::table('tbl_m_menu')->where('menu_cat', 'REQUEST')->get();
                    $data['user_level3'] = DB::table('tbl_m_menu')->where('menu_cat', 'SYSTEM')->get();
                    $data['page'] = 'content.account.add-member';
                    return view('template.content')->with($data);
                } else if($type == 'user-account') {
                    $data['page_name'] = 'Add User Account';
                    $data['path_name'] = 'User Account';
                    $data['type'] = $type;
                    $data['user_level'] = DB::table('tbl_m_grade_admin')->where('grade_stat', '1')->get();
                    $data['page'] = 'content.account.add-member';
                    return view('template.content')->with($data);
                } else if($type == 'seller-adm') {
                    $data['page_name'] = 'Add Seller Admin';
                    $data['path_name'] = 'Seller Admin';
                    $data['type'] = $type;
                    $data['page'] = 'content.account.add-member';
                    return view('template.content')->with($data);
                } else if($type == 'seller') {
                    $data['page_name'] = 'Add Seller';
                    $data['path_name'] = 'Seller';
                    $data['type'] = $type;
                    $data['seller_adm'] = DB::table('tbl_m_user')->where('id_grade', '3')->get();
                    $data['page'] = 'content.account.add-member';
                    return view('template.content')->with($data);
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }
    
    public function showAddUserLevel() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['account'])) {
                foreach ($p['account'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '9') {
                        $data['page_name'] = 'User Level';
                        $data['page'] = 'content.account.add-user-level';
                        $data['user_level'] = DB::table('tbl_m_menu')->where('menu_cat', 'MASTER')->get();
                        $data['user_level1'] = DB::table('tbl_m_menu')->where('menu_cat', 'ACCOUNT')->get();
                        $data['user_level2'] = DB::table('tbl_m_menu')->where('menu_cat', 'REQUEST')->get();
                        $data['user_level3'] = DB::table('tbl_m_menu')->where('menu_cat', 'SYSTEM')->get();
                        return view('template.content')->with($data);
                    }
                }
            } else {
        	    $data['page_name'] = 'Error';
                $data['page'] = 'content.error';
                return view('template.content')->with($data);
            }
        }
    }
    
    public function showAccountDetail1($id) {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $data['page_name'] = 'Account Detail';
            $data['detail_data'] = DB::table('tbl_m_user')->where('id', $id)->first();
            $data['id_user'] = $id;
            $data['page'] = 'content.account.account-detail1';
            return view('template.content')->with($data);
        }
    }
}