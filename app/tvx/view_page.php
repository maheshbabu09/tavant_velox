<?php
require('includes/config.php');
$id = $_GET['id'];
$fetgv = $velox->get_velox_page($id);
?>
<?php echo $fetgv['content']; ?>
 