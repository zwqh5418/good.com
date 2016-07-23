<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index($type=''){
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
		if($type=='buildHtml'){
			$this->buildHtml('index',HTML_PATH,'Index/index');
			}else{
				$this->display();
		}
		
    }
	public function build_html(){
		$this->index('buildHtml');
		return show(1,'首页缓存生成成功');
		}
		//计数
	public function getCount(){
		
		if(!$_POST){
			return show(0,'没有任何内容');
			}
		$newsIds =array_unique($_POST);
		try{
			$list =D("News")->getNewsByNewsIdIn($newsIds);
			
			}catch(Exception $e){
				return show(0,$e->getMessage());
				}
		if(!$list){
			return show(0,'notdata');
			}
		$data=array();
		foreach($list as $k=>$v){
			$data[$v['news_id']]=$v['count'];
			}
			//print_r($data);exit();
			return show(1,'success',$data);
		}
	
}


