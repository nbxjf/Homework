<?php
class ClassManageAction extends CommonAction{
	public function insert(){


		$this->display();
	}

	public function classinsert(){
		$data = array(
			'bno' => I('bno'),
			'bname' => I('bname'),
			'bnum' => I('bnum'),

			);
		$info = M('class') -> where(array('bno' => $data[bno])) -> find();
		//p($data);
		//p($data[tno]);die;
		if($info == $data){
			$this->error('该班级信息已存在');
		}else if(M('class') -> add($data)){
			$this -> success('录入成功');
		}else{
			$this -> error('录入失败');
		}
	}
	
	public function classInfo(){
		import('ORG.Util.Page');
	  	$count = M('class')->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M('class')->select();
	  	//p($data);die;
	  	$this->page = $page->show();

		//$this->display();
		//$this->data = M('class')->select();
		$this->display();
	}


	public function update_classInfo(){
		$this->assign('info',$_GET);
		$this->display();

		//p($_GET);die;
	}

	public function update_classInfo_action(){
		//p($_POST);die;
		$data=array(
			'bno' =>$_POST['newbno'],
			'bname'=>$_POST['newbname'],
			'bnum'=>$_POST['newbnum'],
			);
		
		//p($data);die;
		if($data['bno']== NULL || $data['bname'] ==NULL || $data['bnum'] == NULL){
			$this->error('请填写完整信息');
		}
		if(M('class')->save($data)){
			$this->success('修改成功','classInfo');
		}
	}


	public function select_by_bno(){
		//p($_GET);die;
		import('ORG.Util.Page');
	  	$count = M('student')->where(array('bno'=>$_GET['bno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M('student')->where(array('bno'=>$_GET['bno']))->limit($limit)->select();
	  	//p($data);die;


	  	$this->page = $page->show();
	  	$this->assign('bno',$_GET['bno']);
		$this->display();
	}

}



?>