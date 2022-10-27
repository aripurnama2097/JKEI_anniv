<!--
/**
****	create by Mohamad Yunus
****	on 31 Oktober 2018
****	remark:
**/
-->
<!--
****	body
-->
<body bgcolor="#A0B8FF" style="padding:5px; background-image: url(icons/dashboard.jpg);background-size: cover;">
	<p style="text-align:center;"><font size="5"> JKEI ANNIVERSARY </font></p>
	<br><br><br><br>
	<table cellpadding="2" cellspacing="0" width="40%" border="0">
		<tr align="center">
			<td width="100%"> <a href="index.php?content=ultah21"><img src="icons/ultah21.png" style="max-height:100px;"></a> <br> <span style="color:#0c1840;">Anniversary 21th</span> </td>
		</tr>
		<tr align="center">
			<td width="100%"> <a href="index.php?content=ultah23"><img src="icons/23th.jpg" style="max-height:50px;"></a> <br> <span style="color:#0c1840;">Anniversary 23th</span> </td>
		</tr>
		<tr align="center">
			<td width="100%"> <a href="index.php?content=ultah24"><img src="icons/24th.jpg" style="max-height:50px;"></a> <br> <span style="color:#0c1840;">Anniversary 24th</span> </td>
		</tr>
		<tr align="center">
			<td width="100%"> <a href="index.php?content=ultah25"><img src="icons/25th.jpg" style="max-height:50px;"></a> <br> <span style="color:#0c1840;">Anniversary 25th</span> </td>
		</tr>
	</table>
</body>

<footer>
	<?php if (date("Y") == 2018){ ?>
	<p> &copy; <?php echo date("Y"); ?> IT Department. All Rights Reserved | Version 1.0.0 </p> 
	<?php }else{ ?>
	<p> &copy; 2018 - <?php echo date("Y"); ?> IT Department. All Rights Reserved | Version 1.0.0 </p> 
	<?php } ?>
</footer>