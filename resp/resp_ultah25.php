<?php
	/*
	****	create by Mohamad Yunus
	****	on 2 November 2021
	****	remark: -
	*/  
	include('../../ADODB/con_jeinultah.php');
	
	$typeform	= $_REQUEST['typeform'];
	switch ($typeform)
	{
		//***
		//response reset
		case 'reset':
			//	declare
			//	execute query
			try
			{
				$sql 	= "exec resetUltah25Data;";
				$rs 	= $db->Execute($sql);
				$rs->Close();
				
				$var_msg = 1;
			}
			catch (exception $e)
			{
				$var_msg = $db->ErrorNo();
			}
			
			//	message
			switch ($var_msg)
			{
				case ($var_msg != 1):
					$err		= $db->ErrorMsg();
					$error 		= str_replace( "'", "`", $err);
					$error_msg 	= str_replace( "[Microsoft][ODBC SQL Server Driver][SQL Server]", "", $error);
					
					echo "{
						'success': false,
						'msg': '0, $error_msg'
					}";
					break;
				
				case 1:
					echo "{
						'success': true,
						'msg': '1, Data has been reset.'
					}";
					break;
			}
		break;
		
		//***
		//response undian
		case 'undian':
			//	declare
			$barangid 		= $_REQUEST['barangid'];
			$empstatus 		= $_REQUEST['empstatus'];
			$barangtotal 	= $_REQUEST['barangtotal'];
			
			//	execute query
			try
			{
				$sql 	= "exec insUltah25ResultUndian '{$barangid}', '{$empstatus}', '{$barangtotal}';";
				$rs 	= $db->Execute($sql);
				$rs->Close();
				
				$var_msg = 1;
			}
			catch (exception $e)
			{
				$var_msg = $db->ErrorNo();
			}
			
			//	message
			switch ($var_msg)
			{
				case ($var_msg != 1):
					$err		= $db->ErrorMsg();
					$error 		= str_replace( "'", "`", $err);
					$error_msg 	= str_replace( "[Microsoft][ODBC SQL Server Driver][SQL Server]", "", $error);
					
					echo "{
						'success': false,
						'msg': '0, $error_msg'
					}";
					break;
				
				case 1:
					echo "{
						'success': true,
						'msg': '1, Succesfull.'
					}";
					break;
			}
		break;
		
		//***
		//response hadir
		case 'hadir':
			//	declare
			$empno			= $_REQUEST['empno'];
			$hadiah			= $_REQUEST['hadiah'];
			$gelombangid	= $_REQUEST['gelombangid'];
			$ipaddress		= getenv("REMOTE_ADDR");
			
			//	execute query
			try
			{
				$sql 	= "exec insUltah25Hadir '{$empno}', '{$hadiah}', '{$gelombangid}', '{$ipaddress}';";
				$rs 	= $db->Execute($sql);
				$rs->Close();
				
				$var_msg = 1;
			}
			catch (exception $e)
			{
				$var_msg = $db->ErrorNo();
			}
			
			//	message
			switch ($var_msg)
			{
				case ($var_msg != 1):
					$err		= $db->ErrorMsg();
					$error 		= str_replace( "'", "`", $err);
					$error_msg 	= str_replace( "[Microsoft][ODBC SQL Server Driver][SQL Server]", "", $error);
					
					echo "{
						'success': false,
						'msg': '0, $error_msg'
					}";
					break;
				
				case 1:
					echo "{
						'success': true,
						'msg': '1, Data has been reset.'
					}";
					break;
			}
		break;
		
		//***
		//response tidakhadir
		case 'tidakhadir':
			//	declare
			$empno			= $_REQUEST['empno'];
			$hadiah			= $_REQUEST['hadiah'];
			$gelombangid	= $_REQUEST['gelombangid'];
			$ipaddress		= getenv("REMOTE_ADDR");
			
			//	execute query
			try
			{
				$sql 	= "exec insUltah25TidakHadir '{$empno}', '{$hadiah}', '{$gelombangid}', '{$ipaddress}';";
				$rs 	= $db->Execute($sql);
				$rs->Close();
				
				$var_msg = 1;
			}
			catch (exception $e)
			{
				$var_msg = $db->ErrorNo();
			}
			
			//	message
			switch ($var_msg)
			{
				case ($var_msg != 1):
					$err		= $db->ErrorMsg();
					$error 		= str_replace( "'", "`", $err);
					$error_msg 	= str_replace( "[Microsoft][ODBC SQL Server Driver][SQL Server]", "", $error);
					
					echo "{
						'success': false,
						'msg': '0, $error_msg'
					}";
					break;
				
				case 1:
					echo "{
						'success': true,
						'msg': '1, Data has been reset.'
					}";
					break;
			}
		break;
	}
	//	connection close
	$db->Close();
?>