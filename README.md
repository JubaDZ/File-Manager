# File-Manager
> متحكم في الملفات متعدد المهام :+1: 

Features
--------
* `Single file`, there are no images, or css folders.
* Ajax File Manager ( browse , `Pagination` )
* Ajax File `uploader`
* `Rename` and `Delete`  and `Copy` (files & folders)
* `Unzip` archive
* `Create` folder
* Tree view
* Session `login`
* `Preview` files and images
* Multi-Languages
* `Bootstrap` framework

config
-----------
```php
$LoginDialog      = true;
$show_file_or_dir = true ; 
$perpage          = (isset($_GET['perpage'])) ? (int)$_GET['perpage'] : 10;
$login_user       = 'admin';
$login_pass       = 'admin';
$Allowed_extensions = array();
$CanReadExt         = array( "css","js","txt","json","xml");
$lang[0] =  'en';
```
ScreenShot
--------
#### **Small devices**

![ScreenShot](https://github.com/onexite/File-Manager/blob/master/images/File%20Manager%20001.png)


#### **Medium and large devices**

![ScreenShot](https://github.com/onexite/File-Manager/blob/master/images/File%20Manager%20002.png)

Download
--------
##### [Click here to download latest version](https://github.com/onexite/File-Manager/archive/master.zip)
