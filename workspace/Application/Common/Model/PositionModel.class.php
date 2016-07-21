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
		$list =$this->_db-where($conditions)->order('id')->select();
		return $list;
		}
	public function find($id){
		
		$data =$this->_db->where('id='.id)->find();
		return $data;
		}
	
	
	public function getNormalPositions(){
	$conditions= array('status'=>1);
	$list = $this->_db->where($conditions)->order('id')->select();
	return $list;
	}
	}

