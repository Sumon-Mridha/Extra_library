<?php 
	require 'File.php'; 
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="./" method="POST" enctype="multipart/form-data">
		<input type="file" name="file">
		<button type="submit">upload</button>
	</form>
	<form action="./" method="POST">
		<input type="hidden" name="delete">
		<button type="submit">delete</button>
	</form>
	<form action="./" method="POST">
		<input type="hidden" name="rename">
		<button type="submit">rename</button>
	</form>
</body>
</html>

<?php 
if (isset($_FILES['file'])) {
	$obj = new File('file',__DIR__);
	if ($obj->upload()) {
		echo 'done';
	}else{
		echo 'faield';
	}
}
if (isset($_POST['delete'])) {
	$obj = new File('file.jpg',__DIR__);
	$obj->delete();
}
if (isset($_POST['rename'])) {
	$obj = new File('website.jpg',__DIR__,'file.jpg');
	$obj->rename();
}