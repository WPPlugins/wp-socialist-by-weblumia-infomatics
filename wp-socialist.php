<?php
/**
	Plugin Name: WP Socialist
	Plugin URI: http://weblumia.com/wp-socialist/
	Description: A jQuery Social Plugin to create a single social media stream from multiple social networks.Socialist is a jquery social plugin that creates a social stream (or social "wall") from multiple social media feeds in one place. Use it to pull content from Facebook pages, Twitter, LinkedIn, YouTube and other social networks... 
	Version: 2.2.1
	Author: Jinesh.P.V
	Author URI: http://weblumia.com/wp-socialist/
	License: GPLv2 or later
 */
/**
	Copyright 2013 Jinesh.P.V (email: jinuvijay5@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */


add_action( 'admin_menu', 'wp_socialist_add_menu' );
add_action( 'admin_init', 'wp_socialist_reg_function' );
add_action( 'admin_init', 'wp_socialist_admin_stylesheet' );
add_action( 'wp_head', 'wp_socialist_stylesheet', 20 );
add_action( 'wp_enqueue_scripts', 'wp_socialist_scripts' );
add_action( 'wp_footer', 'wp_socialist_action_scripts', 20 );
add_shortcode( 'wp_socialist_media_stream', 'wp_socialist_media_stream' );

register_activation_hook( __FILE__, 'wp_socialist_activate' );

function wp_socialist_add_menu() {
	add_menu_page( 'WP Socialist', 'WP Socialist', 'administrator', 'wp_socialist_settings', 'wp_socialist_menu_function' );
	add_submenu_page( 'wp_socialist_settings', 'WP Socialist Settings', 'Settings', 'manage_options', 'wp_socialist_settings', 'wp_socialist_add_menu' ); 
}

function wp_socialist_reg_function() {
	$settings			=	get_option( "wp_socialist_settings" );
	if ( empty( $settings ) ) {
		$settings = array(
							'wp_socialist_twitter_id'	 	=>      '',
							'wp_socialist_rss_id'	 		=>      '',
							'wp_socialist_stumbleupon_id'	=>      '',
							'wp_socialist_facebook_id'		=>      '',
							'wp_socialist_fblike_id'		=>		'',
							'wp_socialist_google_id'	 	=>      '',
							'wp_socialist_delicious_id'	 	=>      '',
							'wp_socialist_digg_id'			=>		'',
							'wp_socialist_vimeo_id'			=>		'',
							'wp_socialist_youtube_id'	 	=>      '',
							'wp_socialist_linkedin_id'	 	=>      '',
							'wp_socialist_pinterest_id'	 	=>      '',
							'wp_socialist_flickr_id'	 	=>      '',
							'wp_socialist_lastfm_id'	 	=>      '',
							'wp_socialist_dribbble_id'  	=>      '',
							'wp_socialist_deviantart_id'  	=>      '',
							'wp_socialist_tumblr_id'		=>		'',
							'wp_socialist_location'			=>		'',
							'wp_socialist_offset'			=>		'',
							'wp_socialist_speed'			=>		'',
							'wp_socialist_load_open'		=>		'',
							'wp_socialist_auto_close'		=>		'',
							'wp_socialist_width'			=>		'',
							'wp_socialist_height'			=>		'',
							'wp_socialist_controls'			=>		'',
							'wp_socialist_direction'		=>		'',
							'wp_socialist_delay'			=>		''
						);
		add_option( "wp_socialist_settings", $settings, '', 'yes' );
	}
}

if( $_REQUEST['action'] === 'save' && $_REQUEST['updated'] === 'true' ){
	$settings					=	$_POST;
	$settings					=	is_array( $settings ) ? $settings : unserialize( $settings );
	$updated					=	update_option( "wp_socialist_settings", $settings );
}

function wp_socialist_activate() {
	
}

