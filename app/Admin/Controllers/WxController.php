<?php

namespace App\Admin\Controllers;

use App\UserModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use DB;
use GuzzleHttp\Client;
class WxController extends Controller
{
    use HasResourceActions;


    public function index(Content $content){
        //echo "11";die;
        $data=DB::table('wxuser')->get();
        return $content
            ->header('用户管理')
            ->description('群发消息')
            ->body(view('admin/WX/message',['data'=>$data]));
    }
    public function Add(){

        $client=new Client();
        $openid=$_GET['openid'];
        $text=$_GET['text'];
        $openid=explode(',',$openid);
        //dd($openid);
        $arr=[
            'touser' => $openid,
            'msgtype' => 'text',
            'text' => [
                'content'=>$text
            ]
        ];
        $str=json_encode($arr);
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.getWxAccessToken();
        $response=$client->request('POST',$url,[
            'body'=>$str
        ]);


    }
}
