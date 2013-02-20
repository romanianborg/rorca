<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2011
if(!function_exists("getCurrentLang"))
{
function getCurrentLang()
{
	$lang=session_getvalue("current_language");

	Global $_CONFIG;
	if($lang=='')
		if(isset($_CONFIG['language']))
			$lang=$_CONFIG['language'];

	if($lang=='')
		$lang='en';

	if(!file_exists('config/language_'.$lang.'.php'))
	{
		if(isset($_CONFIG['language']))
			$lang=$_CONFIG['language'];
		if($lang=='')
			$lang='en';
	}

	return $lang;
}

function getLT($key,$lang='',$namespace='')
{
	$lang=getCurrentLang();

	require_once('config/language_'.$lang.'.php');

	if(file_exists('extensions/language_'.$lang.'.php'))
	{
		require_once('extensions/language_'.$lang.'.php');
	}

	global $_LANG_;

	if($namespace!="" && isset($_LANG_[$namespace.'_'.$key])) return $_LANG_[$namespace.'_'.$key];
	if(isset($_LANG_[$key])) return $_LANG_[$key];

	return $key;
}

function getLTforjs($key,$lang='')
{
	return strtok(strip_tags(getLT($key,$lang)),"\"'");
}

function getLangTranslation($key,$lang='')
{
	return getLT($key,$lang);
}
}

?>
