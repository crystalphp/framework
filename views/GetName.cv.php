
<h2>enter your name:</h2>
<form method="post">
	<?php
	GetInfoForm::render('name');
	echo '<br />';
	GetInfoForm::render('age');
	?>
	<input type="submit" />
</form>
