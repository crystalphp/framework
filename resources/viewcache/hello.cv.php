<html>
<head>
	<title>Welcome to crystal</title>
</head>
<body>
	
	<center>
		<h1>Welcome to your new crystal project</h1>
		<?php vu_content($data); ?>
		<h3>start your coding from app/routes.php file</h3>
		
	</center>

	<?php for($i = 0; $i < count($data['peoples']); $i++): ?>
		<?php vu('test.peopleItem' , $data['peoples'][$i]) ?>
	<?php endfor; ?>


</body>
</html>