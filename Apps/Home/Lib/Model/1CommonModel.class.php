<?php
class CommonModel extends Model {
	var $prefix;
	function _initialize() {
      $this->prefix = C('DB_PREFIX');
 	}
}	