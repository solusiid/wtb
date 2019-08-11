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

class RequestController extends Controller {
	public function showAllRequest() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['request'])) {
                foreach ($p['request'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '14') {
                    	$data['page_name'] = 'All Request';
                        $data['page'] = 'content.request.all-request';
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

    public function showAllOffers() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['request'])) {
                foreach ($p['request'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($link->menu_value == 'all-offers') {
                    	$data['page_name'] = 'All Offers';
                        $data['page'] = 'content.request.all-offers';
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
    public function showAllPayment() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['request'])) {
                foreach ($p['request'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($link->menu_value == 'all-payment') {
                        $data['page_name'] = 'All Payment';
                        $data['page'] = 'content.request.all-payment';
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

    public function showSendNotification() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['request'])) {
                foreach ($p['request'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($link->menu_value == 'send-notification') {
                        $data['page_name'] = 'Send Notification';
                        $data['page'] = 'content.request.send-notif';
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