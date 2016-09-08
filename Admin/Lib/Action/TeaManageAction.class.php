<?php
class TeaManageAction extends CommonAction{

	public function insert(){
		$this->display();
	}

	public function teaInsert(){

		$data = array(
			'tno' => I('tno'),
			'tname' => I('tname'),
			'password' => I('password','','md5'),

			);
		$info = M('teacher') -> where(array('tno' => $data[tno])) -> find();
		//p($data);
		//p($data[tno]);die;
		if($info == $data){
			$this->error('该教师信息已存在');
		}else if(M('teacher') -> add($data)){
			$this -> success('录入成功');
		}else{
			$this -> error('录入失败');
		}
	}


	public function teaInfo(){
		import('ORG.Util.Page');
	  	$count = M('teacher')->count();
	  	$page = new Page($count, 8);
	  	$limit = $page->firstRow . ',' . $page->listRows;
	  	$this->data = M('teacher')->limit($limit)->select();
	  	//p($data);die;
	  	$this->page = $page->show();
		$this->display();
	}

	
	public function update_teaInfo(){
		$this->assign('info',$_GET);
		//p($_GET);die;
		$this->display();
	}



	public function update_teaInfo_action(){
		$data=array(
			'tno' =>$_POST['newtno'],
			'tname'=>$_POST['newtname'],
			);
		
		//p($data);die;
		if($data['tno']== NULL || $data['tname'] ==NULL ){
			$this->error('请填写完整信息');
		}
		if(M('teacher')->save($data)){
			$this->success('修改成功','teaInfo');
		}
	}


	public function pl_upload(){
		$this->display();
	}



	public function pl_upload_action(){
		//p($_POST);
		//p($_FILES);die;
		//引入ThinkPHP上传文件类
        import('ORG.Net.UploadFile');
        //实例化上传类
        $upload = new UploadFile();
        //设置附件上传文件大小200Kib
        $upload->mixSize = 2000000;
        //设置附件上传类型
        $upload->allowExts = array('xls', 'xlsx', 'csv');
        //设置附件上传目录在/Home/temp下
        $upload->savePath = './Uploads/temp/';
        //保持上传文件名不变
        $upload->saveRule = '';
        //存在同名文件是否是覆盖
        $upload->uploadReplace = true;
        if (!$upload->upload()) {   //如果上传失败,提示错误信息
            $this->error($upload->getErrorMsg());
        } else {    //上传成功
            //获取上传文件信息
            $info = $upload->getUploadFileInfo();
            //获取上传保存文件名
            $fileName = $info[0]['savename'];
            //重定向,把$fileName文件名传给importExcel()方法
            $this->redirect('TeaManage/importExcel', array('fileName' => $fileName), 1, '上传成功！');
        }


	}




	/**
     *
     * 导入Excel文件
     */
    public function importExcel() {
        header("content-type:text/html;charset=utf-8");
        //引入PHPExcel类
        //vendor('PHPExcel');
        //vendor('PHPExcel.IOFactory');
        //vendor('PHPExcel.Reader.Excel5');
 		Vendor("PHPExcel.PHPExcel");  
        //redirect传来的文件名
        $fileName = $_GET['fileName'];
 
        //文件路径
        $filePath = './Uploads/temp/' . $fileName;
        //实例化PHPExcel类
        $PHPExcel = new PHPExcel();
        //默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
        $PHPReader = new PHPExcel_Reader_Excel2007();
        if (!$PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if (!$PHPReader->canRead($filePath)) {
                echo 'no Excel';
                return;
            }
        }
 
        //读取Excel文件
        $PHPExcel = $PHPReader->load($filePath);
        //读取excel文件中的第一个工作表
        $sheet = $PHPExcel->getSheet(0);
        //取得最大的列号
        $allColumn = $sheet->getHighestColumn();
        //取得最大的行号
        $allRow = $sheet->getHighestRow();
        //从第二行开始插入,第一行是列名
        $num = 0;
        for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
            //获取A列的值
            $tno = $PHPExcel->getActiveSheet()->getCell("A" . $currentRow)->getValue();
            //获取B列的值
            $tname = $PHPExcel->getActiveSheet()->getCell("B" . $currentRow)->getValue();
            //获取C列的值
            $password = $PHPExcel->getActiveSheet()->getCell("C" . $currentRow)->getValue();
 			
 			$data=array(
 				'tno' => $tno, 
 				'tname' => $tname, 
 				'password' => md5($password),
 				);
            $m = M('teacher');
            if($m->add($data)){
                $num ++;
            }
        }
        if ($num > 0) {
            $this->success('添加成功！');
        } else {
            $this->error('添加失败！');
        }
    }

}




?>