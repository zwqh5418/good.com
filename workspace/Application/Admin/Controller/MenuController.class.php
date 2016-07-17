<?php
/**
后台菜单相关业务
*/
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController{
    public function add(){
        if($_POST){
           // print_r($_POST);//调试添加功能
            if(!isset($_POST['name']) || !$_POST['name']){
                return show(0,'菜单名不能为空');
            }
            
            if(!isset($_POST['m']) || !$_POST['m']){
                return show(0,'模块名不能为空');
            }
            
            if(!isset($_POST['c']) || !$_POST['c']){
                return show(0,'控制器名不能为空');
            }
            
            if(!isset($_POST['f']) || !$_POST['f']){
                return show(0,'方法名不能为空');
            }
            //编辑更新
            if($_POST['menu_id']){
                return $this->save($_POST);
            }
            //对数据入库
            $menuId = D("Menu")->insert($_POST);
            //print_r($menuId);
            if($menuId){
                return show(1,'新增成功',$menuId);
            }
            return show(0,'添加失败',$menuId);
             
        }else{
        $this->display();    
        }
        
    }
    public function index(){
        $data = array();
        if(isset($_REQUEST['type']) && in_array($_REQUEST['type'],array(0,1))){
        $data['type']= intval($_REQUEST['type']);
        $this->assign('type', $data['type']);
        }else{
            $this->assign('type',-100);
        }
        
        $page = $_REQUEST['p']? $_REQUEST['p']:1;
        
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize']:3;
        $menus = D("Menu")->getMenus($data,$page,$pageSize);//获取数据库数据
        $menusCount =D("Menu")->getMenusCount($data);
        //print_r($menus);//调试是否从数据库获得数据
        
        
        $res = new \Think\Page($menusCount,$pageSize);
        print_r($res);
        $pageRes= $res->show();
        $this->assign('pageRes',$pageRes);
        $this->assign('menus',$menus);
        $this->display();
    }
    
    public function edit(){
        $menuId = $_GET['id'];
        $menu = D("Menu")->find($menuId);
        print_r($menu);
        $this->assign('menu',$menu);
        $this->display();
    }
    
    public function save($data){
        $menuId = $data['menu_id'];
        unset($data['menu_id']);
        try{
        $id = D("Menu")->updateMenuById($menuId,$data);
        if($id === false){
            return show(0,'更新失败');
        }
         return show(1,'更新成功');
        }catch(Exception $e){
             return show(0,$e->getMessage());
        }
    }
    
    public function setStatus(){
        try{
        if($_POST){
            $id = $_POST['id'];
            $status =$_POST['status'];
            //执行数据更新操作
            $res = D("Menu")->updateStatusById($id,$status);
            if($res){
                return show(1,'删除成功');
            }else{
                return show(0,'删除失败');
            }
        }
        }catch(Exception $e){
            
            return show(0,$e->getMessage());
        }
        return show(0,'没有提交数据');
    }
}