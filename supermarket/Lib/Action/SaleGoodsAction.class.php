<?php

/**
 * Class SaleGoodsAction
 *
 * 商品销售Action，用于完成超市前台的商品销售功能
 * 包括、商品的销售，查询、折扣、退货等
 */
class SaleGoodsAction extends BaseAction
{

    public function index()
    {
        $this->display();
    }


    /**
     * 取消本次入库操作
     */
    public function cancel()
    {
        //清空购物车商品列表
        unset($_SESSION["cart_list"]);
        $this->redirect("SaleGoods/index");
    }

    /**
     * 目前只是用于显示扫描条码页面，以后再添加其他业务逻辑
     */
    public function begin()
    {
        $cartList = $_SESSION["cart_list"];
        //如果购物车为空
        if (empty($cartList)) {
            $this->redirect("SaleGoods/scan");
        } else {
            $this->cartList = $cartList;
            $this->display();
        }
    }

    /**
     * 根据商品条码获取商品信息
     */
    public function getInfo()
    {
        $barcode = $this->_param("barcode");
        if (empty($barcode)) {
            $this->error("参数错误");
        }

        $info = D("Goods", "Service")->getInfo($barcode, $_SESSION["staff_info"]["branch_id"]);
        if (empty($info)) {
            $this->error("不存在对应的商品信息！");
        }

        $this->ajaxReturn($info, '获取商品信息成功！', 1);
    }

    /**
     * 加入商品到购物车
     */
    public function addToCart()
    {
        $barcode = $this->_param("barcode");
        $amount = $this->_param("amount", "intval", 1);
        if (empty($barcode) || empty($amount)) {
            $this->error("请填写完整的商品信息");
        }


        $bFound = false;
        foreach ($_SESSION["cart_list"] as $val) {
            if ($val["barcode"] === $barcode) {
                $bFound = true;
            }
        }
        //如果没有添加，就获取商品信息加入购物车，否则的话只是增加对应商品的数量
        if (!$bFound) {
            $goods = D("Goods", "Service")->getInfo($barcode, $_SESSION["staff_info"]["branch_id"]);
            $goods["amount"] = $amount;
            //加入SESSION内的购物车
            $_SESSION["cart_list"][] = $goods;
        } else {
            foreach ($_SESSION["cart_list"] as &$val) {
                if ($val["barcode"] === $barcode) {
                    $val["amount"] += $amount;
                }
            }
        }


//        //获取商品的促销信息
//        $map["branch_id"] = $_SESSION["staff_info"]["branch_id"];
//        $now = time();
//        //应该处于有效期内
//        $map["time_start"] = array("elt",$now);
//        $map["time_end"] = array("egt",$now);
//        $map["goods_id"] = intval($goods["id"]);
//        $promotion = M("Promotions")->where($map)->find();
//        $goods["promotions"] = $promotion;


        $this->success("添加成功！");
    }

    /**
     * 显示购物清单，
     * 同时获取商品的基本信息、出销信息（如果有的话），并计算商品总量，总额等用于页面展示
     * 同时页面自动处理表单输入，然后完成订单确认之后提交整个购物信息
     */
    public function showCart()
    {
        $staffInfo = $_SESSION["staff_info"];
        $cartList = $_SESSION["cart_list"];
        //商品出销信息的查询条件
        $map = array();
        $map["branch_id"] = $staffInfo["branch_id"];
        $now = time();
        //应该处于有效期内
        $map["time_start"] = array("elt", $now);
        $map["time_end"] = array("egt", $now);
        $promotions = M("promotions");

        $totalPrice = 0.0;
        $totalAmount = 0;
        //获取商品的促销信息
        foreach ($cartList as &$goods) {
            if (!isset($goods["promotions"])) {
                //加入商品ID查询促销
                $map["goods_id"] = intval($goods["id"]);
                //获取商品的折扣信息
                $goods["promotions"] = $promotions->where($map)->find();
            }

            //如果没有折扣
            if (empty($goods["promotions"])) {
                $goods["real_price"] = $goods["sales_price"];
            } else {
                //有折扣就进行折扣
                $goods["real_price"] = $goods["sales_price"] * $goods["promotions"]["discount"];
            }

            $goods["total_price"] = $goods["real_price"] * $goods["amount"];
            $totalPrice += $goods["total_price"];
            $totalAmount += $goods["amount"];
        }

        //更新SESSION的值
        $_SESSION["cart_list"] = $cartList;

        //模板变量
        $this->list = $cartList;
        $this->totalPrice = $totalPrice;
        $this->totalAmount = $totalAmount;
        $this->display();
    }

