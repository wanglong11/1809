<?php
use Illuminate\Support\Facades\Redis;
/**
 * 测试继承方法
**/
function test()
{
    echo 'helper';
}
/**
 * 获取accessToken
 **/
function getWxAccessToken()
{
    $key = 'wx_access_token';       // 1809a_wx_access_token
    //判断是否有缓存
    $access_token = Redis::get($key);
    if($access_token){     //有缓存
        return $access_token;
    }else{      //没有缓存就自己获取
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('APPID').'&secret='.env('SECRET');
        $response = json_decode(file_get_contents($url),true);//转化成字符串
        if(isset($response['access_token'])){    //判断是否有accessToke
            Redis::set($key,$response['access_token']);  //存入redis
            Redis::expire($key,3600);     //过期时间
            return $response['access_token'];    //返回其值
        }else{
            return false;          //否则false
        }
    }
}
/**
 * 获取 微信 jsapi ticket
 * @return bool
 */
function getJsapiTicket()
{
    $key = 'wx_jsapi_ticket';
    $ticket = Redis::get($key);      //获取ticket
    if($ticket){
        return $ticket;       //有缓存直接返回
    }else{       //没有缓存就存
        $access_token = getWxAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
        $ticket_info = json_decode(file_get_contents($url),true);
        if(isset($ticket_info['ticket'])){     //判断ticket_info真实存在性
            Redis::set($key,$ticket_info['ticket']);   //有ticket 就存入redis中
            Redis::expire($key,3600);
            return $ticket_info['ticket'];
        }else{    //否者就false
            return false;
        }
    }
}