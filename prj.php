<?php
$files_path = file_get_contents(getcwd().'\core_settings\FILES_PATH.sh.bat');
echo '<br/>';
echo 'on est dans ' . getcwd() . "\n";
echo '<br/>';
$dir =  getcwd();
$files_path = str_replace("\\", "/", $dir);

$files_path = str_replace("set FILES_PATH=", "", $files_path);
$files_path = str_replace("\\", "/", $files_path);
$dir = $files_path;
// remove trailing slash
$files_path = rtrim($files_path, '/');
echo 'FILES_PATH est ' . $files_path;  // example C:/UniServer/www/doc/files
echo '<br/>';

// Find the last slash
$lastSlash = strrpos($files_path, "/");

// Find the second to last slash
$secondLastSlash = strrpos(substr($files_path, 0, $lastSlash), "/");

// Extract the substring from the second to last slash onwards
$slash_doc = substr($files_path, $secondLastSlash);
echo 'slash_doc est ' . $slash_doc;  // example /doc/files
echo '<br/>';


// detect OS on client
$onmouseover='';    // TODO previent erreur avec wampserver, a revoir
$param1='';
$link =  "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo 'link est '.$link.'<br/>';		//ml //siliconkit.com/doc/files/common/open-command-prompt-here.html
//$linkip =  "//$_SERVER[SERVER_ADDR]$_SERVER[REQUEST_URI]";
$linkip =  "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo 'linkip est '.$linkip.'<br/>';	//ml  linkip est //192.168.1.72/doc/files/common/open-command-prompt-here.html

$hostname=gethostname();
$linkname =  "//$hostname$_SERVER[REQUEST_URI]";
echo 'linkname '.$linkname.'<br/>';		//ml  linkname //DESKTOP-MCQS4FT/doc/files/common/open-command-prompt-here.html

//   //mlerman-lap/doc/files/Engineering/ENVIRONMENT/NODE/fill_sd_ajax/open-command-prompt-here.html
$escaped_link = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
echo 'escaped_link '.$escaped_link.'<br/>';		//ml  escaped_link //siliconkit.com/doc/files/common/open-command-prompt-here.html


$pos=strpos($escaped_link,"/doc/files");


// $escaped_link_cut=substr($escaped_link,0,-29);
$escaped_link_cut='/doc' . $slash_doc;
echo 'escaped_link_cut '.$escaped_link_cut.'<br/>';  //ml  escaped_link_cut //siliconkit.com/doc/files/common/

$id_link=$escaped_link_cut;
echo 'id_link '.$id_link.'<br/>';

$dir_loc=$id_link; 
echo 'dir_loc '.$dir_loc.'<br/>';		//ml  dir_loc /doc/files/common


$display_link=$escaped_link_cut;
$pos=strpos($escaped_link_cut,"/doc/files");
$host=$_SERVER['HTTP_HOST'];
echo 'host '.$host.'<br/>';
$urldir=substr($display_link, $pos);
echo 'urldir '.$urldir.'<br/>';
$display_link=substr($display_link, $pos+10);
echo 'display_link '.$display_link.'<br/>';		//ml  display_link /common/


echo "dir is ".$dir.'<br/>';   //ml  dir is C:/UniServer/www/doc/files/common


//$proj_dir=substr($_GET["reqfname"], 0, strrpos($_GET["reqfname"], "/"));
$proj_dir=$dir;
$proj_dir_lin=str_replace("C:/UniServer/www/doc/","/home/user/",$proj_dir);
echo "proj_dir_lin is ".$proj_dir_lin.'<br/>';		//ml   proj_dir_lin is /home/user/files/common



$urldirpapa=substr($urldir,0, strrpos(substr($urldir,0,-1),"/"));
echo "urldirpapa is ".$urldirpapa.'<br/>';		//ml   urldirpapa is /doc/files


$clienthost = gethostbyaddr($_SERVER['REMOTE_ADDR']);
//$clienthost = "mlerman-lap";		// hack temporaire
$clienthost = str_replace(".micron.com", "", $clienthost);
$clienthost = strtolower($clienthost);

$pos=strrpos($dir, "/");
$prjname=substr($dir, $pos+1);
echo "prjname is ".$prjname.'<br/>';		//ml   prjname is common



// let see here if there is a file autoexec.bat and run it
if (file_exists($dir."/autoexec.bat")) {
  $sovdir=getcwd();
  chdir ($dir);
  $result = shell_exec($dir."/autoexec.bat") ;
  // restore directory
  chdir ($sovdir);
}

$icon_run="";
if (file_exists("/UniServer/www".$dir_loc."/ui_run.run")) {
	//echo "<script>alert('".$dir_loc."');</script>";
	$icon_run="<a href='downloadfile.php?fname=ui_run.run&targetdir=/UniServer/www".$dir_loc."&admin=0'><img src='./images/Play-1-Hot-icon.png'/></a>";
}

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
//echo "CurrOS is ".$CurrOS." \n";
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
//echo "CurrOS is -".$CurrOS."-".$android."<br/>";
if (($CurrOS=="Linux")&&($android=="")&&($mac=="")) echo "<img src=./images/linux.png' title='You are running Linux'>&nbsp;";
if ($android=="Android") echo "<img src='./images/android_ico.png' title='You are running Android'>&nbsp;";
if ($mac=="mac") echo "<img src='./images/osx.png' title='You are running Android'>&nbsp;";
if (($CurrOS=="Windows 7")||($CurrOS=="Windows 10")) echo "<img src='./images/Windows16.png' title='You are running Windows 7'>&nbsp;";
//echo "HTTP_USER_AGENT is ".$_SERVER['HTTP_USER_AGENT']."<br/>";


$no_favicon=false;
echo '<br/>'.$dir.'/favicon.ico'.'<br/>';


if (file_exists ( $dir.'/get_param1.bat' ))
{
	$param1=@file_get_contents($dir."/get_param1.bat");
	$param1=str_replace("set PARAM1=","",$param1);
}

$feu="";
if (file_exists ( $dir.'/get_feu.bat' ))
{
	$feu=@file_get_contents($dir."/get_feu.bat");
	$feu=str_replace("set FEU=","",$feu);
	$feu = trim(preg_replace('/\s\s+/', ' ', $feu));		// remove eol
}

?>


<html>
<head>
<!--
<link rel="icon" href="<?php echo $urldir; ?>favicon.ico?v=<?php echo time() ?>" type="image/x-icon"/>
-->

<!-- testing to see if the other icon shows - no ! -->
<link rel="icon" href="/doc/test/favicon.ico?v=<?php echo time() ?>" type="image/x-icon"/>
<!--
<script type="text/javascript" src="/doc/files/common/instantedithead.js"></script> 
-->
<script src="jquery.min.js"></script>
<script type="text/javascript" src="tipped/tipped.js"></script>
<link rel="stylesheet" type="text/css" href="tipped/tipped.css" />
<script src="clipboard.js/dist/clipboard.min.js"></script>



<style>
body {
    background-image: url("favicon.bmp");
    background-repeat: repeat;
}

.newspaper
{
-webkit-column-count:3; /* Chrome, Safari, Opera */
-moz-column-count:3; /* Firefox */
column-count:3;
}

<?php
if($CurrOS=="Linux")
{
?>

.winlink{
    text-decoration:none;
    color: #c5c;
   pointer-events: none;
   cursor: default;
}

.winlink img {
	-webkit-filter: blur(2px);
}

<?php
}
else
{
?>


.linuxlink{
    text-decoration:none;
    color: #95c;
   pointer-events: none;
   cursor: default;
}

.linuxlink img {
	-webkit-filter: blur(2px);
}

<?php
}
?>


input[type="text"] {
     width: 100%;
     box-sizing: border-box;
     -webkit-box-sizing:border-box;
     -moz-box-sizing: border-box;
}


.crop {
    width: 800px;
    height: 600px;
    overflow: hidden;
}


.crop img {
    width: 1280px;
    height: 768px;
    margin: -75px 0 0 -100px;
}

img {
    opacity: 0.8;
}
iframe {
    margin: 0;
    padding: 0;
    border: none;
    opacity: 1;  /* 0.6 */
}

#other {
    position: absolute;
    top: 0px;
    right: 0px;
    background: yellow; /* this is just to make the frames easier to see */
    height: 36px;
}

#fixed-div {
    position: fixed;
    top: 5em;
    right: 1em;
}

#fixed-div-top {
    position: fixed;
	font-size: 400%;
    top: -26px;
    left: 50px;
    color:orange;
    opacity: 0.2;
    z-index: -1;
}

.editText { 
    width: 80%; 
	display: block;

} 


.checkbox_wrapper{
	position: relative;
	height: 16px;
    width: 60px;    /* give enough space for the checkbox and the label */
	float:left;
}
/*   run   */

