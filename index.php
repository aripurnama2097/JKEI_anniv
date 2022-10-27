<!--
/**
****	create by Mohamad Yunus
****	on 31 Oktober 2018
****	remark:  -
**/
-->
<!DOCTYPE HTML>
<html>
<head>
	<title>JKEI Anniversary</title>
	<style>		
		/* style the footer */
		footer {
			background: #F3F3F3;
			padding: 1px;
			width: 100%;
			border-top: 1px solid #CACACA;
			text-align:center;
			position: fixed;
			bottom: 0;
			margin-left: -7px;
		}
		footer  p {
			color: #7A7676;
			font-size: 14px;
		}
		footer  p a{
			color:#F44336;
		}
		footer  p a:hover{
			text-decoration:underline;
		}
	</style>
	<!-- Additional content -->
	<link rel="stylesheet" type="text/css" href="../extjs-4.2.2/resources/css/ext-all-gray.css" />
	<script type="text/javascript" src="../extjs-4.2.2/ext-all.js"></script>
	<link href="css/styleforextjs.css" rel="stylesheet">
	<link rel="shortcut icon" href="icons/jeinultah.ico"/>
</head>
<?php
	//	cek content
	if(!empty($_GET['content'])){
		$page_dir = 'content';
		$thispages = scandir($page_dir);
		unset($thispages[0], $thispages[1]);
		
		$str 	= $_GET['content'];
		$pisah 	= explode("?",$str);				

		$content = $pisah[0];
		if(in_array($content.'.php', $thispages)){
			include_once('content/'.$content.'.php');
		} else { }
	}
	else{
		echo '<meta http-equiv="refresh" content="0;url=index.php?content=dashboard">';
	}
	//	--end for cek content--
?>
</html>