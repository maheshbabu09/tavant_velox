<?php

$funcNum = $_GET['CKEditorFuncNum'] ;

$url = '/tavant-velox/images/'.$_FILES["upload"]["name"];

$message = UploadImageFile();



echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '".$url."', '".$message."');</script>";



function UploadImageFile()

{

    $warning = '';

    if ( strncasecmp($_FILES["upload"]["type"], "image/", 6)  == 0 )

    {

        if ($_FILES["upload"]["error"] > 0)

        {

            $warning = "Return Code: " . $_FILES["upload"]["error"] ;

        }

        else

        {

            $file_name = $_FILES["upload"]["name"];

            $move_to_file = "../images/" . $file_name;



            if (file_exists($move_to_file))

            {

                $warning = $file_name . " already exists.";

            }

            else

            {

                if( !@move_uploaded_file($_FILES["upload"]["tmp_name"], $move_to_file) )

                {

                    $warning = 'Upload Failed!';

                }

            }

        }

    }

    else

    {

        $warning = "Invalid file";

    }

    return $warning;

}

?>

