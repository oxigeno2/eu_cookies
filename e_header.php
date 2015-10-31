<?php

if (!defined('e107_INIT')) { exit; }

$eucookiesprefs = e107::getPlugPref('eu_cookies');

e107::js('eu_cookies', 'js/jquery.divascookies-0.6.min.js','jquery');
e107::css('eu_cookies', 'css/divascookies_style_'.varset($eucookiesprefs["eu_cookie_theme"]).'_'.varset($eucookiesprefs["eu_cookie_position"]).'.css');


if(USER_AREA)
{

e107::js('footer-inline',"
$(document).ready(function() {
$.DivasCookies({
	bannerText				: '".varset($eucookiesprefs['eu_cookie_text'])."',		
	cookiePolicyLink		: 'http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm',		
	cookiePolicyLinkText	: '".varset($eucookiesprefs['eu_cookie_policylink'])."',				
	thirdPartyPolicyWidget	: '',						
	acceptButtonText		: '".varset($eucookiesprefs['eu_cookie_btn'])."',						
	acceptButtonSrc		: '',						
	openEffect				: '".varset($eucookiesprefs['eu_cookie_openeffect'])."',				
	openEffectDuration	: '".varset($eucookiesprefs['eu_cookie_openeffectduration'])."',						
	openEffectEasing		: '".varset($eucookiesprefs['eu_cookie_openeffecteasing'])."',					
	closeEffect				: '".varset($eucookiesprefs['eu_cookie_closeeffect'])."',				
	closeEffectDuration	: '".varset($eucookiesprefs['eu_cookie_closeeffectduration'])."',						
	closeEffectEasing		: '".varset($eucookiesprefs['eu_cookie_closeeffecteasing'])."',					
	debugMode				: false,					
	saveUserPreferences	: true,						
	cookieDuration			: 365,						
	blockScripts			: true,						
	pageReload				: true,				
	acceptOnScroll			: true,				
	acceptOnClick			: false,					
	excludePolicyPage		: false						
});
});
");

}
unset($eucookiesprefs);
?>