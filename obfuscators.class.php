<?php 

class Obfuscators {
	
	/*
	 * Random Generators
	 */
	
	public static function rand_tag_name() {
		$tag_name = array ('p', 'div', 'b','u','i');
		$count_tag_name = count($tag_name);
		
		return $tag_name[rand(0, $count_tag_name-1)];
	}
	
	public static function get_random_string_array($len, $c) {
		$srt_array = array();
		for ($a = 0; $a <= $c; $a++) {
			$result = "";
			$nums = "1234567890";
			$syms = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
			$sux = $nums.$syms;
			for ($i = 0; $i < $len; $i++) {
		    	$num = rand(0, strlen($sux)-1);
		     	$result .= $sux[ $num ];
		    }
		    $srt_array[] = $syms[rand(0,strlen($syms)-1)].$result;
		 }
		 
		 return $srt_array;
	}
	
	/*
	 * Encryptions
	 */
	
	public static function gen_key($len) {
		$result = "";
		$symb = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		for ($i = 0; $i < $len; $i++) {
			$num = rand(0, strlen($symb)-1);
			if (ereg($symb[ $num ],$result)) {
				$i=$i-1;
			} else {
		     	$result .= $symb[ $num ];
			}
		}
		
		 return $result;
	}

	public static function mkcrypt($code,$rnd_split) {
		$i = strlen($code);
		for ($a=0;$a<$i;$a++) {
			$csnc = ord($code[$a]);
			$csnc--;
			$res .= $csnc.$rnd_split;
		}
		
		return $res;
	}
	
	public static function crypt_with_key($orig,$key) {
		for($l=0;$l<strlen($orig);$l++)	{
			$symb=$orig[$l];
			$pos_in_key=strpos($key,$symb);
			if($pos_in_key >= -1) {
				if($pos_in_key==(strlen($key)-1)) {
					$pos_in_key =-1;
				}
				$crypt .= $key[$pos_in_key+1];
			} else {
				$crypt.=$symb;
			}
		}
		
		return $crypt;
	}
	
	public static function unescape($s) {
		$out = "";
		$res = strtoupper(bin2hex($s));
		$g = round(strlen($res)/4);
		if ($g != (strlen($res)/4)) $res.="00";
		for ($i=0; $i<strlen($res);$i+=4) {
			$out.="%u".substr($res,$i+2,2).substr($res,$i,2);
		}
		
		return $out;
	}
	
