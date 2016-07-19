<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class ImageController extends CommonController {
    private $_uploadObj;
    public function __construct(){
        
    }
    public function ajaxuploadimage(){
      $upload = D("UploadImage");
      $res = $upload->imageUpload();
     
      if($res === false){
          
          return show(0,'上传失败','');
      }
      else{
          
          return show(1,'上传成功',$res);
      }
      
    }
    
    public function kindupload(){
        $upload = D("UploadImage");
      $res = $upload->upload();  
      if($res === false){
          return showKind(1,'上传失败');
      }
      return showKind(0,$res);
    }
    
    
}