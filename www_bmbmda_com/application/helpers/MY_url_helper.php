<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('site_url'))
{
	 function site_url($uri = '',$domain = '')
	 {
	  if(function_exists('rewrite')){
		$uri=rewrite($uri);
	  }
	  $CI =& get_instance();
	  return $CI->config->site_url($uri);
	 }
}

if (!function_exists('rewrite'))
{
	 function rewrite($url){
	  $CI=&get_instance();
	  $CI->load->config('rewrite',TRUE);
	  $rewrite=$CI->config->item('rewrite');

	  ksort($rewrite['pattern']);
	  ksort($rewrite['replace']);

	  $url=preg_replace($rewrite['pattern'],$rewrite['replace'],$url,1);
	  return $url;
	 }
}
if (!function_exists('no_ssl'))
{
	function no_ssl($uri = ''){
	  $CI =& get_instance();
	  $CI->load->config("site",TRUE);
	  $site = $CI->config->item("site");
	  $thisurl = $CI->config->site_url();
	  $uri = str_replace($thisurl,"http://www.motortong.com/",$uri);
	  return $uri;
	}
}

if (!function_exists('mobile_url'))
{
	function mobile_url($uri = ''){
	  $CI =& get_instance();
	  $CI->load->config("site",TRUE);
	  $site = $CI->config->item("site");
	  $thisurl = $CI->config->site_url();
	  $uri = str_replace($thisurl,"http://m.motortong.com/",$uri);
	  return $uri;
	}
}

if (!function_exists('company_url'))
{
	function company_url($uri = '',$replace){
	  $CI =& get_instance();
	  $CI->load->config("site",TRUE);
	  $site = $CI->config->item("site");
	  $thisurl = $CI->config->site_url();
	  $uri = str_replace($thisurl,"http://".$replace.".motortong.com/",$uri);
	  return $uri;
	}
}

if (!function_exists('main_url'))
{
	function main_url($uri = ''){
	  $CI =& get_instance();
	  $CI->load->config("site",TRUE);
	  $site = $CI->config->item("site");
	  $thisurl = $CI->config->site_url();
	  $uri = str_replace($thisurl,$site['main_domain'],$uri);
	  return $uri;
	}
}