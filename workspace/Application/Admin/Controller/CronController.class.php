<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

/*
数据库备份管理
*/
class CronController 
{
    public function dumpmysql(){
		$shell ="mysqldump -u".C("DB_USER").C("DB_PWD").C("DB_NAME")." > /tmp/cms".date("Ymd").".sql";
	exec($shell);	
		//echo $shell;测试开启
	}
	public function databackup(){
		$shell ="mysqldump -u".C("DB_USER").C("DB_PWD").C("DB_NAME")." > /tmp/cms".date("Ymd").".sql";
	exec($shell);	
		//echo $shell;测试开启
	return show(1,'数据备份成功待测试');
	}
	
} 