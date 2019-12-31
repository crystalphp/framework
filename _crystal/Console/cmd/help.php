<?php

function cmd_run($args){



echo '
Crystal Console Help:
	down: down application and in every where show an static page
	up: up the application
	status: show app status(up or down)
	make <itemname>: make items like controller, model ans...
	mix-resources: mix all of file in resources/js and resources/css into public/css/style.css and public/js/scripts.js
		also you can run mix-resources <itemname>(js/css) to just mix them
	start <port?>: serve the app on localhost:8000 or your custome port
	license: to show framework license
	help: show this help
';



}
