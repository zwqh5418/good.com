<?php
namespace Common\Model;
use Think\Model;

class AdminModel  extends Model{
    private $_db = '';
    public function __construct(){
        $this->_db =M('admin');
    }
	public function getAdmins() {
        $data = array(
            'status' => array('neq',-1),
        );
        return $this->_db->where($data)->order('admin_id desc')->select();
    }
    public function getAdminByUsername($username){
        $ret = $this->_db->where('username="'.$username.'"')->find();
		//console.log($ret);
        return $ret;
    }
	public function getAdminByAdminId($adminId=0) {
        $res = $this->_db->where('admin_id='.$adminId)->find();
        return $res;
    }
	public function updateStatusById($id,$status){
		if(!is_numeric($status)){
			throw_exception('status状态能为非数字');
			}
		if(!is_numeric($id) || !$id){
			throw_exception('id不合法');
			}
		$data['status']=$status;
		return $this->_db->where('admin_id='.$id)->save($data);
		}
	public function insert($data = array()){
        if(!$data || !is_array($data)){
            return 0;
        }
        return $this->_db->add($data);
    }
	
	 public function updateByAdminId($id, $data) {

        if(!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)) {
            throw_exception('更新的数据不合法');
        }
        return  $this->_db->where('admin_id='.$id)->save($data); // 根据条件更新记录
    }
	public function getLastLoginUsers(){
		$time =mktime (0,0,0,date("m"),date("d"),date("Y"));
		$data=array(
			'status'=>1,
			'lastLogintime' => array('gt',$time),
		);
		$res= $this->_db->where($data)->count();
		return $res ['tp_count'];
		}
	//-------------
	 public function getAdmin($data,$page,$pageSize=10){
		 if(isset($data['username'])&& $data['username']){
			$conditions['username'] =array('like','%'.$data['username'].'%');
			}
		 if(isset($data['realname'])&& $data['realname']){
			$conditions['realname'] =array('like','%'.$data['realname'].'%');
			}
			$conditions =$data;
			$conditions ['status'] = array('neq',-1);
			$offset =($page-1)*$pageSize;
			$list= $this->_db->where($conditions)
			->order('admin_id desc')
			->limit($offset,$pageSize)
			->select();
			//print_r($list);
			return $list;
		}
		            
	public function getAdminCount($data = array()){
		 if(isset($data['username'])&& $data['username']){
			$conditions['username'] =array('like','%'.$data['username'].'%');
			}
		 if(isset($data['realname'])&& $data['realname']){
			$conditions['realname'] =array('like','%'.$data['realname'].'%');
			}
			$conditions =$data;
			return $this->_db->where($conditions)->count();
		}
	
}