<?php
/*
MIT License

Copyright (c) 2025 Mikhael Lerman checkthisresume.com

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

$term="";
if (isset($_GET["term"])) {
  $term=$_GET["term"];				// term is the name of the terminal typically gnome-terminal or not set
}


$before="";
if (isset($_GET["before"])) {
  $before=$_GET["before"];				// before is addhr or not set
}

$fname="";
if (isset($_GET["fname"])) {
  $fname=$_GET["fname"];
}

$fnamecon="";
if (isset($_GET["fnamecon"])) {
  $fnamecon=$_GET["fnamecon"];
}

$dircon="";
if (isset($_GET["dircon"])) {
  $dircon=$_GET["dircon"];
}

$admin=false;
if (isset($_GET["admin"])) {
  if($_GET['admin']==1)
	$admin=true;
}

$host="";
if (isset($_GET["host"])) {
  $host=$_GET["host"];
  if($host="localhost") {
  // change to the real host name that is stored in c:\UniServer\www\local\hostname.txt
  $host=file_get_contents("c:\UniServer\www\local\hostname.txt");  
  }
}
// remove end of line from $host
$host = trim(preg_replace('/\s\s+/', ' ', $host));

$urldir="";
if (isset($_GET["urldir"])) {
  $urldir=$_GET["urldir"];
}

$isexclam=false;
$targetdir="";
if (isset($_GET["targetdir"])) {
  $targetdir=$_GET["targetdir"];
  $pos = strpos($targetdir, "!");
  if ($pos) {
    $isexclam=true;
  } 
  //$targetdir=str_replace("!", "!", $targetdir);		//escape the exclamation mark
}

$targetfile="";
if (isset($_GET["targetfile"])) {
  $targetfile=$_GET["targetfile"];
} 

$perma="";
if (isset($_GET["perma"])) {
  $perma=$_GET["perma"];
}

$param1="";
if (isset($_GET["param1"])) {
  $param1=$_GET["param1"];
}

$drive="C:";
if (isset($_GET["drive"])) {
  $drive=$_GET["drive"];
}

// quelque soit le OS
// si $before=="addhr"
// et $fname=="ui_edit_this.run" ou "edit_this.rn"
// et $targetfile==".head"
// alors rajouter la ligne <hr/> en debut de .head maintenant

if( 
     ($before=="addhr")
   &&($targetfile==".head")
   &&(  ($fname=="ui_edit_this.run")  ||  ($fname=="edit_this.rn")  )
  )
{

$filehead = $targetdir."\\".$targetfile;
$current = "\n<hr/>\n";
$current .= file_get_contents($filehead);
file_put_contents($filehead, $current);
}


// detect OS on client
include 'oslist.php';
// Loop through the array of user agents and matching operating systems
foreach($OSList as $CurrOS=>$Match)
{
  // Find a match
  if (preg_match('/'.$Match.'/', $_SERVER['HTTP_USER_AGENT']))
  {
    // We found the correct match
    break;
  }
}
// You are using ...
//echo "You are using ".$CurrOS."<br/>";
$android="";
$mac="";
if($CurrOS=="Android") {
$android="Android";
$CurrOS="Linux";
}
if($CurrOS=="Mac OS X Puma") {
$mac="mac";
$CurrOS="Linux";
}

 
$targetdirxp=$targetdir;
//$drive="C:";
if($CurrOS=='Windows XP') {
// change "C:\UniServer\www\doc\files"  with "y:\files" in $targetdir
$targetdirxp=str_replace("C:\\UniServer\\www\\doc\\files", "y:\\files", $targetdir);
$drive="y:";
}

$prefix_string="$";
if ($_SERVER["HTTP_HOST"]=="win7-pc") {
  $prefix_string="";
}
if ($_SERVER["HTTP_HOST"]=="xsjmikhaell30") {
  $prefix_string="";
}


// HTTP_USER_AGENT
//file_put_contents("debug.txt", "HTTP_USER_AGENT : ".$_SERVER["HTTP_USER_AGENT"]."\n" , FILE_APPEND);

//file_put_contents("debug.txt", "les var d'environement sans utilise GET mais avec le referer\n" , FILE_APPEND);
if($host=="") $host=$_SERVER["HTTP_HOST"];
//file_put_contents("debug.txt", "HTTP_HOST : ".$host."\n" , FILE_APPEND);
// REQUEST_URI
//file_put_contents("debug.txt", "REQUEST_URI : ".$_SERVER["REQUEST_URI"]."\n" , FILE_APPEND);
// REQUEST_URI : /doc/files/common/downloadfile.php?fname=openTerminal.rn&targetdir=C:\UniServer\www\doc\files\common&targetfile=common&urldir=/doc/files/common/&host=celine-pc&perma=C:\UniServer\www\doc\files\common\permalinux
// HTTP_REFERER
//file_put_contents("debug.txt", "HTTP_REFERER : ".$_SERVER["HTTP_REFERER"]."\n" , FILE_APPEND);

$str_ref="";
$str_path="";
if (isset($_SERVER['HTTP_REFERER'])) {
  $str_ref=$_SERVER['HTTP_REFERER'];
} 

// was $str_ref=$_SERVER['HTTP_REFERER'];

$pos=strrpos($str_ref,"/");
if (strpos($str_ref, 'open-command-prompt-here.html') !== false) {
    // it is clicked from http://localhost/doc/files/FILE/SZ1735/Eagle_feature_config.txt/open-command-prompt-here.html
    //file_put_contents("debug.txt", "pos : ".$pos."\n" , FILE_APPEND);
    $str_path=substr($str_ref,0,$pos);
    //file_put_contents("debug.txt", "str_path : ".$str_path."\n" , FILE_APPEND);
    $pos=strrpos($str_path,"/");
    $prjname=substr($str_ref,$pos+1);
    $pos=strrpos($prjname,"/");
    $prjname=substr($prjname,0,$pos);
//file_put_contents("debug.txt", "prjname : ".$prjname."\n" , FILE_APPEND);
} else {
    // it is clicked from http://localhost/doc/files/common/frename.php?targetdir=C:/UniServer/www/doc/files/FILE/SZ1735/Eagle_feature_config.txt
    $prjname=substr($str_ref,$pos+1);
}

$prjname=str_replace("%60","`",$prjname);

$pos=strpos($str_path,"/doc/");
$linpath=substr($str_path,$pos);
$linpath=str_replace("/doc/files/","/home/user/files/",$linpath);
//file_put_contents("debug.txt", "linpath : ".$linpath."\n" , FILE_APPEND);
$winpathforwardslash=str_replace("/home/user/files/","c:/UniServer/www/doc/files/",$linpath);
//file_put_contents("debug.txt", "winpathforwardslash : ".$winpathforwardslash."\n" , FILE_APPEND);
$winpath=str_replace("/","\\",$winpathforwardslash);
//file_put_contents("debug.txt", "winpath : ".$winpath."\n" , FILE_APPEND);

///////////////////////////////////////////// Linux ///////////////////////////////////
if(($CurrOS=='Linux')||($CurrOS=='Android')) {

  $prjpath=$linpath;
  $targetdir = rtrim($targetdir, '\\');

  // OK the client is Linux but how if the link was for Windows
  // let's try fix this
  // if fname==ui_total_commander.run then krusaderHere.rn
  if ($fname=='ui_total_commander.run') {
    $fname='krusaderHere.rn';
	$perma=$perma."Linux";
  }

  if ($fname=='ui_tightvnc_remote.run') {
    $fname='tightvnc_remote.rn';
	$perma=$perma."Linux";
  }


    // replace    "/doc/files/ThisPCLinux/apt-get_update"
    // with "/home/user/files/ThisPCLinux/apt-get_update"
    $url=$urldir;
    $urldir=str_replace("/doc/","/home/user/",$urldir);  // adjust for linux
  

  // copy source destination
  if($CurrOS=='Linux') {
    $text="#!/bin/bash "."\n";
  } else {	// this must be android
    $text="#!/system/bin/sh "."\n";
  }
  $text.="# Linux shell file from ".$_SERVER["HTTP_HOST"]."\n";
  $text.="# current detected os: ".$CurrOS."\n";
  $text.="# running ".$fname." "."\n";

  $text.="# Change directory to ".$targetdir." is added by the server script. "."\n";

  // find the path on linux
  // in windows C:\UniServer\www\doc\files\ThisPC\opensuze_guest\test_run_command
  // becomes /home/user/files/ThisPC/opensuze_guest/test_run_command

  $pos=strpos("UniServer\\www\\doc\\files\\",$targetdir);
  $linTargetdir="/home/user/".substr($targetdir,$pos+21);
  $linTargetdir=str_replace("\\","/",$linTargetdir);
  //$text.="#echo \"Change directory to ".$linTargetdir." is added by the server script.\" "."\n";

  if (($fname!="mntFiles.sh")&&($fname!="umntFiles.sh")&&($fname!="testFilesMounted.sh")) {
    //$text .="pwd "."\n";
    //$text.="cd ".$linTargetdir." "."\n";

    // $prjname
    $text.="# from REFERER :"."\n";    
    $text.="export PRJNAME=\"".$prjname."\"; "."\n";
    // $linpath
    $text.="export LINPATH=\"".$linpath."\"; "."\n";
    // $winpathforwardslash
    $text.="export WINPATHFORWARDSLASH=\"".$winpathforwardslash."\"; "."\n";
    // $winpath
    $text.="export WINPATH=\"".$winpath."\"; "."\n";
    $text.="export PRJPATH=\"".$prjpath."\"; "."\n";
    $text.="export LINDIRECTORY=\"".$linTargetdir."\"; "."\n";
    $text.="export TARGETDIR=\"".$targetdir."\"; "."\n";
    $text.="export TARGETFILE=\"".$targetfile."\"; "."\n";
    $text.="export IHOST=\"".$_SERVER["HTTP_HOST"]."\"; "."\n";
    $text.="# from GET :"."\n";    
    $text.="export HOST=\"".$host."\"; "."\n";
    $text.="export URLDIR=\"".$urldir."\"; "."\n";
    $text.="export URL=\"".$url."\"; "."\n";
    if(isset($_GET["param1"])) {
        $text.="export PARAM1=".$param1."\n";
      }
	  
    $text.="  printf 'host ".$host."\\n' \n"; 
	$uid="100";
	if($host=="xsjmikhaell30") $uid="mikhaell";
	if($host=="win7-pc") $uid="mlerman";
	if($host=="celine-pc") $uid="mlerman";
	
    $text.="if [  \"\$HOSTNAME\" = xsjmikhaell50 ]; then"."\n"; 
    $text.="  printf 'guest xsjmikhaell50\\n' \n"; 
    $text.="elif [  \"\$HOSTNAME\" = mlerman-vm-mint ]; then"."\n"; 
    $text.="  printf 'guest mlerman-vm-mint\\n' \n"; 
	
	//$text.="  export http_proxy=proxy\n";
	$text.="  unset http_proxy\n";
    $text.="elif [  \"\$HOSTNAME\" = mint18 ]; then"."\n"; 
    $text.="  printf 'guest mint18\\n' \n"; 
    $text.="fi\n"; 
	  
	// pause for debug
    $text.="  echo http_proxy is \$http_proxy \n"; 
	//$text.="  read -p \"Press any key to continue . . .\" \n"; 
	  
	  
    //$text.="if [ ! -d \"\$LINDIRECTORY\" ]; then"."\n"; 
    $text.="if [ ! -d \"/home/user/".$_SERVER["HTTP_HOST"]."/files/common/\" ]; then"."\n"; 
    $text.="  echo \"dir=\$LINDIRECTORY\""."\n";
    $text.="  echo \"Mounting ".$_SERVER["HTTP_HOST"]."...\";"."\n"; 
    //$text.="  sudo mkdir -p /home/user/files"."\n";
    $text.="  sudo mkdir -p /home/user/".$_SERVER["HTTP_HOST"]."/files"."\n";
    //$text.="  echo \"if error wrong fs type etc try run sudo apt install cifs-utils\";"."\n"; 

    $text.="  export pw=$(wget http://".$_SERVER["HTTP_HOST"]."/local/1521A845-A144-442e-BA7B-42E7D69B19AE -q -O - )"."\n"; 
	
	// a xilinx uid="mlerman" rend bad option
	// wget peut utiliser le proxy a verifier
    $text.="  export mluser=$(wget http://".$_SERVER["HTTP_HOST"]."/local/myusername.txt -q -O - )"."\n";   // myXusername.txt myusername.txt
	//$text.='  echo password is $pw user is $mluser'."\n";
	//sudo demande un password

	// pause for debug
    //$text.="  read -p \"Press [Enter] key to continue... \" "."\n";
	
//Mounting a filesystem does not require superuser privileges under certain conditions, 
//typically that the entry for the filesystem in /etc/fstab contains a flag that permits 
//unprivileged users to mount it, typically user. 
//To allow unprivileged users to mount a CIFS share (but not automount it), 
//you would add something like the following to /etc/fstab: //server/share /mount/point cifs noauto,user 0 0
//                                                     ici  //win7-pc/files /home/user/files

// unmount and test again with umount /home/user/files  pb: c'est busy rebooter, fermer les sessions utilisant files ex krusader et terminal
// mount: only root can use "--options" option
// devalider le password promp de sudo voir visudo_password_prompt_removal
// vers=2.1 a cause du message erreur : mount error(121): Remote I/O error
	
    //$text.="  sudo mount -t cifs -o username=".'$mluser'.",password=\"".'$pw'."\",uid=".'$mluser'.",gid=users,vers=2.1 //".$_SERVER["HTTP_HOST"]."/files /home/user/files"."\n"; 
	// this will expose the password to use just for test and for copy paste the command in the terminal
    //$text.="  sudo mount -t cifs -o username=".'$mluser'.",password=\"".'$pw'."\",uid=".'$mluser'.",gid=users,vers=2.1 //".$_SERVER["HTTP_HOST"]."/files /home/user/".$host."/files"."\n"; 
	// OK but no write access
    //$str_mount=	"  sudo mount -t cifs -o username=".'$mluser'.",password=".'"'.'$pw'.'"'.",forceuid,gid=users,vers=2.1 //".$_SERVER["HTTP_HOST"]."/files /home/user/".$host."/files"."\n"; 
    // uid=0 root proviledge does fix the write access denied
	$str_mount=	"  sudo mount -t cifs -o username=".'$mluser'.",password=".'"'.'$pw'.'"'.",rw,uid=".$uid.",gid=users,vers=2.1,file_mode=0777,dir_mode=0777 //".$_SERVER["HTTP_HOST"]."/files /home/user/".$host."/files"."\n"; 
    //$text.="  echo str_mount : ".$str_mount;
    $text.=$str_mount;

	// pause for debug
    //$text.="  read -p \"Press [Enter] key to continue... \" "."\n";

	//$text.="    sleep 5\n";
	// ca ne fait rien
	$text.="  while [ ! -d \"/home/user/".$_SERVER["HTTP_HOST"]."/files/common\" ]; do\n";
	$text.="    sleep 1\n";
	$text.="  done\n";
		
	// now create a symbolic link ex ln -s /home/user/xsjmikhaell30/files /home/user/files
	// f overwrite existing link
	// des fois il semble que cette commande ne marche pas dans le script
	$text.="  sudo ln -sfn /home/user/".$_SERVER["HTTP_HOST"]."/files /home/user/files\n";
	// now test the link and eventually pause
	//$text.="  test -L /home/user/files && echo \"symbolic link created successfully\" || echo \"could not create symbolic link /home/user/files\" && sed -n q </dev/tty\n";
	// pause removed
	$text.="  test -L /home/user/files && echo \"symbolic link created successfully\" || echo \"could not create symbolic link /home/user/files\"\n";
	
	// pause for debug
    //$text.="  read -p \"Press [Enter] key to continue... \" "."\n";
	
    $text.="else "."\n";
    //$text.="  echo \"The directory exists\";"."\n"; 
	$text.="  sudo ln -sfn /home/user/".$_SERVER["HTTP_HOST"]."/files /home/user/files\n";
	$text.="  test -L /home/user/files && echo \"symbolic link created successfully\" || echo \"could not create symbolic link /home/user/files\"\n";
	$text.="  cd \$LINDIRECTORY"."\n";
    $text.="fi"."\n"; 

	// pause for debug
    //$text.="  read -p \"Press [Enter] key to continue... \" "."\n";

    // add the function pause so it can be used in linux shell
    $text.="pause(){"."\n"; 
    $text.="if [ $# -eq 0 ]; then"."\n";
    $text.='   read -p "Press any key to continue . . ."'; 
    $text.="\n"; 
    $text.="else"."\n";
    $text.='   read -p "$*";'; 
    $text.="\n"; 
    $text.="fi"."\n";
    $text.="}"."\n"; 

 	// pause for debug
    //$text.="read -p \"Press [Enter] key to continue... \" "."\n";
  }


  $text.="# ======= original file below this line ======= "."\n";

  if(isset($_GET["perma"])) {

  $textbat.=file_get_contents($perma."\\".$fname);
  } else {

    $textbat=file_get_contents($targetdir."\\".$fname);
  }


  //ici gnome-termilaler le fichier
  //s'il ne contient pas deja le string "gnome-terminal"
  //alors transformer toute les lignes en un long string separe par des ';'
  //gnome-terminal -e 'sh -c "ligne 1; ligne 2; ligne 3"'
  //escaper les double quote
  if (strpos($textbat, 'gnome-terminal') !== false) {
    // already using gnome-terminal do nothing
//file_put_contents("debug.txt", $textbat);
     $text.=$textbat;
    
    } else {
    // wrap with 
    //gnome-terminal -e 'sh -c "ligne 1; ligne 2; ligne 3"'
	
  	  if( $term == "") {
        $text.=$textbat;
	  } else {

		  // insert title
		  if ($_SERVER["HTTP_HOST"]=="xsjmikhaell30") {		// this works in ubuntu but not in Mint
               $textbat='echo -ne "\033]0; Started in $LINDIRECTORY | running '.$fname.' | from '.$_SERVER["HTTP_HOST"].'\007"'."\n".$textbat;
		  }
	  
	   //$tempstr=$term." -e 'sh -c \"";  // sh: 1: source not found, pause OK
       //$tempstr=$term." -e $'bash -c \"";	// commence a executer
        $tempstr=$term." --geometry=180x25 -e ".$prefix_string."'bash -c \"";	// commence a executer
											// la suite de ce string est quote et double-quote
        //$tempstr=$term." -e 'csh -c \"";	// pas de pause
        
        
		// remove all comment lines starting with #
		$array = explode("\n",$textbat);
		foreach($array as $arr) {
			if (
				   (!(substr($arr, 0, 1) === "#"))	// not a comment line
			    //&& ($arr != "")						// not an empty line 
				&& (!(strlen(trim($arr)) == 0))		// not spaces or empty line
													// TODO: voire aussi si la ligne ne contient que des blancs et tab etc
			   ) {
				$output[] = $arr;
			}
		}
		$textbat_no_comments = implode("\n",$output);
        
        
        $tempstr.= str_replace("\n", ';', addcslashes($textbat_no_comments,'"\''));	// TODO
        $tempstr.="\"'"."\n";					// ferme 
//file_put_contents("debug.txt", $tempstr);
        $text.=$tempstr;
	  }
    }
 

  $text.="\n"."# ======= add auto delete ======="."\n";
  $text.='#rm -- "$0"'."\n";

  //file_put_contents($fname, $text);
  if($CurrOS=='Linux') {
    header('Content-type: "application/octet-stream"');
    //header('Content-type: "application/x-shellscript"');

  } else {	// this must be android
    header('Content-type: "text/x-shellscript"');		// this tells Android with what to open this file
														// to prevent the error message: "can't open file"
  }														// il y a open with maintenant mais ca ne marche pas

  //
  header('Content-Disposition: attachment; filename="'.$fname.'"');
  header("Content-Transfer-Encoding: binary");
  //readfile($fname);
  print($text);		// linux style

} else {

///////////////////////////////////////////// Windows 7 ///////////////////////////////////

    $prjpath=$winpath;



  // OK the client is windows but how if the link was for linux
  // let's try fix this
  // if fname==krusaderHere.rn then ui_total_commander.run
  if ($fname=='krusaderHere.rn') {
    $fname='ui_total_commander.run';
    $perma=substr($perma,0,-5);					// remove "Linux" from the suffix;
	}


  //$admin=false;
  $rest= strtoupper(substr($fname, -4));
  if($rest==".LNK") {
	header('Content-type: "application/octet-stream"');
	header('Content-Disposition: attachment; filename="'.$fname.'.run"');
	header("Content-Transfer-Encoding: binary");
	readfile($targetdir."\\".$fname);
	exit(0);
  }

  // copy source destination

  if (!$isexclam) $text="setlocal enabledelayedexpansion\r\n";
  else $text="";
  $text.="@echo off\r\n";
  if($admin)
    {
    //$admin=true;
    $text.="rem admin mode\r\n";
    }
  //$text.="echo cd =%cd%\r\n";
  $text.="rem current detected os: ".$CurrOS."\r\n";
  $text.="rem Interactive batch file from ".$_SERVER["HTTP_HOST"]."\r\n";
  $text.="rem running ".$fname."\r\n";
  $text.="rem perma is ".$perma."\r\n";
  //$text.="rem Change directory to ".$targetdirxp." is added by the server script.\r\n";
  $text.="rem Change directory added by the server script.\r\n";
  $text.="rem from REFERER :\r\n";
  $text.="set PRJNAME=".$prjname."\r\n";
  $text.="set LINPATH=".$linpath."\r\n";
//$winpathforwardslash  
  $text.="set WINPATHFORWARDSLASH=".$winpathforwardslash."\r\n";
  $text.="set WINPATH=".$winpath."\r\n";
  $text.="set PRJPATH=".$prjpath."\r\n";

  $text.="set HOST=".$host."\r\n";
  $text.="rem from GET :\r\n";
  $text.="set URLDIR=".$urldir."\r\n";
  $text.="set TARGETDIR=".$targetdirxp."\r\n";
  $text.="set TARGETFILE=".$targetfile."\r\n";
  $text.="set FNAMECON=".$fnamecon."\r\n";
  $text.="set DIRCON=".$dircon."\r\n";

  if(isset($_GET["param1"])) {
    $text.="set PARAM1=".$param1."\r\n";
  }

  if(isset($_GET["perma"])) {
    $textbat=file_get_contents($perma."\\".$fname);
  } else {
    $textbat=file_get_contents($targetdir."\\".$fname);
  }


  // create a file in the download directory
  if($admin) {
    $text.="echo @echo off>.admin.bat\r\n";
    $text.="echo rem admin mode>>.admin.bat\r\n";
  
    $text.="echo set TARGETDIR=".$targetdirxp.">>.admin.bat\r\n";
    $text.="echo set TARGETFILE=".$targetfile.">>.admin.bat\r\n";
    $text.="echo ".$drive.">>.admin.bat\r\n"; 		// change drive because cd does not change drive ex for y:
    $text.="echo cd ".$targetdirxp.">>.admin.bat\r\n";
  
   //$text.="echo @echo on>>.admin.bat\r\n";
   $text.="echo rem ======= original file below this line =======>>.admin.bat\r\n";
 
   foreach(preg_split("/((\r?\n)|(\r\n?))/", $textbat) as $line){
     // do stuff with $line
	 if (!empty($line)) {
      $text.="echo ".$line.">>.admin.bat\r\n";
	  }
    } 
  }

  if ((!$admin)&&($targetdirxp!="")) {
    $text.=$drive."\r\n"; 		// change drive because cd does not change drive ex for y:
    $text.="if not exist ".$targetdirxp." mkdir ".$targetdirxp."\r\n";
    $text.="cd ".$targetdirxp."\r\n";
    $text.="for %%a in (.) do set CURRENTFOLDER=%%~na\r\n";
  }

  // create a file in the target directory
  //if($admin) {
  //  $text.="echo rem >.admin.bat\r\n";
  //}

  //$text.="rem perma=".$perma."\r\n";

  //$text.="call c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\AutoRun\\env.cmd\r\n";
  // this should be done with the registry key  "HKLM\software\Microsoft\command processor" and value - Autorun.
  $text.="rem ======= original file below this line ======= & @echo on\r\n";
  $text.="cls\r\n";

  
$array = explode("\n",$textbat);
foreach($array as $arr) {
	if (
	     (substr($arr, 0, 7) === "export ")		// the line starts with "export " to change with "set "
  	   ) {
		$pos = strrpos($arr, "export");			// do only if it starts with and no other "export" there
		if ($pos == 0) 	$arr = str_replace("export ","set ",$arr);
  	     }
	$output[] = $arr;
}
$textbat = implode("\n",$output);

  
  
  
  
  
  if (!$admin) {
    $text.=$textbat;
    $text.="\r\n"."rem ======= add auto delete =======\r\n";
    //$text.="echo 1 %0 %USERPROFILE%\Downloads\r\n";
	
	//$text.="goto EOF\r\n";		// this to disable auto deletion
	$text.="set curfile=%0\r\n";
    $text.='set curfile2=%curfile:"=%'."\r\n";
    $text.='if "%curfile:~-4%" == ".bat" ( echo auto delete .bat '."\r\n";
    $text.="set curfile3=%curfile:~0,-4%\r\n";
    $text.="echo if exist !curfile3! del !curfile3! /Q\r\n";
    $text.=") \r\n";

	
	
    //$text.="if exist %0 del %0 /Q\r\n";
    //$text.="pause\r\n";

    $text.="set curdir=%cd%\r\n";
    $text.='if "%curdir:~-10%" == "\Downloads" ( echo deleting "%~f0"'."\r\n";
    $text.= "\r\n".'echo start /b "" cmd /c del "%~f0"&exit /b'."\r\n";
    //$text.="echo 4\r\n";
    //$text.="pause\r\n";
    $text.="  )";
  }
  if (!$isexclam) $text.="\r\nendlocal\r\n";

  //file_put_contents($fname, $text);

  header('Content-type: "application/octet-stream"');
  header('Content-Disposition: attachment; filename="'.$fname.'"');
  header("Content-Transfer-Encoding: binary");
  //readfile($fname);

  print($text);		// Windows style
  if ($admin) {
    print('c:\UniServer\www\doc\files\ThisPC\nircmd\nircmdc.exe elevate cmd /K " call %cd%\.admin.bat & exit"');
  }
  
}

?>
