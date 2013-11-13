<?php
class UserModel extends CommonModel{
	function GetList(){
		return $this->select();
	}
}
