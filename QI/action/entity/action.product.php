<?php
  if(!defined('QI_PATH'))exit("error!");
    
    
    //默认执行方法
    if ($qi_do == "") {
    	echo "Hello, this is action product.";
      exit ();
    }
    
    
    //新建
    if ($qi_do == "add") {
        $add_product = new M_product();
    	//自动绑定表单数据,前提是表单中键名必须与字段名相同
    	//通过BindForm绑定的数据会被过滤处理
    	$add_product->BindForm();
    	$add_product = format_object($add_product->Add());//添加后会返回这个对象
         $tpl->assign ( "product_entity", $add_product );
    	$tpl->display ( "product.html" );
        exit ();
    }
    
    
    //删除
    if ($qi_do == "del") {
     	if(D_product::DeleteByID($qi_id)){
        	$tpl->assign ( "result", "恭喜,操作成功!");
            $tpl->clear_cache("product.html",md5(product.$qi_id));
        	$tpl->display ( "ok.html" );
      }else{
            $tpl->assign ( "result", "抱歉,操作失败!");
        	$tpl->display ( "sorry.html" );
      }
        exit ();
    }
    
    
    //编辑
    if ($qi_do == "edit") {
         $edit_product = new M_product($qi_id);
    	$edit_product->BindForm ();
    	if($edit_product->Edit()){
        	$tpl->assign ( "result", "恭喜,操作成功!");
            $tpl->clear_cache("product.html",md5(product.$qi_id));
        	$tpl->display ( "ok.html" );
    	}else{
        	$tpl->assign ( "result", "抱歉,操作失败!");//与之前修改一致无变化也会修改失败
        	$tpl->display ( "sorry.html" );
    	}
      exit ();
    }
    
    
    //查询一个记录
    if ($qi_do == "get") {
         if(!$tpl->is_cached("product.html",md5(product.$qi_id))){
             $get_product = D_product::GetModel ( $qi_id );
            	$get_product = format_object ( $get_product);
            	$tpl->assign ( "product_entity", $get_product );
         }
    	$tpl->display ( "product.html",md5(product.$qi_id) );
      exit ();
    }
    
    
    //查询所有数据(分页)
    if ($qi_do == "getall") {
        if(!$tpl->is_cached("product.html",md5($_SERVER['REQUEST_URI']))){
         $get_sql_where_product=" ";
    	$PageSize=$qi_PageSize_news;
    	$PageIndex=$qi_page;
    	$get_all_product= D_product::GetArray($PageSize, $PageIndex,' * ',$get_sql_where_product);
         $get_all_product = format_object ( $get_all_product );
         $tpl->assign ( "product_entity_all_list", $get_all_product );
     }
         $tpl->display ( "product.html",md5($_SERVER['REQUEST_URI']) );
      exit ();
    }
    
    
    //查询所有数据(不分页)
    if ($qi_do == "getalldata") {
        if(!$tpl->is_cached("product.html",md5($_SERVER['REQUEST_URI']))){
    	$get_all_product = D_product::GetArrayALL();
         $get_all_product = format_object ( $get_all_product );
    	$tpl->assign ( "product_entity_all_list", $get_all_product );
         }
    	$tpl->display ( "product.html",md5($_SERVER['REQUEST_URI']) );
      exit ();
    }
    
    
    //找不到执行项目所做的
    echo "404!";
?>