function wp_socialist_admin_stylesheet() {
	
	$adminstylesheetURL 		= 	plugins_url( 'css/admin.css', __FILE__ );
	$adminstylesheet 			= 	dirname( __FILE__ )  . '/css/admin.css';
	
	if ( file_exists( $adminstylesheet ) ) {
		
		wp_register_style( 'wp-socialist--admin-stylesheets', $adminstylesheetURL );
		wp_enqueue_style( 'wp-socialist--admin-stylesheets' );
	}
}

function wp_socialist_stylesheet() {
	
	if( !is_admin() ){
		$stylesheetURL 			= 	plugins_url( 'css/social.css', __FILE__ );
		$stylesheet 			= 	dirname( __FILE__ )  . '/css/social.css';
		
		if ( file_exists( $stylesheet ) ) {
			
			wp_register_style( 'wp-socialist-stylesheets', $stylesheetURL );
			wp_enqueue_style( 'wp-socialist-stylesheets' );
		}
	}
	
}

function wp_socialist_scripts() {
	
	if( !is_admin() ){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'plugins', WP_PLUGIN_URL . '/wp-socialist/js/plugins.js', array( 'jquery' ), '1.4.2' );
		wp_enqueue_script( 'social.media.tabs', WP_PLUGIN_URL . '/wp-socialist/js/social.media.tabs.js', array( 'jquery' ), '1.5' );
	}
}

