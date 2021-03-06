<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use App\Goods_attribute;

/**
*   该控制器包含了商品属性模块的操作
*/
class attrController extends Controller
{
    private $attr;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('gid'商品,'name'名字,'value'内容)
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = DB::table('anchong_goods_attribute')->insertGetId(
            [
                'goods_id'=>$request->gid,
                'name'=>$request->name,
                'value'=>$request->value,
            ]
        );
        $message="保存成功";
        return response()->json(['message' => $message,'id'=>$id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request('name'名字,'varle'内容)
     * @param  int  $id主键ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->attr=new Goods_attribute();
        $data=$this->attr->find($id);
        $data->name=$request->name;
        $data->value=$request->value;
        $data->save();
        $message="保存成功";
        return response()->json(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id主键ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->attr=new Goods_attribute();
        $data=$this->attr->find($id);
        $data->delete();
        return "删除成功";
    }

    /**
     * 获取同一个商品的所有属性信息
     *
     * @param  $request('商品ID')
     * @return \Illuminate\Http\Response
     */
    public function getSiblings(Request $request)
    {
        $this->attr=new Goods_attribute();
        $gid=$request->gid;
        $datas=$this->attr->Good($gid)->get();
        return $datas;
    }
}
