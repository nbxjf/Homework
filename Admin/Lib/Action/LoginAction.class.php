<?php
header("Content-Type:text/html;Charset=utf-8");
// 本类由系统自动生成，仅供测试用途
class LoginAction extends Action {
    public function index(){
    	//var_dump(__URL__);die;
	 	$this->display();
	}


	public function login(){

		if(!IS_POST) $this->{U('Admin/Login/index')};
		$managename = I('managename');
		$managepwd = I('managepwd','','md5');

		$manage = M('manage') ->where(array("managename" => $managename)) ->find();
		//p($manage['managepwd']);die;
		if(!$manage || $manage['managepwd'] != $managepwd){
			$this->error('用户密码或账号错误');
		}
		$data = array(
			'id' => $manage['id'],
			'logintime' => time(),
			'loginip' => get_client_ip(),  
		);
		//p($data);die;
		M('manage')->save($data);

		session(('id'), $manage['id']);
		session('managename' ,$manage['managename']);
		session('logintime' , date('Y-m-d H:i'), $manage['logintime']);
		session('loginip', $manage['loginip']);
		//p($_SESSION);die;

		$this->redirect('Admin/Index/index');
	}

	public function loginout()
 	{
 		session_unset();
		session_destroy();
		$this->redirect('Admin/Login/index');
 	}
}