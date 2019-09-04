<?php
	// File to house a function to escape a string without a database connection.

	function escapeStr($unescaped) {
	  $replacements = array(
	     "\x00"=>'\x00',
	     "\n"=>'\n',
	     "\r"=>'\r',
	     "\\"=>'\\\\',
	     "'"=>"\'",
	     '"'=>'\"',
	     "\x1a"=>'\x1a'
	  );
	  return strtr($unescaped,$replacements);
	}
?>