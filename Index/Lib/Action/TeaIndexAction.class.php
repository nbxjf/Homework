<?php
class TeaIndexAction extends Action{
	public function index(){
		$this->display();
	}
	public function main(){
		$this->display();
	}

	public function changepwd(){
		$this->display();
	}

	public function changepwdaction(){
		//p($_POST);die;
		$info = M('teacher') -> where(array('tno' => $_SESSION[tno])) ->find();
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
				'tno' => $_SESSION[tno],
				'tname' => $_SESSION[tname],
				'password' => $newpassword,
			);
		//p($data);die;
		if($data == $info){
			$this->error('修改信息与原信息相同！无需修改！');
		}else if(M('teacher')->save($data)){
			session_start();
			session_unset();
			//P($_SESSION);die;
			if($_SESSION == NULL){
				session('tno', $data['tno']);
				session('tname' ,$data['tname']);
				//p($_SESSION);die;
				$this->success('修改成功');
			}else
				$this->error('修改失败,请重新修改！');
				// $this->success('修改成功')->redirect('Admin/Login/index');
		}else  
			$this->error('修改失败,请重新修改！');

	}



	public function allcourse(){
		
		import('ORG.Util.Page');
	  	$count = M('course')->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M('course')->limit($limit)->select();
		$this->page = $page->show();

		$this->bno =M('class') -> field('bno')->select();

		$this->display();
	}

	public function choose_course(){
		//$choose_bno = I('choose_bno');
		//p($choose_bno);die;
		//p($_POST);die;
		 $data =array(
			'cno' => I('cno'),
		 	'tno' => $_SESSION[tno],
		 	'bno' => I('choose_bno'),
		 	);
		 //p($_SESSION);die;
		//p($data[bno]);die;
		//$info =M('teach_course')->where(array('cno' =>$data['cno'],'bno'=>$data['bno'],'tno'=>$data['tno']))->find();
		if($data[bno] == 1){
			$this ->error('请选择授课班级');
		}
		if(M('teach_course')->where(array('cno' =>$data['cno'],'bno'=>$data['bno'],'tno'=>$data['tno']))->find()){
			$this->error('已选择该课程');
		}else if(M('teach_course')->add($data)){
			$this->success('选择成功');

		}else{
			$this->error('选择失败');
		}
		//p($data);die;
	}

	public function mycourse(){
		// $a = new Model();
		// $a -> query("select a.tno,b.cname from teach_course as a,course as b where a.cno = b.cno");
		 //$db = new Model();
		// $sql = "select * from teach_course";
		//$sql = "select a.tno,b.cname from teach_course as a,course as b where a.cno = b.cno";
		//$result = $db->query($sql);
		/*$a =M('teach_course')->table('teach_course as a')->join('course as b')->field('a.*,b.*')->select();
		p($a);die;*/

		/*$N = M("teach_course");
		$count = $N->join('hm_course on hm_teach_course.cno=hm_course.cno') ->select();
		p($count);die;
*/



		
		import('ORG.Util.Page');
	  	$count = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno') ->join('hm_class on hm_teach_course.bno=hm_class.bno')->where(array('tno'=>$_SESSION['tno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	//p($_SESSION);die;
	  	$this->data = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno') ->join('hm_class on hm_teach_course.bno=hm_class.bno')->where(array('tno'=>$_SESSION['tno']))->limit($limit)->select();
		$this->page = $page->show();
		//p($bno);die;


		$this->display();
	}



	public function assign_work(){
		$this->data = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno') ->join('hm_class on hm_teach_course.bno=hm_class.bno')->where(array('tno'=>$_SESSION['tno']))->select();
		//p($data);die;
		$this->display();
	}


	public function assign_work_action(){
		//p($_POST);die;
		$cou = M('course')->where(array('cname'=>I('choose_cname')))->find();
		//p($cou);die;
		$homework_theme = I('homework_theme');
		$homework_detail =I('homework_detail');
		$deadline = strtotime(I('deadline'));
		$publishtime = time();
		if($came == 1){
			$this->error('请填写要发布的作业的课程名');
		}
		if($homework_theme == NULL){
			$this->error('作业主题不能为空');
		}

		$fileInfo = $_FILES['homework_attach'];
		if($homework_detail == NULL && $fileInfo['name'] == NULL){
			$this->error('作业附件或者作业详情一项不能为空，请填写');
		}
		//p($_FILES);die;
		//p($fileInfo);die;
		$name = iconv('utf-8','gb2312',$fileInfo['name']);
		//p($name);die;
		if(!empty($fileInfo['name'])){
			if (file_exists("uploads/" . $fileInfo['name']))
	      	{
	     	 $this->error('该附件已存在，请重新上传或重命名！');
	      	}else{
	      		move_uploaded_file($fileInfo["tmp_name"],"uploads/" . $name);
	      // p($fileInfo["name"]);die;
            }
		}
		$data = array(
					'cno' =>$cou['cno'],
					'homework_theme' =>$homework_theme,
					'homework_detail' =>$homework_detail,
					'publishtime' =>$publishtime,
					'deadline' =>$deadline,
                    'tmp_name' => $fileInfo['tmp_name'],//临时名字
                    'tno' => $_SESSION['tno'],
                );
		$data1 = array(
			'tmp_name' => $fileInfo['tmp_name'],//临时名字
            'name' => $fileInfo['name'],//附件名
            'size' =>$fileInfo['size'],//附件大小
            'type' => $fileInfo['type'],
            'error' => $fileInfo['error'],
			);
			 //p($data);die;
        if(M('teawork')->add($data) && M('teattach')->add($data1))
        {
            $this->success('作业布置成功！');
        }
        else{
            $this->error('作业布置失败，请重试！');
        }
	}




	public function jq_up(){
		import('ORG.Util.Page');
	  	$count = M('sup')->join('hm_student on hm_sup.sno=hm_student.sno')->join('hm_course on hm_course.cno=hm_sup.cno')->join('hm_class on hm_student.bno=hm_class.bno')->where(array('tno'=>$_SESSION['tno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M('sup')->join('hm_student on hm_sup.sno=hm_student.sno')->join('hm_course on hm_course.cno=hm_sup.cno')->join('hm_class on hm_student.bno=hm_class.bno')->where(array('tno'=>$_SESSION['tno']))->order('uptime DESC')->limit($limit)->select();
		$this->page = $page->show();
		$this->display();
	}


	public function work_detail(){
		//p($_GET);
		//$id=$_GET[id]-9;
		
		$data = M('sup')->join('hm_student on hm_sup.sno=hm_student.sno')->join('hm_course on hm_course.cno=hm_sup.cno')->join('hm_class on hm_student.bno=hm_class.bno')->where(array('tno'=>$_SESSION['tno'],'id'=>$_GET['id']))->find();
		//$data1 =M('sup')->join('RIGHT JOIN hm_teach_course on hm_teach_course.cno=hm_sup.cno')->select();
		//p($data);die;
		if($data['tmp_name'] == NULL){
			$this->assign('attachment',"无");
		}
		if($data['tmp_name'] != NULL){
			$this->assign('attachment',"有");
		}
		if($data['other'] == NULL){
			$this->assign('other',"无");
		}else{
			$this->assign('other',$data['other']);
		}
		$this->assign('data',$data);

		$backurl = empty($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], 
           $_SERVER['HTTP_HOST']) ?  '#' : $_SERVER['HTTP_REFERER'];
		$this->assign('backurl', $backurl);


		$this->display();
	}

	public function download(){
 		$filename =M('sup')->where(array('id'=>$_GET['id']))->find();
 		if($filename['tmp_name'] == NULL){
 			$this->error('没有附件');
 		}
 		//p($filename);die;
 		header("Content-type:text/html;charset=utf-8");

		$file_name=iconv("utf-8","gb2312",$filename['name']);
		// $file_sub_path="uploads/" . $file_name;
		$file_path="stuUploads/" . $file_name;
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

	public function comment(){
		//p($_POST);die;
		$data=array(
			'score'=>I('grade'),
			'comment'=>I('comment'),
			);
		if(!is_numeric($data['score'])){
			$this->error('成绩不能为空,且要为数字');
		}
		if(M('sup')->where(array('id'=>$_POST['id']))->save($data)){
			$this->error('提交成功！');
		}else{
			$this->success('提交失败');
		}
	}

	//select_by_bno总体查询
	public function select_by_bno(){
		import('ORG.Util.Page');
	  	$count = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno') ->join('hm_class on hm_teach_course.bno=hm_class.bno')->where(array('tno'=>$_SESSION['tno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	//p($_SESSION);die;
	  	$this->data = M("teach_course")->join('hm_course on hm_teach_course.cno=hm_course.cno') ->join('hm_class on hm_teach_course.bno=hm_class.bno')->where(array('tno'=>$_SESSION['tno']))->limit($limit)->select();
		$this->page = $page->show();

		$this->display();
	}
	
	//作业列表
	public function selectwork_by_tno(){
		//p($_GET);die;
		import('ORG.Util.Page');
	  	$count = M("teawork")->join('hm_teach_course on hm_teach_course.cno=hm_teawork.cno')->join('hm_course on hm_course.cno=hm_teawork.cno')->field('hm_teawork.*,hm_teach_course.id bid,hm_teach_course.bno,hm_course.cname')->where(array('bno'=>$_GET['bno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data=M("teawork")->join('hm_teach_course on hm_teach_course.cno=hm_teawork.cno')->join('hm_course on hm_course.cno=hm_teawork.cno')->field('hm_teawork.*,hm_teach_course.id bid,hm_teach_course.bno,hm_course.cname')->where(array('bno'=>$_GET['bno']))->order('publishtime DESC')->limit($limit)->select();
	  	//p($data);die;

	  	$this->page = $page->show();

		$this->display();
	}

	//按照班级查找最后页面
	public function select_bno(){
		//p($_GET);die; 
		import('ORG.Util.Page');
	  	$count = M("teawork")->join('hm_teach_course on hm_teach_course.cno=hm_teawork.cno')->join('hm_course on hm_course.cno=hm_teawork.cno')->field('hm_teawork.*,hm_teach_course.id bid,hm_teach_course.bno,hm_course.cname')->where(array('bno'=>$_GET['bno']))->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	//如何分页
		$Dao =M();
		$data =$Dao->query("select hm_student.sno ssno,hm_student.bno,hm_student.sname,hm_sup.* from hm_student left outer join hm_sup on hm_student.sno=hm_sup.sno and (theme='".$_GET['theme']."' or theme= NULL) where bno='".$_GET['bno']."'");
		$bno=M('class')->where(array('bno'=>$_GET['bno']))->find();
		//p(sizeof($list));
		//p($data);die;
		/*$map['cno']='';
		$map['_logic']='or';*/
		/*$data=M('student')->join('hm_sup on hm_student.sno=hm_sup.sno')->where(array('theme'=>$_GET['theme']))->select();
		$data1=M('student')->join('hm_sup on hm_student.sno=hm_sup.sno')->field('hm_student.sno ssno,hm_student.sname,hm_student.bno,hm_sup.* ')->select();
		p($data1);die;*/
		//所有该班级人数
	  	$countall = M('student')->where(array('bno'=>$_GET['bno']))->count();
	  	$this->assign('people',$countall);
	  	//上交的人数
	  	$count_up =M('sup')->where(array('tno'=>$_GET['tno'],'cno'=>$_GET['cno'],'theme'=>$_GET['theme']))->count();
		$this->assign('up_people',$count_up);
		//p($count_up);die;
		$this->assign('bname',$bno['bname']);
		$this->assign('cname',$_GET['cname']);
		$this->assign('theme',$_GET['theme']);
		$this->assign('data',$data);
		$this->display();
	}

}	
	

?>
