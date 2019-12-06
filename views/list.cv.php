<h1>People</h1>
<?php

foreach ($data['peoples'] as $item) {
	vu('Item' , ['name' => $item]);
}

?>