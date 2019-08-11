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

class NotificationController extends Controller {
	public function showNotif() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['system'])) {
                foreach ($p['system'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '17') {
                    	$data['page_name'] = 'User Grade';
                        $data['page'] = 'content.notification.notification';
                        return view('template.content')->with($data);
                    } else {
                        $data['page_name'] = 'Error';
                        $data['page'] = 'content.error';
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
}