<?php
namespace Common\Model;
use Think\Model;
class PositionModel extends Model{
	private $_db ='';
	public function __construct(){
		$this->_db= M('position');
		}
	public function select($data = array()){
		$conditions =$data;
		$list =$this->_db->where($conditions)->order('id')->select();
		return $list;
		}
	public function find($id){
		
		$data =$this->_db->where('id='.id)->find();
		return $data;
		}
	public function getCount($data=array()) {
		$conditions = $data;
		$list = $this->_db->where($conditions)->count();

		return $list;
	}
	public function updateStatusById($id, $status) {
		if(!is_numeric($status)) {
			throw_exception("status不能为非数字");
		}
		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		$data['status'] = $status;
		return  $this->_db->where('id='.$id)->save($data); // 根据条件更新记录

	}
	public function getNormalPositions(){
	$conditions= array('status'=>1);
	$list = $this->_db->where($conditions)->order('id')->select();
	return $list;
	}
    public function insert($res=array()) {
    	if(!$res || !is_array($res)) {
    		return 0;
    	}
		$res['create_time'] = time();
    	return $this->_db->add($res);
    }
   public function updateById($id, $data) {

		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		if(!$data || !is_array($data)) {
			throw_exception('更新的数据不合法');
		}
		return  $this->_db->where('id='.$id)->save($data); // 根据条件更新记录
	}
	//------------------------
	public function getPosition($data,$page,$pageSize=10){
		$conditions =$data;
		if(isset($data['name'])&& $data['name']){
			$conditions['name'] =array('like','%'.$data['name'].'%');
			}
		if(isset($data['description'])&& $data['description']){
			$conditions['description'] =intval($data['description']);
			}
			$conditions ['status'] = array('neq',-1);
			$offset =($page-1)*$pageSize;
			$list= $this->_db->where($conditions)
			->order('id desc')
			->limit($offset,$pageSize)
			->select();
			//print_r($list);
			return $list;
		}
		            
	public function getPositionCount($data = array()){
			$conditions =$data;
			if(isset($data['name'])&& $data['name']){
				$conditions['name'] =array('like','%'.$data['name'].'%');
			}
			if(isset($data['description'])&& $data['description']){
				$conditions['description'] =intval($data['description']);
			}
			return $this->_db->where($conditions)->count();
		}
	//-----------------------
}

