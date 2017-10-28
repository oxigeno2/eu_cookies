<?php

/**
 * EU cookies plugin for CMS e107 v2
 *
 * @author OxigenO2 (oxigen.rg@gmail.com)
 * @copyright Copyright (C) 2015 OxigenO2 
 * @license GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * @link http://oxigen.mablog.eu/
 */

require_once('../../class2.php');

if (!getperms('P')) 
{
	header('location:'.e_BASE.'index.php');
	exit;
}


//e107::lan('eu_cookies',false,'front'); 
e107::lan('eu_cookies',true,true);

class eu_cookies_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'eu_cookies_ui',
			'path' 			=> null,
			'ui' 			=> 'eu_cookies_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(
			
		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P'),	

		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'EU cookies';
}




				
class eu_cookies_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'EU cookies';
		protected $pluginName		= 'eu_cookies';
	//	protected $eventName		= 'eu_cookies-'; // remove comment to enable event triggers in admin. 		
		protected $table			= '';
		protected $pid				= '';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
	//	protected $batchCopy		= true;		
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
		protected $preftabs				= array(LAN_SETTINGS,LAN_PLUGIN_EUC_STYLE); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= ' DESC';
	
		protected $fields 		= NULL;		
		
		protected $fieldpref = array();
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'eu_cookie_text'		=> array('title'=> LAN_PLUGIN_EUC_TEXT, 'tab'=>0, 'type'=>'textarea', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_policylink'		=> array('title'=> LAN_PLUGIN_EUC_POLICYLINK, 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_btn'		=> array('title'=> LAN_PLUGIN_EUC_BTN, 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_position'		=> array('title'=> LAN_PLUGIN_EUC_POSITION, 'tab'=>0, 'type'=>'dropdown', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_theme'		=> array('title'=> LAN_PLUGIN_EUC_THEME, 'tab'=>1, 'type'=>'dropdown', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_openeffect'		=> array('title'=> LAN_PLUGIN_EUC_OPENEFFECT, 'tab'=>1, 'type'=>'dropdown', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_openeffectduration'		=> array('title'=> LAN_PLUGIN_EUC_OPENEFFECTDURATION, 'tab'=>1, 'type'=>'number', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_openeffecteasing'		=> array('title'=> LAN_PLUGIN_EUC_OPENEFFECTEASING, 'tab'=>1, 'type'=>'dropdown', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_closeeffect'		=> array('title'=> LAN_PLUGIN_EUC_CLOSEEFFECT, 'tab'=>1, 'type'=>'dropdown', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_closeeffectduration'		=> array('title'=> LAN_PLUGIN_EUC_CLOSEEFFECTDURATION, 'tab'=>1, 'type'=>'number', 'data' => 'str', 'help'=>'Help Text goes here'),
			'eu_cookie_closeeffecteasing'		=> array('title'=> LAN_PLUGIN_EUC_CLOSEEFFECTEASING, 'tab'=>1, 'type'=>'dropdown', 'data' => 'str', 'help'=>'Help Text goes here'),
			
		); 

		public function init()
		{
			// Set drop-down values (if any).

		$position = array(
			'top'	=> LAN_PLUGIN_EUC_TOP,
			'bottom'	=> LAN_PLUGIN_EUC_BOTTOM		
		);	
		
					
		$this->prefs['eu_cookie_position']['writeParms'] 		= $position;	
		$this->prefs['eu_cookie_position']['readParms'] 		= $position; 

		$theme = array(
			'dark'	=> LAN_PLUGIN_EUC_DARK,
			'light'	=> LAN_PLUGIN_EUC_LIGHT		
		);	
		
					
		$this->prefs['eu_cookie_theme']['writeParms'] 		= $theme;	
		$this->prefs['eu_cookie_theme']['readParms'] 		= $theme; 

		$openeffect = array(
			'fade'	=> LAN_PLUGIN_EUC_FADE,
			'slideUp'	=> LAN_PLUGIN_EUC_SLIDEDOWN,		
			'slideDown'		=> LAN_PLUGIN_EUC_SLIDEUP,
			'slideLeft'		=> LAN_PLUGIN_EUC_SLIDELEFT,
			'slideRight'		=> LAN_PLUGIN_EUC_SLIDERIGHT		
		);	
		
					
		$this->prefs['eu_cookie_openeffect']['writeParms'] 		= $openeffect;	
		$this->prefs['eu_cookie_openeffect']['readParms'] 		= $openeffect; 

		$openeffecteasing = array(
			'swing'	=> LAN_PLUGIN_EUC_SWING,
			'linear'	=> LAN_PLUGIN_EUC_LINEAR	
		);	
		
					
		$this->prefs['eu_cookie_openeffecteasing']['writeParms'] 		= $openeffecteasing;	
		$this->prefs['eu_cookie_openeffecteasing']['readParms'] 		= $openeffecteasing; 	

		$closeeffect = array(
			'fade'	=> LAN_PLUGIN_EUC_FADE,
			'slideUp'	=> LAN_PLUGIN_EUC_SLIDEDOWN,		
			'slideDown'		=> LAN_PLUGIN_EUC_SLIDEUP,
			'slideLeft'		=> LAN_PLUGIN_EUC_SLIDELEFT,
			'slideRight'		=> LAN_PLUGIN_EUC_SLIDERIGHT		
		);	
		
					
		$this->prefs['eu_cookie_closeeffect']['writeParms'] 		= $closeeffect;	
		$this->prefs['eu_cookie_closeeffect']['readParms'] 		= $closeeffect; 

		$closeeffecteasing = array(
			'swing'	=> LAN_PLUGIN_EUC_SWING,
			'linear'	=> LAN_PLUGIN_EUC_LINEAR	
		);	
		
					
		$this->prefs['eu_cookie_closeeffecteasing']['writeParms'] 		= $closeeffecteasing;	
		$this->prefs['eu_cookie_closeeffecteasing']['readParms'] 		= $closeeffecteasing; 	




		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
			
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			return $text;
			
		}
	*/
			
}
				


class eu_cookies_form_ui extends e_admin_form_ui
{

}		
		
		
new eu_cookies_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>
