<?php
	/*
	****	create by Mohamad Yunus
	****	on 9 November 2021
	****	revise:
	*/
	//	session start
	session_start();
	
	//	connect to svrdbn
	include '../../adodb/con_jeinultah.php';
	
	//	execute query
    $sql 		= "select * from tblUltah25Employee where hadiah != 'BELUM BERUNTUNG'";
    $rs 		= $db->Execute($sql);
?>
<html>
<head>
	<title>Data JKEI Ultah 25th</title>
</head>
<body>
<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=jeinultah25th.xls");
	
	echo '<table border="1">';
		echo '<tr>';
			echo '<th>No</th>';
			echo '<th>NIK</th>';
			echo '<th>NAMA</th>';
			echo '<th>DEPT</th>';
			echo '<th>JOB STATUS</th>';
			echo '<th>JOIN DATE</th>';
			echo '<th>HADIAH</th>';
		echo '</tr>';
		
		$no = 1;
		while(!$rs->EOF){
			echo '<tr>';
				echo '<td>'.$no.'</td>';
				echo '<td>'.$rs->fields[0].'</td>';
				echo '<td>'.$rs->fields[1].'</td>';
				echo '<td>'.$rs->fields[2].'</td>';
				echo '<td>'.$rs->fields[3].'</td>';
				echo '<td>'.$rs->fields[4].'</td>';
				echo '<td>'.$rs->fields[5].'</td>';
			echo '</tr>';
			$no++;
			$rs->MoveNext();
		}
	echo '</table>';
	$rs->Close();
?>
</body>
</html>
<?php	
	$db->Close();
?>