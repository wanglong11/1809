<?php
namespace App\Http\Controllers\good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Model\HistoryModel;
class GoodsController extends Controller
{
    /**
    商品展示
     */
    public function index(){
        $key='ss:goods:view';
        $goods_id=Redis::zRevRange($key,0,100000000000000);//倒序
        //dd($goods_id);
        $data=[];
        foreach ($goods_id as $k=>$v){
           // $goods_id=$v['goods_id'],
            $where=[
                'id'=>$v
            ];
            $data[]=DB::table('p_goods')->where($where)->first();

        }
        //dd($data);

        $goods=DB::table('p_goods')->whereNotIn('id',$goods_id)->get();
       //dd($goods);
        foreach ($goods as $k=>$v){
            $data[]=$goods[$k];
        }
          //dd($data);
        return view('goods/goods',compact('data'));

    }
    /**
    商品详情
     */
    public function detail($id){
        if(!$id){
            die("请选择一个商品");
        }
        $goodsInfo=DB::table('p_goods')->where(['id'=>$id])->first();
        //dd($goodsInfo);
        $redis_view_key='count:view:id:'.$id;//浏览量
        //dd($redis_view_key);
        $redis_ss_view='ss:goods:view'; //浏览排名
         //浏览量
        $history_num=Redis::incr($id);//redis让他浏览历史记录条数 后面可以加n个
        Redis::zAdd($redis_ss_view,time(),$id);//有序集合
       // $history_num=DB::table('p_goods')->update($goodsInfo['history']+1);
//        //把浏览记录存入数据库
//        $this->saveHistoryDb($id);
//        //从数据库中获取浏览历史
//        $historyInfo=$this->getHistoryDb();,'historyInfo'=>$historyInfo

        return view('goods/detail',['goodsInfo'=>$goodsInfo,'history_num'=>$history_num]);
    }

    /**
    哈希缓存测试
     */
    public function cacheGoods($id){
       //$goods_id=intval($id);
       //dd($goods_id);
        $redis_cache_goods_key='h:goods_Info:'.$id;//key
         $cate_Info=Redis::hGetAll($redis_cache_goods_key);//获取缓存
           //dd($goodsInfo);
        if($cate_Info){   //有缓存
           echo "有缓存";
        }else{            //如果没有缓存   //好像得用DB得用model做要不然first后面不能toArray()
            //$goodsInfo=DB::table('p_goods')->where(['id'=>$goods_id])->first();
            $goodsInfo=DB::table('p_goods')->where(['id'=>$id])->first()->toArray();
            //dd($goodsInfo);
           // print_r($goodsInfo);die;
            Redis::hMset($redis_cache_goods_key, $goodsInfo);//存储入
            echo"存储缓存";
        }

    }
    /**
     *获取浏览历史排名
    */
    public function getsort(){
        $key='ss:goods:view';
       //$list=Redis::zRangeByscore($key,0,1000000000000,['withscores'=>true]);//
       // $list=Redis::zRevRange($key,0,1000000000000,true);
          $list=Redis::zRevRange($key,0,10000000000000,true);//倒序
          //dd($list);
         // print_r($list);
        $data=[];
        foreach($list as $k=>$v){
          $where=[
              'id'=>$k
              ];
          $data[]=DB::table('p_goods')->where($where)->first();
        }
        //dd($data);
        return view('goods/history',compact('data'));




    }
   /**
   *把浏览历史记录保存到数据库
    */
   public function saveHistoryDb($id){
       $info=[
           'user_id'=>Auth::id(),
           'goods_id'=>$id,
           'create_time'=>time()
       ];
       $data=HistoryModel::insertGetId($info);
       //dd($data);
   }
   /**
   *把数据展示到商品详情页面
    */
   public function getHistoryDb(){
         $where=[
           'user_id'=>Auth::id(),
         ];
         $goods_id=HistoryModel::where($where)->OrderBy('create_time','desc')->get('goods_id')->toArray();
       foreach ($goods_id as $k=>$v){
           $v=join(',',$v); //降为一维数组
           $goods_id[$k]=$v;
       }
       $goods_id=array_slice(array_unique($goods_id),0,4);
       //dd($goods_id);
       //获取浏览历史数据
       //根据商品id  在商品表中 查询数据
       $goodsInfo=[];
       for($i=0;$i<count($goods_id);$i++){
           $goodsWhere['goods_id']=$goods_id[$i];
           $goodsInfo[]=HistoryModel::where($goodsWhere)->first();
       }
       //把查询到的商品数据返回;
       //dd($goodsWhere);
       //dd($goodsInfo);
       return $goodsInfo;


   }



}
