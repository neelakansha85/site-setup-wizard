<?php

echo '
	<div class="ssw-xtra-block">
    	<a href="#" onclick="ssw_js_submit_form_cancel()" style="color:red;" value="Cancel" />Cancel</a>
';
    	if(!isset($skip)) {
			echo '&nbsp;|&nbsp;<a href="#" onclick="ssw_js_submit_form_skip()">Skip</a>';
		}
echo '    	
	</div>
';

?>