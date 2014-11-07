<?php

            /* Notify NYU Service Link that a new site is created with it's details */
            
            /*
            $to = 'NYU Service Link <askits@nyu.edu>';
            $subject = '['.$blog_details->blogname.'] New Site Created for Web Publishing service';
            $message = 'New site created by '.$admin_email.
                        ' Site Address: http://'.$current_blog->domain.$path.
                        ' Name: '.$title;
            $headers[] = 'From: '.$admin_first_name.' '.$admin_last_name.'<'.$admin_email.'>';
            $headers[] = 'cc: Neel Shah <shah.neel@nyu.edu>';
            wp_mail( $to, $subject, $message, $headers );
            */

            /* Notify the site admin that his site is now created and activated with all the features he selected */
            wpmu_welcome_notification( $new_blog_id, $admin_user_id, $password, $title );


?>