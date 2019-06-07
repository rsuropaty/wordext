<!-- <!DOCTYPE html>
<html>
<head>
	<title>Wordext</title>
</head>
<body>
	<form enctype="multipart/form-data" action="file_upload.php" method="post">
		<input type="file" name="uploaded_file">
		<input type="submit" value="submit">
	</form>
</body>
</html> -->

<?php

include 'file_upload.php';

// docx_extract('uploads/soal_uas.docx');
// read_bin('docx_extract/word/embeddings/oleObject1.bin');
// read_bin('docx_extract/word/embeddings/oleObject2.bin');

wmftoimg('/docx_extract/word/media/image2.wmf');