<?php

    echo '<h3>Options Page</h3>';

    echo '<p>This page will be having all the available options to configure for the Site Setup Wizard Plugin</p>';

    echo '
            <p>Steps to Update Config Options:</p>
            <ol>
                <li>Go to the <span class="strong">Network Admin -> Plugins -> Editor</span>.</li>
                <li>Select <span class="strong">Site Setup Wizard</span> from <span class="strong">\"Select plugin to edit\"</span> screen and click <span class="strong">\"Select\"</span>.</li>
                <li>Click on <span class="strong">nsd-site-setup-wizard/admin/ssw_update_options.php</span></li>
                <li>Change the values of options you intend to modify.</li>
                <li>Click <span class="strong">Update File</span>.</li>
                <li>Go to <span class="strong">Create Site -> Options</span>.</li>
                <li>Click <span class="strong">Update Plugin Settings.</span></li>
            </ol>

    ';

    echo '<input name="ssw_update_options_btn" class="ssw-update-options-btn" type="button" value="Update Plugin Settings" onclick="ssw_js_update_config_options()" tabindex="1" />';

    echo '<p>Following is the Demo of different Sanitize functions of wordpress for reference<br/>';

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
    

/*    $is_privacy_selection = $options['privacy_selection'];
    echo '<br/>$is_privacy_selection = '.(int)$is_privacy_selection.'<br/>';

*/

?>