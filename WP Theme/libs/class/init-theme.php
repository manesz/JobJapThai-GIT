<?php
class inittheme{
	private $def_post = array(
		  'post_title'    => 'My post',
		  'post_content'  => 'This is my post.',
		  'post_status'   => 'publish',
		  'post_author'   => 1
	);
	public function firstInit($firstarrs){
		foreach($firstarrs as $firstarr){
			$this->createPage($firstarr);
		}
	}
	private function createPage($postarr){
		$my_post = array_merge($this->def_post,$postarr);
		// Insert the post into the database
		wp_insert_post($my_post);
		return false;
	}
}