function wp_socialist_action_scripts(){
	
	$settings							=	get_option( "wp_socialist_settings" );
	if( $settings['wp_socialist_twitter_id'] ){
		$wp_socialist					=	"twitterId: '" . $settings['wp_socialist_twitter_id'] . "',\n";
		$widgets						=	'twitter,';
	}
	if( $settings['wp_socialist_rss_id'] ){
		$wp_socialist					.=	"rssId: '" . $settings['wp_socialist_rss_id'] . "',\n";
		$widgets						.=	'rss,';
	}
	if( $settings['wp_socialist_stumbleupon_id'] ){
		$wp_socialist					.=	"stumbleuponId: '" . $settings['wp_socialist_stumbleupon_id'] . "',\n";
		$widgets						.=	'stumbleupon,';
	}
	if( $settings['wp_socialist_facebook_id'] ){
		$wp_socialist					.=	"facebookId: '" . $settings['wp_socialist_facebook_id'] . "',\n";
		$widgets						.=	'facebook,';
	}
	if( $settings['wp_socialist_fblike_id'] ){
		$wp_socialist					.=	"fblikeId: '" . $settings['wp_socialist_fblike_id'] . "',\n";
		$widgets						.=	'fblike,';
	}
	if( $settings['wp_socialist_google_id'] ){
		$wp_socialist					.=	"googleId: '" . $settings['wp_socialist_google_id'] . "',";
		$widgets						.=	'google,';
	}
	if( $settings['wp_socialist_delicious_id'] ){
		$wp_socialist					.=	"deliciousId: '" . $settings['wp_socialist_delicious_id'] . "',\n";
		$widgets						.=	'delicious,';
	}
	if( $settings['wp_socialist_vimeo_id'] ){
		$wp_socialist					.=	"vimeoId: '" . $settings['wp_socialist_vimeo_id'] . "',\n";
		$widgets						.=	'vimeo,';
	}
	if( $settings['wp_socialist_youtube_id'] ){
		$wp_socialist					.=	"youtubeId: '" . $settings['wp_socialist_youtube_id'] . "',\n";
		$widgets						.=	'youtube,';
	}
	if( $settings['wp_socialist_pinterest_id'] ){
		$wp_socialist					.=	"pinterestId: '" . $settings['wp_socialist_pinterest_id'] . "',\n";
		$widgets						.=	'pinterest,';
	}
	if( $settings['wp_socialist_flickr_id'] ){
		$wp_socialist					.=	"flickrId: '" . $settings['wp_socialist_flickr_id'] . "',\n";
		$widgets						.=	'flickr,';
	}
	if( $settings['wp_socialist_lastfm_id'] ){
		$wp_socialist					.=	"lastfmId: '" . $settings['wp_socialist_lastfm_id'] . "',\n";
		$widgets						.=	'lastfm,';
	}
	if( $settings['wp_socialist_dribbble_id'] ){
		$wp_socialist					.=	"dribbbleId: '" . $settings['wp_socialist_dribbble_id'] . "',\n";
		$widgets						.=	'dribbble,';
	}
	if( $settings['wp_socialist_deviantart_id'] ){
		$wp_socialist					.=	"deviantartId: '" . $settings['wp_socialist_deviantart_id'] . "',\n";
		$widgets						.=	'deviantart,';
	}
	if( $settings['wp_socialist_tumblr_id'] ){
		$wp_socialist					.=	"tumblrId: '" . $settings['wp_socialist_tumblr_id'] . "',\n";
		$widgets						.=	'tumblr,';
	}
	if( $settings['wp_socialist_digg_id'] ){
		$wp_socialist					.=	"diggId: '" . $settings['wp_socialist_digg_id'] . "',\n";
		$widgets						.=	'digg,';
	}
	if( $settings['wp_socialist_linkedin_id'] ){
		$wp_socialist					.=	"linkedinId: '" . $settings['wp_socialist_linkedin_id'] . "',\n";
		$widgets						.=	'linkedin,';
	}
	
	$widgets							=	rtrim( $widgets, ',' );
	
	$wp_socialist_location				=	( $settings['wp_socialist_location'] )			?	$settings['wp_socialist_location'] : 'left';
	$wp_socialist_offset				=	( $settings['wp_socialist_offset'] )			?	$settings['wp_socialist_offset'] : '20';
	$wp_socialist_speed					=	( $settings['wp_socialist_speed'] )				?	$settings['wp_socialist_speed'] : '600';
	$wp_socialist_load_open				=	( $settings['wp_socialist_load_open'] )			?	$settings['wp_socialist_load_open'] : 'false';
	$wp_socialist_auto_close			=	( $settings['wp_socialist_auto_close'] )		?	$settings['wp_socialist_auto_close'] : 'false';
	$wp_socialist_width					=	( $settings['wp_socialist_width'] )				?	$settings['wp_socialist_width'] : '360';
	$wp_socialist_height				=	( $settings['wp_socialist_height'] )			?	$settings['wp_socialist_height'] : '500';
	$wp_socialist_controls				=	( $settings['wp_socialist_controls'] )			?	$settings['wp_socialist_controls'] : 'true';
	$wp_socialist_direction				=	( $settings['wp_socialist_direction'] )			?	$settings['wp_socialist_direction'] : 'down';
	$wp_socialist_delay					=	( $settings['wp_socialist_delay'] )				?	$settings['wp_socialist_delay'] : '6000';
	
	$scripts							=	
	"<script type='text/javascript'>
		jQuery( document ).ready( function(){
			jQuery( '#social-stream' ).socialTabs({
				widgets: '" . $widgets. "',
				" . $wp_socialist . "
				method: 'slide',
				position: 'fixed',
				location: '" . $wp_socialist_location . "',
				align: 'top',
				offset: " . $wp_socialist_offset . ",
				speed: " . $wp_socialist_speed . ",
				loadOpen: " . $wp_socialist_load_open . ",
				autoClose: " . $wp_socialist_auto_close . ",
				width: " . $wp_socialist_width . ",
				height: " . $wp_socialist_height . ",
				start: 0,
				controls: " . $wp_socialist_controls . ",
				rotate: {
					direction: '" . $wp_socialist_direction . "',
					delay: " . $wp_socialist_delay . "
				}
			});
		});
	</script>";
	
	echo $scripts;
}


