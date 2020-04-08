<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('UTC'); 

$LoginDialog      = true;
$login_user       = '';
$login_pass       = 'admin';
$charset          = 'utf-8';
$show_file_or_dir = true ; // can show directory
$perpage          = (isset($_GET['perpage'])) ? (int)$_GET['perpage'] : 10;
$table_fixed      = (isset($_GET['perpage'])) ? 'table-fixed' : '';
$alert_msg        = (isset($_GET['alert'])) ? $_GET['alert'] : '';


@session_start();
if(isset($_GET['logout'])) { session_destroy() ; exit(header('Location: '.$_SERVER['PHP_SELF'])); }

 if(isset($_POST['username']) && isset($_POST['password']) )
 {
	if($_POST['username'] == $login_user && $_POST['password'] == $login_pass) 
	{
		
		$_SESSION['login']['user'] = $login_user ;
		$_SESSION['login']['pass'] = $login_pass ;
		$_SESSION['login']['status'] = "1" ;
		exit(header('Location: '.$_SERVER['PHP_SELF'] ));
	}
		
 }

$_extensions[0]  = array();
$_extensions[1]  = array();
//$_extensions[1] = array( "css","js","txt","json","xml"); // can read _extensions
//$_extensions[0] = array("gif", "jpg", "jpeg", "png","bmp","dir","css","js");  // Allowed_extensions = in Browse directorie

$RTL_languages  = array('ar','arc','bcc','bqi','ckb','dv','fa','glk','he','lrc','mzn','pnb','ps','sd','ug','ur','yi');

$RTL_languages  = array_map('strtolower', $RTL_languages);
$_extensions[0] = array_map('strtolower', $_extensions[0]);
$_extensions[1] = array_map('strtolower', $_extensions[1]);

$_maxFileSize   = return_bytes(ini_get('upload_max_filesize'));
$_extensions[2] = array("gif", "jpg", "jpeg", "png","bmp","ico","tiff","svg"); //images extensions
$_extensions[3] = array("mp3", "wav", "ogg"); //music extensions
//$_extensions[4] = array('doc', 'docx', 'docm', 'dot', 'dotx', 'dotm', 'wps','pdf'); //formats doc extensions
$_extensions[2] = array_map('strtolower', $_extensions[2]);
$icon[0]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAr0lEQVQ4jbXTsQrCMBAG4AxOgk66ubj5Cg5C3sBX0SVLl3Mp1pb773cQ+jZ9NBcDUmxDg/3hIOSO7yAQ5/6Zsiy3AAoA0q+qqnZJAEARQlg55xzJDoD/3AvJZ+yNARLPfUBENgDMe7/IAQoRWTdNczCz22Tg+21IdpOBoZn5gdTMYFNVT6pKVX1kAWZ2ret6D8CygLZtlwAuAI5ZwFjmBVT1bGb3X58pFslXasmkvAH6z57RLFab2AAAAABJRU5ErkJggg==';
$icon[1]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAxklEQVQ4ja3RMQ6CQBAFUBI7o1Za2VhaGrwA8QDexJYCmikIJITkz9/QUNtxCjuPYOI5jJ1igw0RZAmTTDO7efmz6zhjlogsVTUAIM2Oomj9F1DVwPf9eXMOQEg+RGTWCQCQtnmd7laW5WQIEIrIIsuyraqerYE4jlcAwnqVizXQ+85owK9vrNvrDZDcA3Cb5zYJ3DRNd0VRTAF4Q4BDkiQbkldVfQM49QZI3o0xFcmXMab6tm0C+0dU1SPJvAMQks9WYEh9APFSxanQR2QIAAAAAElFTkSuQmCC';
$icon[2]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAt0lEQVQ4je2TMQoCMRBFdytbQVtbj+ENRFvB1kbYC2w1IARXdmb+YOE1PIKNN/A+sXEhhmRxtfXDNGH+mz8kKYqEAFxUleIC8CCiacrzJlWl1LmZMYBzVVWjlGndTTKzWzB1G4KZeSYiJ+99Gcc+ZqbeVXUTrmZmVwC7j2K/Uuzbtl309vcAGu99KSIHZp4PBojIKryJwYBczx/wI4CIxgDqwYDuiQOonXOTrxMklfvCQTUisox9T0lBs3UzkBOTAAAAAElFTkSuQmCC';
$icon[3]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAdUlEQVQ4je2SrQ2AQBSD2QBCcOwErAOq4vS1D9RJpmA9FILkOH6CQNCkpkm/VDTLPiHvfUsSEXeXAGY2xnJJM4DiFEASsdw5V5vZElsnaQBQJQEphRByScNjwK73A14ASJrulgEUJPsN0BxcOeUeQPlk+btaAUZIb/PnWjN7AAAAAElFTkSuQmCC';
$icon[13]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAXUlEQVQ4jWNgGJbAk4GBIQQP9qXUghCaG+DMwMDARa4BzgwMDEYMDAwsSJiRFAM6GRgYYhkYGAKQsBwpBjAxMDCkMDAwcONRQzAMmKCYbAMIAYIGEEpIWZS6YJABAEwKC7pKuYTEAAAAAElFTkSuQmCC';
$icon[6]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAd0lEQVQ4jWNgoBXo6+vz7+/vb+jv72+YMGFCVUNDgwhJBkyYMGEyjN3Q0MA3YcKEKoKaYDb29/c3TJw48QAevgNeQwhZQtAVxNCjBgx7AzqhtAM6nZuby97f319NyID5fX19XcjJGJqhGidOnHi1q6tLFa8BpAIAcUCizUwVOu0AAAAASUVORK5CYII=';
$icon[7]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAA/ElEQVQ4ja2TPUpDURCFB2wsopVdNuAWYproArKGkM6U0TxIqikeaMi775xTZAXp3nICwdrOBbgAm/sgvN8oDgxc7sz55jCXa/Yf4e53JDcAvJppmg57ASQ37j6o3gNwSd/VWpIkN7XGJjAAj+4+iqK4MjPL81wAnOT7JYC1u99mWXZP8kByBWAba1t3v+4EVHZzBDACMJMUJKW9Ds7qSwCjeH4CsLxoB6U4hPBgZhZCeKyJuwBx8vhM/No2pQYg+VKKAUwkndpc1gAkF+UzAZjE7Te6bARI+gIwl7QjuWpz2QmQ9Angua2nE/DrHpJTkm9Nn6lMkvu+IX+KH1+Xuy051gU6AAAAAElFTkSuQmCC';
$icon[15]='data:image/gif;base64,R0lGODlhHwAfANUAAP///5qamiYmJuTk5Ly8vMzMzKqqqrCwsKKioujo6NTU1Pb29qioqKCgoK6urtLS0tzc3NjY2Li4uObm5nBwcMbGxmhoaEZGRkhISDIyMvj4+Pr6+lBQUDY2NsTExFZWVpKSkgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAKAAAAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAHwAfAAAG/0CAcEhMPAgOBKDDoQQKxKh0CJEErleAYLu1HDRT6YCALWu5XEolPIwYymY0GmNgAxrwuJybCUcaAHlYZ3sCdxFRA28BgVgHBQMLAAkeIB9ojQYDRGSDAQwKYRsIF4ZlBFR5AJt2a3kQQlZlDBN2QxMMcBKTeaG2Qwp5RnAHv1EHcEdwUMZDBXBIcKzNq3BJcJLUAAtwStrNCNjf3GUIDtLfA9adWMzUz6cPxN/IZQ8JvdTBcAkAsli0jOHSJQSCqmlhNr0awo7RJ19TFORqdAXVEEVZyjyKtG1AgXoZA2iK8oeiKkFZGiCaggelSTiA2LhxidLASjZjBL2siNBOFQ84LyXA+mYEiRJzBO7ZCQIAIfkEAQoAIQAsEAAAAA8ADwAABldAhIPwSISOyGRguZRAAEkkc0oYREPTqSESzU4bXe8ylDEgF4PCYRoSCDCVKEDBCLTdAormasXjD1chFRd+AhaBIQiFAgWBGx+FdoEghRSIHoUciAmFHUEAIfkEAQoAIQAsFgAFAAkAFQAABlnAkDDUiAyHgYBhcEwmCQCh0wkJTRjTgESoyAYSIcAh+xAWsgThIOsQLrKIo1yYENjtHaHnbucIQXwCFCEbH4EBIQiBAgUVF4EWQosHQ3wUGkd2GBVzGQZDQQAh+QQBCgAhACwQABAADwAPAAAGWcCQcChcBI5HBJE4QB4dy2HBGSBEQ4AD9XFVUAOJ6IRBlUQroS+EuEFcBGkkARBKeEAfgR5+NAyEe4F6IQ0RQ4KBGUuIehgGi4gUaJB7FgcaVx0cFAEFV0NBACH5BAEKACEALAUAFgAVAAkAAAZUwJAwVBkajYOjUHBBbJQhgIIROAqugg/IkwgtBoVDYFxdYs+CEHk9DmXQZzWb3DBg4Ff53BAhUvB6awRJQhoHFmiBARIQAFAFARQcHSEIDgQPXUZBACH5BAEKACEALAAAEAAPAA8AAAZZwI5gOEyEjsgjhzj0JJMUpgD0RAakn001VJAKENuQRXqpbA/e0KCqiRJDAYYC8KxghvCA/lAYLJAGGXl6hHpPDYWJTxEGiYRVAwSOAVsAEBKKYSEJDwQOCEEAIfkEAQoAIQAsAAAFAAkAFQAABlnAkNCQERpDFYxAcNRQlkvjAQoVWqiCS6WAFSBCAexnE3pSQUIO1iPsYBPHuBARqNcXQoe9PhAS9gEFQg+ABwAhCYABCkISgAwTIRCKQgB/dkcDBnVyEQ1HQQAh+QQBCgAhACwAAAAADwAPAAAGWMCQcEgsBCicDnGoOVgEUOgyVKFEr0sD5oolZrjdUKQRAkeFA0MgUI5+QJ5ECEBYr8sXxIYIsdupUxJ+AQwTUwmDAQpTIQ+DBwCMdX4FjCEOgwOWCIMLlkEAOw==';
$icon[12]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAyUlEQVQ4jbXSPUtDMQCF4edKkRaHDv0YBHGXDipIpVC4BVel6C9QkNqpCBZEHHRo6VAQ/cUOjXKVYHMLHsjyJudNSMI/poIjnGC7bPkUb7jEOZbIU8sNLJD94q/YTRHcYj/Cm7hPEbxEdi+eIkmwydx3pqhHeBXPKYIDjCP8Gsfryhn2cIcRdlDDDSZWrxC9nwwPmOMqsA4e8YTDwC4wC2u3ioKu1adJzRC9IsgxKCHo46wI2vgIknzNGOA9dH6klVD+Gq0Sp/07n5Y9F3VkGsILAAAAAElFTkSuQmCC';
$icon[4]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAe0lEQVQ4je2RsQ2DQBRDPQFCiCpDkawDlamia84+sUTGyGhUFEgHhBNFCiy5seQn63/gLxRjfEpixq+fALbfG/lIsj4ESGIuDyE8bH9y62wPJNtdwJ5IVrYHAEBK6btxg0MXL1j1bgBgezpbJllL6hdAV/DCnmRTsvxazZqvjASHx2bnAAAAAElFTkSuQmCC';
$icon[11]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAA9UlEQVQ4jc2QTUoDQRCFs0jEn7WuFQ8QFx6gNwYXunP0Cq6EgVkI2XQgzIRuut4rG8HaCV7AI7oxYRwSMhACFjRNP977qroGg39XZjbKORcApiSfiqI46B2u6/pUVd9CCFfOuWFKaUzyPcZ41gugqnMzO25rVVWdkPwiOSO5EJHHjQCSsx5NnlNK43Xhl5xzsQ1QluWRqloI4XIlisiE5F3XLCK3qvrtvT9s6865IUlZCQCmZjZaE35V1U8AH13In++SvBGR+7YBwMPv7ZumOReR640TLHegqnMAvnVc5+0BeJKIMV5s29dyEt/LuE+A2wmw9/oBfgaBG4x+og4AAAAASUVORK5CYII=';
$icon[5]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAhUlEQVQ4jWNgoCZoaGgQmTBhQlV/f38DOm5paZEmaMCECROqysrKeNHF+/v7GyZOnPiloaGBB68B/f39DbjEoa67vmrVKmZyDKhuaGjg6+np0ZgwYcJikg1oa2sT7e/vr4Z65QDJBhCtZtSAYWHAhAkT/CZOnDgFW2aC4YkTJ34jZAlJAADcp3JNo6PIZgAAAABJRU5ErkJggg==';
$icon[10]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAA00lEQVQ4jd3PPQrCQBAF4BWE3EFsvMk2Vl7A1t5tLESwscywsO+91ILXsbJPKVjqDYTYpBCJiX+Vr5xhvplx7v9iZgMAO0kXkldJh5TS9OVhSUdJ0cyGIYSM5BhAKWnVCdSbYxNM8hxjHLUCki5mNmzqkdySnLcCJK8hhOxJLwew7rrgQHL8WK+qqidpD2DSCqSUpgBKMxs8DC8lnbz3/VagvmJF8lz/nEvaSzoVRVEB2HQCzjkXYxyRnANYA5h47/sANm8hTblDFt8gC0mzj4Gf5wYc04KjAuZmyQAAAABJRU5ErkJggg==';
$icon[14]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAwklEQVQ4jb2QPQrCQBCFFyvxBtYKuYOVnZ3nCF7BZpsUG9id96bLDTyDlaWnEGzt0xliJYSwJOvvg9cMzPfejDG/UlEUc5K5iOwBbIwxk+RlAFsAtaq2TwM4VlU1S0oGUJM8O+cya+0UwI5kQ9KPAkjmqto657JeqwPJ2yhARKyqtqnz7wIABJJN93l9k7yGEJZRQGyZ5ElEbNfe+1UUMJTctYjYZECsgYis/wd46YSPnxhCKAHch9IBXMqyXEQB7+gBtIEmVWp3raAAAAAASUVORK5CYII=';
$icon[9]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SMU7DQBBFp+UacACKXMCNJYLCCVxzHDf2CfAqVdaz402NiJK0WRcUuUBAlAEbClJ8CuLIctaS63xpNdJo9Pft7Cc6Kk1TkEeFtcIiyI2BZsbrdqt9c0REI1+TRdBo4xwAIDfm3KSPgEXw9v4BAFiu1tg4BxbxznoJjLXY7z/xXf+cSDTzuUFD0NQkSRDH8a1Yi9/DAVVd46uqAAAzn0GLoF2vZD5HV7nvCX07yJR6ZhFoZmhm5CLIlHoZvAMiuh5PJg9BENyFYXh/nLsZTCDW6iYHLAIuip33miiKHn39dg5cWQIAWGQ2mKCbA1eWF5uDPmXT6aKbgyelFoMN6P/PR51zysEf2/RBFJCWMhsAAAAASUVORK5CYII=';
$icon[8]='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAlElEQVQ4jWNgoCZoaGgQmTBhQlV/f38DOm5paZEmaMCECROqysrKeNHF+/v7GyZOnPiloaGBB68B/f39DTAaCTv09/c3QF13fdWqVcwEDcAiXt3Q0MDX09OjMWHChMUku6CtrU20v7+/GuqVA6QagOEdkr1AtBqquWDUCxR4YcKECX4TJ06cgscFDRMnTvxGyBKSAADats4cMtUnDAAAAABJRU5ErkJggg==';
/*---------------------------arabic -------------------*/

