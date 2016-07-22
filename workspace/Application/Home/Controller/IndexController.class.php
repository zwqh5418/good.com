<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		//获取排行
		$rankNews=$this->getRank();
		//首页一张大图
		$topPicNews = D("PositionContent")->select(array('status'=>1,'position_id'=>2),1);
		//首页三张小图
		$topSmailNews = D("PositionContent")->select(array('status'=>1,'position_id'=>3),3);
		//获取排行列表
		//$listNews = D("News")->select(array('status'=>1,'thumb'=>array('neq','')),30);
		$listNews = D("News")->select(array('status'=>1,'thumb'=>array('neq','')),30);
		//获取两条广告位
		$advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>5),2);
		
        $this->assign('result',array(
		'topPicNews'=>$topPicNews,
		'topSmailNews' =>$topSmailNews,
		'listNews' =>$listNews,
		'advNews' =>$advNews,
		'rankNews'=>$rankNews,
		'catId'=>0,
		));
		$this->display();
    }
}


