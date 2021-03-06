<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;
use Think;
/*
文章内容管理
*/
class ContentController extends CommonController  
{
    public function index(){
        $conds =array();
	    $title = $_GET['title'];
		if($title){
			$conds['title']=$title;
			}
		 
		if($_GET['catid']){
			$conds['catid']= intval($_GET['catid']);
			}
			
		$page = $_REQUEST['p']?$_REQUEST['p']:1;
		$pageSize =3;
		//$conds['status'] = array('neq',-1);
		 $news = D("News")->getNews($conds,$page,$pageSize);
		  //print_r($news);
		 $count = D("News")->getNewsCount($conds);
		 
	     //$res =  new \Think\Page($count,$pageSize);
		  $res = new \Think\Page($count,$pageSize);
		 //print_r($res);
		 $pageres = $res->show();
		 //推荐位信息获取
		 $positions =D("Position")->getNormalPositions();
		 //--------
		 $this ->assign('pageres',$pageres);
		 $this ->assign('news',$news);
		 $this->assign('positions',$positions);
	    $this->assign('webSiteMenu',D("Menu")->getBarMenus());
        $this->display();
    }
    public function add(){
        //print_r($_POST);
    if($_POST){
        if(!isset($_POST['title']) || !$_POST['title']){
            return show(0,'标题不存在');
        }
        if(!isset($_POST['small_title']) || !$_POST['small_title']){
            return show(0,'短标题不存在');
        }
        if(!isset($_POST['catid']) || !$_POST['catid']){
            return show(0,'文章栏目不存在');
        }
        if(!isset($_POST['keywords']) || !$_POST['keywords']){
            return show(0,'关键字不存在');
        }
          if(!isset($_POST['content']) || !$_POST['content']){
            return show(0,'内容不存在');
        }
        
		if($_POST['news_id']){
			return $this->save($_POST);
			}
        $newsId=D("News")->insert($_POST);
        if($newsId){
            $newsContentData['content']=$_POST['content'];
            $newsContentData['news_id']=$newsId;
            $cId = D("NewsContent")->insert($newsContentData);
                                     
            if($cId){
                return show(1,'新增成功');
            }else{
            return show(1,'主表插入成功，附表插入失败');
            }
        }else{
           return show(0,'新增失败'); 
        }
        
    }else{
        // code...
        $webSiteMenu = D("Menu")->getBarMenus();
        $titleFontColor = C("TITLE_FONT_COLOR");
        $copyFrom = C("COPY_FROM");
            $this->assign('webSiteMenu',$webSiteMenu);
            $this->assign('titleFontColor',$titleFontColor);
            $this->assign('webSiteMenu',$webSiteMenu);
            $this->assign('copyfrom',$copyFrom);
            $this->display();
    
        }
    }
	
	public function edit(){
		$newsId = $_GET['id'];
		if(!$newsId){
			$this->redirect('/admin.php?c=content');
			}
		$news =D("News")->find($newsId);
		
		if(!$news){
			$this->redirect('/admin.php?c=content');
			}
		$newsContent = D("NewsContent")->find($newsId);
		
		if($newsContent){
			$news['content']= $newsContent['content'];
			
			}	
			$webSiteMenu =D("Menu")->getBarMenus();
			$titleFontColor = C("TITLE_FONT_COLOR");
			//print_r($titleFontColor);
			$this->assign('webSiteMenu',$webSiteMenu);
			$this->assign('title_font_color',$titleFontColor);
						   
			$this->assign('copyfrom',C("COPY_FROM"));
			$this->assign('news',$news);
		$this->display();
		}
		
		public function save($data){
			$newsId = $data['news_id'];
			unset($data['news_id']);
			try{
			$id = D("News")->updateById($newsId,$data);
			$newsContentData['content']=$data['content'];
			$condId=D("NewsContent")->updateNewsById($newsId,$newsContentData);
			if($id === false || $condId === false){
				return show(0,'更新失败');
				}
			return show(1,'更新成功');
			}catch(Exception $e){
				return show(0, $e->getMessage());
				}
			}
		
		public function setStatus(){
			try{
			if($_POST){
				$id = $_POST['id'];
				$status = $_POST['status'];
				if(!$id){
					return show(0,'ID不存在');
					}
				$res =D("News")->updateStatusById($id,$status);
				if ($res){
					return show(1,'操作成功');
					}
				}
				return show(0,'没有提交的内容');
			}catch(Exception $e){
				return show(0,$e->getMessage());
				}
			}
		
		//排序
		public function listorder(){
			$listorder = $_POST['listorder'];
			$jumpUrl = $_SERVER['HTTP_REFERER'];
			$error =array();
			//print_r($listorder);
			try{
				if($listorder){
				foreach($listorder as $newsId => $v){
					
					$id =D("News")->updateNewsListorderById($newsId,$v);
					if($id === false){
						$error[]=$newsId;
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
	
 	public function push(){
		
		$jumpUrl = $_SERVER['HTTP_REFERER'];
		$positionId =intval($_POST['position_id']);
		$newsId = $_POST['push'];
		
		if(!$newsId || !is_array($newsId)){
			return show(0,'请选择推荐位的文章ID进行推荐');
			}
		if(!$positionId){
			return show(0,'没有选择推荐位');
			}
		//print_r($newsId);exit;
		try{
		$news= D("News")->getNewsByNewsIdIn($newsId);
		if(!$news){
			return show(0,'没有相关内容');
			}
			foreach($news as $new){
				$data = array(
				'position_id' => $positionId,
				'title' => $new['title'],
				'thumb' => $new['thumb'],
				'news_id' => $new['news_id'],
				'status' => 1,
				'create_time' =>$new['create_time'],
				);
				$position = D("PositionContent")->insert($data);
				}
			}catch(Exception $e){
				return show(0,$e->getMessage());
				}
			return show(1,'推荐成功',array('jump_url'=>$jumpUrl));
		}
}