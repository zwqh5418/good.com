<?php
/**
 * 后台Index相关
 */
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    public function index(){
		$news =D("News")->maxcount();
		//print_r($news);exit;
		$newsCount =D('News')->getNewsCount(array('status'=>1));
		$positionCount =D('Position')->getCount(array('status'=>1));
		$adminCount =D('Admin')->getLastLoginUsers();
		
		$this->assign('news',$news);
		$this->assign('newscount',$newsCount);
		$this->assign('positioncount',$positionCount);
		$this->assign('admincount',$adminCount);
		
		$this->display();
    }

    public function main() {
    	$this->display();
    }
}