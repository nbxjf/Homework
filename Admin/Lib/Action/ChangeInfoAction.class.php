<?php
class ChangeInfoAction extends CommonAction{
	public function index(){
		$this -> display();
	}

	public function change(){
		$info = M('manage') -> where(array('managename' => $_SESSION[managename])) ->find();
		$newmanagename = I('newmanagename');
		$newmanagepwd = I('newmanagepwd','','md5');
		$remanagepwd = I('remanagepwd','','md5');
		// p($newmanagepwd);
		// p($remanagepwd);
		// die;
		if($newmanagename == NULL || $newmanagepwd == NULL){
			$this->error('密码或用户名为空');
		}
		if ($newmanagepwd!=$remanagepwd) {
				$this->error('两次密码输入不相同');
			}
		$data = array(
				'id' => $_SESSION['id'],
				'managename' => $newmanagename,
				'managepwd' => $newmanagepwd,
			);
		if($data == $info){
			$this->error('修改信息与原信息相同！无需修改！');
		}else if(M('manage')->save($data)){
			session_start();
			session_unset();
			//P($_SESSION);die;
			if($_SESSION == NULL){
				session('id', $data['id']);
				session('managename' ,$data['managename']);
				session('logintime' , date('Y-m-d H:i'), $data['logintime']);
				session('loginip', get_client_ip());
				$this->success('修改成功');
			}else
				$this->error('修改失败,请重新修改！');
				// $this->success('修改成功')->redirect('Admin/Login/index');
		}else  
			$this->error('修改失败,请重新修改！');
		//p($data);die;
	}


}


?>