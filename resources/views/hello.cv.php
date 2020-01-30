<html>
<head>
	<title>Welcome to crystal</title>
	<style>
		body{
			background-color: rgb(200,200,210);
		}

		ul > li{
			list-style: none;
			display: inline-block;
			margin: 10px;
		}

		ul > li > a{
			text-decoration: none;
			color: black;
		}

		ul > li > a:hover{
			color: rgb(80,80,80);
		}
	</style>
</head>
<body>

	<center>
		<h1>Crystal</h1>
		<ul>
			<li><a href="http://crystalphp.com">Crystal</a></li>
			<li><a href="http://blog.crystalphp.com">Blog</a></li>
			<li><a href="http://forums.crystalphp.com">Forums</a></li>
			<li><a href="http://crystalphp.com/docs">Documentation</a></li>
			<li><a href="http://tutorials.crystalphp.com">Tutorials</a></li>
		</ul>
	</center>
	

		<input type="text" id="username" />
		<input type="password" id="password" />

		<button onclick="ajax('login' , ['#username' , '#password'])">login</button>


	<script src="/js/scripts.js"></script>

</body>
</html>
