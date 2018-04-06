<?php 
require('includes/config.php'); 
$id = $_GET['id'];
$content = $velox->get_velox_page($id);
$url_alias = $content['url_alias'];
$is_remove = $velox->remove_page($id);
if($is_remove) {
	unlink("../".$url_alias.".html");
	header('Location: velox_pages.php?action=delSuccess');
} else {
	header('Location: velox_pages.php?action=delFailure');
}
?>