<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作订单表的模块
*/
class Order extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['order_id'];
    //定义主键名称
    protected $primaryKey = 'order_id';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   订单显示查询
    */
    public function quer($field,$type,$pos,$limit)
    {
         return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('order_id', 'DESC')->get()->toArray()];
    }


    /*
    *   订单显示查询不分页
    */
    public function quernopage($field,$type)
    {
         return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->orderBy('order_id', 'DESC')->get()->toArray()];
    }

    /*
    *   该方法是订单生成
    */
    public function add($cart_data)
    {
       //将订单数据添加入数据表
       $this->fill($cart_data);
       if($this->save()){
           return $this->order_id;
       }else{
           return false;
       }
    }

    /*
    *   该方法是订单信息修改
    */
    public function orderupdate($id,$data)
    {
        $cartnum=$this->find($id);
        if($cartnum->update($data)){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   该方法是订单信息删除
    */
    public function orderdel($data)
    {
        return $this->destroy($data);
    }

    /*
	*  根据条件进行收货地址搜索
	*/
    public function scopeNum($query,$keyNum)
    {
        return $query->where('order_num', '=', $keyNum);
    }

    /*
     *  搜索指定用户的指定状态的订单
     */
    public function scopeUS($query,$keyUser,$keyStatus)
    {
        return $query->where(['users_id'=>$keyUser,'state'=>$keyStatus]);
    }

    /*
    *   订单数量统计
    */
    public function ordercount($type)
    {
        return $this->whereRaw($type)->count();
    }
}
