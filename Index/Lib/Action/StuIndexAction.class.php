<?php
class StuIndexAction extends Action{
	public function index(){
		$this-> display();
	}

	public function main(){
		$this -> display();
	}


	public function changepwd(){
		$data = M('student') ->join('hm_class on hm_student.bno=hm_class.bno')->where(array('sno'=>$_SESSION['sno']))->select();
		//p($data);die;
		$this->assign("bname",$data[0][bname]);
		$this->display();
	}

	public function changepwdaction(){
		//p($_POST);die;
		$info = M('student') -> where(array('sno' => $_SESSION[sno])) ->find();
		$newpassword = I('newpassword','','md5');
		$repassword = I('repassword','','md5');
		// p($newmanagepwd);
		// p($remanagepwd);
		// die;
		if($newpassword == NULL || $repassword == NULL){
			$this->error('密码不能为空');
		}
		if ($newpassword!=$repassword) {
				$this->error('两次密码输入不相同');
			}
		$data = array(
				'sno' => $_SESSION[sno],
				'sname' => $_SESSION[sname],
				'password' => $newpassword,
			);
		//p($data);
		if($data == $info){
			$this->error('修改信息与原信息相同！无需修改！');
		}else if(M('student')->save($data)){
			session_start();
			session_unset();
			//P($_SESSION);die;
			if($_SESSION == NULL){
				session('sno', $data['sno']);
				session('sname' ,$data['sname']);
				$this->success('修改成功');
			}else
				$this->error('修改失败,请重新修改！');
				// $this->success('修改成功')->redirect('Admin/Login/index');
		}else  
			$this->error('修改失败,请重新修改！');

	}



	public  function mycourse(){
		$info = M('student') ->where(array('sno' => $_SESSION['sno']))->find();
		import('ORG.Util.Page');
	  	$count = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno')->join('hm_teacher on hm_teach_course.tno=hm_teacher.tno')->where(array('bno' => $info['bno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno')->join('hm_teacher on hm_teach_course.tno=hm_teacher.tno')->where(array('bno' => $info['bno']))->limit($limit)->select();
	  	$this->page = $page->show();
		$this->display();
	}

	public function select_homework(){
		/*$a =M("teawork")->join('hm_course on hm_course.cno=hm_teawork.cno')->join('hm_teacher on hm_teacher.tno=hm_teawork.tno')->field('hm_teawork.cno,hm_teawork.homework_theme')->select();
		$count=M("teawork")->join('hm_course on hm_course.cno=hm_teawork.cno')->join('hm_teacher on hm_teacher.tno=hm_teawork.tno')->field('hm_teawork.cno,hm_teawork.homework_theme')->count();
		p($count);
		p($a);
		die;*/
		$bno=M('student')->where(array('sno'=>$_SESSION['sno']))->find();
		//p($bno);die;
		import('ORG.Util.Page');
	  	$count = M("teawork")->join('hm_teach_course on hm_teach_course.cno=hm_teawork.cno')->join('hm_course on hm_course.cno=hm_teawork.cno')->field('hm_teawork.*,hm_teach_course.id bid,hm_teach_course.bno,hm_course.cname')->where(array('bno'=>$bno['bno']))->count();
	  	$page = new Page($count, 8);

	  	/*$data=M("teawork")->join('hm_teach_course on hm_teach_course.cno=hm_teawork.cno')->join('hm_course on hm_course.cno=hm_teawork.cno')->field('hm_teawork.*,hm_teach_course.id bid,hm_teach_course.bno,hm_course.cname')->where(array('bno'=>$bno['bno']))->order('publishtime DESC')->limit($limit)->select();
	  	p($data1);die;*/

	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data=M("teawork")->join('hm_teach_course on hm_teach_course.cno=hm_teawork.cno')->join('hm_course on hm_course.cno=hm_teawork.cno')->field('hm_teawork.*,hm_teach_course.id bid,hm_teach_course.bno,hm_course.cname')->where(array('bno'=>$bno['bno']))->order('publishtime DESC')->limit($limit)->select();
	  	//p($data);die;
	  	$this->page = $page->show();
		$this->display();
	}
	public function work_detail(){
		$data = M("teawork")->where(array('id'=>$_GET['id']))-> find();
		if($data['tmp_name'] == NULL){
			$this->assign('attachment',"无");
		}
		if($data['tmp_name'] != NULL){
			$this->assign('attachment',"有");
		}
		if($data['homework_detail'] == NULL){
			$this->assign('detail',"无");
		}else{
			$this->assign('detail',$data['homework_detail']);
		}
		//p($data);die;
		$this->assign('info',$data);
		$this->display();
	}


