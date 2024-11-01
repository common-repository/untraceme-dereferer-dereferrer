<?php
/*
Plugin Name: Untrace Derferreing Service
Plugin URI: http://wordpress.org/plugins/untraceme-dereferer-dereferrer/
Description: Create anonymous links for your articles, pages or posts.
Version: 1.4.0
Author: Kai van Rijswijk
Author URI: http://www.untrace.me
*/

define('DEFAULT_API_URL', 'http://untrace.me/api/v1/service/plugin/url/%s.json');
define('PLUGIN_VERSION', '1.4.0');

/** ****************************************************************************************************************************** */
/** UNTRACEME CLASS BEGIN                                                                                                          */
/** ****************************************************************************************************************************** */
class UntraceMe
{
    /**
     * List of Untrace API URLs
     */
    function api_urls()
    {
        return array(
            array(
                'name' => 'untrace.me',
                'url'  => 'http://untrace.me/api/v1/service/plugin/url/%s.json',
                ),
            );
    }
    
    
    /**
     * List of link options
     */
    function showLinks()
    {
        return array(
            array(
                'name' => 'Short & Encoded Url',
                'value'  => 'all',
                ),
            array(
                'name' => 'Short Url',
                'value'  => 'short',
                ),
            array(
                'name' => 'Encoded Url',
                'value'  => 'encode',
                ),
            array(
                'name' => 'Raw Url [Not recomended]',
                'value'  => 'raw',
                ),
            );
    }
    
    /**
     * List of types
     */
    function showTypes()
    {
        return array(
            array(
                'name' => 'HTML Link',
                'value'  => 'link',
                ),
            array(
                'name' => 'HTML Input Field',
                'value'  => 'input',
                ),
            );
    }

    /**
     * Create Untrace URL based on post URL
     */
    function create($post_id)
    {
       
        $apiURL = DEFAULT_API_URL;
      
        $post = get_post($post_id);
        $pos = strpos($post->post_name, 'autosave');
        if ($pos !== false) {
            return false;
        }
        $pos = strpos($post->post_name, 'revision');
        if ($pos !== false) {
            return false;
        }
        
        /** All urls must be base64 encoded before passing to the api */
        $apiURL = str_replace('%s', base64_encode(get_permalink($post_id)), $apiURL);

        $result = false;

        if (ini_get('allow_url_fopen')) {
            if ($handle = @fopen($apiURL, 'r')) {
                $result = fread($handle, 4096);
                fclose($handle);
            }
        } elseif (function_exists('curl_init')) {
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $result = @curl_exec($ch);
            curl_close($ch);
        }

        if ($result !== false) {
            
            /** Decode json url and strip down till url */
            $decoded_api_request = json_decode($result, true);
            
            delete_post_meta($post_id, 'UntraceUrl');
            delete_post_meta($post_id, 'UntraceUrlEncode');
            delete_post_meta($post_id, 'UntraceUrlUntrace');
            
            
            $res = add_post_meta($post_id, 'UntraceUrl', $decoded_api_request["data"]["short_url"], true);
            $res = add_post_meta($post_id, 'UntraceUrlEncode', $decoded_api_request["data"]["encoded_url"], true);
            $res = add_post_meta($post_id, 'UntraceUrlUntrace', $decoded_api_request["data"]["untrace_url"], true);
            
            
            return true;
        }
    }

    /**
     * Option list (default settings)
     */
    function options()
    {
        return array(
           'ApiUrl'         => DEFAULT_API_URL,
           'Display'        => 'Y',
           'showLinks'      => 'all',
           'showTypes'      => 'input',
           'hideRef'        => 'N'
           );
    }

    /**
     * Plugin settings
     *
     */
    function settings()
    {
        $apiUrls = $this->api_urls();
        $showLinks = $this->showLinks();
        $showTypes = $this->showTypes();
        
        
        $current_version = PLUGIN_VERSION;
        $options = $this->options();
        
        $opt = array();

        if (!empty($_POST)) {
            foreach ($options AS $key => $val)
            {
                if (!isset($_POST[$key])) {
                    continue;
                }
                
                update_option('UntraceUrl' . $key, $_POST[$key]);
            }
        }
        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('UntraceUrl' . $key);
        }
        
