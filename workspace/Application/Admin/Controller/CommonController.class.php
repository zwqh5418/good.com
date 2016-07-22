<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class CommonController extends Controller {


	public function __construct() {
		
		parent::__construct();
		$this->_init();
	}
	/**
	 * 初始化
	 * @return
	 */
	private function _init() {
		// 如果已经登录
		$isLogin = $this->isLogin();
		if(!$isLogin) {
			// 跳转到登录页面
			$this->redirect('/admin.php?c=login');
		}
	}

	/**
	 * 获取登录用户信息
	 * @return array
	 */
	public function getLoginUser() {
		return session("adminUser");
	}

	/**
	 * 判定是否登录
	 * @return boolean 
	 */
	public function isLogin() {
		$user = $this->getLoginUser();
		if($user && is_array($user) ) {
			return true;
		}

		return false;
	}
//修改状态通用
public function setStatus($data,$models){
			try{
			if($_POST){
				//print_r($_POST);exit();
				$id = $data['id'];
				$status = $data['status'];
				//print_r($status);exit();
				if(!$id){
					return show(0,'ID不存在');
					}
				$res =D($models)->updateStatusById($id,$status);
				if ($res){
					return show(1,'操作成功');
					} else{
					return show(0,'操作失败');
						}
					
				}
				return show(0,'没有提交的内容');
			}catch(Exception $e){
				return show(0,$e->getMessage());
				}
			}
			//排序通用
	public function listorder($model=''){
			$listorder = $_POST['listorder'];
			$jumpUrl = $_SERVER['HTTP_REFERER'];
			$error =array();
			//print_r($listorder);
			try{
				if($listorder){
				foreach($listorder as $id => $v){
					
					$id =D($model)->updateListorderById($id,$v);
					if($id === false){
						$error[]=$id;
							}
					}
					if($error){
					return show(0,'排序失败-'.implode(',',$error), array('jump_url'=>$jumpUrl));
							}
						return show(1,'排序成功',array('jump_url'=>$jumpUrl));
				}
			}catch(Exception $e){
			return show(0,$e->getMessage());
			}
			return show(0,'排序失败',array('jump_url'=>$jumpUrl));
	}
	
	

}