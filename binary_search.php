<?php
function binary_search($file_name, $key, $handle = null, $left = 0, $right = null, $old_res = null){
	if(!$handle){
		$handle = fopen($file_name, 'r');
		$filesize = filesize($file_name);
		$mid_byte = floor($filesize / 2);
		$right = $filesize;
	}else{
		$mid_byte = floor(($right + $left) / 2);
	}

	fseek($handle, $mid_byte);

	while( fgetc($handle) != "\n" && $mid_byte > 0){
		fseek($handle, --$mid_byte);
	}

	if( $mid_byte == 0){
		fseek($handle, 0);
	}

	$buffer = fgets($handle, 4000);

	$str = explode("\t", $buffer);

	if($old_res == $str[0]){
		return "undef\n";
	}

	if($str[0] == $key){
		return $str[1];
	}elseif($key < $str[0]){
		return binary_search($file_name, $key, $handle, $left, $mid_byte, $str[0]);
	}elseif($key > $str[0]){
		return binary_search($file_name, $key, $handle, $mid_byte, $right, $str[0]);
	}
}