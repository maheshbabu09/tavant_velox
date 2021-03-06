<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define page title
$title = 'Add Velox Page';

//include header template
require('layout/header.php'); 
include "ckeditor/ckeditor/ckeditor.php";
?>

<div class="container">
	<?php require('layout/welcome.php'); ?>
	<div class="row">

	    <div class="col-md-12">		
<form role="form" action="submit_page.php" method="post">
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
  <th colspan="2"><h2>Add Velox Page</h2> <a href="velox_pages.php">Back to List</a></th>
  </tr>
    <tr>
	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Title</td>
    <td><input name="title" type="text" style="width:300px; padding:2px;" /></td>
  </tr>
  <tr>
	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Content</td>
    <td>
			<?php
  
						$CKeditor = new CKeditor();
						$CKeditor->BasePath = 'ckeditor/';
						$CKeditor->config['filebrowserBrowseUrl'] = 'ckfinder/ckfinder.html';
						$CKeditor->config['filebrowserImageBrowseUrl'] = 'browser/browser.php?type=Images';
						$CKeditor->config['filebrowserFlashBrowseUrl'] = 'ckfinder/ckfinder.html?type=Flash';
						$CKeditor->config['filebrowserUploadUrl'] = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
						$CKeditor->config['filebrowserImageUploadUrl'] = 'uploader/uploader.php?type=Images';
						$CKeditor->config['filebrowserFlashUploadUrl'] = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
						$CKeditor->config['fullPage'] = true;
						$CKeditor->config['ProtectedTags'] = 'html|head|body';	
						$CKeditor->config['allowedContent'] = true;
						$CKeditor->editor('content','');   
												
												
					?>
								</td>
  </tr>
  <tr>
	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
	<td>URL alias</td>
	<td><input type"text" name="url_alias"></td>
  </tr>
  <tr>
	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input class="btnprimary" name="sub" type="submit" value="Preview & Publish" /></td>
    
  </tr>
  <tr>
	<td colspan="2">&nbsp;</td>
  </tr>
</table>

</form>
		</div>
	</div>


</div>

<?php 
//include header template
require('layout/footer.php'); 
?>
