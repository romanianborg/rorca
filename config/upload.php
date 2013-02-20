<?php
require_once("db.php");
// Copyright AI Software Ltd Bucharest, Romania 2001-2009
if(!function_exists("moveUploadedFileTo"))
{
function moveUploadedFileTo($filename,$imagename)
{
	if(is_uploaded_file($filename))
	{
		if (!move_uploaded_file($filename,$imagename))
		{
			//report error
			return getLT('nocopy');
		}
		return "";
	}
	return getLT('nofile');
}

function resizeCreatedImage(&$src_img,$outWidth,$outHeight)
{
	$srcWidth=imagesx($src_img);
	$srcHeight=imagesy($src_img);
	
	if(!$outHeight || $outHeight=='') $outHeight=$outWidth;
	$imgOut=imagecreatetruecolor($outWidth,$outHeight);
	//imagerectangle($imgOut,0,0,$outWidth,$outHeight,imagecolorallocate($imgOut,255,255,255));
	
	$xoffset = 0;
	$yoffset = 0;
	if ($srcWidth*$outHeight > $srcHeight*$outWidth)
	{
		$xtmp = $srcWidth;
		$xratio = 1-((($srcWidth/$srcHeight)-($outWidth/$outHeight))/2);
		$srcWidth = $srcWidth * $xratio;
		$xoffset = ($xtmp - $srcWidth)/2;
	}
	elseif ($srcHeight/ $outHeight > $srcWidth / $outWidth)
	{
		$ytmp = $srcHeight;
		$yratio = 1-((($outWidth/$outHeight)-($srcWidth/$srcHeight))/2);
		$srcHeight = $srcHeight * $yratio;
		$yoffset = ($ytmp - $srcHeight)/2;
	}

	imagecopyresampled($imgOut, $src_img, 0, 0, $xoffset, $yoffset, $outWidth, $outHeight, $srcWidth, $srcHeight);
	  
	return $imgOut;
}

function createthumbnailjpg($image_path,$thumb_path,$thumb_width,$thumb_height=0)
{
    $src_img = imagecreatefromjpeg($image_path);
	 $dst_img = resizeCreatedImage($src_img,$thumb_width,$thumb_height);
    imagejpeg($dst_img, $thumb_path);
    return true;
}
function createthumbnailpng($image_path,$thumb_path,$thumb_width,$thumb_height=0)
{
    $src_img = imagecreatefrompng($image_path);
	 $dst_img = resizeCreatedImage($src_img,$thumb_width,$thumb_height);
    imagepng($dst_img, $thumb_path);
    return true;
}
function createthumbnailgif($image_path,$thumb_path,$thumb_width,$thumb_height=0)
{
    $src_img = imagecreatefromgif($image_path);
	 $dst_img = resizeCreatedImage($src_img,$thumb_width,$thumb_height);
    imagepng($dst_img, $thumb_path);
    return true;
}

function setUniqueValue($value,$user,$userid=0)
{
	$conn=create_db_connection();
	$key=md5($value.":unique-value:".$user);

	$sem=0;
	if(function_exists("sem_get"))
	{
		$sem=sem_get(ftok(realpath("config/upload.php"),'R'));
		sem_acquire($sem);
	}

	$conn->openselect("select * from ".getUserConfig("dbprefix")."uniquevalues where md5='".$key."' and user='".$conn->escape($user)."' and userid=0".intval($userid));
	if($conn->eof())
	{
		$conn->execute("insert into ".getUserConfig("dbprefix")."uniquevalues(md5,util,user,userid) values('".$conn->escape($key)."','".$conn->escape($value)."','".$conn->escape($user)."',0".intval($userid).")");
	}
	else
	{
		resetUniqueValue($key,$value,$user,$userid);
	}

	if($sem)
	{
		sem_release($sem);
		sem_remove($sem);
	}
	$conn->close();

	return $key;
}
function getUniqueValue($md5,$user,$userid=0)
{
	$value="";
	$connf=create_db_connection();
	$connf->openselect("select * from ".getUserConfig("dbprefix")."uniquevalues where md5='".$connf->escape($md5)."' and user='".$connf->escape($user)."' and userid=0".intval($userid));
	if(!$connf->eof())
	{
		$value=$connf->getvalue("util");
	}
	$connf->close();

	return $value;
}
function resetUniqueValue($md5,$value,$user,$userid=0)
{
	$connf=create_db_connection();
	$connf->execute("update ".getUserConfig("dbprefix")."uniquevalues set util='".$connf->escape($value)."' where md5='".$connf->escape($md5)."' and user='".$connf->escape($user)."' and userid=0".intval($userid));

	return $value;
}
}
?>
