<?php
header('X-XSS-Protection:0');
require('includes/config.php');
$title = $_REQUEST['title'];
$content = $_REQUEST['content'];
$url_alias = $_REQUEST['url_alias'];
if(isset($_POST['submit'])) {
	$form_data['title'] = $_POST['title'];
	$form_data['content'] = base64_decode($_POST['content']);
	$form_data['url_alias'] = $_POST['url_alias'];
	if(!empty($_POST['id'])) {
		$id = $_POST['id'];
		$fetgv = $velox->get_velox_page($id);
		$last_revision = $fetgv['content'];	
		$form_data['last_revision'] = $last_revision; 
		$velox->update_page($form_data,$id);
		$action = "update";	
	} else {
		$velox->create_page($form_data);
		$action = "insert";			
	}
	$fp = fopen("../".$url_alias.".html","wb");
	fwrite($fp,$form_data['content']);
	fclose($fp);
	header("Location: velox_pages.php?action=".$action);
}
if(isset($_POST['last_revision'])) {
	$id = $_POST['id'];
	$last_revision_content = $velox->get_velox_page($id);
	$title = $last_revision_content['title'];
	$content = $last_revision_content['last_revision'];
	$url_alias = $last_revision_content['url_alias'];
	$_REQUEST['id'] = $id;
}
?>
<?php echo $content;?>
<div class="preview">
	<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
	<input type="hidden" value="<?php echo $title;?>" name="title">
	<input type="hidden" value="<?php echo base64_encode($content);?>" name="content">
	<input type="hidden" value="<?php echo $url_alias;?>" name="url_alias">
	<input type="hidden" value="<?php echo isset($_REQUEST['id'])?$_REQUEST['id']:"";?>" name="id">
	Preview Mode<br/>
	<input type="submit" value="Publish" name="submit" class="btnprimary" /> (or) <input type="button" value="Cancel" onclick="location.href='velox_pages.php'" class="btnprimary"/>
	</form>
</div>
<style>
.preview {
	 font-size: 24px;
	 display: inline-block;
	 text-decoration: none;
	 position: fixed;
	 top: 70px;
	 z-index: 1000;
	 left: 43%;
	 background: #f2f2f2;
	 border-radius: 5px;
	 width:300px;
	 height:190px;
	 border: 1px solid silver;
	 text-align: center;
	 padding: 10px;
	}
.btnprimary {
	width: 100%;
	display: block;
	padding: 10px 16px;
    font-size: 18px;
    line-height: 1.3333333;
    border-radius: 6px;
	color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
	cursor:pointer;
}
.btnprimary:hover {
    color: #fff;
    background-color: #286090;
    border-color: #204d74;
	cursor:pointer;
}
</style>