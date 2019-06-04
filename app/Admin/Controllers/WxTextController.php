<?php

namespace App\Admin\Controllers;

use App\WxTextModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Http\Requests\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
use App\Model\FodderModel;
class WxTextController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('素材管理')
            ->description('素材添加')
            ->body(view('admin/WX/fodder'));

    }
    public function add(Request $request){
        //文件上传
        $file=$this->uplode($request,'headloge');
        //dd($file);
        $getWxAccessToken=$this->getWxAccessToken();
        //dd($getWxAccessToken);

        $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$getWxAccessToken.'&type=image';
        //dd($url);
        $client=new Client();
        $request=$client->request('POST', $url, [
            'multipart' => [
                [
                    'name'     => 'headloge',
                    'contents' => fopen('../storage/app/'.$file,'r'),

                ],
            ]
        ]);
        $res=json_decode($request->getBody(),true);
       // dd($res);
      if(isset($res['media_id'])){
//         $re= FodderModel::insertGetId($res);
//         if($re){
//             return view('cate/index');
//         }else{
//             header("Refresh:2,url=/cart");
//             die("添加素材失败,");
//          }
      }
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
    /**文件上传*/
    public function uplode(Request $request,$filename){
        //dd($filename);
        //你可以使用 hasFile 方法判断文件在请求中是否存在,使用 isValid 方法判断文件在上传过程中是否出错：
        if ($request->hasFile($filename) && $request->file($filename)->isValid()) {
            $photo = $request->file($filename);
            $store_result = $photo->store('uploads');
            return $store_result;

        }
        exit('未获取到上传文件或上传过程出错');
    }


}
