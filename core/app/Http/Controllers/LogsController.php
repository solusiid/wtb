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

class LogsController extends Controller {
	public function showLogs() {
        if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['system'])) {
                foreach ($p['system'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '18') {
                    	$data['page_name'] = 'Logs';
                        $data['page'] = 'content.logs.logs';
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

    public function showSystemLog() {
    	if(empty(Auth::user()->id)) {
            return redirect(route('login'));
        } else {
            $p = json_decode(Auth::user()->access_menu, true);
            if(!empty($p['system'])) {
                foreach ($p['system'] as $key => $value) {
                    $link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
                    if($value['menu_param'] == '19') {
                    	$data['page_name'] = 'System Log';
                        $data['page'] = 'content.logs.system';        
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