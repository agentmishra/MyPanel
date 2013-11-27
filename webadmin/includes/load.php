<?php
class Loader {
	function __construct($which) {
		$this->which = $which;
	}
	public function load() {
		if($this->which=='frontend') {
			if(!defined("pgr")) {
				exit('Error');
			}
			$files = array('configuration.php', 'session.php');
			foreach($files as $file) {
				require_once('includes/'.$file);
			}
		} elseif($this->which=='webadmin') {

		} else {
			exit('Failed to find a loader to use - loader was not specified or invalid.');
		}
	}
}
?>