    public function delFromCart()
    {
        $goodsId = $this->_param("goodsId");
        $cartList = $_SESSION["cart_list"];
        $len = count($cartList);
        while ($len--) {
            if ($cartList[$len]["id"] == $goodsId) {
                array_splice($cartList, $len, 1);
//                unset($stockList[$len]);
            }
        }
        $_SESSION["cart_list"] = $cartList;
        $this->success("删除成功！");
    }


//    public function showForm(){
//        $staffInfo = session("staff_info");
//        $goodsList = session("cart_list");
//        //商品出销信息的查询条件
//        $map = array();
//        $map["branch_id"] = $staffInfo["branch_id"];
//        $now = time();
//        //应该处于有效期内
//        $map["time_start"] = array("elt",$now);
//        $map["time_end"] = array("egt",$now);
//        $promotions = M("promotions");
//
//        $totalPrice = 0.0;
//        $totalAmount = 0;
//        //获取商品的促销信息
//        foreach($goodsList as &$goods){
//            //加入商品ID查询促销
//            $map["goods_id"] = intval($goods["id"]);
//            //获取商品的折扣信息
//            $goods["promotions"] = $promotions->where($map)->find();
//
//            //如果没有折扣
//            if(empty($goods["promotions"])){
//                $goods["real_price"] = $goods["sales_price"];
//            }else{
//                //有折扣就进行折扣
//                $goods["real_price"] = $goods["sales_price"] * $goods["promotions"]["discount"];
//            }
//
//            $goods["total_price"] = $goods["real_price"] * $goods["amount"];
//            $totalPrice += $goods["total_price"];
//            $totalAmount += $goods["amount"];
//        }
//        //更新SESSION的值
//        session("cart_list", $goodsList);
//
//        //模板变量
//        $this->list = $goodsList;
//        $this->totalPrice = $totalPrice;
//        $this->totalAmount = $totalAmount;
//        $this->display();
//    }


    /**
     * 处理商品销售
     * --------------------------------------------------------------------------------
     * 将SESSION中存储的商品列表以及员工信息取出，
     * 并从表单提交的数量中获取对应的商品数量，
     * 然后统一将数据传给SERVICE进行处理
     * -------------------------------------------------------------------------------
     */
    public function doSale()
    {

        //获取员工信息
        $staffInfo = $_SESSION["staff_info"];
        //获取商品列表
        $goodsList = &$_SESSION["cart_list"];
        $service = D("SalesRecord", "Service");

        //获取各商品的数量
        foreach ($goodsList as &$goods) {
            $goods["amount"] = $this->_param("goods" . $goods["id"], "intval", 1);
        }

        try {
            $result = $service->doSale($staffInfo, $goodsList);
            //保存其他记录信息
            $_SESSION["record_info"] = $result;
        } catch (Exception $e) {
            $this->error("交易发生错误！" . $e->getMessage());
        }


        //清空购物车商品列表
        unset($_SESSION["cart_list"]);
        //$this->success("销售成功！",U("SaleGoods/showticket"));
        //提示成功页面并重定向到打印小票
        $this->success("销售成功！", U("SaleGoods/showticket?id=" . $result["id"]));
    }

    /**
     * 显示并打印小票信息
     */
    public function showticket()
    {
        $id = $this->_param("id");
        if (empty($id)) {
            $this->error("参数错误！");
        }

        $service = D("SalesRecord", "Service");
        try {
            $result = $service->getDetail($id, $_SESSION["staff_info"]["branch_id"], $_SESSION["staff_info"]["id"]);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->list = $result["items"];
        $this->recordInfo = $result["record"];
        $this->display();
    }


    /**
     * 查看个人的历史销售记录（即使是管理员）
     * 如果管理员需要查看所有记录，可以进入后台查看
     */
    public function history()
    {
        //获取员工信息
        $staffInfo = $_SESSION["staff_info"];
        try {
            $result = D("SalesRecord", "Service")->getList(array(), $staffInfo["branch_id"], $staffInfo["id"]);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $this->list = $result["list"];
        $this->page = $result["page"];
        $this->display();
    }

    /**
     * 查看某个销售记录的详情（只能查看自己的）
     */
    public function detail()
    {
        $id = $this->_param("id");
        $service = D("SalesRecord", "Service");
        try {
            $result = $service->getDetail($id, $_SESSION["staff_info"]["branch_id"], $_SESSION["staff_info"]["id"]);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $this->items = $result["items"];
        $this->record = $result["record"];
        $this->display();
    }
}