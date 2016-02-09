<?php
/**
 *    Controlador subpage trips
 *
 * @package   
 * @author     Dani Martí 
 * @copyright 
 * @license   General Public Licence http://opensource-socialnetwork.com/licence
 * @link      http://www.opensource-socialnetwork.com/licence
 */
/* Define Paths */
define('__OSSN_TRIPS__', ossn_route()->com . 'OptionTrips/');
//include classes
require_once(__OSSN_TRIPS__ . 'classes/OptionTrips.php');

function option_trips_init() {
	
	//Hooks
	ossn_add_hook('profile', 'modules', 'profile_modules_trips'); //Funció pq aparegui el modul inferior "profile_modules_trips($hook, $type, $module, $params)"
	ossn_add_hook('profile', 'subpage', 'profile_trips_page');

	//Actions
	ossn_register_action('get', __OSSN_TRIPS__ . 'actions/map/get.php'); //Registre acció recuperar viatges
	
	
	//Callbacks
	ossn_register_callback('page', 'load:profile', 'profile_menu_trips'); //Afageix en el menú de navegació superior la opció viatges
	
	if (ossn_isLoggedin()) {
        //ossn_register_action('verified/user', __OSSN_TRIPS__ . 'actions/user/verified.php');
		//ossn_register_action('unverify/user', __OSSN_TRIPS__ . 'actions/user/unverify.php');
    }
    //CSS i JS
	    //Afegir capçalera styles i scripts
		ossn_extend_view('css/ossn.default', 'css/trips-style'); 
		//Registre JS
		//ossn_new_external_js('google', 'http://maps.google.com/maps/api/js?sensor=false',false);
	 	ossn_new_js('mapa.viatgers', 'js/mapa.viatgers');	
	 	//Carrega JS extern
	 	ossn_load_external_js('maps.google');
	 	ossn_load_js('mapa.viatgers');
 	
	
	
	ossn_profile_subpage('trips');
	
	$url = ossn_site_url();
		if(ossn_isLoggedin()) { //Si ha iniciat sessió
				$user_loggedin = ossn_loggedin_user(); //URL actual de l'usuari
				$icon          = ossn_site_url('components/OptionTrips/images/live_logo.png');
				
				//Afegir enllaç menú sidebar(left)
				ossn_register_sections_menu('newsfeed', array(
						'text' => ossn_print('trips:ossn'),
						'url' => $user_loggedin->profileURL('/trips'),
						'section' => 'links',
						'icon' => $icon
				));
				
		}

}

/**
 * Afageix el mòdul inferior el perfil de l'usuari
 *
 * @return html;
 * @access private;
 */

function profile_modules_trips($hook, $type, $module, $params) {
		$user['user'] = $params['user'];
		$content      = ossn_plugin_view("photos/modules/profile/trips", $user);//
		$title        = ossn_print('trips:ossn');
		
		$module[] = ossn_view_widget(array(
				'title' => $title,
				'contents' => $content
		));
		return $module;
}

/**
 * Afageix el menú superior l'enllaç viatges.
 *
 * @return void;
 * @access private;
 */
function profile_menu_trips($event, $type, $params) {
		$user_loggedin = ossn_user_by_guid(ossn_get_page_owner_guid());
		$url   = ossn_site_url();
		ossn_register_menu_link('trips', 'trips', $user_loggedin->profileURL('/trips'), 'user_timeline');			
}

/**
 * Register user trips page (profile subpage)
 *
 * @return mix data
 * @access private;
 */
function profile_trips_page($hook, $type, $return, $params) {
		$page = $params['subpage'];
		if($page == 'trips') {
				$user['user'] = $params['user'];
				$control      = false;
				//show add album if loggedin user is owner
				if(ossn_loggedin_user()->guid == $user['user']->guid) {
						/*
						$addalbum = array(
								'text' => ossn_print('add:album'),
								'href' => 'javascript:void(0);',
								'id' => 'ossn-add-album',
								'class' => 'button-grey'
						);
						*/
						$control  = ossn_plugin_view('output/url', $addalbum);
				}
				$map = ossn_plugin_view('trips/pages/map', $user);
				echo ossn_set_page_layout('module', array(
						'title' => ossn_print('trips:ossn'),
						'content' => $map,
						'controls' => $control
				));
		}
}


//Inicialitza el component
ossn_register_callback('ossn', 'init', 'option_trips_init');
