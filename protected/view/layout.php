<!DOCTYPE html>
<html lang="ru">
	<head>	
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="/css/style.css" rel="stylesheet" type="text/css"/>
		<title><?php echo $act->title;?></title>
	</head>
	<body>
		<div class="container-fluid">
			<?php  require_once APP_PATH."/view/_navigation.php"; ?>
			<?php if($act->view){ require_once APP_PATH."/view/_{$act->view}.php"; }?>
		</div>
	</body>
</html>