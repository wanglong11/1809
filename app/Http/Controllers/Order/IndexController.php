<?php

namespace App\Http\Controllers\Order;
use App\Model\OrderModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Model\CartModel;
use App\Model\OrderDetailModel;
class IndexController extends Controller
{ /**
 生成订单表
 */
    public function create(){
        //计算总金额
        $goods = CartModel::where(['uid'=>Auth::id(),'session_id'=>Session::getId()])->get()->toArray();
//        $order_amount = 0;
//        //dd($good);
//        foreach($good as $k=>$v){
//            $order_amount += $v['goods_price'];      //计算订单金额
//        }
        $order_amount = 0;
        foreach($goods as $k=>$v){
            $order_amount += $v['goods_price'];       //计算订单金额
        }
        $order_info = [
            'uid'               => Auth::id(),
            'order_sn'          => OrderModel::generateOrderSN(Auth::id()),     //订单编号
            'order_amount'      => $order_amount,
            //'add_time'          => time()
        ];
       // $oid=orderModel::insertGetid($order_info); //写入订单表中
        $oid = OrderModel::insertGetId($order_info);        //写入订单表

       //dd($oid);
        //将信息写入订单信息详情表中
        //订单详情
        foreach($goods as $k=>$v){
            $detail = [
                'oid'           => $oid,
                'goods_id'      => $v['goods_id'],
                'goods_name'    => $v['goods_name'],
                'goods_price'   => $v['goods_price'],
                'uid'           => Auth::id(),
                //'store'         =>$v['store'],
            ];

            //写入订单详情表
            $res=OrderDetailModel::insert($detail);
        }
        //dd($res);
        header('Refresh:3;url=/order/lists');
        echo "生成订单成功";

        }
    /**
     * 订单列表页
     */
    public function oList()
    {
        $list = OrderModel::where(['uid'=>Auth::id()])->orderBy("id","desc")->get()->toArray();
        //dd($list);
        $data = [
            'list'  => $list
        ];
        //dd($data);
        //return view('order/list',$data);
        return view('order/lists',$data);
    }
    /**
     * 查询订单支付状态
     */
    public function payStatus($id)
    {
        //dd($id);
        $info = OrderModel::where(['id'=>$id])->first();
        //dd($info);
        $response = [];
        if($info){
            if($info->add_time>0){      //已支付
                $response = [
                    'status'    => 0,       // 0 已支付
                    'msg'       => 'ok'
                ];
            }
            //cho '<pre>';print_r($info->toArray());echo '</pre>';
                //echo "11";
        }else{
            die("订单不存在");
        }
        die(json_encode($response));
    }

}