        include '../wp-content/plugins/untraceme-dereferer-dereferrer/template/settings.tpl.php';
    }

    /**
     *
     */
    function admin_menu()
    {
        add_options_page('UntraceMe Settings', 'UntraceMe Settings', 10, 'untraceme-settings', array(&$this, 'settings'));
    }
    
    /** GET OPTIONS */
    function getOptions(){
        
        $options = $this->options();

        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('UntraceUrl' . $key);
        }
        
        return $opt;
    }
    
    /**
     * Display the short URL
     */
    function display($content)
    {

        global $post;

        if ($post->ID <= 0) {
            return $content;
        }

        $options = $this->options();

        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('UntraceUrl' . $key);
        }

        $shortUrl = get_post_meta($post->ID, 'UntraceUrl', true);

        if (empty($shortUrl)) {
            return $content;
        }

        $shortUrlEncoded = urlencode($shortUrl);
        
        
        ob_start();
        include './wp-content/plugins/untraceme-dereferer-dereferrer/template/public.tpl.php';
        $content .= ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
/** ****************************************************************************************************************************** */
/** UNTRACEME CLASS END                                                                                                            */
/** ****************************************************************************************************************************** */


/** ****************************************************************************************************************************** */
/** UNTRACEME HIDE REF CLASS BEGIN                                                                                                 */
/** ****************************************************************************************************************************** */
final class anonymize_links {
	
	
	public function anonymize_links_init(){
		wp_register_script('anonymize_links-anonymize_links', WP_PLUGIN_URL . '/untraceme-dereferer-dereferrer/js/anonymize.js');
	}
	
	public function anonymize_links_activate(){
		$opt_name = 'anonymize_links_service';
		$opt_val = get_option( $opt_name );		
		add_option("anonymize_links_service", '', '', 'yes');
	}
	
	public function anonymize_links_deactivate(){
		delete_option("anonymize_links_service");
	}
	
	public function anonymize_links_menu(){
		add_options_page('Anonymize Links Options', 'UntraceMe Referers', 'administrator', 'anonymize_links-options', array($this,'anonymize_links_options_page'));
	}	
	
	public function anonymize_links_options_page(){
		if($_POST['protected_links']){
			echo '<div class="updated"><p><strong> '. __('Options saved.'). '</strong></p></div>';	
			update_option("anonymize_links_service", $_POST['protected_links']);
		} elseif(isset($_POST['protected_links'])){
		   echo '<div class="updated"><p><strong> '. __('Options cleared.'). '</strong></p></div>';	
		   update_option("anonymize_links_service", '');
		}
			
		echo '<div class="wrap">';
        echo '<div id="icon-options-general" class="icon32"></div>';
		echo '<h2>'. __('UntraceMe hide all referers') .'</h2>';
		?>			
		

	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-2">
		
			<!-- main content -->
			<div id="post-body-content">
				
				<div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>Plugin settings</span></h3>
						<div class="inside">
                		<form method="POST" action="">
                		
                		<table class="form-table">
                			<tr><td><p>Do not use UntraceMe for the following domains / keywords:</p></td></tr>
                			<tr valign="top">				
                				<td>
                					<input type="text" class="anonym_input" id="protected_links" name="protected_links" size="100" value="<?php echo get_option('anonymize_links_service')?>">		
                					<br/><span class="description">Comma separated: domain1.tld, domain2.tld, keyword</span>		
                				</td>
                			</tr>
                		</table>
                		<p class="submit">
                			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
                		</p>
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
                    
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- post-body-content -->
			
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				
                <div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>Plugin Support</span></h3>
						<div class="inside">
							If you need any support for this plugin, then please do not hesitate and contact us via the button below.<br /><br />
                            
                            <!--Place this code where you want VIP widget to be rendered -->
                            <div class="casengo-vipbtn"><!-- subdomain="phpapps" group="8472" position="inline" label="Plugin Support" theme="blue"   --></div>
                            
                            <!--Place this code after the last Casengo VIP widget -->
                            <script type="text/javascript">
                            	(function() {
                            		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                            		po.src = '//phpapps.casengo.com/apis/vip-widget.js?r=5f04ec30e60fb14a1235fc2c2a2c1867e1e723ff';
                            		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                            	})();
                            </script>
                            
                            <br />
                            <em>Support is provided by PHPApps</em>
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
                
                <div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>About this plugin</span></h3>
						<div class="inside">
                            Webmasters can use this tool to prevent their site from appearing in the backlink statistics of another webpage and server logs of referred pages as referrer. The operators of the referred pages cannot see where their visitors come from any more. Untrace.me provides a slick, quality derefering service for free. No ads, interstitials or popups. We promise.
                            
                            <br /><br />
							More info about this plugin can be found at our website, <a href="http://www.untrace.me" target="_blank">www.untrace.me</a>.
                            <br /><br />
                            &copy; Copyright 2012 - <? echo date("Y");?> Untrace.me
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
                
                
			
			     <div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>How does Untrace.me works?</span></h3>
						<div class="inside">
							When using Untrace.me you don't link directly to the external target web page but to Untrace.me which redirects your users to the desired page then. So the target page doesn't get to know that the user actually came from your site.
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- #postbox-container-1 .postbox-container -->
			
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">
	</div> <!-- #poststuff -->
        
        
        
        
		<?php
		echo '</div>';
	}
	
