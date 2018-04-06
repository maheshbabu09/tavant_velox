<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define page title
$title = 'Velox Pages';

//include header template
require('layout/header.php'); 
include "ckeditor/ckeditor/ckeditor.php";
$rows = $velox->get_velox_pages();
?>

<div class="container">
		<?php require('layout/welcome.php'); ?>
		<div class="row">
			<div class="col-md-12">
				<?php 
				if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'insert':
							echo "<h2 class='bg-success'>Successfully created new page.</h2>";
							break;
						case 'update':
							echo "<h2 class='bg-success'>Successfully updated page.</h2>";
							break;
						case 'delSuccess':
							echo "<h2 class='bg-success'>Successfully removed page.</h2>";
							break;
						case 'delFailure':
							echo "<h2 class='bg-danger'>Problem while deleting page.</h2>";
							break;						
					}

				}
				?>
			</div>
		</div>
	<div class="row">
		<div class="col-md-12">
		<h2>List of Pages</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-right">
		<a href="add_page.php">Add Page</a>
		</div>
	</div>
	<div class="row">		
	    <div class="col-md-12">		
		
		
<table class="table table-bordered table-striped" width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
  <th>Title</th>
  <th>Actions</th>
  </tr>
	<?php for ($i=0;$i<count($rows);$i++) { ?>
    <tr>
	<td><?php echo $rows[$i]['title'];?></td>
	<td><a href="edit_page.php?id=<?php echo $rows[$i]['id'];?>">Edit</a> | <a href="#" onclick="remove_page(<?php echo $rows[$i]['id'];?>)">Remove</a> | <a target="_blank" href="view_page.php?id=<?php echo $rows[$i]['id'];?>">Preview</a></td>
  </tr>
	<?php } ?>
</table>

</form>
		</div>
	</div>


</div>

<?php 
//include header template
require('layout/footer.php'); 
?>
<script>
function remove_page(id) {
	var conf = confirm("Are you sure want to delete page!!");
	if(conf) {
		location.href = "remove_page.php?id="+id;
	} else {
		return;
	}
}
</script>