$lang[0] =  'ar';
$lang[1] =  'حذف';
$lang[2] =  'تعديل';
$lang[3] =  'معاينة';
$lang[4] =  'الرئيسية';
$lang[5] =  'الاسم';
$lang[6] =  'الحجم';
$lang[7] =  'الصيغة';
$lang[8] =  'الاوامر';
$lang[9] =  'الصفحة';
$lang[10] =  'عدد الملفات';
$lang[11] =  'مستكشف الملفات';
$lang[12] =  'من برمجة';
$lang[13] =  'هل انت متاكد من حذف هذا الملف';
$lang[14] =  'موافق';
$lang[15] =  'الغاء';
$lang[16] =  'مجلد';
$lang[17] =  'جاري الارسال ...';
$lang[18] =  'استعراض المجلد';
$lang[19] =  'بحث';
$lang[20] =  'اعادة التسمية';
$lang[21] =  'لا يمكن فتح الملف';
$lang[22] =  'تسجيل الدخول';
$lang[23] =  'دخول';
$lang[24] =  'اسم المستخدم';
$lang[25] =  'كلمة المرور';
$lang[26] =  'خروج';
$lang[27] =  'حول';
$lang[28] =  'اخر تعديل';
$lang[29] =  'مجلد جديد';
$lang[30] =  'رفع ملف';
$lang[31] =  'لم يتم العثور على تطابق';
$lang[32] =  'احتيار ملف ... ';
$lang[33] =  'خطأ';
$lang[34] =  'نجاح';
$lang[35] =  'جاري التحميل ...';
$lang[36] =  'الصيغ المسموحة';
$lang[37] =  'الحجم الاقصى';
$lang[38] =  'غير موجود';
$lang[39] =  'المجلدات الشجرية';
$lang[40] =  'نسخ الى';
$lang[41] =  'فك الضغط';
$lang[42] =  'معلومات';
$lang[43] =  'فارغ';
$units = array( 'بايت', 'كيلوبايت', 'ميقابايت', 'جيقابايت', 'تيرابايت', 'بيتابايت', 'اكسابايت', 'زيتابايت', 'يوتابيت');

/*---------------------------english -------------------*/

