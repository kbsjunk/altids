<?php namespace Kitbs\Altids;

use Hashids\Hashids as HashidsBase;
use Kitbs\Altids\Traits\AltidTrait;

class Hashids extends HashidsBase {

	use AltidTrait;

	public function __construct($config = array()) {
		
		parent::__construct(@$config['salt'], @$config['length'], @$config['alphabet']);

	}
	
}