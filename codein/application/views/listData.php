<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link type="text/css" href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }
	</style>
</head>
<body>

<div class="container">
	<h1>List Data!</h1>
	<?php
		if(isset($path)){
			foreach($path as $path_view){
				$this->load->view($path_view);
			}
		}

	?>
</div>

</body>
</html>