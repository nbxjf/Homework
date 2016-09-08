<?php
header("Content-Type:text/html;Charset=utf-8");
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	 
    public function index(){
    	$this->display();
    	//echo "前台首页";
	}


	public function login(){
		if(!IS_POST) $this->{U('Index/Login/index')};

		$username = I('username');
		$password = I('password','','md5');
		$identity = I('identity');
		if($identity == NULL){
			$this->error('请选择身份！');
		}
		if($identity == 1){
			
			$student = M('student') ->where(array("sno" => $username)) ->find();
			
			if(!$student || $student[password] != $password){
				$this -> error('用户名或密码错误');
			}else{
				session(('sno'), $username);
				session('sname' ,$student['sname']);
				$this->redirect('Index/StuIndex/index');
			}
		}else if($identity == 2){
			
			$teacher = M('teacher') -> where(array("tno" => $username)) ->find();
			if(!$teacher || $teacher[password] != $password){
				$this -> error('用户名或密码错误');
			}else{
				session(('tno'), $username);
				session('tname' ,$teacher['tname']);
				//p($_SESSION);die;
				$this->redirect('Index/TeaIndex/index');
			}
		}else{
			$this->error('登录失败');
		}

		
		//$this->redirect('Index/TeaIndex/index');

		//p($_POST);die;
	}


	public function loginout()
 	{
 		session_unset();
		session_destroy();
		$this->redirect('Index/Index/index');
 	}

}