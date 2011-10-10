<?php

class RSS {
	
	private $contents;
	
	function RSS($url,$amount) {
		$this->parse($url,$amount);
	}
	
	function get_contents() {
		return $this->contents;
	}
	
	function parse($url,$amount) {
		$contents = array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($url);
		$x=$xmlDoc->getElementsByTagName('item');
		for ($i=0; $i<=$amount; $i++) {
		  $item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
		  $item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
		  $item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
		  $contents[$i] = array("title"=>$item_title,"link"=>$item_link,"description"=>$item_desc);
		}
		
		$this->contents = $contents;
	}
}
?>