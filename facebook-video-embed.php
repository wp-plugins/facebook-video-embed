<?php
/*
 * Plugin Name: Facebook Video Embed
 * Description: Embed Facebook Video's with this shortcode: Usage  [fbvideo link="LINK-of-Facebook-video" width="XX" height="XX" onlyvideo="1"] by <a href="http://www.IrfanAnsari.com">http://www.IrfanAnsari.com</a> 
 * Author: Irfan Ansari 
 * Author URI: http://www.IrfanAnsari.com/
 * Plugin URI: http://irfanansarioffice.github.io/Facebook-Video-Embed-WP-Plugin
 * Version: 1.0.2
 */

class IA_WPFacebookVideo {
   	public function __construct()
    {
    	// Set Plugin Path
    	add_shortcode('fbvideo', array($this, 'shortcode'));
    	add_action('admin_head', array($this, 'add_fb_video_button'));
		add_action( 'admin_enqueue_scripts',array($this, 'add_button_css'));  
    }

    function add_fb_video_button()
    {
		// check user permissions
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
			return;
		}
		// check if WYSIWYG is enabled
		if ( 'true' == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array($this,'add_editor_button'));
			add_filter( 'mce_buttons', array($this,'register_editor_button'));
		}
	}

	// Declare script for fb-video button
	function add_editor_button( $plugin_array ) 
	{
		$plugin_array['IA_fbv_button'] = plugins_url( 'js/editor.js', __FILE__ );
		return $plugin_array;
	}

	// Register fb-video button in the editor
	function register_editor_button( $buttons ) 
	{
		array_push( $buttons, 'IA_fbv_button' );
		return $buttons;
	}

	//  fb-video button Icon in editor
	function add_button_css() 
	{
		wp_enqueue_style('IA-editor-button', plugins_url('css/style.css', __FILE__) );
	}

    public function shortcode($atts)
    {
	    // extract the attributes into variables
	    extract(shortcode_atts(array(
	        'link' => '',
	        'width' => 500,
	        'height' => 500,
	        'onlyvideo' => 1,
	   	), $atts));
    		$videoID = parse_url($link);
			parse_str($videoID['query']);
			if (!$v)
			{
				$str = explode("/", $link);
				$v = $str[count($str)-2];
			}
			return $this->getContent($v, (int) $width, (int) $height, (int) $onlyvideo);
    }

    public function getContent($videoID, $width, $height, $onlyvideo = 1)
    {
    	if ($onlyvideo == 1)
   	    	return'<div id="fb-root"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";  fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script><div class="fb-video" data-allowfullscreen="true" data-href="//www.facebook.com/video.php?v='.$videoID.'" data-width="'.$width.'"></div>';
		return '<div id="fb-root"></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'));</script><div class="fb-post" data-href="//www.facebook.com/video.php?v='.$videoID.'" data-width="'.$width.'"></div>';
    }
}
 
new IA_WPFacebookVideo();