.run_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.run_box + label{
    background:url('../images/run-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.run_box:checked + label{
    background:url('../images/run-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   hlp   */

.hlp_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.hlp_box + label{
    background:url('../images/help-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.hlp_box:checked + label{
    background:url('./images/help-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   pdf   */

.pdf_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.pdf_box + label{
    background:url('./images/pdf-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.pdf_box:checked + label{
    background:url('./images/pdf-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   pty   */

.pty_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.pty_box + label{
    background:url('./images/putty-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.pty_box:checked + label{
    background:url('./images/putty-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   ssh   */

.ssh_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.ssh_box + label{
    background:url('./images/putty-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.ssh_box:checked + label{
    background:url('./images/putty-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   ver   */

.ver_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.ver_box + label{
    background:url('./images/version-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.ver_box:checked + label{
    background:url('./images/version-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   ftp   */

.ftp_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.ftp_box + label{
    background:url('./images/totalcommander16ftp-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.ftp_box:checked + label{
    background:url('./images/totalcommander16ftp-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   cd   */

.cd_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.cd_box + label{
    background:url('./images/totalcommander16-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.cd_box:checked + label{
    background:url('./images/totalcommander16-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}


/*   regedit   */

.reg_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.reg_box + label{
    background:url('./images/regedit-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.reg_box:checked + label{
    background:url('./images/regedit-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   build   */

.bld_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.bld_box + label{
    background:url('./images/build-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.bld_box:checked + label{
    background:url('./images/build-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   embed web page   */

.bed_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.bed_box + label{
    background:url('./images/iFrame16-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.bed_box:checked + label{
    background:url('./images/iFrame16-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   winscp   */

.scp_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.scp_box + label{
    background:url('./images/winscp16-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.scp_box:checked + label{
    background:url('./images/winscp16-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   iexplore   */

.ie_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.ie_box + label{
    background:url('./images/iexplore16-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.ie_box:checked + label{
    background:url('./images/iexplore16-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}


/*   code   */

.cod_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.cod_box + label{
    background:url('./images/code-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.cod_box:checked + label{
    background:url('./images/code-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

/*   jira   */

.jir_box {
    opacity:0;
    height: 16px;
    width: 17px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
}

.jir_box + label{
    background:url('./images/jira16-unchecked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.jir_box:checked + label{
    background:url('./images/jira16-checked.png') no-repeat;
    height: 16px;
    width: 17px;
    display:inline-block;
    padding: 0 0 0 0px;
}

</style>

<script>
var closeAlert;
function getFileFromServer(url, doneCallback) {
    var xhr;

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = handleStateChange;
    xhr.open("GET", url, true);
    xhr.send();

    function handleStateChange() {
        if (xhr.readyState === 4) {
            doneCallback(xhr.status == 200 ? xhr.responseText : null);
        }
    }
}

function show(text_in_div, objet, ii, bulle) {

  text_in_div="<pre>"+text_in_div+"</pre>";
  Tipped.create("#"+bulle+ii, text_in_div);
  if(document.getElementById('message5sec')) {
    document.getElementById('message5sec').innerHTML=text_in_div;
	}
  else
    console.log("is null "+ objet.href + " text " + text_in_div + " ii " + ii);
}

function show_no_id(text_in_div, bulle) {
  Tipped.create("#"+bulle, text_in_div);
}

function show_write(text) {
  //alert(text);
}

function yesClicked() {
obj=document.getElementById("customdiv");
if (typeof obj === 'undefined') {
    // obj is undefined
} else {
  obj.parentNode.removeChild(obj);
  winref = window.open('', '_raw'+"_<?php echo $prjname; ?>", '', true);
  winref.close();
  }
//alert("yes");
}

function noClicked() {
obj=document.getElementById("customdiv");
if (typeof obj === 'undefined') {
    // obj is undefined
} else {
  obj.parentNode.removeChild(obj);
  winref = window.open('', '_raw'+"_<?php echo $prjname; ?>", '', true);
  winref.focus();
  }
}

var ICEcoderWin;

function EditorIsNowOpened (file) {
	alert("coucou");
	//ICEcoderWin.open_editor_path(file);
}


function openOnce(url, target, file){

    if (file=="") { // open but hide the window
      ICEcoderWin = window.open('', target, 'width=1200,height=640,toolbar=no,menubar=no,location=no,status=no,scrollbars=no,resizable=no,left=10000,top=10000,visible=none, width=10, height=10', true);
      //// I don't know how to hide it so let's minimize it
      ////ICEcoderWin.resizeTo(10,10);
      ICEcoderWin.moveTo(-10000,-10000);
      //setTimeout(function(){ ICEcoderWin.close(); }, 3000);
      //setTimeout(function(){ ICEcoderWin.alert(ICEcoderWin.name); }, 3000);  //editor

    } else {
      ICEcoderWin = window.open('', target, 'width=1200,height=640,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50', true);
      ICEcoderWin.resizeTo(1200,640);
      ICEcoderWin.moveTo(100,50);
    }

	//ICEcoderWin.onload = function() { ICEcoderWin.editorCallBack = EditorIsNowOpened; };
	//ICEcoderWin.onload = function() { alert("tutu"); };
	//ICEcoderWin.addEventListener('DOMContentLoaded', function() { alert("tutu"); }, false);
	//TODO il n y a rien qui marche, faire example dans projet separer pour detecter qu'une fenetre a fini de loader

    // if the "target" window was just opened, change its url
    if(ICEcoderWin.location.href === 'about:blank'){
        ICEcoderWin.location.href = url;
    }
	
	
    //ICEcoderWin.open_editor_path(file);
    setTimeout(function(){ ICEcoderWin.open_editor_path(file); }, 2000);

	// test go to line 3
	//window.top.ICEcoder.goToLine(3);
	//ICEcoderWin.goToLine(3);
    return ICEcoderWin;
}

function onradioclick(val) {

//console.log('onradioclick clicked');
  document.getElementById('cmdinput').value=val;
  document.forms['fform'].submit();
  //thiswin=this;
  // create a message box that lives 15sec
  customAlert("&nbsp;Raw output tab ? <button onClick='yesClicked();'>Close</button> <button onClick='noClicked();'>Keep</button> <br/><small>&nbsp;If no answer in 15 sec it's going to be Close</small>","15000",'400','10');
  winrefCurrent = window.self;
  currloc=winrefCurrent.location;

//console.log('This window is not focused because of the submit fform to prompt-action.php');
  // focus back on the current window after 2 sec
  focusBack=window.setInterval(function () {
//console.log('started setInterval of 2 sec to focus back on this window. But this does not break');
	winrefCurrent.focus();			// not working
//console.log('focus failed?');
    //alert("focusBack to " + winrefCurrent.location);				// I didn't find a better way to focus back
    clearTimeout(focusBack);
  }, 2000);

  /*
  // earlier code with javascript confirm box that cannot be closed with javascript
  closeAlert=window.setInterval(function () {
    ret=window.confirm("Close ?");
    winref = window.open('', '_raw'+"_<?php echo $prjname; ?>", '', true);
    if(ret) {
      winref.close();
    } else {
      // winref.document.write("Closed"); this overwrite the content
	  winref.focus();		// does not work, does not bring the tab in front
	  winref.focus();
    }
    clearTimeout(closeAlert);
  }, 2000);
  */

}
</script>

<?php


function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

/*
$notrack=@file_get_contents($proj_dir."/.cknotrack");

		// read last line of .time
$timeFromFile="";
$timeFromFileLast="";
$timestamp=0;
if($notrack!="checked")
  {
  $file = fopen($proj_dir."/.time","a+");
  while(0)
    {
    $timeFromFileLast=$timeFromFile;
    $timeFromFile= fgets($file);
    }
//  fclose($file);

  if (strpos($timeFromFileLast,'NaN') != false) {
      echo "NaN issue<br/>\n";
      exit();
  }

  if($timeFromFileLast=="") {
    //echo "no file .time<br/>\n";;
    $timeFromFileLast="0";
    $date = date_create();
    //echo date_format($date, 'U = Y-m-d H:i:s') . "\n";
    $timestamp=date_format($date, 'U');
    $str="0,".$timestamp.",".get_client_ip().",from-open-command-prompt-here-php\n";
	if (strpos($str,'NaN') == false) {
      file_put_contents($proj_dir."/.time", $str, FILE_APPEND | LOCK_EX);
      } else {
      echo "NaN issue<br/>\n";
	  exit();
	  }
    }
  $pos=strpos($timeFromFileLast,",");
  $timeFromFileLast=substr($timeFromFileLast, 0, $pos);
  } else {
    if(file_exists($proj_dir."/.time")) {
      unlink($proj_dir."/.time");
      }
  }
*/
?>

<script>

<?php
if($notrack=="checked") {
  echo "notrack=true;\n";

} else {
  echo "notrack=false;\n";

}

?>

<!--
//alert(notrack);
var time,timeSite;
window.onload=function(){
 time=new Date();

 //alert("time="+time);
}
-->



totalIsNan=false;

window.onbeforeunload=function(){
// alert are blocked here
 timeSite=new Date()-time;
 timeSite/=1000;  // in sec
 total=parseInt(window.localStorage['<?php echo $id_link; ?>']);

if(isNaN(total)) {
  totalIsNan=true;
  console.log("totalIsNan 1");
}

 totalBeforeIncrement=total;
 console.log("time stored in localStorage: "+totalBeforeIncrement);
 totalFromFile=<?php echo $timeFromFileLast.";"; ?>
 console.log("time read from file .time: "+totalFromFile);

 if (totalFromFile != totalBeforeIncrement) {
   total= Math.max(totalFromFile, totalBeforeIncrement);
if(isNaN(total)) {
  totalIsNan=true;
  console.log("totalIsNan 2");
  }
   console.log("total maxed of "+totalFromFile+" and "+totalBeforeIncrement);
   if(isNaN(total)) total=0;
 }

 total+=timeSite;
if(isNaN(total)) {
  totalIsNan=true;
  console.log("totalIsNan 3");
  }
 total=parseInt(total);
if(isNaN(total)) {
  totalIsNan=true;
  console.log("totalIsNan 4");
  }
if(isNaN(total)) totalIsNan=true;
 window.localStorage['<?php echo $id_link; ?>']=total;



        var xmlhttp;        //Make a variable for a new ajax request.
        if (window.XMLHttpRequest)        //If it's a decent browser...
        {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();        //Open a new ajax request.
        }
        else        //If it's a bad browser...
        {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");        //Open a different type of ajax call.
        }
		if(!isNaN(total)) {
			var url = "time.php?target=<?php echo $proj_dir."/.time"; ?>&time="+total;        //Send the time on the page to a php script of your choosing.
			xmlhttp.open("GET",url,false);        //The false at the end tells ajax to use a synchronous call which wont be severed by the user leaving.
			xmlhttp.send(null);        //Send the request and don't wait for a response.
			}
}

</script>

<script>
gfaddlink="";
function onInputChg(val) {
  if (val!=gfaddlink) {
    document.faddlink.submit();
  }
  gfaddlink=val;
}

gfaddedit="";
function onInputChgEdit(val) {
  if (val!=gfaddedit) {
    document.faddedit.submit();
  }
  gfaddedit=val;
}

gfaddclip="";
function onInputChgClip(val) {
  if (val!=gfaddclip) {
    document.faddclip.submit();
  }
  gfaddclip=val;
}

gfaddsound="";
function onInputChgSound(val) {
  if (val!=gfaddsound) {
    document.faddsound.submit();
  }
  gfaddsound=val;
}

</script>



<script>
function customAlert(msg,duration, left, top)
{
 var styler = document.createElement("div");
  styler.setAttribute("style","border: solid 5px Red;background-color:#444;color:Silver;  position:fixed; left:"+left+"px; top:"+top+"px;");
  styler.setAttribute("id","customdiv");
 styler.innerHTML = "<h4>"+msg+"</h4>";
 setTimeout(function()
 {
   yesClicked();
   styler.parentNode.removeChild(styler);
 },duration);
 document.body.appendChild(styler);
}

var admin_array_added = false;
 <?php
 if(file_exists($dir."/.cliptab")) 
 {
	echo " var arr_admin = ";
	echo @file_get_contents($dir."/.cliptab");
 }
 else
	{
		echo " var arr_admin = ";
		echo "[\n";
		echo "['no .cliptab in this project', 'no .cliptab in this project']";
		echo "]\n";
	}
 ?>;
 
 
function bindme(id, mode) {
    //alert('bindme'+' id is '+id);
    if (mode==1) {
      valToClip=document.getElementById(id).value;
    //alert(valToClip);
      document.getElementById(id).setAttribute('data-clipboard-text', valToClip);
    //alert(document.getElementById(id).getAttribute('data-clipboard-text'));	//OK
    //var clipboard = new ClipboardJS('#'+id, { text: function() { return document.getElementById(id).value;  } });
    }
    
    var clipboard = new ClipboardJS('#'+id, { text: function() { return document.getElementById(id).getAttribute('data-clipboard-text');  } });
    
    if(mode==0) {
      setTimeout(function(){ console.log("copied in clipboard")},1000);
      document.getElementById(id).style.backgroundColor = 'lightgray';
    } 

}


function customAlertRight(msg,duration, right, top)		// http://mlerman-lap/s/W
{
 var styler = document.createElement("div");
  styler.setAttribute("style","border: solid 5px Red;background-color:#444;color:Silver;  position:fixed; right:"+right+"px; top:"+top+"px;");
  styler.setAttribute("id","customdivright");
  if(msg!="") styler.innerHTML = "<h4>"+msg+"</h4>";
 setTimeout(function()
 {
   styler.parentNode.removeChild(styler);
   admin_array_added = false;
 },duration);
 document.body.appendChild(styler);

// MIKHAELL_TEST_CLIPBOARD
 if (!admin_array_added)
 {
   for(ii=0; ii<arr_admin.length; ii++)
   {
     document.getElementById('customdivright').innerHTML +="<br/>&nbsp;<span id='copy_button_admin_"+ii+"' data-clipboard-text='"+arr_admin[ii][0]+"' title='copy to clipboard' style='cursor:pointer'  onmouseover='this.style.backgroundColor=\"white\"' onclick='bindme(this.id, 0);'><img src=\"./images/copyclip.png\"/>&nbsp;"+arr_admin[ii][1]+"</span>";
   }
   admin_array_added=true;
 }  
}

</script>

<script type="text/javascript">
  $(document).ready(function() {
    Tipped.create('.inline');
  });
  
  
function openIceCoderWin() {

    //if (ICEcoderWin == undefined) alert("undefined");
    //else alert ("OK");
    //ICEcoderWin = window.open('/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/', "editor", 'width=1200,height=640,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50', true);

//openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor","");

}  
  
</script>



</head>
<!-- was onload="gfaddlink=document.getElementById('idfaddlink').value" -->

<body onload="document.getElementById('idfaddlink').value=''; openIceCoderWin();">
<script> 
setVarsForm("pageID=profileEdit&userID=11&sessionID=<?php echo $urldir;?>"); 
</script> 

<script>
function getLastProject()
{
getFileFromServer('/local/recentfirst.php', function(text){ 
  var arr=text.split("href=");
  var arr2=arr[2].split('"');
  var elem=document.getElementById("lastrecentproj");
  elem.href=arr2[1];
  //find the project name
  var n = arr2[1].lastIndexOf("/");
  var str=arr2[1].substring(0, n);
  n = str.lastIndexOf("/");
  str=str.substring(n+1);
  elem.title="recent : "+str;
  elem.setAttribute('target', str);
  
  elem=document.getElementById("lastrecentproj2");
  elem.href=arr2[1];
  elem.title="recent : "+str;
  elem.setAttribute('target', str);
  
  //alert(str);
  });
}
</script>

<a href="http://<?php echo $linkip; ?>"><img src="./images/adresse-ip.png"/></a>&nbsp;
<a href="http://<?php echo $linkname; ?>"><img src="./images/adresse-name.png"/></a>&nbsp;
<?php
if ($icon_run!="") {
  echo "&nbsp;".$icon_run."&nbsp;";
}
?>
<?php
if($CurrOS!="Linux")
{
  $dirp="perma";
  $file="ui_total_commander.run";
  echo '&nbsp;<a class="winlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dir).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirp).'" '.$onmouseover.'  onclick="this.href=this.href+\'&param1=\'+document.getElementById(\'inpf\').value.replaceAll(\'\\\\\',\'`\');" ><img src="./images/totalcommander16.png" title="Total commander" /></a>';  
} else
{
	$dirpm="permalinux";
	$file="krusaderHere.rn";
	echo '<a class="linuxlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dir).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirpm).'"  onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, -1)});"><img src="./images/krusader16.png" title="krusader" /></a>';
}
?>
<!-- top links http://mlerman-lap/s/O -->
&nbsp;<a href="http://<?php echo $clienthost; ?>/doc/elfinder.html" id="homelink" target="elfinder"><img src="./images/home.png" title="Go to <?php echo $clienthost; ?> elfinder" id="hometitle" /></a>&nbsp;
&nbsp;<a href="zipfolder.php?fname=<?php echo $prjname; ?>&targetdir=<?php echo realpath($dir); ?>&debug=12345678"><img src="./images/compress-icon.png" title="Download this folder zipped"/></a>&nbsp;
<!--
&nbsp;<a href="/doc/files/common/env.php&targetdir=<?php echo $dir; ?>" target="env" onclick="javascript:void window.open('/doc/files/common/env.php?targetdir=<?php echo $dir; ?>','1481656702602','width=1500,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/Programming-Variable-icon16.png" title="Manage environment variables" /></a>
-->
&nbsp;<a href="env.php&targetdir=<?php echo $dir; ?>" target="env" onclick="javascript:void window.open('frename.php?targetdir=<?php echo $dir; ?>','1481656702602','width=800,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/Programming-Variable-icon16.png" title="Manage file names" /></a>
&nbsp;<a href="http://<?php echo $clienthost.$dir_loc; ?>/../_constructor/open-command-prompt-here.html" target="_constructor"><img src="./images/constructor.ico" title="Go to _constructor" /></a>&nbsp;
&nbsp;<a href="/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/frequent_copy_paste/" target="chartime" onclick="javascript:void window.open('/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/frequent_copy_paste/','1481656702602','width=800,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/copyclip.png" title="frequent copy paste" /></a>
&nbsp;<a href="/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/Codiad/?name=<?php echo $prjname; ?>&path=<?php echo $proj_dir; ?>" target="codiad" onclick="javascript:void window.open('/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/Codiad/?name=<?php echo $prjname; ?>&path=<?php echo $proj_dir; ?>','1481656702602','width=800,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/codiad16.png" title="CODIAD editor" /></a>
&nbsp;<a href="<?php echo $urldir; ?>"><img src="./images/chrome16.png" title="index.html" /></a>
<?php
$githuburl="https://github.com/mlerman/WIN10LAP/tree/master".$display_link;
?>
<?php 
$code='';
if (file_exists($dir."/.code")) { 
    $code = @file_get_contents($dir."/.code");
    $code = str_replace("\\","\\\\",$code);
  } 
?>

&nbsp;<a href="env.php&targetdir=C:/UniServer/www/doc/files/common/global_settings" target="env" onclick="javascript:void window.open('env.php?targetdir=C:/UniServer/www/doc/files/common/global_settings','1481656702602','width=1800,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/Programming-Variable-icon16.png" title="Manage environment variables" /></a>
<!--
&nbsp;<a href="https://confluence.microchip.com/pages/viewpage.action?pageId=319526555" target="confluence" onclick="javascript:void window.open('https://confluence.microchip.com/pages/viewpage.action?pageId=319526555','1481656702602','width=1100,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;">ML</a>
-->
&nbsp;<a href="javascript:alert('onclick event sometimes was not fired');" target="shorturl" onclick="window.open('/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/extplorer2-1-15/index.php?lang=english&homedir=<?php echo $proj_dir;?>','shortenanurl','width=1200,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/extplorer16.png" title="ExtPlorer" /></a>

&nbsp;<span><?php if (file_exists($dir."/.outtop")) { echo @file_get_contents($dir."/.outtop");} ?></span>

<br/>
<fieldset style="float: left;">

<fieldset style="float: left;">
<legend>&nbsp;<a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.previous&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>" ><img src="./images/notepad-plus-plus.gif"/></a>
        <a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "<?php echo $urldir; ?>.previous");  return false;'><img src="./images/text.png"/></a>
              <a href="jquery-fileTree/pickrelated.php?parent=<?php echo $display_link;?>&close=closePagePrevious" target="pickf" onclick="javascript:void window.open('jquery-fileTree/pickrelated.php?parent=<?php echo $display_link;?>&close=closePagePrevious','1481656702602','width=550,height=750,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/add_file.png"/></a>
        &nbsp;<img src="./images/Arrowprevious48.png"/> 
</legend>
<?php echo @file_get_contents($proj_dir."/.previous"); ?>
</fieldset>
<fieldset>
<legend>&nbsp;<a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.next&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>"><img src="./images/notepad-plus-plus.gif"/></a>
        <a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "<?php echo $urldir; ?>.next");  return false;'><img src="./images/text.png"/></a>
              <a href="jquery-fileTree/pickrelated.php?parent=<?php echo $display_link;?>&close=closePageNext" target="pickf" onclick="javascript:void window.open('jquery-fileTree/pickrelated.php?parent=<?php echo $display_link;?>&close=closePageNext','1481656702602','width=550,height=750,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/add_file.png"/></a>
        &nbsp;<img src="./images/Arrownext48.png"/> 
</legend>
<?php echo @file_get_contents($proj_dir."/.next"); ?>
</fieldset>

<h1 class="inline" id="idh1" onmouseover="getFileFromServer('.brief', function(text){ show(text, this, 1, 'idh')});">
<script>
function adjust_target()
{
  

// show the frame name
if (window.name!="<?php echo $prjname; ?>") 
{
  //alert("current : " + window.name + " parent : " + parent.window.name + " closing current window");
  window.close();
}
window.open('<?php echo $urldir; ?>open-command-prompt-here.html','<?php echo $prjname; ?>');

//TODO sometimes it shows _constructor need to find the root cause
// peut etre s'ouvre dans des tab different car ils ont des parent different
}

function debug()
{

alert(  'current : ' + window.name 
      + ' \n$prjname : <?php echo $prjname?>'
      + ' \n$link : <?php echo $link?>'
      + ' \n$display_link : <?php echo $display_link?>'
      + ' \n$dir : <?php echo $dir?>'
      + ' \n$dir_loc : <?php echo $dir_loc?>'
      + ' \n$proj_dir : <?php echo $proj_dir?>'
      + ' \n$proj_dir_lin : <?php echo $proj_dir_lin?>'
      + ' \n$clienthost : <?php echo $clienthost?>'
      + ' \n$urldir : <?php echo $urldir?>' 
      + ' \n$urldirpapa : <?php echo $urldirpapa?>'
      + ' \n$_SERVER["HTTP_HOST"] : <?php echo $_SERVER["HTTP_HOST"]?>'
      + ' \n$_SERVER["REQUEST_URI"] : <?php echo $_SERVER["REQUEST_URI"]?>'
      + ' \nwindow.screen.availHeight : ' + window.screen.availHeight
      + ' \nwindow.screen.availWidth : ' + window.screen.availWidth
	  );
/*
    //  + ' \n$_GET["reqfname"] : <?php echo $_SERVER["reqfname"]?> (.htaccess)'
    //  + ' \n$_GET["requri"] : <?php echo $_SERVER["requri"]?> (.htaccess)'
	  //
      //+ ' \nICEcoderWin.global_var : ' + ICEcoderWin.global_var	// ca ne marche pas, ICEcoderWin est undefined
	  
	  );
	  //call a function fron editor.php if defined
	  //ICEcoderWin.editor_php_func();
*/
}

</script>
<!--a href="<?php echo $urldir; ?>open-command-prompt-here.html" target="<?php echo $prjname; ?>" title="Re-open in tab target <?php echo $prjname; ?>"><?php echo $prjname; ?></a-->
<?php echo $prjname; ?>
&nbsp;<span id="copy-button-2" data-clipboard-text="<?php echo $prjname; ?>" title="copy project name to clipboard" onmouseover="this.style.backgroundColor = 'white'" onclick='bindme(this.id, 0);'><img src="./images/copyclip.png"/></span>
&nbsp;<a href="/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/d3_directed_graph/project_graph.php?target=<?php echo $urldir; ?>" onclick="javascript:void window.open('/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/d3_directed_graph/project_graph.php?target=<?php echo $urldir; ?>','1481602525735','width=980,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" ><img src="./images/digraph.gif" /></a>
&nbsp;<span onclick="debug();"><img src=../images/debug.png /></span>
&nbsp;<span onclick="adjust_target();" id="animreload" style="display:none"><img src=../images/loader_grayblue.gif /></span>

<script>
var prjname="<?php echo $prjname; ?>";

<?php 
if($param1!="") echo "var param1=\""; 
$param1_q = strpos($param1, ' ') ? '"' . $param1 . '"' : $param1; // put quotes if contains space
$param1_q = str_replace(PHP_EOL, '', $param1_q);	// remove newline
echo $param1_q; 
if($param1!="") echo "\";"; 
 ?>
</script>
</h1>


<fieldset style="float: left;">
<legend>Attribute: </legend>
<input type="checkbox" name=".ckbuild" <?php echo @file_get_contents($proj_dir."/.public"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.public"; ?>&value='+this.checked, function(text){ show_write(text)});"> Public<br/>
<input type="checkbox" name=".ckbuild" <?php echo @file_get_contents($proj_dir."/.core"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.core"; ?>&value='+this.checked, function(text){ show_write(text)});"> Core<br/>
<input type="checkbox" name=".ckbuild" <?php echo @file_get_contents($proj_dir."/.lfiles"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.lfiles"; ?>&value='+this.checked, function(text){ show_write(text)});"> lfiles<br/>
<input type="checkbox" name=".ckpfunc" <?php echo @file_get_contents($proj_dir."/.ckpfunc"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckpfunc"; ?>&value='+this.checked, function(text){ show_write(text)});"> Experimental<br/>
<input type="checkbox" name=".ckffunc" <?php echo @file_get_contents($proj_dir."/.ckffunc"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckffunc"; ?>&value='+this.checked, function(text){ show_write(text)});"> Fully functional<br/>
</fieldset>


<fieldset style="float: left;">
<legend>&nbsp;<a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.related&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>"><img src="./images/notepad-plus-plus.gif"/></a>
    <a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "<?php echo $urldir; ?>.related");  return false;'><img src="./images/text.png"/></a>
              <a href="jquery-fileTree/pickrelated.php?parent=<?php echo $display_link;?>&close=closePage" target="pickf" onclick="javascript:void window.open('jquery-fileTree/pickrelated.php?parent=<?php echo $display_link;?>&close=closePage','1481656702602','width=550,height=750,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/add_file.png"/></a>
        &nbsp;<small>(.related)</small> Related: 
</legend>
<?php echo @file_get_contents($proj_dir."/.related"); ?>
</fieldset>


</fieldset>
<?php
//echo $urldir."<br/>\n";

if ($no_favicon)     echo "&nbsp;<a href=\"https://www.google.com/search?q=".$prjname."&biw=1680&bih=943&tbm=isch&source=lnt&tbs=isz:ex,iszw:48,iszh:48\">No favicon.ico, find one</a>\n";
?>



<fieldset>
<legend>&nbsp;<a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.head&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>"><img src="./images/notepad-plus-plus.gif"/></a> 
        <a href="do.php?&targetdir=<?php echo realpath($dir); ?>&targetfile=.head" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "<?php echo $urldir; ?>.head");  return false;'><img src="./images/text.png"/></a>
		&nbsp;<a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.head&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>&before=addhr"><img src="./images/embedicon.png"/></a> 
              <small>(.head)</small> Notes: 
</legend>
<pre>
<!-- id is the fieldname in instantedithead.js l'id contient le path du fichier -->
<span id="<?php echo $proj_dir;?>/.head" class="editText">
<?php 
if (file_exists($proj_dir."/.head"))
{
if ( 0 == filesize( $proj_dir."/.head" ) ) 
    echo "..."; 
else 
    echo @file_get_contents($proj_dir."/.head"); 
}
else
    echo "......"; 
?></span> 
</pre>
</fieldset>



<?php
$escaped_link_cut.="favicon.ico";

$file_data = '<a href="delete_line_in_recent.php?line='.uniqid().'" onclick="delEntry(this.href); return false;"><img src="./images/delete.png"/></a>&nbsp;<a href="'.$dir_loc.'/open-command-prompt-here.html" target="'.$prjname.'"><img src="'.$dir_loc.'/favicon.ico"  height="16" width="16"/>'.$display_link.'</a>'.$icon_run."<br/>\n";
$ignorebefore=109;


$frecent='/UniServer/www/local/recent.txt';
if(!is_file($frecent)) {
        fclose(fopen($frecent,"x")); //create the file and close it
    }

$f = fopen($frecent, 'r');
$firstline = fgets($f);
fclose($f);

if(substr($file_data,$ignorebefore)!=substr($firstline,$ignorebefore)) {		// only new location. If we do refresh it would not add

  $file = '/UniServer/www/local/recent.txt';
  $fh = fopen($file, 'r') or die('Could not open file: '.$file);

  $i = 0;
  $content=$file_data;		// most recent project
  while (!feof($fh)) {
    $buffer = fgets($fh);

     if (substr($buffer, $ignorebefore) == substr($file_data,$ignorebefore)) {
     //echo $buffer." skiped<br/>\n";
     }  else {
     //echo $buffer."<br/>\n";
     $content.=$buffer;
     }
   $i++;
  }
  fclose($fh);
  file_put_contents($file, $content);
  }

?>

<h1 style="clear: both;" ></h1>

<table width="100%" style="clear: both;">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><strong>Command</strong></td>
    <td><hr /></td>
  </tr>
</table>

<img src="./images/command_promt-16.png" title="Run a command or input PARAM1" style="float: left;" /><span style="float: left;">&nbsp;</span>
<form name="fform" id="f1" action="prompt-action.php" method="get" style="display: inline; float: left;" target="_raw_<?php echo $prjname; ?>">
	<table align="left" valign="top" width="100%" border="0"><tbody>
	<tr>
		<td>
			<input type="text" name="cmd" id="cmdinput" size="100">
			<input type="hidden" name="rawdisplay" value="1">
		</td>
	</tr>
	</tbody></table>
</form>
<input type="submit" value="Run" onclick="return OnButtonRun();" />
<input type="submit" value="Save" onclick="return OnButtonRunSave();" />
<a href="#view" onclick="location.reload(true);"><img src="./images/eye.gif"/></a>
<input type="submit" value="goto new" id="gotonew" onclick="OnGotoNew();"/>

<script type="text/javascript">

function OnGotoNew()
{
var cmdin=document.getElementById("cmdinput").value;
if(cmdin.indexOf("new ") == 0) {
  var str=cmdin.substring(4);
  window.location="<?php echo $urldirpapa;?>/"+str+"/open-command-prompt-here.html";
}
return true;
}



function OnButtonRun()
{
	window.open('', 'runThisOnServer', 'width=600,height=800,resizeable,scrollbars');
	document.fform.target = 'runThisOnServer';
    document.fform.action = "prompt-action.php"
    document.fform.submit();             // Submit the page
    return true;
}

function OnButtonRunSave()
{
    document.fform.action = "prompt-action-save.php"
    document.fform.submit();             // Submit the page
    return true;
}


function AddFile(id)
{
var newfn=document.getElementById(id).value
location.href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo str_replace('\\', '/', realpath($dir)); ?>&targetfile="+newfn+"&perma=<?php if($CurrOS!='Linux') echo str_replace('\\', '/', realpath('perma')); else echo str_replace('\\', '/', realpath('permalinux')); ?>";

}
</script>

<script>
function psexec(phpfile) {
//alert(phpfile);
    $.get(phpfile);
    return false;
}
</script>


<table width="100%" style="clear: both;">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=specific-here.inc&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>"><img src="./images/notepad-plus-plus.gif"/></a>
    <a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "<?php echo $urldir; ?>specific-here.inc");  return false;'><img src="./images/text.png"/></a>
	&nbsp;<strong>Saved commands specific to this &#34;<script>document.write("<?php echo $prjname; ?>");</script>&#34; project </strong><small>(stored in web page, see specific-here.inc, runs on Windows server)</small></td>
    <td><hr /></td>
  </tr>
</table>


<?php
if (file_exists($dir.'/'."specific-here.inc"))
{
  $handle = fopen($dir.'/'."specific-here.inc", "r");
  if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
		$line_body=$line;
		$pos=strpos($line_body, '&::');
		if ( $pos !== FALSE) {
			$line_body = str_replace('&::', '<span style="color:green;">&::', $line_body);
			$line_body = $line_body."</span>";
		}
	  	echo "<input type='radio' name='cb' value='".$line."' onclick='onradioclick(this.value);'  />".$line_body."<br/>";
     }
  } else {
    // error opening the file.
  }
  fclose($handle);
}
?>

<table width="100%" style="clear: both;">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><a href="#view"><span><img src="./images/eye.gif"></span></a>&nbsp;<img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" /></span>&nbsp;<strong>Frequent Edit</strong>&nbsp;<a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.recentedit&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>"><img src="./images/notepad-plus-plus.gif" title="Edit this section"/></a>
	    <a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "<?php echo $urldir; ?>.recentedit");  return false;'><img src="./images/text.png"/></a>
<script>
function recentedit_plus() {
// rajouter le contenu de l'input field inpg
var search_or_line_number = document.getElementById('inpg').value;
//alert(search_or_line_number);
window.open('jquery-fileTree/pickrecentedit.php?drive=c&param1='+search_or_line_number+'&parent=<?php echo $display_link;?>&headpath=:/UniServer/www/doc/files','1481656702602','width=550,height=750,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');
}
</script>
		&nbsp;<a href="jquery-fileTree/pickrecentedit.php?drive=c&parent=<?php echo $display_link;?>&headpath=:/UniServer/www/doc/files" target="pickf" onclick="recentedit_plus(); return false;"><img src="./images/add_file.png" title="C:\"/></a>
	<!--
	&nbsp;&nbsp;<a href="/doc/files/common/jquery-fileTree/pickrecentedit.php?drive=//&parent=<?php echo $display_link;?>&headpath=mlerman-vm-mint/lfiles" target="pickf"><img src="./images/add_file.png" title="M:\"/></a> 
	-->
	<small>Search string or line number:</small>&nbsp;<input size="6" id="inpg"/>
	</td>
    <td><hr /></td>
  </tr>
</table>
<img src="./images/EditData16.png" title="Drag and drop full file path in this field" style="float: left;" /><span style="float: left;">&nbsp;</span>
<form name="faddedit" method="get" action="addedit.php"  style="float: left;" >
<input type="text" name="path" id="dropedit" onmouseout="onInputChgEdit(this.value)" onblur="onInputChgEdit(this.value)" size="200" />
<input type="hidden" name="parent" value=<?php echo $display_link;?> />
</form>
<br/ style="clear: both;">
<div id="fedit">
<?php echo @file_get_contents($proj_dir."/.recentedit"); ?>

<?php
if($CurrOS=="Linux")
{
?>
<script>
$('#fedit a').each(function () {
    var $this = $(this),
        href = $this.attr('href');
		if(href.indexOf("ui_edit_this.run") != -1) { 
			href=href.replace("ui_edit_this.run","edit_this.rn");
			//common\perma
			href=href.replace("common\\perma","common\\permalinux");
			//alert(href);
			$this.attr('href', href);
		}
})
</script>
<?php
}
?>
<small>raccourci notepad++: &amp;param1=search/string ou &amp;param1=numeroDeLigne</small>

</div>

<?php
//if ($feu!="") echo "feu is ===".$feu."===<br/>";
//echo 'FEU is ' .$_ENV["FEU"];
if ($feu!="") {
?>
<a name="feu"></a>
<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><span><a href="#view"><span class="winlink" ><img src="./images/eye.gif"></span></a>&nbsp;<img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" />&nbsp;<strong>Formatted external URL </strong></span></td>
    <td><hr /></td>
  </tr>
</table>

<?php
  echo '<iframe src="'.$feu.'" width="100%" height="600px"></iframe>';
}
?>

<?php
if ( file_exists("/UniServer/www".$dir_loc."/scr1.png"))
{
?>
<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;">
      <span>
	<a href="#view"><span class="winlink" >
	  <img src="./images/eye.gif"></a>
	  </span>
	  &nbsp;<img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" />
	  &nbsp;
	  <strong>
	    <a nohref="" style="cursor:pointer" onclick="window.open('/doc/files//Engineering/ENVIRONMENT/PHP_SERVER/Image-Gallery-From-Folder-PHP/index.php?HOME_DIRECTORY=<?php echo $proj_dir;?>','gallery','width=1200,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;">Screenshots</a>
	  </strong>
      </span>
    </td>
    <td><hr /></td>
  </tr>
</table>
<?php
  echo "<div>";
  echo "</div>";
}
?>

<a name="view"></a>
<script>
function open_div_in_window()
{
var divText = document.getElementById("lightbluediv").outerHTML;
var divWindow = window.open('','','toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no, width=550, height=650');
var doc = divWindow.document;
doc.open();
doc.write(divText);
doc.close();
}
</script>
<!-- http://mlerman-lap/s/1t -->
<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;">
		<img src="./images/up.png" onclick="window.scrollTo(0, 0);" style="cursor:pointer" title="Scroll all the way up">
		&nbsp;<a href="#view"><img src="./images/eye.gif"></a>&nbsp;<a href="#feu"><img src="./images/link-icon.gif" onclick="location.reload(true);"></a>
	    &nbsp;<img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" />
		<img src="./images/detach16.gif" onclick="open_div_in_window();">
		&nbsp;<span class="winlink" >
		<strong>Interactive windows batch files in this &#34;<script>document.write("<?php echo $prjname; ?>");</script>&#34; project </strong>
		<small>(download and run local)</small>
		&nbsp;<input size="6" id="addf" value="ui_test.run"/><a href="#" onclick="AddFile('addf');"><img src="./images/add_file.png"></a>  
        <div class="checkbox_wrapper">
            <input type="checkbox" class="cd_box" name=".ckcd" <?php echo @file_get_contents($proj_dir."/.ckcd"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckcd"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;cd</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="run_box" name=".ckrun" <?php echo @file_get_contents($proj_dir."/.ckrun"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckrun"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;run</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="hlp_box" name=".ckhlp" <?php echo @file_get_contents($proj_dir."/.ckhlp"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckhlp"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;help</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="pdf_box" name=".ckpdf" <?php echo @file_get_contents($proj_dir."/.ckpdf"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckpdf"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PDF</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="pty_box" name=".ckpty" <?php echo @file_get_contents($proj_dir."/.ckpty"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckpty"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;serial</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="ssh_box" name=".ckssh" <?php echo @file_get_contents($proj_dir."/.ckssh"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckssh"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ssh</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="ver_box" name=".ckver" <?php echo @file_get_contents($proj_dir."/.ckver"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckver"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ver</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="ftp_box" name=".ckftp" <?php echo @file_get_contents($proj_dir."/.ckftp"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckftp"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ftp</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="reg_box" name=".ckreg" <?php echo @file_get_contents($proj_dir."/.ckreg"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckreg"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>regedit</small></label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="bld_box" name=".ckbld" <?php echo @file_get_contents($proj_dir."/.ckbld"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckbld"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;build</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="bed_box" name=".ckbed" <?php echo @file_get_contents($proj_dir."/.ckbed"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckbed"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;embed</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="scp_box" name=".ckscp" <?php echo @file_get_contents($proj_dir."/.ckscp"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckscp"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;winscp</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="ie_box" name=".ckbie" <?php echo @file_get_contents($proj_dir."/.ckbie"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckbie"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IE</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="cod_box" name=".ckcod" <?php echo @file_get_contents($proj_dir."/.ckcod"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckcod"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;code</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="jir_box" name=".ckjir" <?php echo @file_get_contents($proj_dir."/.ckjir"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckjir"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;jira</label>
        </div>
	<!--
	if you add a div here you need to update /doc/files/common/write_ckfile.php
	-->
	</span></td>
    <td><hr /></td>
  </tr>
</table>
<!-- http://mlerman-lap/s/S -->
<div class="newspaper" style="background-color: lightblue; opacity: 0.6" id="lightbluediv">
<?php
if($CurrOS=="Linux") echo "<small>Disabled because you are using ".$CurrOS."</small><br/>";
$dirperma="perma";
if ($handle = opendir($dir)) {
	$i=0;
    while (false !== ($file = readdir($handle))) {

        if ($file != '.' && $file != '..') {
			if(!is_dir($dir.'/'.$file)) {		// don't display directories
				$rest = strtoupper(substr($file, -4));
				if( /*($rest==".BAT") || */($rest==".RUN") || ($rest==".LNK")) {							// display only .bat files
					$admin=0;
					if (substr($file,0,3)=="ai_") $admin=1;
					if((substr($file,0,3)=="ui_")||($admin)||($rest==".LNK")) {			// only interactive commands
					if (file_exists ( $dir.'/.'.$file )) {	// prevent error messages in console 404 not found
							$onmouseover='onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, '.$i.', \'bulle\')});"';
					} else {
						$onmouseover='';
					}
					$onmouseover_view=  'onmouseover="getFileFromServer('  .  '\''.$file.'\''  .  ', function(text){ show(text, this, '.$i.', \'view\')});"';
					$str_bulle_icon_png="comment.png";
					if (file_exists ( $dir.'/.'.$file )) {
						if( strpos(@file_get_contents( $dir.'/.'.$file),"bad.jpg") !== false) {
							$str_bulle_icon_png="comment_bad.png";
						} else {
							$str_bulle_icon_png="comment_exist.png";
						}
					}
						echo '<a class="winlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dir).'&admin='.$admin.'" onclick="this.href=this.href+\'&param1=\'+document.getElementById(\'cmdinput\').value;"   >'.$file.'</a>'
							// to be debuged execute d'un coup
							.'&nbsp;<a id="view'.$i.'" class="inline" href="downloadfile.php?fname=ui_opencon.run&targetdir=C:/UniServer/www/doc/files/Engineering/ENVIRONMENT/PYTHON/interactive_web_shell_standalone&fnamecon='.$file.'&dircon='.realpath($dir).'&admin='.$admin.'" onclick="this.href=this.href+\'&param1=\'+document.getElementById(\'cmdinput\').value;"><img src="./images/command_promt-16.png" '.$onmouseover_view.' /></a>'
                            // was:
							//.'&nbsp;<a id="view'.$i.'" class="inline" href="/doc/files/common/prompt-action.php?cmd='.$file.'&targetdir='.$dir.'" onclick="javascript:void window.open(\'/doc/files/common/prompt-action.php?cmd='.$file.'&rawdisplay=1&targetdir='.$dir.'\',\'1481602525735\',\'width=980,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=150,top=50\'); return false;"><img src="./images/command_promt-16.png" '.$onmouseover_view.' /></a>'
							// to be debuged execute pas a pas
							.'&nbsp;<a id="view'.$i.'" class="inline" href="/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/shell/shell.php?fname='.$file.'&targetdir='.$dir.'" onclick="javascript:void window.open(\'/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/shell/shell.php?fname='.$file.'&targetdir='.$dir.'\',\'1481602525735\',\'width=980,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=150,top=50\'); return false;"><img src="./images/debug16.png" '.$onmouseover_view.' /></a>'
						// edit icon:
							.' <a class="winlink" href="downloadfile.php?fname=ui_edit_this.run&targetdir='.realpath($dir).'&targetfile='.$file.'&perma='.realpath($dirperma).'"><img src="./images/notepad-plus-plus.gif"/></a>'
							.'<a href="#" onclick=\'openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "'.$urldir.$file.'");  return false;\'><img src="./images/text.png"/></a>'
							
						// view icon xxx                                                                                                                 // window.open replace with alert to test
							.'<a id="view'.$i.'" class="inline" href="viewfile/viewdos.php?fname='.$file.'&targetdir='.$dir.'" onclick="javascript:void window.open(\'/viewfile/viewdos.php?fname='.$file.'&targetdir='.$dir.'\',\'1481602525735\',\'width=980,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=150,top=50\'); return false;"><img src="./images/view.png" '.$onmouseover_view.' /></a>'
						// windows psexec icon
							.'<a href="psexec.php?targetdir='.realpath($dir).'&targetfile='.$file.'&urldir='.$urldir.'&host='.$host.'"  onclick=\'psexec(this.href); return false;\' ><img src="./images/Windows16.png" title="System" /></a>'
						// for debug showing the output, without return false
						//	.'<a href="/doc/files/common/psexec.php?targetdir='.realpath($dir).'&targetfile='.$file.'&urldir='.$urldir.'&host='.$host.'"  onclick=\'psexec(this.href); \' ><img src="./images/Windows16.png"/></a>'
						// wine icon
							.'<a class="linuxlink" href="downloadfile.php?fname=wine_this.rn&targetdir='.realpath($dir).'&targetfile='.$file.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath("permalinux").'"  ><img src="./images/wine16.png"/></a>'
						// add comment bull icon
							.'<a id="bulle'.$i.'" class="inline" href="downloadfile.php?fname='.($CurrOS!='Linux'?'ui_':'').'edit_this.'.($CurrOS!='Linux'?'run':'rn').'&targetdir='.realpath($dir).'&targetfile=.'.$file.'&perma='.realpath($dirperma).($CurrOS!='Linux'?'':'Linux').'"  ><img src="./images/'.$str_bulle_icon_png.'"   '.$onmouseover.'/></a>'
						// add screenshot camera icon
							.'&nbsp;<a class="winlink" href="downloadfile.php?fname=ui_screenshot.run&targetdir='.realpath($dir).'&urldir='.$urldir.'&targetfile=.'.$file.'&perma='.realpath($dirperma).'"><img src="./images/screenshot.png"/></a>';
						echo '<br/>';
						$i++;
					}
				}
			}
        }
    }
    closedir($handle);
}
?>
</div>
<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><img src="./images/refresh.gif"onclick="location.reload(true);" style="cursor:pointer" title="Reload" />&nbsp;<span class="linuxlink" ><strong>Linux shell files in this &#34;<script>document.write("<?php echo $prjname; ?>");</script>&#34; project </strong><small>(download and run local)</small>&nbsp;<input size="6" id="addfl" value="test.rn"/><a href="#" onclick="AddFile('addfl');"><img src="./images/add_file.png"></a>
	
        <div class="checkbox_wrapper">
            <input type="checkbox" class="run_box" name=".cklrun" <?php echo @file_get_contents($proj_dir."/.cklrun"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.cklrun"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;run</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="ver_box" name=".cklver" <?php echo @file_get_contents($proj_dir."/.cklver"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.cklver"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ver</label>
        </div>
        <div class="checkbox_wrapper">
            <input type="checkbox" class="cd_box" name=".cklcd" <?php echo @file_get_contents($proj_dir."/.cklcd"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.cklcd"; ?>&value='+this.checked, function(text){ show_write(text)}); location.reload(true);"/>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;cd</label>
        </div>
	
	</span></td>
    <td><hr /></td>
  </tr>
</table>

<div class="newspaper" style="background-color: lightgray; opacity: 0.6">
<?php
if($CurrOS!="Linux") echo "<small>Disabled because you are using ".$CurrOS."</small><br/>";
$dirperma="permalinux";		// not used
if ($handle = opendir($dir)) {
	$i=0;
    while (false !== ($file = readdir($handle))) {

        if ($file[0] != '.' && $file != '..') {
			if(!is_dir($dir.'/'.$file)) {		// don't display directories
				$rest = strtoupper(substr($file, -3));
				if(($rest==".SH") || ($rest==".RN")) {							// display only .bat files
						$str_edit="";
						if($CurrOS=="Linux") {
							$str_edit = ' <a class="linuxlink" href="downloadfile.php?fname=edit_this.rn&targetdir='.realpath($dir).'&targetfile='.$file.'&perma='.realpath("permalinux").'"><img src="./images/notepad-plus-plus.gif"/></a>';
						} else {
							$str_edit = ' <a class="winlink" href="downloadfile.php?fname=ui_edit_this.run&targetdir='.realpath($dir).'&targetfile='.$file.'&perma='.realpath("perma").'"><img src="./images/notepad-plus-plus.gif"/></a>';
						}
						$str_edit.='<a href="#" onclick=\'openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "'.$urldir.$file.'");  return false;\'><img src="./images/text.png"/></a>';
					if (file_exists ( $dir.'/.'.$file )) {	// prevent error messages in console 404 not found
							$onmouseover='onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, '.$i.', \'lbulle\')});"';
					} else {
						$onmouseover='';
					}
					$onmouseover_view='onmouseover="getFileFromServer('.'\''.$file.'\''.', function(text){ show(text, this, '.$i.', \'lview\')});"';
					$str_bulle_icon_png="comment.png";
					if (file_exists ( $dir.'/.'.$file )) {
					
						if( strpos(@file_get_contents( $dir.'/.'.$file),"bad.jpg") !== false) {
							$str_bulle_icon_png="comment_bad.png";
						} else {
							$str_bulle_icon_png="comment_exist.png";
						}
					}
						echo '<a class="linuxlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dir).'&term=gnome-terminal"  onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, -1)});">'.$file.'</a>'
							// to be debug execute
							.'&nbsp;<a id="lview'.$i.'" class="inline" href="/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/shell/shell.php?fname='.$file.'&targetdir='.$dir.'" onclick="javascript:void window.open(\'/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/shell/shell.php?fname='.$file.'&targetdir='.$dir.'\',\'1481602525735\',\'width=980,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=150,top=50\'); return false;"><img src="./images/debug16.png" '.$onmouseover_view.' /></a>'
							// edit
							.$str_edit
							// view 
							.'<a id="lview'.$i.'" class="inline" href="viewlfile/viewdos.php?fname='.$file.'&targetdir='.$dir.'" onclick="javascript:void window.open(\'/viewfile/viewdos.php?fname='.$file.'&targetdir='.$dir.'\',\'1481602525735\',\'width=980,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=150,top=50\'); return false;"><img src="./images/view.png" '.$onmouseover_view.' /></a>'
							// run a linux gui with windows psexec
							.'<a class="winlink" href="runinlinux.php?targetdir='.realpath($dir).'&targetfile='.$file.'&urldir='.$urldir.'&host='.$host.'"  onclick=\'psexec(this.href); return false;\' ><img src="./images/linux.png"/></a>'
							//.'<a class="winlink" href="/doc/files/common/runinlinux.php?targetdir='.realpath($dir).'&targetfile='.$file.'&urldir='.$urldir.'&host='.$host.'"  onclick=\'psexec(this.href); \' ><img src="./images/linux.png"/></a>'
							// cygwin
							.'<a class="winlink" href="downloadfile.php?fname=ui_run_with_cygwin.run&targetdir='.realpath($dir).'&targetfile='.$file.'&perma='.realpath("permalinux").'"><img src="./images/cygwin16.png"/></a>'
							// add to constructor
							.'&nbsp;<a href="copy_to_constructor.php?fname='.$file.'&targetdir='.$dir.'&urldir='.$urldir.'&host='.$host.'." onclick="javascript:void window.open(\'copy_to_constructor.php?fname='.$file.'&targetdir='.$dir.'&urldir='.$urldir.'&host='.$host.'\',\'1481602525735\',\'width=980,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=150,top=50\'); return false;"><img src="./images/constructor.ico" title="Add this to _constructor" /></a>'
							// add comment bull icon
							.'&nbsp;<a id="lbulle'.$i.'" class="inline" href="downloadfile.php?fname='.($CurrOS!='Linux'?'ui_':'').'edit_this.'.($CurrOS!='Linux'?'run':'rn').'&targetdir='.realpath($dir).'&targetfile=.'.$file.'&perma='.realpath("perma").($CurrOS!='Linux'?'':'Linux').'"  ><img src="./images/'.$str_bulle_icon_png.'"   '.$onmouseover.'/></a>';
							
						echo '<br/>';
						$i++;
				}
			}
        }
    }
    closedir($handle);
}
?>
</div>

<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><a href="#view"><span><img src="./images/eye.gif"></a>&nbsp;<img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" />&nbsp;<strong>Perma commands </strong><small>(runs on Windows server)</small></td>
    <td><hr /></td>
  </tr>
</table>

<div class="newspaper">
<!--#include virtual="/doc/files/common/perma-here.inc"-->
</div>


<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;">
      <a href="#view"><span><img src="./images/eye.gif"></a>
      &nbsp;<img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload"  />
      &nbsp;<strong>Save clipboard </strong><small>label:</small>&nbsp;<input size="6" id="inph" onblur="updateLabel(this.value);"/></td>
    <td><hr /></td>
  </tr>
</table>

<script>
    function updateLabel(text) {
        document.getElementById('cliplabel').value=text;
        //alert(text);
    }
</script>

<img src="./images/copyclip.png" title="Drag and drop clipboard text in this field" style="float: left;" /><span style="float: left;">&nbsp;</span>

<form name="faddclip" method="get" action="addclip.php"  style="float: left;" >
<input type="text" name="path" id="dropclip" data-clipboard-text="something" onmouseout="bindme(this.id, 1); onInputChgClip(this.value);" onblur="onInputChgClip(this.value);" size="104%" />
<input type="hidden" name="parent" value=<?php echo $display_link;?> /> <!-- mettre ici le contenu du filed id inph -->
<input type="hidden" name="label" id="cliplabel"/>
</form>
<br/ style="clear: both;">


<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;">
      <a href="#view"><span><img src="./images/eye.gif"></a>
      &nbsp;<img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload"  />
      &nbsp;<strong>Perma batch </strong><small>PARAM1:</small>&nbsp;<input size="40" id="inpf"/></td>
    <td><hr /></td>
  </tr>
</table>

<div class="newspaper" style="background-color: lightblue; opacity: 0.6" id="lightbluediv">
<?php
$dirlocal=$dir;
// http://mlerman-lap/s/P
if($CurrOS!="Linux")
{

	if ($handle = opendir($dirp)) {
		$i=0;
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if(!is_dir($dirp.'/'.$file)) {		// don't display directories
					if($file=="ui_edit_this.bat") continue; 	// skip this file
					if($file=="ui_screenshot.bat") continue; 	// skip this file
					if($file=="ui_edit_this.run") continue; 	// skip this file
					if($file=="ui_screenshot.run") continue; 	// skip this file
					$rest = strtoupper(substr($file, -4));
					if(($rest==".BAT") || ($rest==".RUN")) {							// display only .bat files
						if(substr($file,0,3)=="ui_") {			// only interactive commands
							$onmouseover ='onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, -1)});"';
							$onmouseover = '';  // no need here
							echo '<a class="winlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dirlocal).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirp).'" '.$onmouseover.'  onclick="this.href=this.href+\'&param1=\'+document.getElementById(\'inpf\').value.replaceAll(\'\\\\\',\'`\');" >'.$file.'</a>';
							echo "&nbsp";
							$i++;
						}
					}
				}
			}
		}
		closedir($handle);
	}
}
?>
</div>

<div class="newspaper" style="background-color: lightgray; opacity: 0.6">
<?php
// http://mlerman-lap/s/Q
if($CurrOS=="Linux")
{
echo "<hr/>\n";
	$dirpm="permalinux";

	if ($handle = opendir($dirpm)) {
		$i=0;
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if(!is_dir($dirpm.'/'.$file)) {		// don't display directories
					if(($file=="edit_this.sh") || 
					($file=="edit_this.rn") ||
					($file=="wine_this.rn")
					) continue; 	// skip this file
					$rest = strtoupper(substr($file, -3));
					if($rest==".RN") {							// display only .bat files
							echo '<a class="linuxlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dirlocal).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirpm).'"  onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, -1)});">'.$file.'</a>';
						/////      echo '<a class="winlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dirlocal).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirp).'" onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, -1)});"  onclick="this.href=this.href+\'&param1=\'+document.getElementById(\'cmdinput\').value;" >'.$file.'</a>';
							//echo '<br/>';
							echo "&nbsp";
							$i++;
					}
				}
			}
		}
		closedir($handle);
	}
}

?>
</div>
<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" />&nbsp;<strong>Drag and drop url links in the box below</strong>&nbsp;<a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.links&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>"><img src="./images/notepad-plus-plus.gif" title="Edit this section"/></a>
    <a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "<?php echo $urldir; ?>.links");  return false;'><img src="./images/text.png"/></a>
	
	</td>
    <td><hr /></td>
  </tr>
</table>
<img src="./images/link.png" title="Drag and drop url links in this field" style="float: left;" /><span style="float: left;">&nbsp;</span>
<form name="faddlink" method="get" action="addlink.php" style="float: left;" >
<input type="text" name="url" id="idfaddlink" onmouseout="onInputChg(this.value)" onblur="onInputChg(this.value)" size="200" />
<input type="hidden" name="parent" value=<?php echo $display_link;?> />
</form>
<br/ style="clear: both;" >
<?php echo @file_get_contents($proj_dir."/.links"); ?>


<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" />&nbsp;<strong>Make a sound alert when the following file changes</strong>&nbsp;<a href="downloadfile.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'rn'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.sound&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>"><img src="./images/notepad-plus-plus.gif" title="Edit this section"/></a>
    <a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "<?php echo $urldir; ?>.sound");  return false;'><img src="./images/text.png"/></a>
	</td>
    <td><hr /></td>
  </tr>
</table>

<img src="./images/speaker.png" title="Drag and drop full file path in this field" style="float: left;" /><span style="float: left;">&nbsp;</span>
<form name="faddsound" method="get" action="addsound.php" style="float: left;" >
<input type="text" name="path" id="dropsound" onmouseout="onInputChgSound(this.value)" onblur="onInputChgSound(this.value)" size="200" />
<input type="hidden" name="parent" value=<?php echo $display_link;?> />
</form>
<br/ style="clear: both;" >
<?php
$path_sound=@file_get_contents($proj_dir."/.sound");
echo $path_sound;
$path_sound = str_replace("\\", "\\\\", $path_sound);
?><br/>


<script>


var previous_file_time=0;
var xmlhttp_filechange = new XMLHttpRequest();
	xmlhttp_filechange.onreadystatechange = function() {
		if( xmlhttp_filechange.readyState == 4) {
			if( xmlhttp_filechange.status == 200) {
				file_time=xmlhttp_filechange.responseText;
				file_time_int=parseInt(file_time);
				if (previous_file_time!=0) {  // not the first time
					if (previous_file_time!=file_time_int) {
						//var p = document.createElement('p');
						//p.innerHTML = file_time;
						//document.body.appendChild(p);
						var audio = new Audio('/doc/sounds/Electronic_Chime-KevanGC-495939803.mp3');
						audio.play();
					}
				}
				previous_file_time=file_time_int;
			}
			else {
				var p = document.createElement('p');
				p.innerHTML = "HTTP error "+xmlhttp_filechange.status+" "+xmlhttp_filechange.statusText;
				document.body.appendChild(p);
			}
		}
	}


<!--
//setInterval(tick_ftime_check, 1500);
//function tick_ftime_check() {
//	xmlhttp_filechange.open("GET","/doc/files/common/filechange.php?target=<?php echo $path_sound;?>");
//	xmlhttp_filechange.send();
//}
-->
</script>




<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;"><img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" />&nbsp;<strong>Drag and drop files in the iframe below</strong></td>
    <td><hr /></td>
  </tr>
</table>

<!--
<iframe src="/doc/upload/index.html?dir=<?php echo $dir_loc; ?>" width="100%" height="600px" ></iframe>
-->										  
<!--										  
<div id="message5sec" >
<script>
var w=window.innerWidth;
if (w<1595)
document.write("<span style=\"color:red\">Please enlarge<br/>the browser's<br/> window and reload<br/> w = "+w+" <br/>is less than 1595</span>");
else
document.write("<span style=\"color:green\">OK thx</span>");
</script>
</div>
-->

<table width="100%">
  <tr>
    <td><hr /></td>
    <td style="width:1px; padding: 0 10px; white-space: nowrap;">Time spent on this project</td>
    <td><hr /></td>
  </tr>
</table>


<script>
var totalSec =Math.round(window.localStorage['<?php echo $id_link; ?>']);

var days = 0;
var hours = 0;
var minutes = 0;
var seconds = 0;
if (!isNaN(totalSec)) {
  days = parseInt( totalSec / 86400 );
  totalSec -= days * 86400;
  hours = parseInt( totalSec / 3600 ) % 24;
  totalSec -= hours * 3600;
  minutes = parseInt( totalSec / 60 ) % 60;
  totalSec -= minutes * 60;
  seconds = totalSec % 60;
  } else {
  window.localStorage['<?php echo $id_link; ?>']=0;
  }

  dd="";
  if(days>0) {
    dd=(days < 10 ? "0" + days : days) + " days -";
  }
  hh="";
  if(hours>0) {
    hh=(hours < 10 ? "0" + hours : hours) + " hours -";
  }
var result = dd  + hh + (minutes < 10 ? "0" + minutes : minutes) + " minutes -" + (seconds  < 10 ? "0" + seconds : seconds) + " seconds";

document.write(result);
</script>

<fieldset>
<legend>Attributes: </legend>
<input type="checkbox" name=".cknotrack" <?php echo @file_get_contents($proj_dir."/.cknotrack"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.cknotrack"; ?>&value='+this.checked, function(text){ show_write(text)});"> Don't track time<br/>
<input type="checkbox" name=".ckreport" <?php echo @file_get_contents($proj_dir."/.ckreport"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckreport"; ?>&value='+this.checked, function(text){ show_write(text)});"> Include in Sharepoint<br/>
<input type="checkbox" name=".ckgithub" <?php echo @file_get_contents($proj_dir."/.ckgithub"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckgithub"; ?>&value='+this.checked, function(text){ show_write(text)});"> Add github commands<br/>
<input type="checkbox" name=".ckftpx" <?php echo @file_get_contents($proj_dir."/.ckftpx"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckftpx"; ?>&value='+this.checked, function(text){ show_write(text)});"> Add FTP commands<br/>
<input type="checkbox" name=".ckpasswd" <?php echo @file_get_contents($proj_dir."/.ckpasswd"); ?> onclick="getFileFromServer('write_ckfile.php?target=<?php echo $proj_dir."/.ckpasswd"; ?>&value='+this.checked, function(text){ show_write(text)});"> Password Protect (cannot be un-checked)<br/>
</fieldset>

<hr/>

<div id="fixed-div"> <!-- http://mlerman-lap/s/N  -->
<img src="./images/up.png" onclick="window.scrollTo(0, 0);" style="cursor:pointer" title="Scroll all the way up" /><br/><br/>
<a href="#view" ><span><img src="./images/eye.gif" title="Scroll to view programs"></a><br/><br/>

<a href="env.php?targetdir=<?php echo $dir; ?>" target="env" onclick="javascript:void window.open('env.php?targetdir=<?php echo $dir; ?>','1481656702602','width=1500,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50');return false;"><img src="./images/Programming-Variable-icon16.png" title="Manage environment variables" /></a><br/><br/>
<script>
var str10="";
</script>
<a href="/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/frequent_copy_paste/" target="chartime" onclick="javascript:void window.open('/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/frequent_copy_paste/','1481656702602','width=800,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=600,top=50');return false;"><img src="./images/copyclip.png" title="frequent copy paste" onmouseover="customAlertRight(str10,'10000','50','300')" /></a>
<div id="prevclip">none</div>
<br/>

<img src="./images/refresh.gif" onclick="location.reload(true);" style="cursor:pointer" title="Reload" /><br/><br/>
<?php

if($CurrOS!="Linux")
{
	$dirp="perma";
	$file="ui_total_commander.run";
	echo '&nbsp;<a class="winlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dir).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirp).'" '.$onmouseover.'  onclick="this.href=this.href+\'&param1=\'+document.getElementById(\'inpf\').value.replaceAll(\'\\\\\',\'`\');" ><img src="./images/totalcommander16.png" title="Total commander" /></a><br/><br/>';
} else
{
	$dirpm="permalinux";
	$file="krusaderHere.rn";
	echo '<a class="linuxlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dirlocal).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirpm).'"  onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, -1)});"><img src="./images/krusader16.png" title="krusader" /></a><br/><br/>';
}


if($CurrOS!="Linux")
{
	$dirp="perma";
	$file="ui_copy_path_to_clipboard.run";
	echo '&nbsp;<a class="winlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dir).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirp).'" '.$onmouseover.'  onclick="this.href=this.href+\'&param1=\'+document.getElementById(\'inpf\').value.replaceAll(\'\\\\\',\'`\');" ><img src="./images/clip16.png" title="Copy path to clipboard" /></a><br/><br/>';
} else
{
	$dirpm="permalinux";
	$file="copy_path_to_clipboard.rn";
	echo '<a class="linuxlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dirlocal).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirpm).'"  onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, -1)});"><img src="./images/clip16.png" title="Copy path to clipboard" /></a><br/><br/>';
}


if($CurrOS!="Linux")
{
	$dirp="perma";
	$file="ui_DOS_prompt.run";
	echo '&nbsp;<a class="winlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dir).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirp).'" '.$onmouseover.'  onclick="this.href=this.href+\'&param1=\'+document.getElementById(\'inpf\').value.replaceAll(\'\\\\\',\'`\');" ><img src="./images/terminal16.png" title="DOS session" /></a><br/><br/>';
} else
{
	$dirpm="permalinux";
	$file="openTerminal.rn";
	echo '<a class="linuxlink" href="downloadfile.php?fname='.$file.'&targetdir='.realpath($dirlocal).'&targetfile='.$prjname.'&urldir='.$urldir.'&host='.$host.'&perma='.realpath($dirpm).'"  onmouseover="getFileFromServer('.'\'.'.$file.'\''.', function(text){ show(text, this, -1)});"><img src="./images/terminal16.png" title="Terminal" /></a><br/><br/>';
}

?>
<a href="#bottom"><img src="./images/dn.png" title="Scroll all the way down"/></a><br/><br/>
</div>

<div id="fixed-div-top">
<h1><?php echo $prjname; ?></h1>
</div>


<script>
function adjustWindow(){  // not used not working
    var width = 600;
    var height = 400;
    self.resizeTo(width, height);
    self.moveTo(((screen.width - width) / 2), ((screen.height - height) / 2));
    self.resizeBy(-200, -200);
	alert("current window width="+window.innerWidth);
}

//ml: http://mlerman-lap/s/19

var listItemAnchors = document.getElementsByTagName('a');
//ml icons
for (i = 0; i < listItemAnchors.length; i++) {
	var s=listItemAnchors[i].innerText;
	if(s.indexOf("layout") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/application-x-pcb-layout.png' title='"+s+"'/>";
	  }
	if(s.indexOf("show_schematic") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/11172739-technical-drawing.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("show_pinout") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/pinout.png' title='"+s+"'/>";
	  }
	if(s.indexOf("total_commander") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/total_commander_icon.png' title='"+s+"'/>";
	  }
	if(s.indexOf("total_commander_bin") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/total_commander_bin_icon.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("total_commander_src") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/total_commander_src_icon.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("total_commander_rtl") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/total_commander_rtl_icon.png' title='"+s+"'/>";
	  }
	if(s.indexOf("total_commander_ftp") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/total_commander_ftp_icon.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("total_commander_cd") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/total_commander_cd.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("total_commander_remote") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/total_commander_remote.png' title='"+s+"'/>";
	  }
	if(s.indexOf("total_commander_down") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/total_commander_down.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Terminal") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/terminal.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("SuTerm") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/terminalRed.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("prompt.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/prompt.png' title='"+s+"'/>";
	  }
	if(s.indexOf("elevated_prompt") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/promptred.png' title='"+s+"'/>";
	  }
	if(s.indexOf("device_manager") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/device_manager.png' title='"+s+"'/>";
	  }
	if(s.indexOf("mint_vm") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/mint.png' title='"+s+"'/>";
	  }
	if(s.indexOf("krusaderHereUSB.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/krusader-usb.png' title='"+s+"'/>";
	  }
	if(s.indexOf("krusaderHere.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/krusader.png' title='"+s+"'/>";
	  }
	if(s.indexOf("krusaderHere.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/krusader.png' title='"+s+"'/>";
	  }
	if(s.indexOf("krusader.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/krusader.png' title='"+s+"'/>";
	  }
	if(s.indexOf("krusaderHereDown.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/krusader-down.png' title='"+s+"'/>";
	  }
	if(s.indexOf("mntFiles") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/mnt.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("umntFiles") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/umnt.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("usbview") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/usb.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("curl_remote_dir") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/curl-remote-dir.png' title='"+s+"'/>";
	  }
	if(s.indexOf("CygwinConsole") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/cygwin.png' title='"+s+"'/>";
	  }
	if(s.indexOf("adminCygwinConsole") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/admincygwin.png' title='"+s+"'/>";
	  }
	if(s.indexOf("grepWin") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/grepWin.png' title='"+s+"'/>";
	  }
	if(s.indexOf("grepWin_input") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/grepWinInput.png' title='"+s+"'/>";
	  }
	if(s.indexOf("grepWin_input_file") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/grepWinInputFile.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("putty") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/putty.png' title='"+s+"'/>";
	  }
	if(s.indexOf("kitty_cmd") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/kitty_cmd.png' title='"+s+"'/>";
	  }
	if(s.indexOf("putty_ssh") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/ssh.png' title='"+s+"'/>";
	  }
	if(s.indexOf("network.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/wired.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("config_wired_10_52") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/wired10-52.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("config_wired_192") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/wired192-168.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("config_ethernet") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/wired.png' title='"+s+"'/>";
	  }
	if(s.indexOf("config_ethernet_home") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/wiredhome.png' title='"+s+"'/>";
	  }
	if(s.indexOf("config_ethernet_work") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/wiredwork.png' title='"+s+"'/>";
	  }
	if(s.indexOf("config_ethernet_auto") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/wiredauto.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_upload") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/upload.png' title='"+s+"'/>";
	  }
	if(s.indexOf("download.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/download.png' title='"+s+"'/>";
	  }
	if(s.indexOf("dbgview") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/dbgview.png' title='"+s+"'/>";
	  }
	if(s.indexOf("notepad") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/notepad.png' title='"+s+"'/>";
	  }
	if(s.indexOf("visual_studio") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/vstudio.png' title='"+s+"'/>";
	  }
	if(s.indexOf("visual_studio_2010") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/vsstudio2010.png' title='"+s+"'/>";
	  }
	if(s.indexOf("_dediprog") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/dediprog.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("delete_this") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/deleteRed.jpg' title='"+s+"'/>";
	  }
	if(s.indexOf("show_param1") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/blank-param1.png' title='"+s+"'/>";
	  }
	if(s.indexOf("set_param1") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/blank-param1Input.png' title='"+s+"'/>";
	  }
	if(s.indexOf("netbeans") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/netbeans_icon.png' title='"+s+"'/>";
	  }
	if(s.indexOf("eclipse.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/eclipse.png' title='"+s+"'/>";
	  }
	if(s.indexOf("build.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/build48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("make.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/build48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/application_run.png' title='"+s+"'/>";
	  }
	if(s.indexOf("run.sh") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/application_run.png' title='"+s+"'/>";
	  }
	if(s.indexOf("run.rn") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/application_run.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_rerun.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/application_re_run.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ai_run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/application_run_admin.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_run_install") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/run_install.png' title='"+s+"'/>";
	  }
	if(s.indexOf("path_to_clipboard") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/copy-path-to-clipboard.png' title='"+s+"'/>";
	  }
	if(s.indexOf("path_cygwin_to_clipboard") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/copy-path-cyg-to-clipboard.png' title='"+s+"'/>";
	  }
	if(s.indexOf("path_url_to_clipboard") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/copy-path-url-to-clipboard.png' title='"+s+"'/>";
	  }
	if(s.indexOf("anchor_url_to_clipboard") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/copy-anchor-url-to-clipboard.png' title='"+s+"'/>";
	  }
	if(s.indexOf("moss.micron.com") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/moss.png' title='"+s+"'/>";
	  }
	if(s.indexOf("collab.micron.com") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/sharepoint.png' title='"+s+"'/>";
	  }
	if(s.indexOf("new_sharepoint") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/sharepoint-plus.png' title='"+s+"'/>";
	  }
	if(s.indexOf("github_client") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-sociocon.png' title='"+s+"'/>";
	  }
	if(s.indexOf("github.com/mlerman") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-sociocon.png' title='"+s+"'/>";
	  }
	if(s.indexOf("github_win10lap") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-sociocon.png' title='"+s+"'/>";
	  }
	if(s.indexOf("git_create_repo") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-plus.png' title='"+s+"'/>";
	  }
	if(s.indexOf("git_download") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-fdown.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_force_pull") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-fdown.png' title='"+s+"'/>";
	  }
	if(s.indexOf("git_force_pullupload") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-up.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_push_to_github") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-up.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_pull_from_github") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-down.png' title='"+s+"'/>";
	  }
	if(s.indexOf("force_push_to_github") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/github-fup.png' title='"+s+"'/>";
	  }
	if(s.indexOf("set_env_var") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/env-varable.png' title='"+s+"'/>";
	  }
	if(s.indexOf("tightvnc_view") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/tightvnc.png' title='"+s+"'/>";
	  }
	if(s.indexOf("tightvnc_remote") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/tightvnc-remote.png' title='"+s+"'/>";
	  }
	if(s.indexOf("stop.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/player_stop.png' title='"+s+"'/>";
	  }
	if(s.indexOf("disk_man.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/diskman.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_edit_line") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/notepad-plus-plus-48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_jump_to_with_ie") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/iexplore.png' title='"+s+"'/>";
	  }
	  //winzip-icon.png
	if(s.indexOf("ui_down_load_zipped") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/winzip-icon.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_lan_location_with_windows_explorer_N.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/48px-Win_explorer-logo-grey_N.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_lan_location_with_windows_explorer_Y.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/48px-Win_explorer-logo-grey_Y.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_lan_location_with_windows_explorer_I.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/48px-Win_explorer-logo-grey_I.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_lan_location_with_windows_explorer.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/48px-Win_explorer-logo-grey.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_lan_location_with_windows_explorer_S.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/48px-Win_explorer-logo-grey_S.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_lan_location_with_windows_explorer_W.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/48px-Win_explorer-logo-grey_W.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_lfiles_with_windows_explorer.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/48px-Win_explorer-logo-grey-lfiles.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_ufiles_with_windows_explorer.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/48px-Win_explorer-logo-grey-ufiles.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_H_with_chrome") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/chrome_H.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_lan_location_with_chrome") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/chrome.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_help") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Help.png' title='"+s+"'/>";
	  }
	if(s.indexOf("help.rn") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Help.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_move_most_recently_downl_file_to_here") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/ch.png' title='"+s+"'/>";
	  }
	if(s.indexOf("version.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/version.png' title='"+s+"'/>";
	  }
	if(s.indexOf("i_regedit") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/regedit48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_crlf") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/tux_windows.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_showpdf") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/pdf48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_new_project_side") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/MI_CreateFolderSide.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_new_project_down") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/MI_CreateFolderDown.png' title='"+s+"'/>";
	  }
	if(s.indexOf("winscp.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/winscp.png' title='"+s+"'/>";
	  }
	if(s.indexOf("everything_input") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/everythingInput.png' title='"+s+"'/>";
	  }
	if(s.indexOf("test.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/playredtest.png' title='"+s+"'/>";
	  }
	if(s.indexOf("hctosys.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/clock.png' title='"+s+"'/>";
	  }
	if(s.indexOf("paint.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/paint.png' title='"+s+"'/>";
	  }
	if(s.indexOf("gimp.rn") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/paint.png' title='"+s+"'/>";
	  }
	if(s.indexOf("word.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/dwr_48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("powerpoint.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/powerpoint.png' title='"+s+"'/>";
	  }
	if(s.indexOf("video_capture_screen.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/video.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_network_connection_adapter.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/network.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_jotty.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/malware.png' title='"+s+"'/>";
	  }
	if(s.indexOf("bin_edit.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/binedit.png' title='"+s+"'/>";
	  }
	if(s.indexOf("convert_dos_to_linux.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/win2lin.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_convert_linux_to_dos.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/lin2win.png' title='"+s+"'/>";
	  }
	if(s.indexOf("systemMonitor.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/graph48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_rename_file_no_spaces.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/underscore.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_services.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/services.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_stop_CISCO_VPN_service.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/killciscovpn.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_start_CISCO_VPN_service.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/ciscovpn.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_powershell.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/powershell.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_put_next.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Arrownext48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_process_explorer.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/graph48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_jump_to_jira.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/jira48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_open_jira.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/jira48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_minimenu_always_on_top.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/minib.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_archive.run") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/archive48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("reset_processor.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Reset_button48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_jtagterminal_debug") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/jtagterminal.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_XSCT_Xilinx_Software_command_line_tool") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/xsctterminal.png' title='"+s+"'/>";
	  }
	if(s.indexOf("resume.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/media-play-resume.png' title='"+s+"'/>";
	  }
	if(s.indexOf("suspend.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/media-play-pause.png' title='"+s+"'/>";
	  }
	if(s.indexOf("ui_add_readme") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/readme.png' title='"+s+"'/>";
	  }
	if(s.indexOf("nxt.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/next-step.png' title='"+s+"'/>";
	  }
	if(s.indexOf("stpout.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/ret.png' title='"+s+"'/>";
	  }
	if(s.indexOf("dis.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/asm.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_google_drive") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Google-Drive-48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("edit_environment_variable.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/variable.png' title='"+s+"'/>";
	  }
	if(s.indexOf("hw_server.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/hw.png' title='"+s+"'/>";
	  }
	if(s.indexOf("vivado.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/vivado.png' title='"+s+"'/>";
	  }
	if(s.indexOf("vivado_tcl.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/vivado_tcl.png' title='"+s+"'/>";
	  }
	if(s.indexOf("launch_script.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/script.png' title='"+s+"'/>";
	  }
////////////  
	if(s.indexOf("showFiles.rn") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/ln-files.png' title='"+s+"'/>";
	  }
	if(s.indexOf("share_files.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/sharedir.png' title='"+s+"'/>";
	  }
	if(s.indexOf("bashdb.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/bug48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("vcs_gui.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/vcs.png' title='"+s+"'/>";
	  }
	if(s.indexOf("push_files.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/copyover48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("codecompare.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/codecompare.png' title='"+s+"'/>";
	  }
	if(s.indexOf("remove.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/remove.png' title='"+s+"'/>";
	  }
	if(s.indexOf("open_review.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/smartbear.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Y_drive.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/monitor_Y_48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("I_drive.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/monitor_I_48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("L_drive.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/monitor_L_48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("W_drive.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/monitor_W_48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("N_drive.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/monitor_N_48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("S_drive.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/monitor_S_48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("H_drive.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/monitor_H_48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("_next.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/gtk-go-back-rtl.png' title='"+s+"'/>";
	  }
	if(s.indexOf("_from_jira.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/jira48down.png' title='"+s+"'/>";
	  }
	if(s.indexOf("clean_") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/clean.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Hemmati") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/sarvineh.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Sherry_Wang") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/sherrywang.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Anosh_Mohammed") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/anosh.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Mark_Liu") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/markliu.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Henry_Chung") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Henry_Chung.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Gerald_Logoteta") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Gerald_Logoteta.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Basavaraj_Masarakal") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Basavaraj_Masarakal.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Kunal_Shenoy") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Kunal_Shenoy.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Ramesh_Mangamuri") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Ramesh_Mangamuri.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Patrick_Turner") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Patrick_Turner.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Shrikant_Shukla") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Shrikant_Shukla.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Kuldeep_Bhadoria") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Kuldeep_Bhadoria.png' title='"+s+"'/>";
	  }
	if(s.indexOf("AstroGrep") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/astrogrep.png' title='"+s+"'/>";
	  }
	if(s.indexOf("view_log.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/glogg.png' title='"+s+"'/>";
	  }
	if(s.indexOf("move_jira_emails.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/jira48_remove.png' title='"+s+"'/>";
	  }
	if(s.indexOf("config.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/configure.png' title='"+s+"'/>";
	  }
	if(s.indexOf("force_CQ_only.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/cq_only.png' title='"+s+"'/>";
	  }
	if(s.indexOf("DOS_web.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/promptconsole.png' title='"+s+"'/>";
	  }
	if(s.indexOf("apache_error.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/apachelogo.png' title='"+s+"'/>";
	  }
	if(s.indexOf("xming.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Xming.png' title='"+s+"'/>";
	  }
	if(s.indexOf("t32_xming.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/t32.png' title='"+s+"'/>";
	  }
	if(s.indexOf("RIS.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/ris.png' title='"+s+"'/>";
	  }
	if(s.indexOf("scan_far.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/scan.png' title='"+s+"'/>";
	  }
	if(s.indexOf("query_far.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/query.png' title='"+s+"'/>";
	  }
	if(s.indexOf("RAID_0.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/raid48_0.png' title='"+s+"'/>";
	  }
	if(s.indexOf("RAID_5.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/raid48_5.png' title='"+s+"'/>";
	  }
	if(s.indexOf("show_far.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/eye48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("clear_config_far.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/clear.png' title='"+s+"'/>";
	  }
	if(s.indexOf("uart_far.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/uart.png' title='"+s+"'/>";
	  }
	if(s.indexOf(".kitty.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/kitty.png' title='"+s+"'/>";
	  }
	if(s.indexOf("kitty_run.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/kitty.png' title='"+s+"'/>";
	  }
	if(s.indexOf("sync.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/FreeFileSync48.png' title='"+s+"'/>";
	  }
	if(s.indexOf("source_insight.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/source_insight.png' title='"+s+"'/>";
	  }
	if(s.indexOf("email_shipped.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/email_shipped.png' title='"+s+"'/>";
	  }
	if(s.indexOf("relance.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/overdue.png' title='"+s+"'/>";
	  }
	if(s.indexOf("estimate.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/estimate.png' title='"+s+"'/>";
	  }
	if(s.indexOf("cart_str_to_order.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/insert_db.png' title='"+s+"'/>";
	  }
	if(s.indexOf("robot.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/robot.png' title='"+s+"'/>";
	  }
	if(s.indexOf("FPExpress.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/FPExpress.png' title='"+s+"'/>";
	  }
	if(s.indexOf("SoftConsole.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/SoftConsole.png' title='"+s+"'/>";
	  }
	if(s.indexOf("Libero.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/Libero.png' title='"+s+"'/>";
	  }
	if(s.indexOf("MSS_Configurator.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/MSS.png' title='"+s+"'/>";
	  }
	if(s.indexOf("mtPutty.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/mtputty.png' title='"+s+"'/>";
	  }
	if(s.indexOf("category.r") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/category.png' title='"+s+"'/>";
	  }
	if(s.indexOf("unzip_") > -1) {
	  listItemAnchors[i].innerHTML="<img src='./images/winzip-icon-original.png' title='"+s+"'/>";
	  }
}

for (i = 0; i < listItemAnchors.length; i++) {
	var s=listItemAnchors[i].innerText;
	if(s.indexOf("ui_jump_to") == 0) {
		listItemAnchors[i].style.color = "#DDCC00";
		/*
		// does not help because it is launched from the batch file
		alert(listItemAnchors[i].target);
		listItemAnchors[i].target = "_self";
		alert(listItemAnchors[i].target);
		*/
		//alert(listItemAnchors[i].href);
	  }
	if(s.indexOf("ai_") == 0) {
		listItemAnchors[i].style.color = "#DD0000";
	  }
}

</script>


<script>
//alert(sessionStorage.forcerefresh);
//alert("<?php echo $_SERVER['HTTP_REFERER']; ?>");
//alert(document.location);
    if   (sessionStorage.forcerefresh == "yes") {
          sessionStorage.setItem("forcerefresh", "no");
          window.location.reload();
   }


jQuery(function($){
    $.ajax({
        type: 'GET',
        url: 'http://localhost/jsonp.php',
        data: {
            field: 'value'
        },
        dataType: 'jsonp',
        crossDomain: true,
    }).done(function(response){
        //console.log(response);
		//alert(response);
		// "http://<?php echo $clienthost.$dir_loc; ?>/open-command-prompt-here.html"
		//alert($('#homelink').attr('href'));
		//alert("http://"+response+"<?php echo $dir_loc; ?>/open-command-prompt-here.html" );
		//$('#homelink').attr('href', "http://"+response+"<?php echo $dir_loc; ?>/open-command-prompt-here.html");
		$('#homelink').attr('href', "http://"+response+"/doc/elfinder.html");
		// hometitle
		$('#homelink').attr('title', "Go to "+response);
    }).fail(function(error){
        console.log(error.statusText);
    });
});

document.title="<?php echo $prjname; ?>";

</script>
<script>
window.addEventListener("storage", message_receive);

function message_broadcast(message) {
    localStorage.setItem('message',JSON.stringify(message));
    localStorage.removeItem('message');
}

function message_receive(ev) {
    if (ev.key!='message') return; // ignore other keys
    var message=JSON.parse(ev.newValue);
    if (!message) return; // ignore empty msg or msg reset

    // here you act on messages.
    // you can send objects like { 'command': 'doit', 'data': 'abcd' }
    if (message.command == 'myname') 
	{
		//console.log("<?php echo $prjname; ?> received broadcast message from : " + message.prjname + " url : " + message.urldir);
		// alert on duplicate tabs
		if((message.prjname=="<?php echo $prjname; ?>")&&(message.urldir=="<?php echo $urldir; ?>"))
		{
			//alert("duplicate tabs " + message.prjname + " url : " + message.urldir + " closing...");
			window.close();
		}
	}
}

message_broadcast({'command': 'myname', 'prjname': '<?php echo $prjname; ?>', 'urldir': '<?php echo $urldir; ?>', 'uid': (new Date).getTime()+Math.random() });


if (window.name!="<?php echo $prjname; ?>") 
{
  //alert("DEBUG Wrong page title. current name : \"" + window.name + "\" parent name : \"" + parent.window.name + "\" Close me!");
  document.getElementById("animreload").style.display="";
}

</script>

<a name="bottom"></a>

PARAM1=<?php echo $param1; ?>

    <div id='examples'>

<span class='inline' data-tipped-options="inline: 'inline-tooltip-1'">Inline 1</span>
<div id='inline-tooltip-1' style='display:none'>Moved into the tooltip</div>

<span class='inline' data-tipped-options="inline: 'inline-tooltip-2'">Inline 2</span>
<div id='inline-tooltip-2' style='display:none'>Another one</div>

      <div class='boxes positions'>

      </div> <!-- /#examples -->

    </div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<?php
if(file_exists($proj_dir."/.alert")) 
{
$fcontent=@file_get_contents($proj_dir."/.alert");
echo("<script>\n");
echo("alert('".$fcontent."');\n");
echo("</script>\n");
}
?>
<script>
function testIce() {
	if (ICEcoderWin.closed) {
		//alert("Cannot run unit tests because IceCoder closed");
		ICEcoderWin = window.open('', target, 'width=1200,height=640,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50', true);
		ICEcoderWin.resizeTo(1200,640);
		ICEcoderWin.moveTo(100,50);
	} else {
		//alert("testIce, will close open tabs");
		var ww = ICEcoderWin.innerWidth;
		//alert("window width is "+ww);
		ICEcoderWin.focus();
		if (ww < 200) {
			ICEcoderWin.resizeTo(1200, 640);
			ICEcoderWin.focus();
		}
	ICEcoderWin.filesFrame.contentWindow.frames['testControl'].location.href = '/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/test';
	}
}

function edit_with_icecoder(url, target, targetdir, targetfile, search_or_line) {
	if (ICEcoderWin.closed) {
		//alert("Cannot run unit tests because IceCoder closed");
		ICEcoderWin = window.open('', target, 'width=1200,height=640,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50', true);
		ICEcoderWin.resizeTo(1200,640);
		ICEcoderWin.moveTo(100,50);
	} else {
		//alert("testIce, will close open tabs");
		var ww = ICEcoderWin.innerWidth;
		//alert("window width is "+ww);
		ICEcoderWin.focus();
		if (ww < 200) {
			ICEcoderWin.resizeTo(1200, 640);
			ICEcoderWin.focus();
		}
	ICEcoderWin.filesFrame.contentWindow.frames['testControl'].location.href = url+'test/edit_with_icecoder.php?targetdir='+targetdir+'&targetfile='+targetfile+'&param1='+search_or_line;
	}
}


function openOnceTest(url, target, file){
    if (file=="") { // open but hide the window
      ICEcoderWin = window.open('', target, 'width=1200,height=640,toolbar=no,menubar=no,location=no,status=no,scrollbars=no,resizable=no,left=10000,top=10000,visible=none', true);
      // I don't know how to hide it so let's minimize it
      ICEcoderWin.resizeTo(10,10);
      ICEcoderWin.moveTo(1000,1000);
      
    } else {
      ICEcoderWin = window.open('', target, 'width=1200,height=640,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50', true);
      ICEcoderWin.resizeTo(1200,640);
      ICEcoderWin.moveTo(100,50);
    }
    if(ICEcoderWin.location.href === 'about:blank'){
        ICEcoderWin.location.href = url;
    }
	
	
	ICEcoderWin.open_editor_path(file);
	// test go to line 3
	//window.top.ICEcoder.goToLine(3);
	//ICEcoderWin.goToLine(3);
    return ICEcoderWin;
}
// ICECODER_TESTING
</script>
<!-- ici hyper activity de la page -->
<!--
	<a nohref="" onclick='openOnceTest("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor","/doc/files/common/ui_test.run");' style="cursor: pointer">openOnceTest()</a><br/>
	<a nohref="" onclick="edit_with_icecoder('/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/', 'editor', 'c:/UniServer/www/doc/files/common/', 'open-command-prompt-here.html', 'ICECODER_TESTING');" style="cursor: pointer">edit_with_icecoder()</a><br/>
    <a nohref="" onclick="testIce();" style="cursor: pointer">testIce()</a><br/><br/><br/>


<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/eXtplorer2-1-15/config/.htusers.php");  return false;'><img src="./images/text.png" title="mntFiles.rn"/></a>&nbsp; 
<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "/doc/files/common/permalinux/mntFiles.rn");  return false;'><img src="./images/text.png" title="mntFiles.rn"/></a>&nbsp; 
<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "/doc/files/common/open-command-prompt-here.html");  return false;'><img src="./images/text.png" title="open-command-prompt-here.html"/></a>&nbsp; 
<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "/doc/files/common/downloadfile.php");  return false;'><img src="./images/text.png" title="downloadfile.php"/></a>&nbsp; 
<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "/doc/files/common/instantedithead.js");  return false;'><img src="./images/text.png" title="instantedithead.js"/></a>&nbsp; 
<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "/doc/files/common/updatehead.php");  return false;'><img src="./images/text.png" title="updatehead.php"/></a>&nbsp; 
<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "viewlfile/viewdos.php");  return false;'><img src="./images/text.png" title="viewdos.php"/></a>&nbsp; 
<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "/doc/files/common/write_ckfile.php");  return false;'><img src="./images/text.png" title="write_ckfile.php"/></a>&nbsp; 
<a href="#" onclick='openOnce("/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder2/", "editor", "/doc/files/common/psexec.php");  return false;'><img src="./images/text.png" title="psexec.php"/></a>&nbsp; 
-->


<!--
<iframe id="other" src="othersites.php?urldir=<?php echo $urldir; ?>" />
-->
</body>
</html>
<!--//-->