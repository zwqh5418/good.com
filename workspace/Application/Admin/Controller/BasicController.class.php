<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;
class BasicController extends CommonController{
	public function index(){
		$result= D("Basic")->select();
		$this->assign('vo',$result);
		$this->assign('type',1);
		$this->display();
		}
		
	public function add(){
		
		if($_POST){
					if(!$_POST['title']){
						return show(0,'站点标题不能为空');
						}
					if(!$_POST['keywords']){
						return show(0,'站点关键字不能为空');
						}
					if(!$_POST['description']){
							return show(0,'站点描述不能为空');
						}
					D("Basic")->save($_POST);
					return show(1,'配置成功');
			}else{
				return show(0,'没有提交的数据');	
		   }
		}
		//缓存管理
		public function cache(){
			$this->assign('type',2);
			$this->display();
			}
		//数据备份管理
	  public function databackup(){
			$this->assign('type',3);
			$this->display();
			}
		
	}