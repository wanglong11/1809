<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QRcodeController extends Controller
{
    public function index(){
       // $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.getWxAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.getWxAccessToken();
          $data=[
                 "action_name"=>'QR_LIMIT_SCENE',
              "action_info"=>[
                  "scene"=>[
                      "scene_id"=>123
                  ],
              ],

          ];
        $res=json_encode($data);
        dd($res);
    }
}
