<?php

namespace App\Http\Controllers;

use http\Header;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
use App\Model\CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
{
    public $uid=0;
    public function __construct()
    {
        $this->uid=Auth::id();
    }

    /**
     购物车展示页面
     */
    public function index(){
       $cate_list=CartModel::where(['uid'=>Auth::id(),'session_id'=>Session::getId()])->get()->toArray();
       //dd($cate_list);
        if($cate_list){
            $total_price=0;
            foreach($cate_list as $k=>$v){
                //
                $goods=GoodsModel::where(['id'=>$v['goods_id']])->first()->toArray();
                //获取总价格
                $total_price+=$goods['price'];
                $goods_list[] = $goods;//获取添加购物车数据
            }
            //dd($goods_list);
            $data=[
               'goods_list' => $goods_list,
                'total'     => $total_price /100
            ];
              return view('cate/index',$data);

        }else{
            header("Refresh:2,url=/cart");
            die("没有改数据,2秒后自动跳回商品添加页面");
        }
    }
    /**
    添加购物车数据
     */
    public function AddCart($id=0){
        //echo Session::getId();die;
        if(empty($id)){
            header('Refresh:2,url=/cart');
            die("没有改商品ID，两秒后跳转至首页");

        }
        //echo $id;
        //查询商品表的数据条件是否存在是否删除
        $goods=GoodsModel::where(['id'=>$id])->first();
        //dd($goods);
        if($goods){
            if($goods->is_deletd==1){
                header('Refresh:2,url=/');
                die("该商品不存在,请重新选择,两秒后跳转至首页");
            }
            //添加至购物车
            $cart_info = [
                'goods_id'  => $id,
                'goods_name'    => $goods->name,
                'goods_price'    => $goods->price,
                'uid'       => Auth::id(),
                'add_time'  => time(),
                'session_id' => Session::getId()
            ];
            //入库
            $resCart=CartModel::insertGetId($cart_info);
           if($resCart){
               header('Refresh:2,url=/cart');
               die('添加购物车成功,跳转至购物车展示页面');
           }else{
               header('Refresh:2,url=/add');
               die('添加购物车失败,跳转至商品添加页面');
           }

        }else{
            die("没有改商品");
        }


    }
}
UiO6OexWgQiEBaAbi69fbsMpcXZqbY0tPnrnCdopDTA