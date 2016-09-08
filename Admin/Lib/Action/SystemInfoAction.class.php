<?php

class SystemInfoAction extends CommonAction{

	public function index(){
		$this->assign('title',C('cfg_name'));
	      //获取服务器信息
    	//P($_SERVER);die;
        $sysdata['sysos'] = $_SERVER[SERVER_SOFTWARE]; //获取服务器标识的字串
        //p($sysdata['sysos'] );die;
        $sysdata['sysversion'] = PHP_VERSION; //获取PHP服务器版本
        //以下两条代码连接MySQL数据库并获取MySQL数据库版本信息
        //从服务器中获取GD库的信息
        if(function_exists("gd_info")){ 
        $gd = gd_info();
        $sysdata['gdinfo'] = $gd['GD Version'];
        }else {
        $sysdata['gdinfo'] = "未知";
        }
        //从GD库中查看是否支持FreeType字体
        $sysdata['freetype'] = $gd["FreeType Support"] ? "支持" : "不支持";
        //从PHP配置文件中获得是否可以远程文件获取
        $sysdata['allowurl']= ini_get("allow_url_fopen") ? "支持" : "不支持";
        //从PHP配置文件中获得最大上传限制
        $sysdata['max_upload'] = ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled";
        //从PHP配置文件中获得脚本的最大执行时间
        $sysdata['max_ex_time']= ini_get("max_execution_time")."秒";
        //以下两条获取服务器时间，中国大陆采用的是东八区的时间,设置时区写成Etc/GMT-8
        date_default_timezone_set("Etc/GMT-8");
        $sysdata['systemtime'] = date("Y-m-d H:i:s",time()); 
        $this->assign('sysdata',$sysdata);
	 	$this->display();
	}
}


?>