<?php
$funcNum = $_GET['CKEditorFuncNum'] ;
echo '<iframe style="width:98%; height: 98%;" src="selector.php"></iframe>';
echo "<script type='text/javascript'>function GetFuncNum(){ return '".$funcNum."'; }</script>";
?>
