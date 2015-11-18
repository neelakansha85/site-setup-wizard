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

?>