	public function download(){
 		$id=$_GET['id'];
 		$fileInfo=M("teawork")->where(array('id'=>$id))-> find();;
 		//p($fileInfo);die;
 		if($fileInfo['tmp_name'] == NULL){
 			$this->error('没有附件');
 		}
 		$filename =M('teattach')->where(array('tmp_name'=>$fileInfo['tmp_name']))->find();
 		//p($filename);die;
 		header("Content-type:text/html;charset=utf-8");

		$file_name=iconv("utf-8","gb2312",$filename['name']);
		// $file_sub_path="uploads/" . $file_name;
		$file_path="uploads/" . $file_name;
		if(!file_exists($file_path)){
				$this->error("没有该文件文件");
		}
		$fp=fopen($file_path,"r");
		$file_size=filesize($file_path);
		//p($file_size);die;
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length:".$file_size);
		Header("Content-Disposition: attachment; filename=".$file_name);
		$buffer=1024;
		$file_count=0;
		//向浏览器返回数据
		while(!feof($fp) && $file_count<$file_size){
		$file_con=fread($fp,$buffer);
		$file_count+=$buffer;
		echo $file_con;
		}
		fclose($fp); 	
 	}

	public function upload_homework(){
		$data = M("teawork")->join('hm_course on hm_course.cno=hm_teawork.cno')->where(array('id'=>$_GET['id']))-> find();
		$this->assign('info',array('cname' => $data['cname'],'theme' => $data['homework_theme'],'id'=>$_GET['id']));
		$this->display();
	}


	public function work_upload(){
		//p($_GET);
		//p($_POST);die;
		$data = M("teawork")->join('hm_course on hm_course.cno=hm_teawork.cno')->where(array('id'=>$_GET['id']))-> find();
		//p($data);
		//p($_sever);die;
		$cname = I('ccname');
		$cinfo = M('course') ->where(array('cname' => $cname))->find();
		$other = I('other');
		//p($cname);
		//$cinfo = M('course') ->where(array('cname' => $cname))->find();
		//p($cinfo);die;
		$deadline = M('teawork')->where(array('cno'=>$cinfo['cno'],'theme'=>I('theme')))->find();
		$time = time();
		if($time > $deadline['deadline']){
			$this->error('已经超过截止时间，停止上交');
		}
		$up = M('sup')->where(array('cno'=>$cinfo['cno'],'theme'=>I('theme')))->find();
		if($up){
			$this->error('已经上传过改作业，请勿重复上传');
		}
		if($cname == 1){
			$this->error('请选择课程名');
		}
		$fileInfo = $_FILES['homework_attach'];
		if($fileInfo['name'] == NULL){
			$this->error('请上传作业附件');
		}
		//p($_FILES);die;
		//p($fileInfo);die;
		$name = iconv('utf-8','gb2312',$fileInfo['name']);
		//p($name);die;
		if(!empty($fileInfo['name'])){
			if (file_exists("stuUploads/" . $fileInfo["name"]))
	      	{
	     	 $this->error('该附件已存在，请重新上传或重命名！');
	      	}else{
	      		move_uploaded_file($fileInfo["tmp_name"],"stuUploads/" . $name);
            }
		}
		$data = array(
					'sno' => $_SESSION['sno'],
					'score' => 0,
					'comment'=>'',
                    'tmp_name' => $fileInfo['tmp_name'],//临时名字
                    'name' => $fileInfo['name'],//附件名
                    'size' =>$fileInfo['size'],//附件大小
                    'type' => $fileInfo['type'],
                    'error' => $fileInfo['error'],
                    'cno' =>$cinfo['cno'],
                    'theme'=> I('theme'),
                    'other' =>$other,
                    'uptime'=>$time,
                    'tno'=>$data['tno'],
                );
			 //p($data);die;
        if(M('sup')->add($data))
        {
            $this->success('上交作业成功！');
        }
        else{
            $this->error('上交作业失败，请重试！');
        }
	}



	public function mywork(){
		import('ORG.Util.Page');
	  	$count = M('sup')->join('hm_course on hm_sup.cno=hm_course.cno')->join('hm_student on hm_student.sno=hm_sup.sno')->where(array('sname'=>$_SESSION['sname']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M('sup')->join('hm_course on hm_sup.cno=hm_course.cno')->join('hm_student on hm_student.sno=hm_sup.sno')->where(array('sname'=>$_SESSION['sname']))->order('uptime DESC')->limit($limit)->select();
	  	$this->page = $page->show();
		$this->display();
	}


	public function find_work(){
		//p($_GET);die;
		import('ORG.Util.Page');
	  	$count = M('teawork') ->where(array('cno'=>$_GET['cno'],'tno'=>$_GET['tno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;

	  	$this->data = M('teawork')->where(array('cno'=>$_GET['cno'],'tno'=>$_GET['tno']))->order('publishtime DESC')->limit($limit)->select();
	  	//p($data);die;
	  	$this->assign('cname',$_GET['cname']);
	  	$this->page = $page->show();
		//$data = M('teawork') ->where(array('cno'=>$_GET['cno'],'tno'=>$_GET['tno']))->select();
		$this->display();
	}

	public function select_by_cno(){
		//p($_SESSION);die;
		$info = M('student') ->where(array('sno' => $_SESSION['sno']))->find();
		//p($info);die;
		import('ORG.Util.Page');
	  	$count = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno')->join('hm_teacher on hm_teach_course.tno=hm_teacher.tno')->where(array('bno' => $info['bno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno')->join('hm_teacher on hm_teach_course.tno=hm_teacher.tno')->where(array('bno' => $info['bno']))->limit($limit)->select();
	  	//p($data);die;
	  	$this->page = $page->show();

		$this->display();
	}

}


?>