function wp_socialist_media_stream(){
	
	$html			=	'<input type="hidden" value="' . WP_PLUGIN_URL . '/wp-socialist/" id="pluginURL" /><div id="social-stream"></div>';
	
	echo $html;
}
function wp_socialist_menu_function() {
?>

<div class="wrap">
    <h2><?php _e( 'WP Socialist Settings', 'wp-socialist' ) ?></h2>
    <?php if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Theme Settings updated.</p></div>';?>
    <?php $settings			=	get_option( "wp_socialist_settings" );?>
    <form method="post" action="?page=wp_socialist_settings&action=save&updated=true">
        <div class="wl-pages" >
            <div class="wl-page wl-settings active">
                <div class="wl-box wl-settings">
                    <h3 class="header"><?php _e( 'General Settings', 'wp-socialist' ) ?></h3>
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php _e( 'Location', 'wp-socialist' ) ?></td>
                                    <td>
                                        <select name="wp_socialist_location" id="wp_socialist_location">
                                            <option value="top" <?php if( $settings["wp_socialist_location"] == 'top' ) echo 'selected = "selected"'; ?>>Top</option>
                                            <option value="right" <?php if( $settings["wp_socialist_location"] == 'right' ) echo 'selected = "selected"'; ?> >Right</option>
                                            <option value="bottom" <?php if( $settings["wp_socialist_location"] == 'bottom' ) echo 'selected = "selected"'; ?>>Bottom</option>
                                            <option value="left" <?php if( $settings["wp_socialist_location"] == 'left' ) echo 'selected = "selected"'; ?> >Left</option>
                                        </select>
                                     </td>
                                     <td class="desc"><?php _e( 'Widget position for appearing.', 'wp-socialist' ) ?></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Offset', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_offset" id="wp_socialist_offset" size="10" value="<?php echo ( !empty( $settings["wp_socialist_offset"] ) ) ? esc_html( $settings["wp_socialist_offset"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"><?php _e( 'Widget offset for appearing.', 'wp-socialist' ) ?></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Speed', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_speed" id="wp_socialist_speed" size="10" value="<?php echo ( !empty( $settings["wp_socialist_speed"] ) ) ? esc_html( $settings["wp_socialist_speed"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"><?php _e( 'Widget mooving speed.', 'wp-socialist' ) ?></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Load Open', 'wp-socialist' ) ?></td>
                                    <td>
                                        <select name="wp_socialist_load_open" id="wp_socialist_load_open">
                                            <option value="true" <?php if( $settings["wp_socialist_load_open"] == 'true' ) echo 'selected = "selected"'; ?>>True</option>
                                            <option value="false" <?php if( $settings["wp_socialist_load_open"] == 'false' ) echo 'selected = "selected"'; ?> >False</option>
                                        </select>
                                     </td>
                                     <td class="desc"><?php _e( 'If true, winget is opened at the time of loading.', 'wp-socialist' ) ?></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Auto Close', 'wp-socialist' ) ?></td>
                                    <td>
                                        <select name="wp_socialist_auto_close" id="wp_socialist_auto_close">
                                            <option value="true" <?php if( $settings["wp_socialist_auto_close"] == 'true' ) echo 'selected = "selected"'; ?>>True</option>
                                            <option value="false" <?php if( $settings["wp_socialist_auto_close"] == 'false' ) echo 'selected = "selected"'; ?> >False</option>
                                        </select>
                                     </td>
                                     <td class="desc"><?php _e( 'If true, widget is closed automatically.', 'wp-socialist' ) ?></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Controls', 'wp-socialist' ) ?></td>
                                    <td>
                                        <select name="wp_socialist_controls" id="wp_socialist_controls">
                                            <option value="true" <?php if( $settings["wp_socialist_controls"] == 'true' ) echo 'selected = "selected"'; ?>>True</option>
                                            <option value="false" <?php if( $settings["wp_socialist_controls"] == 'false' ) echo 'selected = "selected"'; ?> >False</option>
                                        </select>
                                     </td>
                                     <td class="desc"><?php _e( 'If true, widget controls enabled.', 'wp-socialist' ) ?></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Rotate', 'wp-socialist' ) ?></td>
                                    <td colspan="2">  
                                        Direction : <input type="text" name="wp_socialist_direction" id="wp_socialist_direction" size="10" value="<?php echo ( !empty( $settings["wp_socialist_direction"] ) ) ? esc_html( $settings["wp_socialist_direction"] ) : ''; ?>" class="input" />&nbsp;&nbsp;&nbsp;
                                        Delay : <input type="text" name="wp_socialist_delay" id="wp_socialist_delay" size="10" value="<?php echo ( !empty( $settings["wp_socialist_delay"] ) ) ? esc_html( $settings["wp_socialist_delay"] ) : ''; ?>" class="input" />
                                     </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3 class="header"><?php _e( 'Global Settings', 'wp-socialist' ) ?></h3>
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php _e( 'Twitter Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_twitter_id" id="wp_socialist_twitter_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_twitter_id"] ) ) ? esc_html( $settings["wp_socialist_twitter_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'RSS Feed', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_rss_id" id="wp_socialist_rss_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_rss_id"] ) ) ? esc_html( $settings["wp_socialist_rss_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'StumbleUpon Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_stumbleupon_id" id="wp_socialist_stumbleupon_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_stumbleupon_id"] ) ) ? esc_html( $settings["wp_socialist_stumbleupon_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Facebook Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_facebook_id" id="wp_socialist_facebook_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_facebook_id"] ) ) ? esc_html( $settings["wp_socialist_facebook_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Facebook Like Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_fblike_id" id="wp_socialist_fblike_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_fblike_id"] ) ) ? esc_html( $settings["wp_socialist_fblike_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Google Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_google_id" id="wp_socialist_google_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_google_id"] ) ) ? esc_html( $settings["wp_socialist_google_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Delicious Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_delicious_id" id="wp_socialist_delicious_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_delicious_id"] ) ) ? esc_html( $settings["wp_socialist_delicious_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Vimeo Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_vimeo_id" id="wp_socialist_vimeo_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_vimeo_id"] ) ) ? esc_html( $settings["wp_socialist_vimeo_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Digg Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_digg_id" id="wp_socialist_digg_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_digg_id"] ) ) ? esc_html( $settings["wp_socialist_digg_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Youtube Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_youtube_id" id="wp_socialist_youtube_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_youtube_id"] ) ) ? esc_html( $settings["wp_socialist_youtube_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Pinterest Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_pinterest_id" id="wp_socialist_pinterest_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_pinterest_id"] ) ) ? esc_html( $settings["wp_socialist_pinterest_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Flickr Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_flickr_id" id="wp_socialist_flickr_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_flickr_id"] ) ) ? esc_html( $settings["wp_socialist_flickr_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Lastfm Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_lastfm_id" id="wp_socialist_lastfm_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_lastfm_id"] ) ) ? esc_html( $settings["wp_socialist_lastfm_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Dribbble Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_dribbble_id" id="wp_socialist_dribbble_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_dribbble_id"] ) ) ? esc_html( $settings["wp_socialist_dribbble_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Deviantart Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_deviantart_id" id="wp_socialist_deviantart_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_deviantart_id"] ) ) ? esc_html( $settings["wp_socialist_deviantart_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                                <tr>
                                    <td><?php _e( 'Tumblr Username', 'wp-socialist' ) ?></td>
                                    <td>
                                        <input type="text" name="wp_socialist_tumblr_id" id="wp_socialist_tumblr_id" size="10" value="<?php echo ( !empty( $settings["wp_socialist_tumblr_id"] ) ) ? esc_html( $settings["wp_socialist_tumblr_id"] ) : ''; ?>" class="input" />
                                     </td>
                                     <td class="desc"></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        <div class="wl-box wl-publish">
            <h3 class="header"><?php _e('Publish', 'wp-socialist') ?></h3>
            <div class="inner">
                <input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'wp-socialist' ); ?>" />
                <p class="wl-saving-warning"></p>
                <div class="clear"></div>
            </div>
        </div>
    </form>
</div>

<?php } ?>