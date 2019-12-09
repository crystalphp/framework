<?php

foreach($data['users'] as $user){
?>
<div>
	Email: <?= $user->email ?>
	<br />
	Username: <?= $user->username ?>
</div>
<?php
}

?>