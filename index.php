<?php
$maxsize = 10*1000000000; //10 Gb
$dir = '/dirname';


function convert($size){
    $unit=array('byte','Kb','Mb','Gb','Tb','Pb','Eb','Zb','Yb');
    return @round($size/pow(1000,($i=floor(log($size,1000)))),2).' '.$unit[$i];
}
function get_dirsize($dirname){
    $dirsize = 0;
    if($dir = opendir($dirname)){
        while($file = readdir($dir)){
            if($file == "." || $file == ".."){
            }elseif(is_dir($dirname.'/'.$file)){
              $dirsize = $dirsize+get_dirsize($dirname . "/" . $file);
            }else{
              $dirsize = $dirsize+filesize($dirname."/".$file);
            }
        }
        closedir($dir);
    }
    return $dirsize;
}

$maxh = get_dirsize($dir);
$scan = scandir($dir);
$folders = array();

foreach($scan as $file)
{
    if (is_dir($dir."/".$file))
    {
        if($file != '.' and $file != '..'){
        	$folders[$file] = get_dirsize($dir.'/'.$file);
        }
    }
}

$color = array('#FFB900','#E74856','#0078D7','#7A7574','#0099BC','#F7630C','#8E8CD8','#69797E','#647C64','#0063B1','#00B294');



$szazalek = ($maxh*100)/$maxsize;
?>
<table><tr><td style="width: 120px;">
<b>Full size</b></td><td><div class="proress_alap">
<div class="proress_data" style="width:<?=$szazalek ?>%;"></div>
</div>
<div class="proress_text"><?=convert($maxh) ?> / <?=convert($maxsize) ?></div>
</td></tr><tr><td></td><td>
<div class="proress_alap"><?php
$i = 0;
foreach ($folders as $key => $value){
$szazalek = ($value*100)/$maxh;
?>
<div class="proress_data" style="width:<?=$szazalek ?>%;background:<?=$color[$i] ?>;"></div>
<?php
if($i+1<count($color)){
$i++;
}else{
$i = 0;
}
}
?></div>
<div class="proress_text"><?=convert($maxh) ?></div>
</td></tr>
<?php 
$i = 0;
foreach ($folders as $key => $value){
$szazalek = ($value*100)/$maxh;
?>
<tr><td><?=$key ?></td><td><div class="proress_alap"><div class="proress_data" style="width:<?=$szazalek ?>%;background:<?=$color[$i] ?>;"></div></div>
<div class="proress_text"><?=convert($value) ?></div>
</td></tr>
<?php
if($i+1<count($color)){
$i++;
}else{
$i = 0;
}
}
?>
</table>
