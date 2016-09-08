<?php
class CouManageAction extends CommonAction{

	public function insert(){
		$this->display();
	}
	public function couInsert(){
		$cno = I('cno');
		$cname = I('cname');
		$credit = I('credit');
		if($cno == NULL||$cname == NULL || $credit == NULL){
			$this -> error('信息录入不完整，各项不能为空');
		}
		$info = M('course') -> where(array('cno' => $cno)) -> find();
		//p($info);

		$data= array(
			'cno' => $cno,
			'cname' => $cname,
			'credit' => $credit,
			);
		//p($data);die;

		if($info == $data){
			$this -> error('该课程已存在');
		}else if(M('course') -> add($data)){
			$this->success('录入成功');
		}else{
			$this -> error('录入失败');
		}
	}

	public function couInfo(){
		import('ORG.Util.Page');
	  	$count = M('course')->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M('course')->limit($limit)->select();
	  	//p($data);die;
	  	$this->page = $page->show();

		//$this->display();
		//$this->data = M('class')->select();		
		$this->display();
	}

	public function update_couInfo(){

		//p($_GET);die;
		$this->assign('info',$_GET);
		$this->display();

	}

	public function update_couInfo_action(){
		//p($_POST);die;
		$data=array(
			'cno' =>$_POST['newcno'],
			'cname'=>$_POST['newcname'],
			'credit'=>$_POST['newcredit'],
			);
		//p($data);die;
		if($data['cno']== NULL || $data['cname'] ==NULL || $data['credit'] == NULL){
			$this->error('请填写完整信息');
		}
		if(M('course')->save($data)){
			$this->success('修改成功','couInfo');
		}
		//$this->redirect('couInfo');
	}


}



?>