	public static function encrypt($original) {
	    $symb = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	    $rnd_split = $symb[rand(0, strlen($symb) - 1)];
	    $original = Obfuscators::mkcrypt($original, $rnd_split);
	
	    $key = Obfuscators::gen_key(rand(40, 60));
	    $crypt = Obfuscators::crypt_with_key($original, $key);
	
	    $ii = 0;
	    while (strlen($crypt) > 0) {
	        $pos = rand(50, 590);
	        $var_array[$ii] = substr($crypt, 0, $pos);
	        $crypt = substr($crypt, $pos);
	        $ii++;
	    }
	
	    for ($ii = 0; $ii < count($var_array); $ii++) {
	        $rnd_div_name = Obfuscators::get_random_string_array(rand(2, 10), count($var_array));
	        $tag_name = Obfuscators::rand_tag_name();
	        if (rand(0, 3) == 0) $rn = " \r\n";
	        else $rn = "";
	        //$TESTECH.= $var_array[$ii];
	        $div_echo .= "<$tag_name id ='$rnd_div_name[$ii]'>".$var_array[$ii]."</".$tag_name.">".$rn;
	        if ($ii == (count($var_array) - 1)) {
	            $js_array .= '"'.$rnd_div_name[$ii].'"';
	        }
	        else {
	            $js_array .= '"'.$rnd_div_name[$ii].'",';
	        }
	    }
	    $div_echo = "<div style='display: none;'>".$div_echo."</div>";
	    $js_array = "new Array(".$js_array.");";
	
	    $rnd_nm_crypt = Obfuscators::get_random_string_array(rand(3, 10), 19);
	    $script_body = '';
		$script_body .= "<script>";
		$script_body .= "var $rnd_nm_crypt[10] = '';";
		$script_body .= "var $rnd_nm_crypt[8] = $js_array";
		$script_body .= "var $rnd_nm_crypt[12] = '';";
		$script_body .= "function $rnd_nm_crypt[7]($rnd_nm_crypt[8],$rnd_nm_crypt[9]) {";
		$script_body .= "return $rnd_nm_crypt[9] = document.getElementById($rnd_nm_crypt[8][$rnd_nm_crypt[9]]).innerHTML;}";
		$script_body .= "function $rnd_nm_crypt[13] ($rnd_nm_crypt[14]) {";   
		$script_body .= "return String.fromCharCode($rnd_nm_crypt[14]);}";
		$script_body .= "function decryptor($rnd_nm_crypt[15]) {";
		$script_body .= "$rnd_nm_crypt[16] = $rnd_nm_crypt[15].split('$rnd_split');";
		$script_body .= "for (var i=0;i<$rnd_nm_crypt[16].length-1;i++) {";
		$script_body .= "$rnd_nm_crypt[16][i]++;";
		$script_body .= "$rnd_nm_crypt[12] += $rnd_nm_crypt[13]($rnd_nm_crypt[16][i]);} return($rnd_nm_crypt[12]);}";
		$script_body .= "function $rnd_nm_crypt[17]($rnd_nm_crypt[5]) {";
		$script_body .= "var $rnd_nm_crypt[1],$rnd_nm_crypt[2],$rnd_nm_crypt[3],$rnd_nm_crypt[4] = '',";
		$script_body .= "$rnd_nm_crypt[6] ='$key';";
		$script_body .= "for($rnd_nm_crypt[1] = 0;$rnd_nm_crypt[1]<$rnd_nm_crypt[5].length;$rnd_nm_crypt[1]++){";
		$script_body .= "$rnd_nm_crypt[2] = $rnd_nm_crypt[5].charAt($rnd_nm_crypt[1]);";
		$script_body .= "$rnd_nm_crypt[3] = $rnd_nm_crypt[6].indexOf($rnd_nm_crypt[2]);";
		$script_body .= "if($rnd_nm_crypt[3]>=0) {";
		$script_body .= "if($rnd_nm_crypt[3] == 0){ $rnd_nm_crypt[3] = " . (strlen($key) - 1) . ";}";
		$script_body .= "else { $rnd_nm_crypt[3] = $rnd_nm_crypt[3] -1;} $rnd_nm_crypt[4] += $rnd_nm_crypt[6].charAt($rnd_nm_crypt[3]);}"; 
		$script_body .= "else { $rnd_nm_crypt[4] += $rnd_nm_crypt[2]; }};";
		        
		$script_body .= "xvx = decryptor($rnd_nm_crypt[4]); return xvx;}";
		$script_body .= "var $rnd_nm_crypt[11] = $rnd_nm_crypt[8].length;";
		$script_body .= "for ($rnd_nm_crypt[9] = 0; $rnd_nm_crypt[11] > $rnd_nm_crypt[9]; $rnd_nm_crypt[9]++) {var $rnd_nm_crypt[10] = $rnd_nm_crypt[10] + $rnd_nm_crypt[7]($rnd_nm_crypt[8],$rnd_nm_crypt[9]);}";
		$script_body .= "var $rnd_nm_crypt[9] = $rnd_nm_crypt[17]($rnd_nm_crypt[10]);";
		$script_body .= "var gogle=document; var yandex=document;";
		$script_body .= "gogle.write('<scri'+'pt>');";
		$script_body .= "yandex.write($rnd_nm_crypt[9]);";
		$script_body .= "document.write('</sc'+'ript>');";
		$script_body .= "</script>";
		
	    $script_body = str_replace("\r\n", ' ', $script_body);
	    $out = $div_echo.$script_body;
	
	    return $out;
	}
}

?>