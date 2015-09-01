<?php

echo '<p class="sww-breadcrumb-text">';
	echo '<span ';
	if(isset($step1)) {
		echo 'class="sww-breadcrumb-selected"';
	}
	echo '>Start</span> -> <span ';
	if(isset($step2)) {
		echo 'class="sww-breadcrumb-selected"';
	}
	echo '>Essential Settings</span> -> <span ';
/*	if(isset($step3)) {
		echo 'class="sww-breadcrumb-selected"';
	}
	echo '>Themes</span> -> <span ';
*/
	if(isset($step4)) {
		echo 'class="sww-breadcrumb-selected"';
	}
	echo '>Features</span> -> <span ';
	if(isset($finish)) {
		echo 'class="sww-breadcrumb-selected"';
	}
	echo '>Done!</span></p>';

?>