<?php

echo '<p class="sww-breadcrumb-text">';
echo '<span ';
if(isset($step1)) {
	echo 'class="sww-breadcrumb-selected"';
}
echo '>'.$steps_name['step1'].'</span> -> <span ';
if(isset($step2)) {
	echo 'class="sww-breadcrumb-selected"';
}
echo '>'.$steps_name['step2'].'</span> -> <span ';
if(isset($step3)) {
	echo 'class="sww-breadcrumb-selected"';
}
echo '>'.$steps_name['step3'].'</span> -> <span ';
if(isset($step4)) {
	echo 'class="sww-breadcrumb-selected"';
}
echo '>'.$steps_name['step4'].'</span> -> <span ';
if(isset($finish)) {
	echo 'class="sww-breadcrumb-selected"';
}
echo '>'.$steps_name['finish'].'</span></p>';

?>