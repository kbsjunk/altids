<?php namespace Kitbs\Altids;

use Hashids\Hashids as HashidsBase;

class Hashids extends HashidsBase {

	public function __construct($config = array()) {
		
		parent::__construct(@$config['salt'], @$config['length'], @$config['alphabet']);

	}
	
}