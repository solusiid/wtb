<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Crypt;
use Redirect;
use App;
use Excel;

class APIController extends Controller {
    public function getCsrf() {
        return response(csrf_token());
    }
	public function doLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            $result = array('rc' => '01', 'rcdesc' => 'PARAM_MISSING', 'message' => 'Username or Password is missing!');
            return json_encode($result);
        }
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => $email, 'detail_log' => 'Login to system']);
            $result = array('rc' => '00', 'rcdesc' => 'SUCCESS', 'message' => 'Success Login!');
            return json_encode($result);
        } else {
            $result = array('status' => '02', 'rcdesc' => 'INVALID_CREDENTIAL', 'messages' => 'username and password doesn\'t match');
            return json_encode($result);
        }
    }

    public function doLogout() {
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Logout from system']);
    	Auth::logout();
        return redirect(route('login'));
    }

    public function doListNotifUser(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
    	$list = DB::table('tbl_r_notification')->where('receiver_id', $req->id)->where('status_read', '0')->count();
    	$html = '';
    	if($list == 0) {
    		$html .= '';
    	} else {
    		$html .= '<span class="badge badge-pill badge-danger">' .$list. '</span>';
    	}
    	return $html;
    }
    
    function multineedle_stripos($haystack, $needles, $offset=0) {
        foreach($needles as $needle) {
            $found[$needle] = stripos($haystack, $needle, $offset);
        }
        return $found;
    }

    // MASTER
    public function doListMerk() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Brand']);
    	$list = DB::table('tbl_m_merk')->get();
    	return json_encode($list);
    }

    public function doUploadListMerk(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Upload list Brand']);
    	$file = Input::file('fileInput');
    	$ext = $file->getClientOriginalExtension();
    	$fileName = md5(time()).".$ext";
        $destinationPath = "uploads/".date('Y').'/'.date('m').'/';
        $moved_file = $file->move($destinationPath, $fileName);
        $path = $moved_file->getRealPath();
        $data_process = [];
        $file = $destinationPath . '' . $fileName;
        $dataImport = Excel::load($file)->get();
        $i = 1;
        $berhasil = 0;
        $gagal = 0;
        $key = '<';
        
        if($ext != 'csv') {
            $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
            return json_encode($result);
        }
        foreach ($dataImport as $d) {
            if (stripos($d->name, $key) === false) {
                if (stripos($d->category, $key) === false) {
                    if (stripos($d->status, $key) === false) {
                        if(!empty($d->name)) {
                            $insert = DB::table('tbl_m_merk')->insert([
                        		'name_merk' => $d->name,
                        		'stat_merk' => $d->status,
                        	]);
                        	if($insert) {
                        		$berhasil = $berhasil + 1;
                        	} else {
                        		$gagal = $gagal + 1;
                        	}
                        }
                    }
                }
            }
        }
        $data = array('rc' => '00', 'rcdesc' => 'Success Upload data!'); //' Success : ' + $berhasil + ' & Failed : ' + $gagal);
        return json_encode($data);
    }

    public function doListModel() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Model']);
    	$list = DB::table('tbl_m_model')->leftjoin('tbl_m_merk', 'tbl_m_merk.id', '=', 'tbl_m_model.id_merk')->select('tbl_m_model.id', 'name_model', 'name_merk', 'stat_model')->get();
    	return json_encode($list);
    }

    public function doUploadListModel(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Upload list Model']);
    	$file = Input::file('fileInput');
    	$ext = $file->getClientOriginalExtension();
    	$fileName = md5(time()).".$ext";
        $destinationPath = "uploads/".date('Y').'/'.date('m').'/';
        $moved_file = $file->move($destinationPath, $fileName);
        $path = $moved_file->getRealPath();
        $data_process = [];
        $file = $destinationPath . '/' . $fileName;
        $dataImport = Excel::load($file)->get();
        $i = 1;
        $berhasil = 0;
        $gagal = 0;
        $key = '<';
        if($ext != 'csv') {
            $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
            return json_encode($result);
        }
        foreach ($dataImport as $d) {
        	$id_brand = DB::table('tbl_m_merk')->where('name_merk', $d->brand)->first();
        	if(!empty($id_brand)) {
        	    if (stripos($d->name, $key) === false) {
                    if (stripos($d->status, $key) === false) {
                        if(!empty($d->name)) {
                            $insert = DB::table('tbl_m_model')->insert([
            	        		'id_merk' => $id_brand->id,
            	        		'name_model' => $d->name,
            	        		'stat_model' => $d->status,
            	        	]);
                        	if($insert) {
                        		$berhasil = $berhasil + 1;
                        	} else {
                        		$gagal = $gagal + 1;
                        	}
                        }
                    }
                }
        	}
        }
        $data = array('rc' => '00', 'rcdesc' => 'Success Upload data!'); //' Success : ' + $berhasil + ' & Failed : ' + $gagal);
        return json_encode($data);
    }

    public function doListType() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Type']);
    	$list = DB::table('tbl_m_type')
    			->leftjoin('tbl_m_model', 'tbl_m_model.id', '=', 'tbl_m_type.id_model')
    			->select('tbl_m_type.id', 'name_type', 'name_model', 'stat_type')
    			->get();
    	return json_encode($list);
    }

    public function doUploadListType(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Upload list Type']);
    	$file = Input::file('fileInput');
    	$ext = $file->getClientOriginalExtension();
    	$fileName = md5(time()).".$ext";
        $destinationPath = "uploads/".date('Y').'/'.date('m').'/';
        $moved_file = $file->move($destinationPath, $fileName);
        $path = $moved_file->getRealPath();
        $data_process = [];
        $file = $destinationPath . '/' . $fileName;
        $dataImport = Excel::load($file)->get();
        $i = 1;
        $berhasil = 0;
        $gagal = 0;
        $key = '<';
        if($ext != 'csv') {
            $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
            return json_encode($result);
        }
        foreach ($dataImport as $d) {
        	$id_brand = DB::table('tbl_m_model')->where('name_model', $d->model)->first();
        	if(!empty($id_brand)) {
        	    if (stripos($d->name, $key) === false) {
                    if (stripos($d->status, $key) === false) {
                        if(!empty($d->name)) {
                            $insert = DB::table('tbl_m_type')->insert([
            	        		'id_model' => $id_brand->id,
            	        		'name_type' => $d->name,
            	        		'stat_type' => $d->status,
            	        	]);
                        	if($insert) {
                        		$berhasil = $berhasil + 1;
                        	} else {
                        		$gagal = $gagal + 1;
                        	}
                        }
                    }
                }
        	}
        }
        $data = array('rc' => '00', 'rcdesc' => 'Success Upload data!'); //' Success : ' + $berhasil + ' & Failed : ' + $gagal);
        return json_encode($data);
    }

    public function doListMainCat() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Main Category']);
    	$list = DB::table('tbl_m_category')->get();
    	return json_encode($list);
    }

    public function doListCat() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Category']);
    	$list = DB::table('tbl_m_subcat')
    			->leftjoin('tbl_m_category', 'tbl_m_category.id', '=', 'tbl_m_subcat.id_cat')
    			->select('tbl_m_subcat.id', 'name_sub_cat', 'name_cat', 'stat_subcat')
    			->get();
    	return json_encode($list);
    }

    public function doUploadListCat(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Upload list Category']);
    	$file = Input::file('fileInput');
    	$ext = $file->getClientOriginalExtension();
    	$fileName = md5(time()).".$ext";
        $destinationPath = "uploads/".date('Y').'/'.date('m').'/';
        $moved_file = $file->move($destinationPath, $fileName);
        $path = $moved_file->getRealPath();
        $data_process = [];
        $file = $destinationPath . '/' . $fileName;
        $dataImport = Excel::load($file)->get();
        $i = 1;
        $berhasil = 0;
        $gagal = 0;
        $key = '<';
        if($ext != 'csv') {
            $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
            return json_encode($result);
        }
        foreach ($dataImport as $d) {
        	$id_brand = DB::table('tbl_m_category')->where('name_cat', $d->parent_category)->count();
        	if($id_brand == 0) {
        	    if (stripos($d->parent_category, $key) === false) {
                    if (stripos($d->name, $key) === false) {
                        if (stripos($d->status, $key) === false) {
                            DB::table('tbl_m_category')->insert([
                    			'name_cat' => $d->parent_category
                    		]);
                    		$id_cat = DB::table('tbl_m_category')->where('name_cat', $d->parent_category)->first();
                    		if(!empty($d->name)) {
                        		$insert = DB::table('tbl_m_subcat')->insert([
                	        		'id_cat' => $id_cat->id,
                	        		'name_sub_cat' => $d->name,
                	        		'stat_subcat' => $d->status,
                	        	]);
                	        	if($insert) {
                	        		$berhasil = $berhasil + 1;
                	        	} else {
                	        		$gagal = $gagal + 1;
                	        	}
                    		}
                        }
                    }
                }
        	} else {
        	    if (stripos($d->parent_category, $key) === false) {
                    if (stripos($d->name, $key) === false) {
                        if (stripos($d->status, $key) === false) {
                            $id_cat = DB::table('tbl_m_category')->where('name_cat', $d->parent_category)->first();
                    		$insert = DB::table('tbl_m_subcat')->insert([
            	        		'id_cat' => $id_cat->id,
            	        		'name_sub_cat' => $d->name,
            	        		'stat_subcat' => $d->status,
            	        	]);
            	        	if($insert) {
            	        		$berhasil = $berhasil + 1;
            	        	} else {
            	        		$gagal = $gagal + 1;
            	        	}
                        }
                    }
                }
        	}
        }
        $data = array('rc' => '00', 'rcdesc' => 'Success Upload data!'); //' Success : ' + $berhasil + ' & Failed : ' + $gagal);
        return json_encode($data);
    }

    public function doListPayment() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Payment Method']);
    	$list = DB::table('tbl_m_payment')
    			->get();
    	return json_encode($list);
    }

    public function doListTenor() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Tenor']);
    	$list = DB::table('tbl_m_tenor')
    			->get();
    	return json_encode($list);
    }

    public function doAddPayment(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $validator = Validator::make($req->all(), [
           'payment' => 'required|max:20',
        ]);
        if ($validator->fails()) {
            $data = array('rc' => '01', 'rcdesc' => 'Invalid Param!');
            return json_encode($data);
        }
        $key = '<';
        if(stripos(strtoupper($req->payment), $key) === false) {
            $db = DB::table('tbl_m_payment')->insert([
        		'payment_name' => $req->payment,
        		'stat_payment' => '1'
        	]);
        	if($db) {
                DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Add Payment Method']);
        		$data = array('rc' => '00', 'rcdesc' => 'Success add data!');
        	} else {
        		$data = array('rc' => '01', 'rcdesc' => 'Failed add data!');
        	}
        	return json_encode($data);
        } else {
            $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
            return json_encode($hasil);
        }
    }

    public function doAddTenor(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        if(preg_match('/^[0-9]+$/', $req->payment)) {
            $validator = Validator::make($req->all(), [
                'payment' => 'required|max:4'
            ]);
            $key = '<';
            if(stripos($req->payment, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $db = DB::table('tbl_m_tenor')->insert([
            		'tenor' => $req->payment,
            		'tenor_name' => $req->payment. ' Bulan',
            		'stat_tenor' => '1'
            	]);
            	if($db) {
                    DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Add Tenor']);
            		$data = array('rc' => '00', 'rcdesc' => 'Success add data!');
            	} else {
            		$data = array('rc' => '01', 'rcdesc' => 'Failed add data!');
            	}
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else {
            $data = array('rc' => '01', 'rcdesc' => 'Invalid Param!');
        }
        return json_encode($data);
    }

    public function doListCity() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu City']);
    	$list = DB::table('tbl_m_kota')
    			->get();
    	return json_encode($list);
    }

    public function doUploadListCity(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Upload list City']);
    	$file = Input::file('fileInput');
    	$ext = $file->getClientOriginalExtension();
    	$fileName = md5(time()).".$ext";
        $destinationPath = "uploads/".date('Y').'/'.date('m').'/';
        $moved_file = $file->move($destinationPath, $fileName);
        $path = $moved_file->getRealPath();
        $data_process = [];
        $file = $destinationPath . '/' . $fileName;
        $dataImport = Excel::load($file)->get();
        $i = 1;
        $berhasil = 0;
        $gagal = 0;
        $key = 'script';
        if($ext != 'csv') {
            $result = array('rc' => '01', 'rcdesc' => 'File must be csv!');
            return json_encode($result);
        }
        foreach ($dataImport as $d) {
        	$id_brand = DB::table('tbl_m_kota')->where('name_kota', $d->kota_kabupaten_city)->count();
        	if($id_brand == 0) {
        	    if(stripos($d->kota_kabupaten_city, $key) === false) {
        	        if(!empty($d->kota_kabupaten_city)) {
                		DB::table('tbl_m_kota')->insert([
                			'name_kota' => $d->kota_kabupaten_city,
                			'stat_kota' => '1'
                		]);
        	        }
        	    }
        	}
        }
        $data = array('rc' => '00', 'rcdesc' => 'Success Upload data!'); //' Success : ' + $berhasil + ' & Failed : ' + $gagal);
        return json_encode($data);
    }

    // ACCOUNT
    public function doListGrade() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu User Level']);
    	$list = DB::table('tbl_m_grade_admin')
    			->get();
    	return json_encode($list);
    }

    public function doListAdmin() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu User Account']);
    	$list = DB::table('tbl_m_user')->where('id_grade', '1')
    	        ->leftjoin('tbl_m_grade_admin', 'tbl_m_user.id_grade', '=', 'tbl_m_grade_admin.id')
    	        ->select('tbl_m_user.id', 'name', 'email', 'grade_desc', 'user_status')
    	        ->get();
    	return json_encode($list);
    }

    public function doListCustomer() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Customer']);
    	$list = DB::table('tbl_m_user')->where('id_grade', '2')->get();
    	return json_encode($list);
    }

    public function doListSellerAdm() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Seller Admin']);
    	$list = DB::table('tbl_m_user')->where('id_grade', '3')->get();
    	return json_encode($list);
    }

    public function doListSeller() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Seller']);
    	$list = DB::table('tbl_m_user')->where('id_grade', '4')->get();
    	return json_encode($list);
    }
    
    public function doListSellerBy() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu Seller']);
    	$list = DB::table('tbl_m_user')->where('id_seller_adm', Auth::user()->id)->get();
    	return json_encode($list);
    }

    public function doListPaymentUser() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access menu List Payment User']);
    	$list = DB::table('tbl_r_payment')
    			->leftjoin('tbl_m_user', 'tbl_m_user.id', '=', 'id_user')
    			//->leftjoin('tbl_m_user', 'tbl_m_user.id', '=', 'id_seller')
    			->leftjoin('tbl_m_payment', 'tbl_m_payment.id', '=', 'id_payment')
    			->orderby('tbl_r_payment.create_at', 'DESC')
    			->select('invoice_no', 'tbl_m_user.name as user', 'tbl_m_user.name as seller', 'nominal', 'img_payment')
    			->get();
    	$data = [];
    	$i = 1;
    	foreach ($list as $key => $value) {
    		$data = [
    			'id' => $i,
    			'invoice_no' => $value->invoice_no,
    			'user' => $value->user,
    			'seller' => 0,//$value->seller,
    			'nominal' => $value->nominal,
    			'img_payment' => $value->img_payment,
    		];
    		$i++;
    	}
    	return json_encode($data);
    }

    public function doUpdateData(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $key = '<';
        if($req->param == 'user-account') {
        	$validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required',
                'phoneno' => 'required',
            ]);
            if(stripos($req->name, $key) === false && stripos($req->email, $key) === false && stripos($req->phoneno, $key) === false && stripos($req->alamat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $db_update = DB::table('tbl_m_grade_admin')->where('id', $req->user_level_id)->count();
                if($db_update == '1') {
                    $db_grade = DB::table('tbl_m_grade_admin')->where('id', $req->user_level_id)->first();
                    if(empty($req->password)) {
                        $db_update1 = DB::table('tbl_m_user')
                                    ->where('id', $req->id_user)
                                    ->update([
                                        'name' => $req->name,
                                        'email' => $req->email,
                                        'phone_no' => $req->phoneno,
                                        'address' => $req->alamat,
                                        'access_menu' => $db_grade->access_menu,
                                        'access_grade' => $req->user_level_id,
                                        'update_at' => date('Y-m-d H:i:s'),
                                    ]);
                        if($db_update1) {
                            DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update User Account']);
                            $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('user-account'));
                            return json_encode($result);
                        } else {
                            $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                            return json_encode($result);
                        }
                    } else {
                        $db_update1 = DB::table('tbl_m_user')
                                    ->where('id', $req->id_user)
                                    ->update([
                                        'name' => $req->name,
                                        'email' => $req->email,
                                        'password' => bcrypt($req->password),
                                        'phone_no' => $req->phoneno,
                                        'address' => $req->alamat,
                                        'access_menu' => $db_grade->access_menu,
                                        'access_grade' => $req->user_level_id,
                                        'update_at' => date('Y-m-d H:i:s'),
                                    ]);
                        if($db_update1) {
                            DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update User Account']);
                            $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('user-account'));
                            return json_encode($result);
                        } else {
                            $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                            return json_encode($result);
                        }
                    }
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Grade is missing!');
                    return json_encode($result);
                }
            } else {
                $result = array('rc' => '09', 'rcdesc' => 'XSS Detected!');
                return json_encode($result);
            }
        } else if($req->param == 'user-grade') {
        	$validator = Validator::make($req->all(), [
                'grade_code' => 'required',
                'grade_desc' => 'required',
            ]);
            if(stripos($req->grade_code, $key) === false && stripos($req->grade_desc, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $master = []; $account = []; $request = []; $system = [];
                if(!empty($req->menu_master)) {
                    foreach ($req->menu_master as $key => $value) {
                        $name = DB::table('tbl_m_menu')->where('id', $value)->first();
                        $master[] = [
                            'menu_name' => $name->menu_param,
                            'menu_param' => $value,
                        ];
                    }
                }
                if(!empty($req->menu_account)) {
                    foreach ($req->menu_account as $key => $value) {
                        $name = DB::table('tbl_m_menu')->where('id', $value)->first();
                        $account[] = [
                            'menu_name' => $name->menu_param,
                            'menu_param' => $value,
                        ];
                    }
                }
                if(!empty($req->menu_request)) {
                    foreach ($req->menu_request as $key => $value) {
                        $name = DB::table('tbl_m_menu')->where('id', $value)->first();
                        $request[] = [
                            'menu_name' => $name->menu_param,
                            'menu_param' => $value,
                        ];
                    }
                }
                if(!empty($req->menu_system)) {
                    foreach ($req->menu_system as $key => $value) {
                        $name = DB::table('tbl_m_menu')->where('id', $value)->first();
                        $system[] = [
                            'menu_name' => $name->menu_param,
                            'menu_param' => $value,
                        ];
                    }
                }
                $json_menu = [
                    'master' => $master,
                    'account' => $account,
                    'request' => $request,
                    'system' => $system,
                ];
                $db_update = DB::table('tbl_m_grade_admin')
                ->where('id', $req->id_user)
                ->update([
                        'grade_code' => $req->grade_code,
                        'grade_desc' => $req->grade_desc,
                        'access_menu' => json_encode($json_menu),
                    ]);
                if($db_update) {
                    DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update User Level']);
                    $result = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'route'=>route('user-grade'));
                    return json_encode($result);
                } else {
                    $result = array('rc'=>'01', 'rcdesc'=>'Gagal');
                    return json_encode($result);
                }
            } else {
                $result = array('rc' => '09', 'rcdesc' => 'XSS Detected!');
                return json_encode($result);
            }
        } else if($req->param == 'cutomer') {
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required',
                'phoneno' => 'required',
            ]);
            if(stripos($req->name, $key) === false && stripos($req->email, $key) === false && stripos($req->phoneno, $key) === false && stripos($req->alamat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                if(empty($req->password)) {
                    $db_update1 = DB::table('tbl_m_user')
                                ->where('id', $req->id_user)
                                ->update([
                                    'name' => $req->name,
                                    'email' => $req->email,
                                    'phone_no' => $req->phoneno,
                                    'address' => $req->alamat,
                                    'notif_email' => $req->notif_email,
                                    'update_at' => date('Y-m-d H:i:s'),
                                ]);
                    if($db_update1) {
                        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update Customer']);
                        $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('cutomer'));
                        return json_encode($result);
                    } else {
                        $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                        return json_encode($result);
                    }
                } else {
                    $db_update1 = DB::table('tbl_m_user')
                                ->where('id', $req->id_user)
                                ->update([
                                    'name' => $req->name,
                                    'email' => $req->email,
                                    'password' => bcrypt($req->password),
                                    'phone_no' => $req->phoneno,
                                    'address' => $req->alamat,
                                    'notif_email' => $req->notif_email,
                                    'update_at' => date('Y-m-d H:i:s'),
                                ]);
                    if($db_update1) {
                        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update Customer']);
                        $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('cutomer'));
                        return json_encode($result);
                    } else {
                        $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                        return json_encode($result);
                    }
                }
            } else {
                $result = array('rc' => '09', 'rcdesc' => 'XSS Detected!');
                return json_encode($result);
            }
        } else if($req->param == 'seller-adm') {
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required',
                'phoneno' => 'required',
            ]);
            if(stripos($req->name, $key) === false && stripos($req->email, $key) === false && stripos($req->phoneno, $key) === false && stripos($req->alamat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                if(empty($req->password)) {
                    $db_update1 = DB::table('tbl_m_user')
                                ->where('id', $req->id_user)
                                ->update([
                                    'name' => $req->name,
                                    'email' => $req->email,
                                    'phone_no' => $req->phoneno,
                                    'address' => $req->alamat,
                                    'update_at' => date('Y-m-d H:i:s'),
                                ]);
                    if($db_update1) {
                        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update Seller Admin']);
                        $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('seller-adm'));
                        return json_encode($result);
                    } else {
                        $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                        return json_encode($result);
                    }
                } else {
                    $db_update1 = DB::table('tbl_m_user')
                                ->where('id', $req->id_user)
                                ->update([
                                    'name' => $req->name,
                                    'email' => $req->email,
                                    'password' => bcrypt($req->password),
                                    'phone_no' => $req->phoneno,
                                    'address' => $req->alamat,
                                    'update_at' => date('Y-m-d H:i:s'),
                                ]);
                    if($db_update1) {
                        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update Seller Admin']);
                        $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('seller-adm'));
                        return json_encode($result);
                    } else {
                        $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                        return json_encode($result);
                    }
                }
            } else {
                $result = array('rc' => '09', 'rcdesc' => 'XSS Detected!');
                return json_encode($result);
            }
        } else if($req->param == 'seller') {
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required',
                'phoneno' => 'required',
            ]);
            if(stripos($req->name, $key) === false && stripos($req->email, $key) === false && stripos($req->phoneno, $key) === false && stripos($req->alamat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                if(empty($req->password)) {
                    $db_update1 = DB::table('tbl_m_user')
                                ->where('id', $req->id_user)
                                ->update([
                                    'name' => $req->name,
                                    'email' => $req->email,
                                    'phone_no' => $req->phoneno,
                                    'address' => $req->alamat,
                                    'id_seller_adm' => $req->id_seller_adm,
                                    'update_at' => date('Y-m-d H:i:s'),
                                ]);
                    if($db_update1) {
                        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update Seller']);
                        $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('seller'));
                        return json_encode($result);
                    } else {
                        $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                        return json_encode($result);
                    }
                } else {
                    $db_update1 = DB::table('tbl_m_user')
                                ->where('id', $req->id_user)
                                ->update([
                                    'name' => $req->name,
                                    'email' => $req->email,
                                    'password' => bcrypt($req->password),
                                    'phone_no' => $req->phoneno,
                                    'address' => $req->alamat,
                                    'id_seller_adm' => $req->id_seller_adm,
                                    'update_at' => date('Y-m-d H:i:s'),
                                ]);
                    if($db_update1) {
                        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Update Seller']);
                        $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('seller'));
                        return json_encode($result);
                    } else {
                        $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                        return json_encode($result);
                    }
                }
            } else {
                $result = array('rc' => '09', 'rcdesc' => 'XSS Detected!');
                return json_encode($result);
            }
        } else {
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required',
            ]);
            if(stripos($req->name, $key) === false && stripos($req->email, $key) === false && stripos($req->phoneno, $key) === false && stripos($req->alamat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                if(empty($req->password)) {
                    $db_update1 = DB::table('tbl_m_user')
                                ->where('id', $req->id_user)
                                ->update([
                                    'name' => $req->name,
                                    'email' => $req->email,
                                    'address' => $req->alamat,
                                    'update_at' => date('Y-m-d H:i:s'),
                                ]);
                    if($db_update1) {
                        $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('seller'));
                        return json_encode($result);
                    } else {
                        $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                        return json_encode($result);
                    }
                } else {
                    $db_update1 = DB::table('tbl_m_user')
                                ->where('id', $req->id_user)
                                ->update([
                                    'name' => $req->name,
                                    'email' => $req->email,
                                    'password' => bcrypt($req->password),
                                    'address' => $req->alamat,
                                    'update_at' => date('Y-m-d H:i:s'),
                                ]);
                    if($db_update1) {
                        $result = array('rc' => '00', 'rcdesc' => 'Success update User Account!', 'route'=>route('seller'));
                        return json_encode($result);
                    } else {
                        $result = array('rc' => '03', 'rcdesc' => 'Failed update User Account!');
                        return json_encode($result);
                    }
                }
            } else {
                $result = array('rc' => '09', 'rcdesc' => 'XSS Detected!');
                return json_encode($result);
            }
        }
    }

    // Logs
    public function doListLogs() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Log']);
    	$list = DB::table('tbl_r_log')->get();
    	return json_encode($list);
    }

    public function doListOTPLogs() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Log OTP']);
    	$list = DB::table('tbl_r_otp')->get();
    	return json_encode($list);
    }

    public function doListEmailNotif() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Notif']);
    	$list = DB::table('tbl_r_email_notif')->get();
    	return json_encode($list);
    }

    // Request
    public function doListRequest() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Request']);
    	$list = DB::table('tbl_r_req_off')->where('type_order', 'REQUEST')->get();
    	return json_encode($list);
    }

    public function doListOffers() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Offers']);
    	$list = DB::table('tbl_r_req_off')->where('type_order', 'OFFERS')->get();
    	return json_encode($list);
    }

    // Customer
    public function doListRequestPerUser() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Request User']);
    	$list = DB::table('tbl_r_req_off')->where('type_order', 'REQUEST')->where('id_sender', Auth::user()->id)->get();
    	return json_encode($list);
    }

    public function doListOffersPerUser() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Offers User']);
    	$list = DB::table('tbl_r_req_off')
    			->where('type_order', 'OFFERS')
    			->where('id_receiver', Auth::user()->id)
    			->orwhere('id_sender', Auth::user()->id)
    			->get();
    	return json_encode($list);
    }

    public function doConfirmDP(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Confirm Down Payment']);
    	$validator = Validator::make($req->all(), [
            'invoice_no' => 'required',
            'amount' => 'required',
            'sender_name' => 'required',
            'sender_bank' => 'required'
        ]);
        if ($validator->fails()) {
            $result = array('rc' => '01', 'rcdesc' => 'PARAM_MISSING', 'message' => 'Data is missing!');
            return json_encode($result);
        }
        $key = '<';
        if(stripos(strtoupper($req->invoice_no), $key) === false && stripos(strtoupper($req->sender_name), $key) === false && stripos(strtoupper($req->sender_bank), $key) === false && stripos(strtoupper($req->amount), $key) === false) {
            $insert = DB::table('tbl_r_payment')->insert([
            	'invoice_no' => $req->invoice_no,
            	'id_user' => Auth::user()->id,
            	'id_seller' => NULL,
            	'id_payment' => NULL,
            	'sender_name' => $req->sender_name,
            	'sender_bank' => $req->sender_bank,
            	'nominal' => $req->amount,
            	'date_payment' => NULL,
            	'img_payment' => NULL,
            	'stat_payment' => '0',
            	'create_at' => date('Y-m-d H:i:s'),
            ]);
            DB::table('tbl_r_notification')->where('no_offers', $req->invoice_no)->where('receiver_id', Auth::user()->id)->update(['type_notif'=>'PAYMENT_OFFER']);
            if($insert) {
            	$result = array('rc' => '00', 'rcdesc' => 'SUCCESS', 'message' => 'Success send confirmation DP!');
            } else {
            	$result = array('rc' => '02', 'rcdesc' => 'FAILED', 'message' => 'Failed send confirmation DP!');
            }
        }
        return json_encode($result);
    }

    public function doListNotification() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Notification']);
    	$list = DB::table('tbl_r_notification')->where('user_id', Auth::user()->id)->get();
    	return json_encode($list);
    }

    // Admin Seller
    public function doBrandChoose(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Access Menu Setting']);
        $brand = DB::table('tbl_m_merk')->whereIn('id_cat', $req->provinsi)->get();
        return json_encode($brand);
    }

    public function doAddSeller(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $key = 'script';
        $validator = Validator::make($req->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            $result = array('rc' => '01', 'rcdesc' => 'Username or Password is missing!');
            return json_encode($result);
        }
        if(stripos(strtoupper($req->name), $key) == false && stripos(strtoupper($req->email), $key) == false && stripos(strtoupper($req->password), $key) == false && 
        stripos(strtoupper($req->phoneno), $key) == false && stripos(strtoupper($req->alamat), $key) == false) {
            $insert = DB::table('tbl_m_user')->insert([
                'name' => $req->name,
                'email' => $req->email,
                'password' => bcrypt($req->password),
                'phone_no' => $req->phoneno,
                'address' => $req->alamat,
                'id_seller_adm' => Auth::user()->id,
                'id_grade' => '4',
                'create_at' => date('Y-m-d H:i:s'),
            ]);
            if($insert) {
                DB::table('tbl_r_log')->insert(['time_log' => date('Y-m-d H:i:s'), 'user_log' => Auth::user()->email, 'detail_log' => 'Add Seller']);
                $result = array('rc' => '00', 'rcdesc' => 'Success create new seller!');
            } else {
                $result = array('rc' => '02', 'rcdesc' => 'Failed create new seller!');
            }
        }
        return json_encode($result);
    }

    public function doAdmSetting(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $validator = Validator::make($req->all(), [
            'category' => 'required',
            'brand' => 'required'
        ]);
        if ($validator->fails()) {
            $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
            return json_encode($result);
        }
        //if(stripos(strtoupper($req->category), $key) == false && stripos(strtoupper($req->brand), $key) == false) {
            $insert = DB::table('tbl_m_catbrand')->insert([
                'id_admin_seller' => Auth::user()->id,
                'cat_seller' => "'" .implode(", ", $req->category). "'",
                'brand_seller' => "'" .implode(", ", $req->brand). "'",
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if($insert) {
                $result = array('rc' => '00', 'rcdesc' => 'Success create new seller!');
            } else {
                $result = array('rc' => '02', 'rcdesc' => 'Failed create new seller!');
            }
        //}
        return json_encode($result);
    }

    // Seller
    public function doListRequestSeller() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $list = DB::table('tbl_r_req_off')->where('type_order', 'REQUEST')->where('id_receiver', Auth::user()->id)->get();
        return json_encode($list);
    }

    public function doListOffersSeller() {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $list = DB::table('tbl_r_req_off')
                ->where('type_order', 'OFFERS')
                ->where('id_sender', Auth::user()->id)
                ->get();
        return json_encode($list);
    }

    public function doDeleteGrade(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $delete = DB::table('tbl_m_grade_admin')->where('id', $req->id)->delete();
        if($delete) {
            $result = array('rc' => '00', 'rcdesc' => 'Success delete Grade!');
        } else {
            $result = array('rc' => '02', 'rcdesc' => 'Failed delete Grade!');
        }
        return json_encode($result);
    }

    public function doDeleteUser(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $delete = DB::table('tbl_m_user')->where('id', $req->id)->delete();
        if($delete) {
            $result = array('rc' => '00', 'rcdesc' => 'Success delete user!');
        } else {
            $result = array('rc' => '02', 'rcdesc' => 'Failed delete user!');
        }
        return json_encode($result);
    }

    public function doAddUser(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'alamat' => 'required',
            'phoneno' => 'required'
        ]);
        $key = '<';
        // $master = [];
        // $account = [];
        // $request = [];
        // $system = [];
        // if(!empty($req->menu_master)) {
        //     foreach ($req->menu_master as $key => $value) {
        //         $name = DB::table('tbl_m_menu')->where('id', $value)->first();
        //         $master[] = [
        //             'menu_name' => $name->menu_param,
        //             'menu_param' => $value,
        //         ];
        //     }
        // }
        // if(!empty($req->menu_account)) {
        //     foreach ($req->menu_account as $key => $value) {
        //         $name = DB::table('tbl_m_menu')->where('id', $value)->first();
        //         $account[] = [
        //             'menu_name' => $name->menu_param,
        //             'menu_param' => $value,
        //         ];
        //     }
        // }
        // if(!empty($req->menu_request)) {
        //     foreach ($req->menu_request as $key => $value) {
        //         $name = DB::table('tbl_m_menu')->where('id', $value)->first();
        //         $request[] = [
        //             'menu_name' => $name->menu_param,
        //             'menu_param' => $value,
        //         ];
        //     }
        // }
        // if(!empty($req->menu_system)) {
        //     foreach ($req->menu_system as $key => $value) {
        //         $name = DB::table('tbl_m_menu')->where('id', $value)->first();
        //         $system[] = [
        //             'menu_name' => $name->menu_param,
        //             'menu_param' => $value,
        //         ];
        //     }
        // }
        // $json_menu = [
        //     'master' => $master,
        //     'account' => $account,
        //     'request' => $request,
        //     'system' => $system,
        // ];

        if ($validator->fails()) {
            $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
            return json_encode($result);
        }
        if($req->type == 'adminseller') {
            $id_grade = 6;
        } else if($req->type == 'customer') {
            $id_grade = 5;
        } else if($req->type == 'admin') {
            $id_grade = 2;
        } else {
            $id_grade = 7;
        }
        if(stripos(strtoupper($req->name), $key) == false && stripos(strtoupper($req->email), $key) == false && stripos(strtoupper($req->password), $key) == false && stripos(strtoupper($req->phoneno), $key) == false && 
        stripos(strtoupper($req->alamat), $key) == false) {
            if($req->type == 'admin') {
                $db = DB::table('tbl_m_grade_admin')->where('id', $req->menu_master)->first();
                $insert = DB::table('tbl_m_user')->insert([
                    'name' => $req->name,
                    'email' => $req->email,
                    'password' => bcrypt($req->password),
                    'phone_no' => $req->phoneno,
                    'address' => $req->alamat,
                    'id_grade' => $id_grade,
                    'access_menu' => $db->access_menu,
                    'create_at' => date('Y-m-d H:i:s'),
                ]);
                if($insert) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success create new seller!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed create new seller!');
                }
                return json_encode($result);
            } else {
                $check_data = DB::table('tbl_m_user')->where('email', $req->email)->count();
                if($check_data == 0) {
                    $insert = DB::table('tbl_m_user')->insert([
                        'name' => $req->name,
                        'email' => $req->email,
                        'password' => bcrypt($req->password),
                        'phone_no' => $req->phoneno,
                        'address' => $req->alamat,
                        'id_grade' => $id_grade,
                        'create_at' => date('Y-m-d H:i:s'),
                    ]);
                    if($insert) {
                        $result = array('rc' => '00', 'rcdesc' => 'Success create new seller!');
                    } else {
                        $result = array('rc' => '02', 'rcdesc' => 'Failed create new seller!');
                    }
                    return json_encode($result);
                } else {
                    $result = array('rc' => '03', 'rcdesc' => 'Email already registered!');
                    return json_encode($result);
                }
            }
        }
    }

    public function doListMenu(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $menu = json_decode(Auth::user()->access_menu, true);
        $html = '';
        $data['menu_master'] = $menu['master'];
        $data['menu_account'] = $menu['account'];
        $data['menu_request'] = $menu['request'];
        $data['menu_system'] = $menu['system'];
        $html .= '
        <li class="site-menu-item has-sub">
            <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Master</span>
                <span class="site-menu-arrow"></span>
            </a>
            <ul class="site-menu-sub">
        ';
        foreach ($menu['master'] as $key => $value) {
            $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
            $html .= '
                <li class="site-menu-item">
                    <a class="animsition-link" href="' .route($link->menu_value). '">
                        <span class="site-menu-title">' .$value['menu_name']. '</span>
                    </a>
                </li>
            ';
            print_r($value['menu_name']);
        }
        $html .= '
            </ul>
        </li>
        ';
        return $html;
    }
    
    public function doUpdateData1(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $validator = Validator::make($req->all(), [
            'id' => 'required',
            'data' => 'required'
        ]);
        $key = 'script';
        if ($validator->fails()) {
            $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
            return json_encode($result);
        }
        if(stripos(strtoupper($req->id), $key) === false && stripos(strtoupper($req->data), $key) === false) {
            if($req->data == 'type') {
                $updatee = DB::table('tbl_m_type')->where('id', $req->id)->update(['stat_type' => $req->stat]);
                if($updatee) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success update!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed update!');
                }
                return json_encode($result);
            } else if($req->data == 'tenor') {
                $updatee = DB::table('tbl_m_tenor')->where('id', $req->id)->update(['stat_tenor' => $req->stat]);
                if($updatee) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success update!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed update!');
                }
                return json_encode($result);
            } else if($req->data == 'payment') {
                $updatee = DB::table('tbl_m_payment')->where('id', $req->id)->update(['stat_payment' => $req->stat]);
                if($updatee) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success update!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed update!');
                }
                return json_encode($result);
            } else if($req->data == 'model') {
                $updatee = DB::table('tbl_m_model')->where('id', $req->id)->update(['stat_model' => $req->stat]);
                if($updatee) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success update!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed update!');
                }
                return json_encode($result);
            } else if($req->data == 'city') {
                $updatee = DB::table('tbl_m_kota')->where('id', $req->id)->update(['stat_kota' => $req->stat]);
                if($updatee) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success update!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed update!');
                }
                return json_encode($result);
            } else if($req->data == 'cat') {
                $updatee = DB::table('tbl_m_subcat')->where('id', $req->id)->update(['stat_subcat' => $req->stat]);
                if($updatee) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success update!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed update!');
                }
                return json_encode($result);
            } else if($req->data == 'merk') {
                $updatee = DB::table('tbl_m_merk')->where('id', $req->id)->update(['stat_merk' => $req->stat]);
                if($updatee) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success update!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed update!');
                }
                return json_encode($result);
            } else if($req->data == 'mcategory') {
                $updatee = DB::table('tbl_m_category')->where('id', $req->id)->update(['stat_cat' => $req->stat]);
                if($updatee) {
                    $result = array('rc' => '00', 'rcdesc' => 'Success update!');
                } else {
                    $result = array('rc' => '02', 'rcdesc' => 'Failed update!');
                }
                return json_encode($result);
            } else {
                $result = array('rc' => '02', 'rcdesc' => 'Invalid Param!');
                return json_encode($result);
            }
        }
    }
    
    public function doUpdateParam(Request $req) {
        if(empty(Auth::user()->id)) {
            $array = array('message' => 'Invalid Credential! Please login first!');
            return json_encode($array);
        }
        $key = '<';
        if($req->param == 'mcategory') {
            $validator = Validator::make($req->all(), [
                'main_category' => 'required'
            ]);
            if(stripos($req->main_category, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_category')
                            ->where('id', $req->id)
                            ->update([
                                'name_cat'=>$req->main_category,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil Edit Main Category', 'url'=>route('mcategory'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal Edit Main Category');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'category') {
            $validator = Validator::make($req->all(), [
                'category' => 'required'
            ]);
            if(stripos($req->category, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_subcat')
                            ->where('id', $req->id)
                            ->update([
                                'id_cat'=>$req->cat_id,
                                'name_sub_cat'=>$req->category,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil Edit Category', 'url'=>route('category'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal Edit Category');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'brand') {
            $validator = Validator::make($req->all(), [
                'brand' => 'required'
            ]);
            if(stripos($req->brand, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_merk')
                            ->where('id', $req->id)
                            ->update([
                                'id_cat'=>$req->subcat_id,
                                'name_merk'=>$req->brand,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil Edit Brand', 'url'=>route('brand'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal Edit Brand');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'model') {
            $validator = Validator::make($req->all(), [
                'model' => 'required'
            ]);
            if(stripos($req->model, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_model')
                            ->where('id', $req->id)
                            ->update([
                                'id_merk'=>$req->merk_id,
                                'name_model'=>$req->model,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil Edit Model', 'url'=>route('model'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal Edit Model');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'type') {
            $validator = Validator::make($req->all(), [
                'type' => 'required'
            ]);
            if(stripos($req->type, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_type')
                            ->where('id', $req->id)
                            ->update([
                                'id_model'=>$req->model_id,
                                'name_type'=>$req->type,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil Edit Type', 'url'=>route('type'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal Edit Type');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'payment') {
            $validator = Validator::make($req->all(), [
                'payment' => 'required'
            ]);
            if(stripos($req->payment, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_payment')
                            ->where('id', $req->id)
                            ->update([
                                'payment_name'=>$req->payment,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil Edit Payment Method', 'url'=>route('payment'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal Edit Payment Method');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'tenor') {
            if(preg_match('/^[0-9]+$/', $req->tenor)) {
                $validator = Validator::make($req->all(), [
                    'tenor' => 'required|max:4'
                ]);
                if(stripos($req->payment, $key) === false) {
                    if ($validator->fails()) {
                        $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                        return json_encode($result);
                    }
                    $data_file = DB::table('tbl_m_tenor')
                                ->where('id', $req->id)
                                ->update([
                                    'tenor'=>$req->tenor,
                                    'tenor_name'=>$req->tenor. ' Bulan',
                                ]);
                    if($data_file) {
                        $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil Edit Tenor', 'url'=>route('tenor'));
                    } else {
                        $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal Edit Tenor');
                    }
                    return json_encode($hasil);
                } else {
                    $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                    return json_encode($hasil);
                }
            } else {
                $hasil = array('rc' => '01', 'rcdesc' => 'Invalid Param!');
                return json_encode($hasil);
            }
        } else if($req->param == 'city') {
            $validator = Validator::make($req->all(), [
                'city' => 'required'
            ]);
            if(stripos($req->city, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_kota')
                            ->where('id', $req->id)
                            ->update([
                                'name_kota'=>$req->city,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil Edit City', 'url'=>route('city'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal Edit City');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        }
    }
    
    public function doUpdateKota(Request $req) {
        $validator = Validator::make($req->all(), [
            'name_kota' => 'required'
        ]);
        $key = '<';
        if(stripos(strtoupper($req->name_kota), $key) == false) {
            if ($validator->fails()) {
                $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                return json_encode($result);
            }
            $data_file = DB::table('tbl_m_kota')
                        ->where('id', $req->id)
                        ->update(['name_kota'=>$req->name_kota]);
            if($data_file) {
                $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('city'));
            } else {
                $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
            }
            return json_encode($hasil);
        } else {
            $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
            return json_encode($hasil);
        }
    }
    
    public function dotambahdataadd(Request $req) {
        if($req->param == 'city') {
            $validator = Validator::make($req->all(), [
                'name_kota' => 'required'
            ]);
            $key = '<';
            if(stripos(strtoupper($req->name_kota), $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_kota')
                            ->insert([
                                'name_kota'=>$req->name_kota,
                                'stat_kota'=>1,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('city'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'type') {
            $validator = Validator::make($req->all(), [
                'name_type' => 'required'
            ]);
            $key = '<';
            if(stripos(strtoupper($req->name_type), $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_type')
                            ->insert([
                                'id_model'=>$req->model_id,
                                'name_type'=>$req->name_type,
                                'stat_type'=>1,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('type'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'model') {
            $validator = Validator::make($req->all(), [
                'name_model' => 'required'
            ]);
            $key = '<';
            if(stripos(strtoupper($req->name_model), $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_model')
                            ->insert([
                                'id_merk'=>$req->merk_id,
                                'name_model'=>$req->name_model,
                                'stat_model'=>1,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('model'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'brand') {
            $validator = Validator::make($req->all(), [
                'name_merk' => 'required'
            ]);
            $key = '<';
            if(stripos(strtoupper($req->name_merk), $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_merk')
                            ->insert([
                                'id_cat'=>$req->subcat_id,
                                'name_merk'=>$req->name_merk,
                                'stat_merk'=>1,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('brand'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'category') {
            $validator = Validator::make($req->all(), [
                'name_sub_cat' => 'required'
            ]);
            $key = '<';
            if(stripos(strtoupper($req->name_sub_cat), $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_subcat')
                            ->insert([
                                'id_cat'=>$req->cat_id,
                                'name_sub_cat'=>$req->name_sub_cat,
                                'stat_subcat'=>1,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('category'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        }  else if($req->param == 'mcategory') {
            $validator = Validator::make($req->all(), [
                'name_mcat' => 'required'
            ]);
            $key = '<';
            if(stripos(strtoupper($req->name_mcat), $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $data_file = DB::table('tbl_m_category')
                            ->insert([
                                'name_cat'=>$req->name_mcat,
                                'stat_cat'=>1,
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('mcategory'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        }
    }
    
    public function doupdatetenor(Request $req) {
        $validator = Validator::make($req->all(), [
            'tenor' => 'required'
        ]);
        $key = '<';
        if(stripos(strtoupper($req->tenor), $key) == false) {
            if ($validator->fails()) {
                $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                return json_encode($result);
            }
            $data_file = DB::table('tbl_m_tenor')
                        ->where('id', $req->id)
                        ->update(['tenor'=>$req->tenor, 'tenor_name'=>$req->tenor.' Bulan']);
            if($data_file) {
                $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('tenor-item'));
            } else {
                $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
            }
            return json_encode($hasil);
        } else {
            $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
            return json_encode($hasil);
        }
    }
    
    public function doupdatepayment(Request $req) {
        $validator = Validator::make($req->all(), [
            'payment_name' => 'required'
        ]);
        $key = '<';
        if(stripos(strtoupper($req->tenor), $key) == false) {
            if ($validator->fails()) {
                $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                return json_encode($result);
            }
            $data_file = DB::table('tbl_m_payment')
                        ->where('id', $req->id)
                        ->update(['payment_name'=>$req->payment_name]);
            if($data_file) {
                $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'url'=>route('payment-item'));
            } else {
                $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
            }
            return json_encode($hasil);
        } else {
            $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
            return json_encode($hasil);
        }
    }
    
    public function doaddaccount(Request $req) {
        $key = '<';
        if($req->param == 'user-grade') {
            $validator = Validator::make($req->all(), [
                'grade_code' => 'required',
                'grade_desc' => 'required',
            ]);
            if(stripos($req->grade_code, $key) === false && stripos($req->grade_desc, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $master = []; $account = []; $request = []; $system = [];
                if(!empty($req->menu_master)) {
                    foreach ($req->menu_master as $key => $value) {
                        $name = DB::table('tbl_m_menu')->where('id', $value)->first();
                        $master[] = [
                            'menu_name' => $name->menu_param,
                            'menu_param' => $value,
                        ];
                    }
                }
                if(!empty($req->menu_account)) {
                    foreach ($req->menu_account as $key => $value) {
                        $name = DB::table('tbl_m_menu')->where('id', $value)->first();
                        $account[] = [
                            'menu_name' => $name->menu_param,
                            'menu_param' => $value,
                        ];
                    }
                }
                if(!empty($req->menu_request)) {
                    foreach ($req->menu_request as $key => $value) {
                        $name = DB::table('tbl_m_menu')->where('id', $value)->first();
                        $request[] = [
                            'menu_name' => $name->menu_param,
                            'menu_param' => $value,
                        ];
                    }
                }
                if(!empty($req->menu_system)) {
                    foreach ($req->menu_system as $key => $value) {
                        $name = DB::table('tbl_m_menu')->where('id', $value)->first();
                        $system[] = [
                            'menu_name' => $name->menu_param,
                            'menu_param' => $value,
                        ];
                    }
                }
                $json_menu = [
                    'master' => $master,
                    'account' => $account,
                    'request' => $request,
                    'system' => $system,
                ];
                $data_file = DB::table('tbl_m_grade_admin')
                            ->insert([
                                'grade_code'=>$req->grade_code,
                                'grade_desc'=>$req->grade_desc,
                                'grade_stat'=>1,
                                'access_menu'=>json_encode($json_menu),
                            ]);
                if($data_file) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Berhasil', 'route'=>route('user-grade'));
                } else {
                    $hasil = array('rc'=>'01', 'rcdesc'=>'Gagal');
                }
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'user-account') {
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'phone' => 'required',
            ]);
            if(stripos($req->name, $key) === false && stripos($req->email, $key) === false && stripos($req->password, $key) === false && stripos($req->phone, $key) === false && stripos($req->alamat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $db_check = DB::table('tbl_m_grade_admin')->where('id', $req->user_level_id)->count();
                if($db_check == '1') {
                    $db_get = DB::table('tbl_m_grade_admin')->where('id', $req->user_level_id)->first();
                    $db_insert = DB::table('tbl_m_user')->insert([
                            'name' => $req->name,
                            'email' => $req->email,
                            'password' => bcrypt($req->password),
                            'phone_no' => $req->phone,
                            'address' => $req->alamat,
                            'access_menu' => $db_get->access_menu,
                            'id_grade' => '1',
                            'access_grade' => $req->user_level_id,
                            'create_at' => date('Y-m-d H:i:s'),
                        ]);
                    if($db_insert) {
                        $hasil = array('rc'=>'00', 'rcdesc'=>'Success add User Account!', 'route'=>route('user-account'));
                        return json_encode($hasil);
                    } else {
                        $hasil = array('rc'=>'03', 'rcdesc'=>'Failed add User Account!');
                        return json_encode($hasil);
                    }
                } else {
                    $hasil = array('rc'=>'02', 'rcdesc'=>'User Level invalid!');
                    return json_encode($hasil);
                }
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'seller-adm') {
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'phone' => 'required',
            ]);
            if(stripos($req->name, $key) === false && stripos($req->email, $key) === false && stripos($req->password, $key) === false && stripos($req->phone, $key) === false && stripos($req->alamat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $db_insert = DB::table('tbl_m_user')->insert([
                        'name' => $req->name,
                        'email' => $req->email,
                        'password' => bcrypt($req->password),
                        'phone_no' => $req->phone,
                        'address' => $req->alamat,
                        'id_grade' => '3',
                        'create_at' => date('Y-m-d H:i:s'),
                    ]);
                if($db_insert) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Success add Seller Admin!', 'route'=>route('seller-adm'));
                    return json_encode($hasil);
                } else {
                    $hasil = array('rc'=>'03', 'rcdesc'=>'Failed add Seller Admin!');
                    return json_encode($hasil);
                }
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        } else if($req->param == 'seller') {
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'phone' => 'required',
            ]);
            if(stripos($req->name, $key) === false && stripos($req->email, $key) === false && stripos($req->password, $key) === false && stripos($req->phone, $key) === false && stripos($req->alamat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $db_insert = DB::table('tbl_m_user')->insert([
                        'name' => $req->name,
                        'email' => $req->email,
                        'password' => bcrypt($req->password),
                        'phone_no' => $req->phone,
                        'address' => $req->alamat,
                        'id_grade' => '4',
                        'id_seller_adm' => $req->seller_adm_id,
                        'create_at' => date('Y-m-d H:i:s'),
                    ]);
                if($db_insert) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Success add Seller Admin!', 'route'=>route('seller'));
                    return json_encode($hasil);
                } else {
                    $hasil = array('rc'=>'03', 'rcdesc'=>'Failed add Seller Admin!');
                    return json_encode($hasil);
                }
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        }
    }
    
    public function doupdateaccount(Request $req) {
        $key = '<';
        if($req->param == 'admin') {
            $validator = Validator::make($req->all(), [
                'id' => 'required',
                'stat' => 'required',
            ]);
            if(stripos($req->id, $key) === false && stripos($req->stat, $key) === false) {
                if ($validator->fails()) {
                    $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                    return json_encode($result);
                }
                $db_update = DB::table('tbl_m_user')->where('id', $req->id)->update(['user_status'=>$req->stat]);
                if($db_update) {
                    $hasil = array('rc'=>'00', 'rcdesc'=>'Success update data!');
                    return json_encode($hasil);
                } else {
                    $hasil = array('rc'=>'02', 'rcdesc'=>'Failed update data!');
                    return json_encode($hasil);
                }
            } else {
                $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
                return json_encode($hasil);
            }
        }
    }
    
    public function doaddoffers(Request $req) {
        $key = '<';
        $no_offer = 'WTB' .date('YmdHis');
        $validator = Validator::make($req->all(), [
            'harga' => 'required|max:11',
            'dp' => 'required|max:11',
            'notes' => 'required',
        ]);
        if(stripos($req->harga, $key) === false && stripos($req->dp, $key) === false && stripos($req->notes, $key) === false) {
            if ($validator->fails()) {
                $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                return json_encode($result);
            }
            $db_list = DB::table('tbl_m_user')->where('id_grade', '2')->get();
            foreach($db_list as $value) {
                DB::table('tbl_r_req_off')->insert([
                        'no_offers' => $no_offer,
                        'type_order'=>'OFFERS',
                        'id_sender' => Auth::user()->id,
                        'id_receiver' => $value->id,
                        'date_send' => date('Y-m-d H:i:s'),
                        'detail_sender' => $req->notes,
                        'price' => $req->harga,
                        'downpayment' => $req->dp
                    ]);
                DB::table('tbl_r_notification')->insert([
                        'no_offers' => $no_offer,
                        'date_send' =>date('Y-m-d H:i:s'),
                        'type_notif' =>'NEW_OFFERS',
                        'sender_id' =>Auth::user()->id,
                        'receiver_id' =>$value->id,
                        'notification_detail' =>'New Offers from ' .Auth::user()->name,
                    ]);
            }
            $hasil = array('rc'=>'00', 'rcdesc'=>'Success Send Offers', 'route' => route('seller-off'));
            return json_encode($hasil);
        } else {
            $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
            return json_encode($hasil);
        }
    }
    
    public function dodeloffers(Request $req) {
        $db = DB::table('tbl_r_req_off')->where('no_offers', $req->no_offers)->delete();
        $db1 = DB::table('tbl_r_notification')->where('no_offers', $req->no_offers)->delete();
        if($db) {
            $hasil = array('rc'=>'00', 'rcdesc'=>'Success Delete Offers', 'route' => route('seller-off'));
            return json_encode($hasil);
        } else {
            $hasil = array('rc'=>'01', 'rcdesc'=>'Failed Delete Offers');
            return json_encode($hasil);
        }
    }
    
    public function doeditoffers(Request $req) {
        $key = '<';
        $validator = Validator::make($req->all(), [
            'harga' => 'required|max:11',
            'dp' => 'required|max:11',
            'notes' => 'required',
        ]);
        if(stripos($req->harga, $key) === false && stripos($req->dp, $key) === false && stripos($req->notes, $key) === false) {
            if ($validator->fails()) {
                $result = array('rc' => '01', 'rcdesc' => 'Param is missing!');
                return json_encode($result);
            }
            $db_update = DB::table('tbl_r_req_off')->where('no_offers', $req->no_offers)->update([
                'detail_sender' => $req->notes,
                'price' => $req->harga,
                'downpayment' => $req->dp
            ]);
            if($db_update) {
                $hasil = array('rc'=>'00', 'rcdesc'=>'Success Edit Offers', 'route' => route('seller-off'));
                return json_encode($hasil);
            } else {
                $hasil = array('rc'=>'01', 'rcdesc'=>'Failed Edit Offers');
                return json_encode($hasil);
            }
        } else {
            $hasil = array('rc'=>'09', 'rcdesc'=>'XSS Detected');
            return json_encode($hasil);
        }
    }
    
    public function dolistnotif() {
        $db = DB::table('tbl_r_notification')->where('sender_id', Auth::user()->id)->get();
        return $db;
    }
    
    public function doacceptoffer(Request $req) {
        $db = DB::table('tbl_r_notification')->where('no_offers', $req->id_user)->where('receiver_id', Auth::user()->id)->update(['type_notif'=>'ACCEPT_OFFERS']);
        if($db) {
            $hasil = array('rc'=>'00', 'rcdesc'=>'Success Accept Offers', 'route' => route('confirm-dp'));
            return json_encode($hasil);
        } else {
            $hasil = array('rc'=>'01', 'rcdesc'=>'Failed Accept Offers');
            return json_encode($hasil);
        }
    }
    
    public function dosendnow(Request $req) {
        $key = '<';
        $no_offer = 'WTB'.date('YmdHis');
        $validator = Validator::make($req->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);
        if(stripos($req->title, $key) === false && stripos($req->body, $key) === false && stripos($req->receiver, $key) === false) {
            if($req->receiver == '0') {
                $list_user = DB::table('tbl_m_user')->where('id_grade', '!=', '0')->get();
                foreach($list_user as $value) {
                    DB::table('tbl_r_notification')->insert([
                        'no_offers' => $no_offer,    
                        'date_send' => date('Y-m-d H:i:s'),    
                        'type_notif' => 'NEW_OFFERS',    
                        'sender_id' => Auth::user()->id,    
                        'receiver_id' => $value->id,   
                        'notification_detail' => $req->body,    
                    ]);
                }
                $hasil = array('rc'=>'00', 'rcdesc'=>'Success Send Notif', 'route' => route('dashboard'));
                return json_encode($hasil);
            } else if($req->receiver == '2') {
                $list_user = DB::table('tbl_m_user')->where('id_grade', '!=', '2')->get();
                foreach($list_user as $value) {
                    DB::table('tbl_r_notification')->insert([
                        'no_offers' => $no_offer,    
                        'date_send' => date('Y-m-d H:i:s'),    
                        'type_notif' => 'NEW_OFFERS',    
                        'sender_id' => Auth::user()->id,    
                        'receiver_id' => $value->id,   
                        'notification_detail' => $req->body,    
                    ]);
                }
                $hasil = array('rc'=>'00', 'rcdesc'=>'Success Send Notif', 'route' => route('dashboard'));
                return json_encode($hasil);
            } else if($req->receiver == '4') {
                $list_user = DB::table('tbl_m_user')->where('id_grade', '!=', '4')->get();
                foreach($list_user as $value) {
                    DB::table('tbl_r_notification')->insert([
                        'no_offers' => $no_offer,    
                        'date_send' => date('Y-m-d H:i:s'),    
                        'type_notif' => 'NEW_OFFERS',    
                        'sender_id' => Auth::user()->id,    
                        'receiver_id' => $value->id,   
                        'notification_detail' => $req->body,    
                    ]);
                }
                $hasil = array('rc'=>'00', 'rcdesc'=>'Success Send Notif', 'route' => route('dashboard'));
                return json_encode($hasil);
                
            } 
        }
    }
}