$lang[0] =  'en';
$lang[1] =  'Remove';
$lang[2] =  'Edit';
$lang[3] =  'Preview';
$lang[4] =  'home';
$lang[5] =  'Filename';
$lang[6] =  'Size';
$lang[7] =  'Extension';
$lang[8] =  'Actions';
$lang[9] =  'Page';
$lang[10] =  'Total files';
$lang[11] =  'File Manager';
$lang[12] =  'by';
$lang[13] =  'Are you sure you want to Remove this file';
$lang[14] =  'Save';
$lang[15] =  'Cancel';
$lang[16] =  'Folder';
$lang[17] =  'Sending ...';
$lang[18] =  'Browse directorie';
$lang[19] =  'Search';
$lang[20] =  'Rename';
$lang[21] =  'Unable to open file!';
$lang[22] =  'Sign in';
$lang[23] =  'Login';
$lang[24] =  'Username';
$lang[25] =  'Password';
$lang[26] =  'Logout';
$lang[27] =  'About';
$lang[28] =  'Last modified';
$lang[29] =  'New folder';
$lang[30] =  'Upload file';
$lang[31] =  'Match not found';
$lang[32] =  'Browse ... ';
$lang[33] =  'Error';
$lang[34] =  'Success';
$lang[35] =  'Loading ...';
$lang[36] =  'Allowed extensions';
$lang[37] =  'Max filesize';
$lang[38] =  'Not exists';
$lang[39] =  'Tree View';
$lang[40] =  'Copy to';
$lang[41] =  'UnZip file';
$lang[42] =  'Information';
$lang[43] =  'Empty';

$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

/*----------------------------------------------*/

    $is_rtl=false;
if( in_array( $lang[0], $RTL_languages  ) ) 
	$is_rtl=true;


function Login()
{
	global $login_user,$login_pass;
	if(isset($_SESSION['login']))
	{
	if($_SESSION['login']['user'] ==$login_user && $_SESSION['login']['pass'] ==$login_pass && $_SESSION['login']['status'] =="1")
		return true; else return false;	
	}  else return false;	
	
}

function print_array($array)
{
	global $charset;
	header("Content-type: application/json; charset=".$charset);
	return json_encode($array);
}

