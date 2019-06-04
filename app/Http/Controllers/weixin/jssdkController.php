<?php

namespace App\Http\Controllers\weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Storage;
class jssdkController extends Controller
{
    //
    public function jssdk(){

        //设置签名
        $nonceStr = Str::random(10);  //随机字符串
        $ticket = getJsapiTicket();  //获取ticket
        $timestamp = time();    //获取单前时间
        $current_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];
        //    [HTTP_HOST] => 1809wangweilong.comcto.com获取当前路径  [REQUEST_URI] => /weixin/jssdk 获取控制器名方法名
        //echo '<pre>';print_r($_SERVER);echo '</pre>';die;

        $string1 = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$current_url";
        //. 对所有待签名参数按照字段名的ASCII 码从小到大排序（字典序）后，使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串string1：
        $sign = sha1($string1); //对string1进行sha1签名
        //dd($sign);

        $js_config = [
            'appId' => env('APPID'),        //公众号APPID
            'timestamp' => $timestamp,
            'nonceStr' => $nonceStr,   //随机字符串
            'signature' => $sign,                      //签名
        ];
        $data = [
            'jsconfig'  => $js_config
        ];
        return view('weixin/jssdk',$data);
    }
    public function getImg()
    {
        $serverId=$_GET['serverId'];
        $time = date('Y-m-d H:i:s');
        $str = $time . $serverId."\n";
        file_put_contents("logs/wx_aa.log", $str, FILE_APPEND);
        $client=new Client();
        $url='https://api.weixin.qq.com/cgi-bin/media/get?access_token='.getWxAccessToken().'&media_id='.$serverId;
        $img=$client->get(new Uri($url));
        //获取文件类型
        $headers=$img->getHeaders();
        $img_name=$headers['Content-disposition'][0];
        $fileInfo=substr($img_name,'-15');
        $img_name=substr(md5(time().mt_rand(1111,9999)),5,8).$fileInfo;
        $img_name=rtrim($img_name,'"');
        Storage::put('weixin/'.$img_name, $img->getBody());

    }
}
