<?php

namespace Admin\Controller;
 use Think\Controller;
 class AdminController extends CommonController{
	public function index(){
		//$admins= D("Admin")->getAdmins();
		//print_r($admins);exit();
		//-------------
		$conds =array();
		
	    $name = $_GET['username'];
		if($name){
			$conds['username']=$name;
		}
		 $name = $_GET['realname'];
		if($name){
			$conds['realname']=$name;
			}
		$page = $_REQUEST['p']?$_REQUEST['p']:1;
		$pageSize =2;
		 $conds ['status'] = array('neq',-1);
		$Admins = D("Admin")->getAdmin($conds,$page,$pageSize);
		  //print_r($Admin);exit;
		 $count = D("Admin")->getAdminCount($conds);
		  $res = new \Think\Page($count,$pageSize);
		 //print_r($res);
		 $pageres = $res->show();
		 $this ->assign('pageres',$pageres);
		//---------------
		
		$this->assign('admins',$Admins);
		$this->display();
		}
public function add(){

	if($_POST){
		//print_r($_POST);
		if(!isset($_POST['username'])||!$_POST['username']){
			return show (0,'用户名不能为空');
			}
		if(!isset($_POST['password'])||!$_POST['password']){
			return show (0,'密码不能为空');
			}
		$_POST['password']=getMd5Password($_POST['password']);
		//判断用户名是否存在
		$admin=D("Admin")->getAdminByUsername($_POST['username']);
		if($admin && $admin['status']!=-1){
			return show(0,'该用户已存在');
			}
	
		$id=D("Admin")->insert($_POST);
		
		if(!$id){
			//print_r($id);exit;
			return  show(0,'新增失败');
			}
		return show(1,'新增成功');
		}
		$this->display();
	}
	
public function setStatus(){
	$data =array(
		'admin_id'=>intval($_POST['id']),
		'status'=>intval($_POST['status']),
	);
	return parent::setStatus($_POST,'Admin');
	}
	
public function personal(){
		$res=$this->getLoginUser();
		//print_r($res);exit();
		$user=D("Admin")->getAdminByAdminId($res['admin_id']);
		$this->assign('vo',$user);
		$this->display();
	}
public function save(){
	$user = $this->getLoginUser();
	//print_r($user);
	if(!$user){
		return show(0,'用户不存在');
		}
		$data['realname']=$_POST['realname'];
		$data['email']=$_POST['email'];
		
		try{
			$id =D("Admin")->updateByAdminId($user['admin_id'],$data);
			if($id===false){
			return show(0,'配置失败');
			}
		return show(1,'配置成功');
		  }catch(Exception $e){
				return show(0,$e->getMessage());
				}
	}
 }