	public function anonymize_links_scripts(){		
		wp_enqueue_script('anonymize_links-anonymize_links');		
	}
	
	public function add_anonymize_links_js(){
		$opt_val = get_option('anonymize_links_service');	
		echo '<script type="text/javascript"><!--
		protected_links = "'.$opt_val.'";

		auto_anonyminize();
		//--></script>';
	}
}
/** ****************************************************************************************************************************** */
/** UNTRACEME HIDE REF CLASS END                                                                                                   */
/** ****************************************************************************************************************************** */

/** ****************************************************************************************************************************** */
/** START CLASSES                                                                                                                  */
/** ****************************************************************************************************************************** */
$gssu                   = new UntraceMe;
$__anonymize_links      = new anonymize_links();



/** ****************************************************************************************************************************** */
/** SETTINGS ONLY WHEN ADMIN BEGIN                                                                                                 */
/** ****************************************************************************************************************************** */
if (is_admin()) {
    
    // UNTRACE SHORT SETTINGS
    add_action('edit_post', array(&$gssu, 'create'));
    add_action('save_post', array(&$gssu, 'create'));
    add_action('publish_post', array(&$gssu, 'create'));
    add_action('admin_menu', array(&$gssu, 'admin_menu'));
    add_action( 'add_meta_boxes', 'UntraceMe_info_box' );
    
    function UntraceMe_info_box() {
        
        add_meta_box(  'myplugin_sectionid', __( 'Untrace.me details', 'untrace_textdomain' ), '_untrace_content', 'post'  );
        add_meta_box(  'myplugin_sectionid', __( 'Untrace.me details', 'untrace_textdomain' ), '_untrace_content', 'page'  );
        
    }
    
    /* Prints the box content */
    function _untrace_content( $post ) {
    
      // Use nonce for verification
      wp_nonce_field( plugin_basename( __FILE__ ), 'untraceme-dereferer-dereferrer' );
    
      // The actual fields for data entry
  
      _e("<strong>Short url:</strong><br /><input style='width:98%;' onClick='this.select();' value='". get_post_meta($post->ID, 'UntraceUrl', true) ."'><br /><br />");
      _e("<strong>Encoded url:</strong><br /><input style='width:98%;' onClick='this.select();' value='". get_post_meta($post->ID, 'UntraceUrlEncode', true) ."'><br /><br />");
      _e("<strong>Raw url:</strong><br /><input style='width:98%;' onClick='this.select();' value='". get_post_meta($post->ID, 'UntraceUrlUntrace', true) ."'><br /><br />");
    }

} else {
    
    add_filter('the_content', array(&$gssu, 'display'));
}

/** ****************************************************************************************************************************** */
/** SETTINGS ONLY WHEN ADMIN END                                                                                                   */
/** ****************************************************************************************************************************** */


/** ****************************************************************************************************************************** */
/** HIDE REFERERES IF ENABLED IN SETTINGS PAGE                                                                                     */
/** ****************************************************************************************************************************** */
$options_hide = $gssu->getOptions();
    
foreach ($options_hide AS $key => $val)
{
    $opt_hide[$key] = get_option('UntraceUrl' . $key);
}

function add_settings_link($links, $file) {
    
    static $this_plugin;
    if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
     
    if ($file == $this_plugin){
        $settings_link = '<a href="options-general.php?page=anonymize_links-options">'.__("Settings", "anonymize_links-options").'</a>';
        array_unshift($links, $settings_link);
    }
    
    return $links;
}

if($opt_hide['hideRef'] =='Y'){
    

    
    add_action('wp_footer', array($__anonymize_links,'add_anonymize_links_js'));

    add_action('wp_enqueue_scripts', array($__anonymize_links, 'anonymize_links_scripts'));
    add_action('init', array($__anonymize_links, 'anonymize_links_init'));
    
    $plugin_dir = basename(dirname(__FILE__));
    
    register_activation_hook(__FILE__, array($__anonymize_links,'anonymize_links_activate'));
    register_deactivation_hook(__FILE__, array($__anonymize_links,'anonymize_links_deactivate'));
    
    

}

add_action('admin_menu', array($__anonymize_links,'anonymize_links_menu'));
add_filter('plugin_action_links', 'add_settings_link', 10, 2 );
/** ****************************************************************************************************************************** */
/** HIDE REFERERES IF ENABLED IN SETTINGS PAGE END                                                                                 */
/** ****************************************************************************************************************************** */