function recurse_copy($src,$dst) { 
 if ( is_file($src) )
 {
	 $_DIRNAME = pathinfo($dst, PATHINFO_DIRNAME);
     if(!file_exists($_DIRNAME))
        @mkdir($_DIRNAME, 0777, true); 
    return @copy($src,$dst); 
 }
     
    $dir = opendir($src); 
	if(!file_exists($dst))
       @mkdir($dst, 0777, true); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 
function openZipArchive($file,$extract_path)
{
	global $alert_msg,$lang;
	if(!file_exists($extract_path))
    @mkdir($extract_path, 0777, true); 

$zip = new ZipArchive;
$res = $zip->open($file);
if ($res === TRUE) {
  $zip->extractTo($extract_path);
  $zip->close();
   return true;
} else {
  $alert_msg=$lang[33].' - '.$lang[41];
  return false;
}	
}


function unlinkRecursive($dir, $RemoveRootToo)
{
	 if (is_file($dir) === true)
     return @unlink($dir);  
    if(!$dh = @opendir($dir))
     return;   
    while (false !== ($obj = readdir($dh)))
    {
        if($obj == '.' || $obj == '..')
        continue;
        if (!@unlink($dir . '/' . $obj))
        unlinkRecursive($dir.'/'.$obj, true);       
    }
    closedir($dh);
    if ($RemoveRootToo)
     @rmdir($dir);    
    return;
}



function return_bytes ($size_str)
{
    switch (substr ($size_str, -1))
    {
        case 'M': case 'm': return (int)$size_str * 1048576;
        case 'K': case 'k': return (int)$size_str * 1024;
        case 'G': case 'g': return (int)$size_str * 1073741824;
        default: return $size_str;
    }
}

function is_sub_dir($path = NULL, $parent_folder = SITE_PATH) {
    $dir = dirname($path);
    $folder = substr($path, strlen($dir));
    $dir = realpath($dir);
    $folder = preg_replace('/[^a-z0-9\.\-_]/i', '', $folder);
    if( !$dir OR !$folder OR $folder === '.') {
    	return FALSE;
    }
    $path = $dir.'/'. $folder;/*DS*/
    if( strcasecmp($path, $parent_folder) > 0 ) {
    	return $path;
    }
    return FALSE;
}
function text_position($position=0)
{
global $is_rtl;
if($position==0)
{if($is_rtl ) echo 'left'; else echo 'right';}
else
{if($is_rtl ) echo 'right'; else echo 'left';}	
}

function css()
{  
global $is_rtl;	
$css='';

if(file_exists('./css/bootstrap.min.css'))
    $css.='<link href="./css/bootstrap.min.css" rel="stylesheet">';
else
	$css.='<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';

if(file_exists('./js/jquery-2.2.0.min.js'))
	$css.='<script src="./js/jquery-2.2.0.min.js"></script>';
else
	$css.='<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>';

if(file_exists('./js/bootstrap.min.js'))
	$css.='<script src="./js/bootstrap.min.js"></script>';
else
	$css.='<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';

if(file_exists('./js/jquery.twbsPagination.min.js'))
	$css.='<script src="./js/jquery.twbsPagination.min.js"></script>'; 
else 
	$css.='<script src="//raw.githubusercontent.com/esimakin/twbs-pagination/develop/jquery.twbsPagination.min.js"></script>';

if( $is_rtl ) 
if(file_exists('./css/bootstrap-rtl.min.css'))
	$css.='<link href="./css/bootstrap-rtl.min.css" rel="stylesheet">';
else  
	$css.='<link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">';
         	
	return $css;

} 	
function alert($str)
{
	global $lang;
	return '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$lang[33].'!</strong> '.$str.'</div>';
}

function  AJAX_request()
{
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	return true ; else return false; 
}


if(!Login() && $LoginDialog && ( isset($_GET['uploadfile']) || isset($_GET['listFolderFiles']) || isset($_GET['copy']) || isset($_GET['unzip']) || isset($_GET['table']) || isset($_GET['rename']) || isset($_GET['Remove']) || isset($_GET['read']) || isset($_GET['newfolder']) )  )
{

  die(print_array(array( 'table' => '<div class="container_01"><center>'.$lang[31].'</center></div>' , 'total' => 1 , 'page' => 1, 'dir' => '' , 'dirHtml' => '' ,'alert' => alert($lang[22])  )));
}


if(!Login() && $LoginDialog)
{
	if($login_user=='')
		$html_input_user='<input name="username" value="" type="hidden" >';
	else
		$html_input_user='<div class="input-group" style="margin-top:10px;">
                           <span class="input-group-addon"><i class="UserIcon"></i></span>
                           <input id="user" type="text" class="form-control" name="username" value="" placeholder="'.$lang[24].'">                                        
                         </div>';
echo ('<!DOCTYPE html>
<html>
<head>
<title>'.$lang[22].'</title>
<meta charset="'.$charset.'">
<link href="'.$icon[12].'" rel="icon" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
'.css().'
<style>
body {background: #F1F1F1 none repeat scroll 0% 0%;}
.UserIcon{background:url( '.$icon[12].') no-repeat left center;padding: 5px 0 5px 20px;}
.PassIcon{background:url( '.$icon[14].') no-repeat left center;padding: 5px 0 5px 20px;}
</style>
</head>
<body>
<div class="container">
 <div class="col-sm-4 col-sm-offset-4" style="margin-top:50px;">
		<div class="well" style="background-color: #FFF;">
      <legend>'.$lang[22].'</legend>
    <form accept-charset="'.$charset.'" action="" method="post">'.$html_input_user.'
		          
                    <div class="input-group" style="margin-top:10px;">
                        <span class="input-group-addon"><i class="PassIcon"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="'.$lang[25].'">
                    </div>  
					
        <button class="btn btn-info btn-block" style="margin-top:10px;"  type="submit">'.$lang[23].'</button>
    </form>
	    </div>
  </div>
</div>


</body>
</html>');
	unset($lang);
	unset($icon);
	unset($_extensions);
    unset($RTL_languages);
	unset($LoginDialog);
	unset($login_user);
	unset($login_pass);
	unset($is_rtl);
	unset($units);
	unset($charset);
	unset($_maxFileSize);
    unset($_SERVER); unset($_SESSION);unset($_COOKIE);unset($_GET);  unset($_POST);unset($_FILES);unset($_ENV); unset($_REQUEST); 

exit();
}


$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
if(!($page>0)) $page = 1;
$directory = (isset($_GET['dir'])) ? $_GET['dir'] : '.';

if(isset($_GET['copy']) /*&& AJAX_request()*/ ) {file_exists_str($_GET['copy']); recurse_copy( $_GET['copy'],$_GET['to'] );  } 
if(isset($_GET['Remove']) && AJAX_request() ) {file_exists_str($_GET['Remove']);@unlinkRecursive($_GET['Remove'],true);	} 
if(isset($_GET['newfolder']) && AJAX_request() ) {@mkdir(  $directory .'/'.$_GET['newfolder'] , 0777, true);	} 
if(isset($_GET['rename']) && AJAX_request() ) {file_exists_str($_GET['rename']);@rename($_GET['rename'],$directory .'/'.$_GET['newrename']);} 
if(isset($_GET['unzip']) && AJAX_request() ) {file_exists_str($_GET['unzip']);@openZipArchive($_GET['unzip'],$_GET['to']);} 
if(isset($_GET['listFolderFiles'])  && AJAX_request() ) {die(listFolderFiles($directory));} 

if(isset($_GET['read']) && $show_file_or_dir && AJAX_request() ) {file_exists_str($_GET['read']);if(in_array(extension($_GET['read']), $_extensions[1]) || count($_extensions[1])==0 )
	{   header('Content-type: text/html; charset='.$charset);
		die( _read($_GET['read']) ) ; 
	}   else die($lang[7]);} 
	
if(isset($_GET['write']) && $show_file_or_dir && AJAX_request() ) {file_exists_str($_POST['write']);if(in_array(extension($_POST['write']), $_extensions[1]) || count($_extensions[1])==0 )
	{   header('Content-type: text/html; charset='.$charset);
        $txtData = (isset($_POST['txt'])) ? $_POST['txt'] : '';
		die( _write($_POST['write'],$txtData) ) ; 
	}   else die($lang[7]);} 
	
 if ( isset($_GET['uploadfile']) && AJAX_request() ) { 
 
 $response = array();
 if (isset( $_FILES["inputFileUpload"] ) && !empty( $_FILES["inputFileUpload"]["name"] ) )
 if (is_array($_FILES['inputFileUpload']['name']) || is_object($_FILES['inputFileUpload']['name']))
 foreach($_FILES['inputFileUpload']['name'] as $n => $name) {
	
	if(!empty($name)) {	
	$tmp_name = basename($name);
	$tmp_size = $_FILES["inputFileUpload"]["size"][$n] ;
	$tmp_type = $_FILES["inputFileUpload"]["type"][$n] ;
	$error    = $_FILES["inputFileUpload"]["error"][$n] ;
	$name_    = $_FILES["inputFileUpload"]["name"][$n] ;
	$target_file = $directory .'/'.$tmp_name; 	
		
// )
if( in_array(extension($tmp_name), $_extensions[0]  ) || count($_extensions[0]) ==0 )
 {
	
if(move_uploaded_file($_FILES["inputFileUpload"]["tmp_name"][$n], $target_file))	
    $response[] =array( 'code' => '1','status' => $lang[34] ,'url' => $target_file , 'tmp_name' =>  $tmp_name , 'size' => $tmp_size , 'type' => $tmp_type , 'error' => $error , 'name' => $name_);
elseif($error!=0)
    $response[] =array( 'code' => '0','status' => $lang[33].'_'.$error );	
elseif($tmp_size>$_maxFileSize)
    $response[] =array( 'code' => '0','status' => $lang[37] );		
else
	$response[] =array( 'code' => '0','status' => $lang[33] );	
	
 } else $response[] = array( 'code' => '0','status' => $lang[7] );  
} else $response[] = array( 'code' => '0','status' => $lang[38] );  
}

  die(print_array($response));										
 
}; //$alert_msg=$lang[38];

//exit(header('Location: ?page='.$page.'&dir='.$directory.'"'));

if(!function_exists('scandir')) {
   function scandir($dir, $sortorder = 0) {
       if(is_dir($dir))        {
           $dirlist = opendir($dir);
           while( ($file = readdir($dirlist)) !== false) {
               if(!is_dir($file)) {
                   $files[] = $file;
               }
           }
           ($sortorder == 0) ? asort($files) : rsort($files);
           return $files;
       } else {
       return FALSE;
       }
   }
};


function folderSize ($dir)
{
    $size = 0;
    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : folderSize($each);
    }
    return $size;
}

function FilterScanDir($dir)
{
	global $_extensions,$directory;
$times	= array() ;
$files_tmp = array() ;	
$folers_tmp = array() ;	
$total_files = 0;
$files = (is_dir($dir)) ? @scandir($dir) : array() ;	
if (is_array($files) || is_object($files))
foreach($files as $file)
if(  ( in_array(extension($file), $_extensions[0] ) || count($_extensions[0]) ==0 ) && $file !=='.'  )	
{
	if($file !=='..')
	$total_files++;

    if(is_dir($file))
	 $folers_tmp[]=$file;
    else
	 $files_tmp[]=$file;
 
	$times[] = date ("d/m/Y H:i:s", @filemtime($directory.'/'.$file));
}
//arsort($files_tmp);
//$files = array_keys($files_tmp);
//array_multisort(array_map('filemtime', $files_tmp ), SORT_DESC, $files_tmp);
return array( 'list' => array_merge($folers_tmp,$files_tmp)  ,'times' => $times , 'count' => $total_files );
}

function listFolderFiles($dir){
	global $_extensions;
	 if (is_file($dir) === true) 
		 return ;
    $ffs = scandir($dir);
    echo ' <ul>';
	if (is_array($ffs) || is_object($ffs))
    foreach($ffs as $ff){ 
        if($ff != '.' && $ff != '..' &&  ( in_array(extension($ff), $_extensions[0]  ) || count($_extensions[0]) ==0 )  ){
            echo '<li><a href="'.$dir.'/'.$ff.'">'.$ff;
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            echo '</a></li>';
        }
    }
    echo '</ul>';
}

$total_files = 0;

$offset = ($page-1)*$perpage;
//setcookie('directory', $directory, time() + (86400 * 30), "/");

//get subset of file array
$FilesArray = FilterScanDir($directory);
$files      = $FilesArray['list'];
$times      = $FilesArray['times'];
$total_files= $FilesArray['count'];


//$files = (isset($files_tmp) && is_array($files_tmp)) ? $files_tmp : array();
if(isset($_GET['search']))
{
unset($files);
$files = array();
$total_files = 1;
if (in_array($_GET['search'], $FilesArray['list']))  
  $files[0] = $_GET['search']; 
else 
  $files[0] = 'Match_not_found';
}
if($table_fixed=='')
$total_pages = ceil($total_files/$perpage);
else
$total_pages = 1;	

unset($FilesArray);

if($table_fixed=='')
$files = array_slice($files, $offset, $perpage);


function showfile($file)
{
global $directory,$_extensions,$lang;

if($file=='.' )		
	return '<a href="?" onclick="getContent('."'dir=".$directory.'/'.$file."'".',0); return false;"><strong>'.$file.'</strong></a>';

elseif($file=='Match_not_found')
    return '<span class="ExplorIcon">'.$lang[31].'</span>';
	
elseif($file=='..' )
    return '<span class="TreeIcon"></span><a href="?" onclick="getContent('."'dir=".$directory.'/'.$file."'".',0); return false;">'.$file.'</a>';

elseif(is_dir($directory.'/'.$file) && file_exists($directory.'/'.$file) )	
	return '<span class="CFolderIcon"></span><a href="?" onclick="getContent('."'dir=".$directory.'/'.$file."'".',0); return false;">'.$file.'</a>';
	
elseif (in_array(extension($file), $_extensions[2]  ))
	return  '<span class="ImageIcon"></span><a href="'.$directory.'/'.$file.'">'.$file.'</a>' ;
	
elseif (in_array(extension($file), array("zip","rar","7z","gzip","tar","wim","xz")  ))
	return '<span class="ZipIcon"></span><a href="'.$directory.'/'.$file.'">'.$file.'</a>' ;
	
else
	return '<span class="PhpIcon"></span><a href="'.$directory.'/'.$file.'">'.$file.'</a>';
}

function extension($file)
{
	global $lang;
if($file=='Match_not_found')
	return '--'; 
$extension=strtolower(pathinfo($file, PATHINFO_EXTENSION ))	;
if($extension=='') 
	return 'dir';//$lang[16] ; 
else 
	return $extension; //ucfirst
}


function file_exists_str($file)
{
	global $alert_msg,$lang;
	if(!file_exists($file))
		$alert_msg=$lang[38];
}
function file_size($file)
{
global $directory;
return @filesize_formatted($directory.'/'.$file);	
}


function action($file)
{
global $directory,$page,$show_file_or_dir,$lang,$total_files,$_extensions;
if($file=='Match_not_found' )
	return '--'; 
if( $file =='..')
	return '--'; 

$html= '<a data-toggle="tooltip" title="'.$lang[1].'" onclick="SetRemoveModalattr('."'".$directory.'/'.$file.'&dir='.$directory.'&page='.$page."'".'); return false;" href="#"><span class="RemoveIcon"></span></a> ';
if($show_file_or_dir)
{
	if(is_dir($directory.'/'.$file))
	{
		$count=FilterScanDir($directory.'/'.$file); //$count=FilterScanDir($directory.'/'.$file)['count'];
		$count=$count['count'];
		$html.='<a data-toggle="tooltip" title="'.$lang[18].'"  onclick="SetShowFileModalattr('."'".$directory.'/'.$file.'/&perpage='.$count."&#directory'".'); return false;"  href="#"><span class="OFolderIcon"></span></a> ' ;	 
        unset($count);		
	}
		
	elseif (in_array(extension($file), $_extensions[2]  ))
	   $html.='<a data-toggle="tooltip" title="'.$lang[3].'" onclick="SetShowFileModalattr('."'".$directory.'/'.$file."'".'); return false;" href="#"><span class="ImageIcon"></span></a> ' ;
	elseif (in_array(extension($file), array("zip","rar","7z","gzip","tar","wim","xz")  ))
	   $html.='<a data-toggle="tooltip" title="'.$lang[41].'" onclick="SetZipFileModalattr('."'".$directory.'/'.$file.'&dir='.$directory.'&page='.$page."'".'); return false;" href="#"><span class="ZipIcon"></span></a> ' ;
	else	
       $html.='<a data-toggle="tooltip" title="'.$lang[3].'" onclick="SetShowFileModalattr('."'".$directory.'/'.$file."'".'); return false;" href="#"><span class="ShowIcon"></span></a> ' ;
}
$html.='<a data-toggle="tooltip" title="'.$lang[40].'" onclick="SetCopyFileModalattr('."'".$directory.'/'.$file.'&dir='.$directory.'&page='.$page."'".'); return false;" href="#"><span class="CopyIcon"></span></a>';	
$html.='<a data-toggle="tooltip" title="'.$lang[20].'" onclick="SetRenameModalattr('."'".$directory.'/'.$file.'&dir='.$directory.'&page='.$page."'".'); return false;" href="#"><span class="RenameIcon"></span></a>';	
    return $html;
}

function _read($file,$Modes="r")
{
global $lang;

$file_size = filesize($file);
if( !$file_size || !is_readable($file) ) return $lang[21];

$myfile = fopen($file, $Modes) ;
if(!$myfile) return $lang[21]; //w
return fread($myfile, $file_size );
fclose($myfile);
};

function _write($file,$txt='',$Modes="w")
{
global $lang;

if(file_exists($file) && $txt=='') return $lang[43];

if( file_exists($file) && ( !filesize($file) || !is_readable($file) ) ) return $lang[21];

$myfile = fopen($file, $Modes) ;
if(!$myfile) return $lang[21]; //w
if ( fwrite($myfile, $txt ) )
{
fclose($myfile);
return $lang[34];
}	else {
	     fclose($myfile);
         return $lang[33];
         }

};

function GetOldirectory()
{
global $directory,$page,$lang;

$html='<li><a href="#" onclick="getContent('."'dir=."."'".',0); return false;">'.$lang[4].'</a></li>';
$newDir='.';
$elements = explode('/',$directory);
if (is_array($elements) || is_object($elements))
foreach ( $elements as $key_value )
{
	if($key_value!='.'){
	$newDir = $newDir.'/'.$key_value;
	$html.='<li><a href="#" onclick="getContent('."'dir=".$newDir.'&page='.$page."'".',0); return false;">'.$key_value.'</a></li>';
	}
}

return $html;
}

function filesize_formatted($path)
{
global $units ;
	if(is_dir($path) || $path=='./Match_not_found' ) return '--';//directory 
    $size = filesize($path);
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
function fileTime($index,$file)
{ 
global $times ;
if($file=='Match_not_found') return '--';
return $times[$index];
};

if(isset($_GET['table']) && AJAX_request() )
{
	
$html='<div class="table-responsive"><table class="table table-hover '.$table_fixed.'"><thead><tr>';
	if($table_fixed=='')
	$html.='<th class="col-md-4">'.$lang[5].'</th><th class="hidden-xs col-md-2">'.$lang[6].'</th><th class="hidden-xs col-md-2">'.$lang[7].'</th><th class="hidden-xs col-md-2">'.$lang[28].'</th>';
	else
	$html.='<th class="col-xs-12 col-sm-6">'.$lang[5].'</th><th class="hidden-xs col-xs-2 col-sm-2 col-md-2">'.$lang[6].'</th><th class="hidden-xs col-xs-2 col-sm-2 col-md-2">'.$lang[7].'</th>';

    $html.='<th class="hidden-xs col-md-2">'.$lang[8].'</th></tr></thead><tbody>';
//output appropriate items
if (is_array($files) || is_object($files))
foreach($files as $index => $file )
{
	$html.='<tr>';
	if($table_fixed=='')
	$html.='<td class="col-md-3">'.showfile($file).'</td><td class="hidden-xs col-md-2">'.file_size($file).'</td><td class="hidden-xs col-md-2">'.extension($file).'</td><td class="hidden-xs col-md-2">'.fileTime($index,$file).'</td>';
	else
	$html.='<td class="col-xs-12 col-sm-5">'.showfile($file).'</td><td class="hidden-xs col-xs-2 col-sm-2 col-md-2">'.file_size($file).'</td><td class="hidden-xs col-xs-2 col-sm-2 col-md-2"><span class="label label-default">'.extension($file).'</span></td>';

	$html.='<td class="hidden-xs col-xs-3 col-sm-3 col-md-3">'.action($file).'</td></tr>'; 
}


$html.='<tr>';
if($table_fixed=='')
$html.='<td colspan="5" class="col-xs-12 col-sm-12 col-md-12">';
else
$html.='<td colspan="4" class="col-xs-12 col-sm-12 col-md-12">';	
$html.=$lang[9].' : <mark>'.$page.'</mark> '.$lang[10].' : <mark>'.$total_files.'</mark></td></tr></tbody></table></div>';
if($alert_msg!='') 
	$alert_msg = alert($alert_msg);
  $response = array( 'table' => $html , 'total' => $total_pages , 'page' => $page , 'dir' => $directory , 'dirHtml' => GetOldirectory() ,'alert' => $alert_msg);
  unset($html); 
  die(print_array($response));
  
}

// free memory
unset($files);
unset($times);
//unset($directory);
unset($total_files);
//unset($page);
unset($offset);
//unset($total_pages);
unset($perpage);
unset($table_fixed);
unset($RTL_languages);
unset($show_file_or_dir);
unset($alert_msg);
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>	
	    <meta charset="<?php echo $charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <?php echo css();?>  
		<link href="<?php echo $icon[4];?>" rel="icon" type="image/x-icon" />
		<title><?php echo $lang[11]; ?></title>
        
		<style>

.ZipIcon {background:url(<?php echo $icon[0];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.ImageIcon {background:url(<?php echo $icon[1];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.CopyIcon {background:url(<?php echo $icon[2];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}		
.CFolderIcon {background:url(<?php echo $icon[3];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.OFolderIcon {background:url(<?php echo $icon[4];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.PhpIcon{background:url( <?php echo $icon[5];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.RemoveIcon {background:url(<?php echo $icon[6];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.RenameIcon{background:url( <?php echo $icon[7];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.ShowIcon {background:url(<?php echo $icon[8];?>) no-repeat left center; padding: 5px 0 5px 25px;margin-left: 5px;}
.TreeIcon{background:url( <?php echo $icon[9];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.ExplorIcon{background:url( <?php echo $icon[10];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.UploadIcon{background:url( <?php echo $icon[11];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.UserIcon{background:url( <?php echo $icon[12];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}
.LogoutIcon{background:url(  <?php echo $icon[13];?>) no-repeat left center;padding: 5px 0 5px 25px;margin-left: 5px;}

.table,.breadcrumb,.navbar-default{border: 1px solid #D8D8D8;background: #fff none repeat scroll 0% 0%;}
.container_01{border: 1px solid #D8D8D8;background: #fff none repeat scroll 0% 0%;padding: 25px;margin-bottom:20px;}
.Loading{background:url(<?php echo $icon[15];?>) no-repeat center center; padding: 25px ;}
body {background: #F1F1F1 none repeat scroll 0% 0%;margin-bottom:20px;}
td{font-size: 12px;}
.pagination { margin:0px;}
.table-fixed { border-top: 0px ;}
.table-fixed thead { width: 97%;}
.table-fixed tbody {height: 300px;overflow-y: auto;width: 100%;}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {display: block;}
.table-fixed tbody td, .table-fixed thead > tr> th {float: left;border-bottom-width: 1px;}
.btn-file {position: relative;overflow: hidden;}
.btn-file input[type=file] {position: absolute;top: 0;right: 0;min-width: 100%;min-height: 100%;font-size: 100px;text-align: right;filter: alpha(opacity=0);opacity: 0;outline: none; background: white;cursor: inherit;display: block;}
.navbar-brand {font-size: 14px;}

.treeview, .treeview ul {margin:0;padding:0;list-style:none;color: #D8D8D8;}
.treeview ul { margin-left:1em;position:relative}
.treeview ul ul {margin-left:.5em}

.treeview li {margin:0;padding:0 1em;line-height:2em;position:relative}
<?php if( $is_rtl ) { ?>
.treeview ul:before {content:"";display:block;width:0;position:absolute;top:0;right:0;border-right:1px solid;bottom:15px;}
.treeview ul li:before {content:"";display:block;width:10px;height:0;border-top:1px solid;margin-top:-1px;position:absolute;top:1em;right:0}
<?php } else {?>
.treeview ul:before {content:"";display:block;width:0;position:absolute;top:0;left:0;border-left:1px solid;bottom:15px;}
.treeview ul li:before {content:"";display:block;width:10px;height:0;border-top:1px solid;margin-top:-1px;position:absolute;top:1em;left:0}
<?php } ?>
		</style>
    </head>
    <body>


<div class="container">



<div class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
      <a class="navbar-brand" href="">  <span class="ExplorIcon" ></span>  <?php echo $lang[11].'<span class="hidden-xs"> , '.$lang[12].'  '. base64_decode('PGNvZGU+b25leGl0ZTwvY29kZT4=') . '  '?></span></a>
    </div>
     
	  
	 <div class="collapse navbar-collapse navbar-ex1-collapse"> 
	  
<ul class="nav navbar-nav navbar-<?php text_position();?>">       
 <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
       <span class="UserIcon"></span> <?php /*if(isset($_SESSION['login']['user'])) echo $_SESSION['login']['user']; */?>
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu dropdown-menu-<?php text_position();?>">
	  <li><a href="#" onclick="SetNewFolderModalattr();return false;"><span class="CFolderIcon"></span> <?php echo $lang[29];?></a></li>
	  <li><a href="#" onclick="SetUploadFileModalattr();return false;"><span class="UploadIcon"></span> <?php echo $lang[30];?></a></li>	  
	  <?php if($LoginDialog) {?>
      <li><a href="?logout"><span class="LogoutIcon"></span> <?php echo $lang[26];?></a></li>
	  <?php }?>
	  
    </ul>
  </li>
</ul>
	 
        <div class = "navbar-form navbar-<?php text_position();?>"  role="search">
        <div class="input-group">
            <input type="text" class="form-control" id="inputSearch" placeholder="<?php echo $lang[19];?>" name="q">
			<input type="hidden" value="<?php echo $directory.'&page='.$page;?>" id="dirInputSearch">
            <div class="input-group-btn">
                <button class="btn btn-default" onclick="Search()" type="submit"><span class="ExplorIcon" style="padding: 5px 0px 5px 18px;"></span></button>
            </div>
        </div>
        </div>		
	</div>	
    </div>	
</div>


		

<!-- Modal Rename -->
<div id="Rename" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang[20]; ?> : <code id="RenamefileName"></code></h4>
      </div>
      <div class="modal-body">
	    <input id="renameDir" type="hidden" >	
		<input id="renameOldInput" type="hidden" >	
		
        <input type="text" class="form-control" id="renameInput">
      </div>
     <div class="modal-footer">
	 
	    <span id="RenameLabelsuccess" class="label label-success pull-<?php text_position(1);?>"></span> 
	    <button  type="button" class="btn btn-success"  onclick="renameAndContent()"><?php echo $lang[14]; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang[15]; ?></button>
		 
	 </div>
    </div>

  </div>
</div>	



<!-- Modal Remove -->
<div id="Remove" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang[1]; ?> : <code id="RemovefileName"></code></h4>
      </div>
      <div class="modal-body">
	    <input id="Removedir" type="hidden" >	
		<input id="RemoveInput" type="hidden" >	
		<?php echo $lang[13]; ?>

      </div>
     <div class="modal-footer">
	 
	    <span id="RemoveLabelsuccess" class="label label-success pull-<?php text_position(1);?>"></span> 
	    <button  type="button" class="btn btn-success" onclick="RemoveAndContent()"><?php echo $lang[14]; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang[15]; ?></button>
		 
	 </div>
    </div>

  </div>
</div>	



<!-- Modal Remove -->
<div id="ZipFile" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang[41]; ?> : <code id="ZipfileName"></code></h4>
      </div>
      <div class="modal-body">
	    <input id="Zipdir" type="hidden" >	
     <input class="form-control" id="FolderUnzipInput" >

      <div id="ZipLoad"></div>
      </div>
     <div class="modal-footer">
	 
	    <span id="ZipLabelsuccess" class="label label-success pull-<?php text_position(1);?>"></span> 
	    <button  type="button" class="btn btn-success" onclick="zipAndContent()"><?php echo $lang[14]; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang[15]; ?></button>
		 
	 </div>
    </div>

  </div>
</div>	


<!-- Modal NewFolder -->
<div id="NewFolder" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang[29]; ?> </h4>
      </div>
      <div class="modal-body">
	    <input id="NewFolderDir" type="hidden" >	
		<input type="text" class="form-control" id="NewFolderInput">
      </div>
     <div class="modal-footer">
	 
	    <span id="NewFolderLabelsuccess" class="label label-success pull-<?php text_position(1);?>"></span> 
	    <button  type="button" class="btn btn-success"  onclick="newfolderAndContent()"><?php echo $lang[14]; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang[15]; ?></button>
		 
	 </div>
    </div>

  </div>
</div>	

<!-- Modal CopyFolder -->
<div id="CopyFolder" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang[40]; ?> </h4>
      </div>
      <div class="modal-body">
	    <input id="FromFolderDir" type="hidden" >	
		<input type="text" class="form-control" id="ToFolderInput">
      </div>
     <div class="modal-footer">
	 
	    <span id="CopyLabelsuccess" class="label label-success pull-<?php text_position(1);?>"></span> 
	    <button  type="button" class="btn btn-success"  onclick="copyAndContent()"><?php echo $lang[14]; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang[15]; ?></button>
		 
	 </div>
    </div>

  </div>
</div>	


<!-- Modal UploadFile -->
<div id="UploadFile" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	 
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang[30]; ?> </h4>
		
      </div>
      <div class="modal-body">
	  <p><?php echo $lang[36] .' : <code>{ '.implode(",",$_extensions[0]).' }</code> <br> 
	  '.$lang[37].' : <code id="maxFileSize">'.$_maxFileSize.'</code>'; ?> <br>
	  <?php echo $lang[6] ?> : <code><span id="UploadFileSize"></span></code></p>
	<form  id="FileUploadForm" enctype="multipart/form-data" method="post">
	    <input id="UploadFileDir" type="hidden" >	

            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-default btn-file">
                         <?php echo $lang[32]; ?> <input name="inputFileUpload[]" type="file" multiple >
                    </span> 
                </span>
                <input type="text" class="form-control" readonly id="inputFileUpload">
            </div>	
			
      </div>
     <div class="modal-footer">
	 
	    <span id="FileUploadLabelsuccess" class="label label-success pull-<?php text_position(1);?>"></span> 
	    <button type="submit" name="upload" class="btn btn-success"  id="FileUploadBtn" disabled><?php echo $lang[14]; ?></button> 
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang[15]; ?></button>

        </form>
		
	 </div>
	
    </div>

  </div>
</div>	

 <div class="modal fade" id="ShowFile" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[3] ;?> <code id="imgUrl"></code></h4>
        </div>
        <div class="modal-body">
		  <input id="filenameDir" type="hidden" >	
          <input type="hidden" id="filenameInput">
          
		  
		
		
		<ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#_browse" id="HrefBrowse"><?php echo $lang[18] ;?></a></li>
            <li class=""><a data-toggle="tab" href="#_tree" id="HrefTree"><?php echo $lang[39] ;?></a></li>
        </ul>

        <div class="tab-content">
			
            <div id="_browse" class="tab-pane fade in active">
                <div id="Result" class="zone" > </div>
            </div>
			 
            <div id="_tree" class="tab-pane fade">
			    <br>
                <ul class="treeview" id="listFolderFiles"> 
				</ul>
			</div>
        </div>
		
        </div>
        <div class="modal-footer">
		  <span id="FileWriteLabelsuccess" class="label label-success pull-<?php text_position(1);?>"></span> 
          <button type="button" class="btn btn-success"  id="FileWriteBtn" onclick="writeAndContent()" ><?php echo $lang[14]; ?></button> 
		  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang[15]; ?></button>
        </div>
      </div>
      
    </div>
  </div>


 
  
        <ol class="breadcrumb" id="breadcrumb">  </ol>		 
		<div id="content"></div>		  
		<input type="hidden" id="directory">		
		 <div id="alert"></div>
		 <ul id="pagination" class="pagination"></ul>
        <script type="text/javascript">
		
/**
 *  BootTree Treeview plugin for Bootstrap.
 *
 *  Based on BootSnipp TreeView Example by Sean Wessell
 *  URL:	http://bootsnipp.com/snippets/featured/bootstrap-30-treeview
 *
 *	Revised code by Leo "LeoV117" Myers
 *
 */
 var FileTypes = [ <?php if(count($_extensions[1])!=0) echo "'".implode("','",$_extensions[1])."'" ; ?>]; 
 var ImgTypes = [ <?php if(count($_extensions[2])!=0) echo "'".implode("','",$_extensions[2])."'" ; ?>]; 
 var units = [<?php if(count($units)!=0) echo "'".implode("','",$units)."'" ; ?>];
 var maxFileSize = parseInt('<?php echo $_maxFileSize ?>');
$.fn.extend({
	treeview:	function() {
		return this.each(function() {
			var tree = $(this);
			
			tree.addClass('treeview-tree');
			tree.find('li').each(function() {
				var stick = $(this);
			});
			tree.find('li').has("ul").each(function () {
				var branch = $(this); 				
				branch.prepend("<i class='tree-indicator CFolderIcon'></i>");
				branch.addClass('tree-branch');
				branch.on('click', function (e) {
					if (this == e.target) {
						var icon = $(this).children('i:first');
						
						icon.toggleClass("OFolderIcon");
						$(this).children().children().toggle();
					}
				})
				branch.children().children().toggle();	
				branch.children('.tree-indicator, button, a').click(function(e) {
					branch.click();
					
					e.preventDefault();
				});
			});
		});
	}
});

		
	/*************************************************************/	
		
		
    $('#FileUploadForm').on('submit',(function(e) {
		$('#FileUploadLabelsuccess').html('<?php echo $lang[17]; ?>');	 
		$("#FileUploadBtn").attr("disabled", "disabled");
        e.preventDefault();
        var formData = new FormData(this);
        var dir =$('#UploadFileDir').val();
        $.ajax({
			xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = Math.round(evt.loaded * 100 / evt.total);
						$('#FileUploadLabelsuccess').html('<?php echo $lang[17]?> ' + percentComplete + '%');
						}}, false);
				return xhr;
			},
            type:'POST',
            url: '?uploadfile&dir='+dir,
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				$('#FileUploadLabelsuccess').html('');
				$('#inputFileUpload').val('');
				$('#UploadFile').modal('hide');	
				//$("#FileUploadBtn").attr("disabled", "disabled");
				getContent("dir="+dir,0)	;
            },
            error: function(data){
                $('#FileUploadLabelsuccess').html('<?php echo $lang[33]?>');
            }
			
			
        });
    }));

	function formatFileSize(bytes) {
				
				for(var pos = 0;bytes >= 1000; pos++,bytes /= 1024);
				var d = Math.round(bytes*10);
				return pos ? [parseInt(d/10),".",d%10," ",units[pos]].join('') : bytes + units[0];
			}


		    var LoadingHtml='<div class="container_01"><center><span class="Loading"></span><br><br><?php echo $lang[35]?></center></div>';
            $(function(){$('body').tooltip({ selector: '[data-toggle="tooltip"]' });});
			
					$(document).on('change', '.btn-file :file', function() {
						var input = $(this),
						numFiles = input.get(0).files ? input.get(0).files.length : 1,
						label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
						input.trigger('fileselect', [numFiles, label]);
						var Tsize=0;
						var Tlabel='';
						for (i = 0; i < numFiles; i++) {
                             Tsize  = Tsize+ this.files[i].size;
							 Tlabel = Tlabel+','+this.files[i].name;
							 }
							// alert(Tlabel);

						$("#UploadFileSize").html(formatFileSize(Tsize));	 
						
						if(numFiles==0)		
							$("#FileUploadBtn").attr("disabled", "disabled");
						else
							$("#FileUploadBtn").removeAttr("disabled");
						
						
						
						if(numFiles>1)				
						  $('#inputFileUpload').val('<?php echo $lang[10];?> '+numFiles);	
						else
						{
							
							$('#inputFileUpload').val(label);	
							
							if(Tsize>maxFileSize)
							{
								$('#FileUploadLabelsuccess').html('<?php echo $lang[33].' : '.$lang[37]?>  '+formatFileSize(maxFileSize) );
								$("#FileUploadBtn").attr("disabled", "disabled");
							} else $('#FileUploadLabelsuccess').html('');
							
							
						}
						  
						
						
						}); 	
						
			
			$("#content").html(LoadingHtml);
		     $.getJSON("?table&page=1", function(result){ 
			$("#content").html(result.table); 
		    $('#breadcrumb').html(result.dirHtml);
			$('#directory').val(result.dir);
            // init bootpag -sm
			$('#alert').html(result.alert);
			
			 $('#pagination').twbsPagination({
        totalPages: result.total,
        visiblePages: 5,
		first : '<?php  if($is_rtl ) echo '→'; else echo '←' ?>',
		prev : '«',
		next : '»',
		last : '<?php  if($is_rtl ) echo '←' ;else echo '→' ?>',
        onPageClick: function (event, page) {
            $("#content").html(LoadingHtml);
			$.getJSON("?table&page="+page+"&alert="+result.alert, function(result){ $("#content").html(result.table); $('#breadcrumb').html(result.dirHtml); $('#alert').html(result.alert);});		 
        }
		});
			
			});
			

	    function setCookie(key, value) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }
	
	      function escapeTags( str ) {
			  return String( str )
           .replace( /&/g, '&amp;' )
           .replace( /"/g, '&quot;' )
           .replace( /'/g, '&#39;' )
           .replace( /</g, '&lt;' )
           .replace( />/g, '&gt;' );
		   }
		   
		   function replace_dir( str ) {
			  return String( str ).replace( '///', '/' ).replace( '//', '/' ); 
		   }
		   
		   function isFile(pathname) {
			   return pathname.split('/').pop().split('.').length > 1;
		   }
		   function isDir(pathname) { return !isFile(pathname); }
	
			function getContent(url,type)
			{
				  setCookie('url', url);
				 $("#content").html(LoadingHtml);
				  url = replace_dir(url); 
			      $.getJSON("?table&"+url, function(data){
				 //  alert("?table&"+url);			  
		          $("#content").html(data.table);
			      $('#breadcrumb').html(data.dirHtml);
				  $('#dirInputSearch').val(data.dir);
				  $("#Result").html(data.table);
				  $('#directory').val(data.dir);
				  $('#pagination').empty().removeData("twbs-pagination").unbind("page");
				  $('#alert').html(data.alert);		  
		        $('#pagination').twbsPagination({
                    totalPages: data.total,
                    visiblePages: 5,
		            first : '<?php  if($is_rtl ) echo '→'; else echo '←' ?>',
		            prev : '«',
		            next : '»',
		            last : '<?php  if($is_rtl ) echo '←' ;else echo '→' ?>',
                    onPageClick: function (event, page) {
		            if(type==0)  { 	
			          $("#content").html(LoadingHtml);
		              $.getJSON("?dir="+data.dir+"&table&page="+page+"&alert="+data.alert, function(data){$("#content").html(data.table); $("#Result").html(data.table); $('#breadcrumb').html(data.dirHtml);  $('#alert').html(data.alert);});}
		            }        
		        });
			      });	
				  
			};
			
			function Search()
			{
			    getContent("dir="+$('#dirInputSearch').val()+'&search='+$('#inputSearch').val(),1)	
			}
			

			
			 function SetRenameModalattr(dir)
			 {
				//var filename= SplitFileName(dir,"/").split("&")[0];
				dir = replace_dir(dir); 
				var filename = SplitFileName(dir.split("&")[0],"/"); 
				$('#renameInput').val(filename);$('#renameDir').val(dir);$('#RenamefileName').html(filename);
				$('#ShowFile').modal('hide');	
				$('#Rename').modal('show');	
				$( "#renameInput" ).focus();					
			 };
			 
			 
			  function SetNewFolderModalattr()
			 {
				dir = $('#directory').val();
				dir = replace_dir(dir); 
				$('#NewFolderDir').val(dir);
				$('#ShowFile').modal('hide');	
				$('#NewFolder').modal('show');	
				$( "#NewFolderDir" ).focus();					
			 };
			 
			 function SetUploadFileModalattr()
			 {
				dir = $('#directory').val();
				dir = replace_dir(dir); 
				$('#UploadFileDir').val(dir);
				$('#inputFileUpload').val('');
				$("#UploadFileSize").html('');	
				$('#ShowFile').modal('hide');	
				$("#FileUploadBtn").attr("disabled", "disabled");
				$('#maxFileSize').html( formatFileSize(maxFileSize) );	
				$('#FileUploadLabelsuccess').html('');
				$('#UploadFile').modal('show');				
			 };
			 
			  function SetCopyFileModalattr(dir)
			 {
		
				dir = replace_dir(dir); 
				//var filename = SplitFileName(dir.split("&")[0],"/"); 
				var filename = dir.split("&")[0]; 
				//var filename = filename.split("/")[filename.split("/").length-1]+'/'; 
				$('#FromFolderDir').val(dir);
				$('#ToFolderInput').val(filename); //filename.slice( 0, filename.lastIndexOf("/"))+'/'
				$('#ShowFile').modal('hide');	
				$('#CopyFolder').modal('show');		
				$( "#ToFolderInput" ).focus();				
			 };
			 
			 function SetZipFileModalattr(dir)
			 {
		
				dir = replace_dir(dir); 
				//var filename = ; 			
				$('#Zipdir').val(dir);
				var filename = dir.split("&")[0]; 
                $('#ZipfileName').html(SplitFileName(dir.split("&")[0],"/"));
				$('#FolderUnzipInput').val(filename.slice( 0, filename.lastIndexOf("/"))+'/');
				$('#ShowFile').modal('hide');	
				$('#ZipFile').modal('show');		
				$( "#FolderUnzipInput" ).focus();				
			 };
			 
			 
			  
			 
			 function SetRemoveModalattr(dir)
			 {
				dir = replace_dir(dir); 
	            var filename = SplitFileName(dir.split("&")[0],"/"); 
				$('#RemoveInput').val(filename);$('#Removedir').val(dir);$('#RemovefileName').html(filename);
				$('#ShowFile').modal('hide');	
				$('#Remove').modal('show');				
			 };

	        function getExt(filename)
	        {
			  return filename.substr(filename.lastIndexOf('.')+1).toLowerCase();
		      //return filename.split('.').pop();
		    }
			
			function SplitFileName(dir,split)
			{
				var file_name_array = dir.split(split);
				return file_name_array[file_name_array.length - 1];
			}
	
			  function SetShowFileModalattr(dir)
			 {
				 $("#FileWriteBtn").hide();
				 dir = replace_dir(dir); 
				 if (dir.indexOf("#") !=-1) 
					 var filename = SplitFileName(dir,"#");
				 else
					 var filename = SplitFileName(dir,"/");

                $('#filenameInput').val(filename);
				// var dir = file_name_array[file_name_array.length - 2];
				$('.nav-tabs a[href="#_browse"').tab('show');
				$("#listFolderFiles").html('');
                $("#HrefBrowse").html('<?php echo $lang[3];?>');
				$("#HrefTree").html('');
			
				$("#Result").html('<center><br><br><span class="Loading"></span><br><br><?php echo $lang[35]?></center>');
	            $('#filenameDir').val(dir);$('#imgUrl').html(filename);
				$('#ShowFile').modal('show');	
				
			if(filename =='directory'){
				
				$("#HrefTree").html('<?php echo $lang[39];?>');
				$("#HrefBrowse").html('<?php echo $lang[18];?>');
				$.getJSON("?table&dir="+dir+"&#directory", function(result){ $("#Result").html(result.table); $('#imgUrl').html('#<?php echo $lang[18]; ?>');});
			   $("#listFolderFiles").html('<li><center><span class="Loading"></span><br><br><?php echo $lang[35]?></center></li>');			   
			   $.get("?listFolderFiles&dir="+dir, function(data){
			      $("#listFolderFiles").html(data);
	              $('.treeview').treeview();
    
			   });

		  
					return;
			};
			
			    if( $.inArray(getExt(filename), ImgTypes  )!==-1)
				{
					$("#Result").html('<center><br><img src="'+dir+'" class="img-rounded img-responsive" alt=""></center>'); 
					return;
				};
					
					
				if( $.inArray(getExt(filename), FileTypes  )!==-1 || FileTypes.length ==0 ) {
				
					$.get("?read="+dir, function(result){ 
					 $("#FileWriteBtn").show();
					 $('#FileWriteLabelsuccess').html('');
                     $("#FileWriteBtn").removeAttr("disabled");
                     $("#Result").html('<input id="FileTxt_OK" type="hidden" ><textarea id="FileTxt" class="form-control" rows="15" style="border-top: 0px ; box-shadow: inset 0 0px 1px rgba(0,0,0,.075);border-top-left-radius: 0px; ">'+escapeTags(result)+'</textarea>'); 
					});	
					return;
				};
				
					
						
			 };
			 
			 
			 
			 function writeAndContent() 
			 { 
			 
			  if( !$('#FileTxt_OK').length ) {$("#FileWriteBtn").attr("disabled", "disabled"); $('#FileWriteLabelsuccess').html('<?php echo $lang[33]?>'); return ;}
			 
			 
			   $("#FileTxt").attr("disabled", "disabled"); $("#FileWriteBtn").attr("disabled", "disabled");
			   $('#FileWriteLabelsuccess').html('<?php echo $lang[17]; ?>');		
			   dir = replace_dir($('#filenameDir').val()); 
			   txtData = $('#FileTxt').val();

			   $.post( "?write", { write: dir, txt: txtData } , function( data,status ) {
              
			  if(status=='success'){
				$('#ShowFile').modal('hide'); 
				$('#FileWriteLabelsuccess').html('');
				$('#FileTxt').val('');
			  } else 
				$('#FileWriteLabelsuccess').html('<?php echo $lang[33]?>');
			
                $("#FileTxt").removeAttr("disabled"); $("#FileWriteBtn").removeAttr("disabled");
		       
			   delete txtData; 

			   });
		
             };
			 
			 
			 function renameAndContent() 
			 { 
			   $("#renameInput").attr("disabled", "disabled");
			   $('#RenameLabelsuccess').html('<?php echo $lang[17]; ?>');		
			   dir = replace_dir($('#renameDir').val()); 
			   $.getJSON("?rename="+dir+"&table&newrename="+$('#renameInput').val(), function(data){
	           $("#content").html(data.table);
			   $('#alert').html(data.alert);		
	           $('#Rename').modal('hide');
               $("#renameInput").removeAttr("disabled");
		       $('#RenameLabelsuccess').html('');
			   $('#renameInput').val('');
			   
	         });	
  
             };
			 
			 
			
			function newfolderAndContent()
			{
			   $('#NewFolderLabelsuccess').html('<?php echo $lang[17]; ?>');	
               dir = replace_dir($('#NewFolderDir').val()); 			 
			   $.getJSON("?newfolder="+$('#NewFolderInput').val()+"&table&dir="+dir, function(data){$("#content").html(data.table);$('#alert').html(data.alert); $('#NewFolderLabelsuccess').html('');$('#NewFolderInput').val('');$('#NewFolder').modal('hide');});					  
			}

		
			function RemoveAndContent()
			{
			   $('#RemoveLabelsuccess').html('<?php echo $lang[17]; ?>');		
			   dir = replace_dir($('#Removedir').val()); 
			   $.getJSON("?Remove="+dir+"&table", function(data){$("#content").html(data.table); $('#alert').html(data.alert);$('#RemoveLabelsuccess').html('');$('#Remove').modal('hide');});					  
			}
			
			 function copyAndContent() 
			 { 

			   $("#ToFolderInput").attr("disabled", "disabled");
			   $('#CopyLabelsuccess').html('<?php echo $lang[17]; ?>');		
			   dir = replace_dir($('#FromFolderDir').val()); 
			   $.getJSON("?copy="+dir+"&table&to="+$('#ToFolderInput').val(), function(data){
	           $("#content").html(data.table);
			   $('#alert').html(data.alert);		
	           $('#CopyFolder').modal('hide');
               $("#ToFolderInput").removeAttr("disabled");
		       $('#CopyLabelsuccess').html('');
			   $('#ToFolderInput').val('');
			   
	         });	
             };
			 
			 
			  	 function zipAndContent() 
			 { 

			  $("#ZipLoad").html('<center><br><br><span class="Loading"></span><br><br><?php echo $lang[35]?></center>');
			   $("#FolderUnzipInput").attr("disabled", "disabled");
			   $('#ZipLabelsuccess').html('<?php echo $lang[17]; ?>');		
			   dir = replace_dir($('#Zipdir').val()); 
			   $.getJSON("?unzip="+dir+"&table&to="+$('#FolderUnzipInput').val(), function(data){
	           $("#content").html(data.table);
			   $('#alert').html(data.alert);		
	           $('#ZipFile').modal('hide');
               $("#FolderUnzipInput").removeAttr("disabled");
		       $('#ZipLabelsuccess').html('');
			   $('#FolderUnzipInput').val('');
			   $("#ZipLoad").html('');
	         });	
  
             };
			 delete LoadingHtml; 
			 /*
			 for ( var i in window ) {
              console.log(i, typeof window[i], window[i]);
	         }*/
        </script>
		</div>
    </body>
    </html>
	<?php 
	// free memory
	unset($lang);
	unset($icon);
	unset($_extensions);
	
	unset($directory);
	unset($page);
	unset($total_pages);
	unset($LoginDialog);
	unset($login_user);
	unset($login_pass);
	unset($is_rtl);
	unset($units);
	unset($charset);
	unset($_maxFileSize);
    unset($_SERVER); unset($_SESSION);unset($_COOKIE);unset($_GET);  unset($_POST);unset($_FILES);unset($_ENV); unset($_REQUEST); 
	/*
	echo  memory_get_usage();
	$arr = get_defined_vars();
	
	echo '<pre>';
	print_r($arr);
	echo '</pre>';*/
	?>
<!--<div class="navbar navbar-default  navbar-fixed-bottom" role="navigation">
    <div class="container text-center">
        <p class="navbar-text col-md-12 col-sm-12 col-xs-12">&copy; onexite</p>
    </div>
    </div>-->