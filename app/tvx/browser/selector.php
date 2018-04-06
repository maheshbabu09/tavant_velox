<?php

echo BrowseImageFile();

echo "<script type='text/javascript'>

        function selectFile(filename){

        var sel_file='/tavant-velox/images/'+filename;

        window.parent.window.opener.CKEDITOR.tools.callFunction(window.parent.GetFuncNum(), sel_file, '');

        window.parent.window.close();}

        function cancelSelectFile(){window.parent.window.close();}

    </script>";



function IsSupportedImgFile($filename)

{

	$supported_type = array('gif', 'jpeg', 'jpg', 'pjpeg', 'png', 'bmp');
	
	$tmp = explode('.', $filename);

    return in_array(end($tmp), $supported_type);

}



function BrowseImageFile()

{

	$s = '<button onClick="cancelSelectFile()">Cancel</button><br>';

	$location = '../images';

	$files = scandir($location);

	foreach($files as $filename)

	{

		$this_file = $location.'/'.$filename;

		if( is_file($this_file) && IsSupportedImgFile($filename) )

        {

            $s .= '<div id="'.$filename.'" onClick="selectFile(this.id)" style="cursor:pointer;float:left;padding:10px;">

                    <a>'.$filename.'<img src="'.$this_file.'" width="40px" height="30px"></a>

                </div>';

		}

	}

	return $s;

}

?>

