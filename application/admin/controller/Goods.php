<?php
/**
 * Created by PhpStorm.
 * User: CHEN
 * Date: 2018/7/11
 * Time: 16:12
 */

namespace app\admin\controller;

use think\console\Input;
use think\Controller;
use think\Request;
use think\Image;

class Goods extends Controller{
    /**
     * [商品列表]
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 陈绪
     */
    public function index(){
        return view("goods_index");
    }

    public function add(){

        return view("goods_add");
    }

    public function save(Request $request){
       if ($request->isPost()){
          
           $data = $request->only(["text"]);
           halt($data);
           $goods_data = $request->only([
                        "goods_name",
                        "sort_number",
                        "goods_type_id",
                        "goods_specification",
                        "goods_place",
                        "goods_supplier",
                        "goods_unit",
                        "goods_bazaar_money",
                        "goods_bottom_money",
                        "goods_keyword",
                        "goods_abstract",
                        "goods_detail",
           ]);
           $bool = db("goods")->insert($goods_data);
           if($bool){
               //取出图片在存到数据库
               if(isset($goods_images)){
                   $strrchr = uniqid().time().strrchr($goods_images,".");
                   $file = request()->file('goods_images');
                   $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                   halt($info);
                   $bool = $goods_images->validate(["ext"=>"jpg,png,gif"])->move(ROOT_PATH . "public".DS."upload");
                   halt($bool);
               }
           }
       }
    }
}