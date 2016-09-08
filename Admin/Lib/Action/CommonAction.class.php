<?php

Class CommonAction extends Action{
 	public function _initialize() {
   
  	if(!isset($_SESSION['id']) ){	
			$this->error('非法访问')->U('Admin/Login/index');
		}
	}
}

?>