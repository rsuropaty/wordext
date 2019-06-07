<?php
	// $file = upload();
	// var_dump($file);
	
	echo "<pre>";
	var_dump (read_docx('uploads/soal_uas.docx'));
	

	function upload()
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);

		if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file))
		{
	        // echo "The file ". basename( $_FILES["uploaded_file"]["name"]). " has been uploaded.";
	        return $target_file;
	    }
	    else
	    {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
	

	function read_docx($file){

        $striped_content = '';
        $content = '';

        $zip = zip_open($file);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
            // $wmf[] = strpos($content, "<o:OLEObject");
            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $found = substr_count($content, "<o:OLEObject");
        $content = preg_replace('/<o:OLEObject[^>]*>*/', 'img', $content);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);
        $striped_content = explode("\r\n", $striped_content);

        $striped_content = str_replace('img', "<img src=\"docx_extract/word/media/image1.wmf\"/>", $striped_content);

        return $striped_content;
    }

    function docx_extract($file_docx)
    {
    	$zip = new ZipArchive;
    	$res = $zip->open($file_docx);

    	if($res === TRUE)
    	{
    		$zip->extractTo('docx_extract/');
    		$zip->close();
    	}
    	else
    	{
    		echo "Gagal!";
    		die;
    	}
    }

    function read_bin($file_bin)
    {
    	$handle = fopen($file_bin, "rb");
    	$content = fread($handle, filesize($file_bin));
    	fclose($handle);
    	echo "<pre>";
    	var_dump($content);
    }

    function wmftoimg($wmf)
    {
    	try
    	{
            // echo $wmf;
            // die;

    		$image = new Imagick();
            $image->setresolution(300, 300);
            $image->readimage($wmf);
            $image->resizeImage(1500,0,Imagick::FILTER_LANCZOS,1);
            $image->setImageFormat('jpg');
            $image->writeImage("1.jpg");

            header ("Content-Type: image/jpg"); 
            $data = $image->getImageBlob(); 
            echo $data; 
            file_put_contents ('test.jpg', $data); 
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    	}
    }
?>