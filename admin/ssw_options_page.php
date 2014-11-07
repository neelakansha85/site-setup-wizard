<?php

	echo "<h3>Options Page</h3>";

	echo "<p>This page will be having all the available options to configure for the Site Setup Wizard Plugin</p>";

	echo "<p>Following is the Demo of different Sanitize functions of wordpress for reference<br/>";

	$sanitization_string = 'Hello_World - Test 91 %user <br/>\' " $ \\ & % ; neelshah@email.com! ';
	echo '<br /><br />Original String: '.$sanitization_string.'<br /><br />';
		$semail = sanitize_email($sanitization_string);
        $skey = sanitize_key($sanitization_string);
        $stextfield = sanitize_text_field($sanitization_string);
        $stitle = sanitize_title($sanitization_string);
        $stitle_query = sanitize_title_for_query($sanitization_string);

    echo 'Sanitized Values for: <br />';
    	echo '<br/>$semail = '.$semail.'<br/>';
        echo '<br/>$skey = '.$skey.'<br/>';
        echo '<br/>$stextfield = '.$stextfield.'<br/>';
        echo '<br/>$stitle = '.$stitle.'<br/>';
        echo '<br/>$stitle_query = '.$stitle_query.'<br/>';
    




?>