<?php
namespace Home\Controller;
use Think\Controller;
class DetailController extends CommonController{
	public function index(){
	
		 $id =intval($_GET['$id']);
		 //print_r($_GET['id']);exit();
		 if(!$id || $id<0){
			 return  $this->error("ID不合法1");
			 }
		$news =D("News")->find($id);
		
		if(!$news || $news['status']!=1){
			return $this->error("ID不存在或者资讯被关闭");
			}
		$count =intval($news['count'])+1;
		D('News')->updateCount($id,$count);
		//操作附表
		$content=D("NewsContent")->find($id);
		$news['content']=htmlspecialchars_decode($content['content']);
		
		$advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>5),2);
		$rankNews=$this->getRank();
		
		$this->assign('result',array(
			'advNews' =>$advNews,
			'rankNews'=>$rankNews,
			'catId'=>$news['catid'],
			'news'=>$news,
			//'listNews'=>$news,
			//'pageres'=>$pageres
		));
	
		$this->display("Detail/index");
				
	}
	public function view(){
		if(!getLoginUsername()){
			$this->error("您没有访问权限");
			}
		$this->index();	
	}
}