<div class="wrap">
   <h1>AnimateGL</h1>
   <h2>Default animation</h2>
   <p>Add AGL animations to any image by adding CSS class <code>agl</code>. Edit default Entrance and Mouse animations with Editor.</p>
   <div class="image-section">
	   <img class="agl" src="<?php echo esc_url( $this->plugin_dir_url . 'img/ian-dooley-TevqnfbI0Zc-unsplash.jpg' ); ?>">
	   <img class="agl" src="<?php echo esc_url( $this->plugin_dir_url . 'img/unkknown-traveller-m02YmeDhPjw-unsplash.jpg' ); ?>">
	</div>
</div>
<?php

wp_enqueue_script( "agl-admin"); 
wp_enqueue_script( "agl-editor"); 

$agl_nonce = wp_create_nonce( "agl_nonce");
wp_localize_script( 'agl-admin', 'agl_localize_script', array($agl_nonce, esc_js(get_option("agl_json"))) );