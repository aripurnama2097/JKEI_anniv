<?php
	/*
	****	create by Mohamad Yunus
	****	on 09 November 2017
	****	revise: -
	*/
	//	connection open
	include('../ADODB/con_jeinultah.php');
	
	//	delete data result undian
	$rs = $db->execute("delete from tblUltah21ResultUndian");
	$rs->Close();
	
	//	connection close
	$db->Close();
?>
<style>
body {
  padding:5px;
}
</style>
<!--
****	content extjs
-->
<script type="text/javascript">
	Ext.Loader.setConfig({enabled:true});
	Ext.Loader.setPath('Ext.ux','../extjs-4.2.2/examples/ux');
	
	Ext.onReady(function(){
		Ext.QuickTips.init();
		
		//	All about function
		//	***
			//	function untuk fontsize grid
				function upsize(val) {
					return '<font size="3" style="font-family:sans-serif; white-space:normal; line-height:1.5;">' + val + '</font>';
				}
			//	function untuk numeric
				function convertToRupiah(angka)
				{
					var rupiah 		= '';
					var angkarev 	= angka.toString().split('').reverse().join('');
					for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
					return rupiah.split('',rupiah.length-1).reverse().join('');
				}
				
				function numeric(val) {
					if (val > 0) {
						return '<font size="2" style="font-family:sans-serif; white-space:normal; color:green; float:right;">' + convertToRupiah(val) + '</font>';
					} else if (val <= 0) {
						return '<font size="2" style="font-family:sans-serif; white-space:normal; color:red; float:right;">' + convertToRupiah(val) + '</font>';
					} else {
						return '<font size="2" style="font-family:sans-serif; white-space:normal; color:gray; float:right;">' + val + '</font>';
					}
					return val;
				}
			//	function untuk combine kolom grid
				function combinecolsinput(value, meta, record, rowIndex, colIndex, store) {
					value2 = record.get('input_date');
					return '<font size="2" style="font-family:sans-serif; white-space:normal; line-height:1.5;">' + value + '<br>' + value2 + '</font>';
				}
				function combinecolsupdate(value, meta, record, rowIndex, colIndex, store) {
					value2 = record.get('update_date');
					return '<font size="2" style="font-family:sans-serif; white-space:normal; line-height:1.5;">' + value + '<br>' + value2 + '</font>';
				}
			//	function required
				var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
			//	new date
				var date = new Date();		
		//	----***----  //
		
		//	All about json data
		//	***
			var itemperpage = 100;
			//	data
				Ext.define('ultah21',{
					extend:'Ext.data.Model',
					fields:[ 'empno', 'empname', 'division', 'dept', 'status', 'hadiah', 'input_user', 'input_date', 'update_user', 'update_date' ]
				});
				var datastore = Ext.create('Ext.data.JsonStore', {
					model       : 'ultah21',
					autoLoad    : true,
					pageSize    : itemperpage,
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_ultah21.php',
						reader	: {
							type			: 'json',
							root			: 'rows',
							totalProperty	: 'totalcount'
						}
					}
				});
				Ext.define('ultah21empno',{
					extend:'Ext.data.Model',
					fields:[ 'empno']
				});
				var dsempno = Ext.create('Ext.data.JsonStore', {
					model       : 'ultah21empno',
					autoLoad    : true,
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_ultah21empno.php',
						reader	: {
							type	: 'json',
							root	: 'rows'
						}
					}
				});
			//	combobox
				Ext.define('ultah21cbxgelombang',{
					extend:'Ext.data.Model',
					fields:[ 'gelombangid', 'gelombangname' ]
				});
				var dscbx_gelombang = Ext.create('Ext.data.JsonStore', {
					model       : 'ultah21cbxgelombang',
					autoLoad    : true,
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_ultah21cbxgelombang.php',
						reader	: {
							type	: 'json',
							root	: 'rows'
						}
					}
				});
		//	----***----  //
		
		//	All content
		//	***
			//	form
				var formdata	= Ext.widget('form', {
					layout		: {
						type: 'vbox',
						align: 'stretch'
					},
					frame			: false,
					border			: false,
					bodyStyle		: 'background:transparent;',
					bodyPadding		: 35,
					buttonAlign:'center',
					fieldDefaults	: {
						labelWidth	: 100,
						labelAlign	: 'top',
						labelStyle	: 'font-weight:bold',
					},
					items: [
						{
							xtype		: 'label',
							text		: 'JEIN ANNIVERSARY 21th',
							anchor		: '100%',
							style		: 'font-weight:bold; text-align:center; font-size:15pt; color:black;'
						}, {
							xtype		: 'label',
							id			: 'lbl_message',
							text		: '00000',
							anchor		: '100%',
							style		: 'font-weight:bold; text-align:center; font-size:80pt; color:#0D0D8A;'
						}
					],
					buttons			: [
						{
							xtype				: 'combo',
							id					: 'gelombangid',
							name				: 'gelombangid',
							queryMode			: 'local',
							displayField		: 'gelombangname',
							valueField			: 'gelombangid',
							emptyText			: 'Kategori',
							width				: 180,
							height 				: 35,
							editable			: false,
							allowBlank			: false,
							store				: dscbx_gelombang
						}, {
							text		: '<div style="font-size:20px !important; font-weight:bold !important; color:#03216D;"> Putar </div>',
							id			: 'btn_play',
							width		: 150,
							height 		: 35,
							formBind	: true,
							handler		: function() {
								dsempno.loadPage(1);
								Ext.getCmp('btn_play').setVisible(false);
								Ext.getCmp('btn_stop').setVisible(true);
								var i 	= 1;
								var max = dsempno.data.length;
								(function looper() {
									if( i++ < max ) {
										Ext.getCmp('lbl_message').setText(dsempno.getAt(i).get('empno'));
										t = setTimeout(looper, 35);
									}
								})();
							}
						}, {
							text		: '<div style="font-size:20px !important; font-weight:bold !important; color:#6D0303;"> Berhenti </div>',
							id			: 'btn_stop',
							width		: 150,
							height 		: 35,
							hidden		: true,
							handler		: function() {
								Ext.getCmp('btn_play').setVisible(true);
								Ext.getCmp('btn_stop').setVisible(false);
								setTimeout(function () {
									var valgelombangid 	= Ext.getCmp('gelombangid').getValue();
									if (valgelombangid == 7){
										clearTimeout(t);
										Ext.getCmp('lbl_message').setText(Ext.getCmp('lbl_message').text);
										var valempno 	= Ext.getCmp('lbl_message').text;
										var box			= Ext.Msg.wait('sending data');
										Ext.Ajax.request({
											url		: 'resp/resp_ultah21.php',
											method	: 'POST',
											params	: 'empno='+valempno+'&typeform=undianlain',
											success	: function(response, opts) {
												var obj = Ext.decode(response.responseText);
												var r 	= obj.msg;
												var msg = r.split(",");
												box.hide();
												if (obj.success == true) {
													//	refresh data
													Ext.getCmp('valempno').reset();
													Ext.getCmp('valempname').reset();
													datastore.proxy.setExtraParam('valempno',	'');
													datastore.proxy.setExtraParam('valempname',	'');
													datastore.loadPage(1);
												}else{
													//	refresh data
													Ext.getCmp('valempno').reset();
													Ext.getCmp('valempname').reset();
													datastore.proxy.setExtraParam('valempno',	'');
													datastore.proxy.setExtraParam('valempname',	'');
													datastore.loadPage(1);
													
													//	response dari database
													Ext.Msg.show({
														title		:'Setel ulang data',
														icon		: Ext.Msg.ERROR,
														msg			: msg[1],
														buttons		: Ext.Msg.OK
													});
												}
											}
										});
									}
									else{
										var box = Ext.Msg.wait('sending data');
										Ext.Ajax.request({
											url		: 'resp/resp_ultah21.php',
											method	: 'POST',
											params	: 'gelombangid='+valgelombangid+'&typeform=undian',
											success	: function(response, opts) {
												var obj = Ext.decode(response.responseText);
												var r 	= obj.msg;
												var msg = r.split(",");
												box.hide();
												if (obj.success == true) {
													//	refresh data
													Ext.getCmp('valempno').reset();
													Ext.getCmp('valempname').reset();
													datastore.proxy.setExtraParam('valempno',	'');
													datastore.proxy.setExtraParam('valempname',	'');
													datastore.loadPage(1);
												}else{
													//	refresh data
													Ext.getCmp('valempno').reset();
													Ext.getCmp('valempname').reset();
													datastore.proxy.setExtraParam('valempno',	'');
													datastore.proxy.setExtraParam('valempname',	'');
													datastore.loadPage(1);
													
													//	response dari database
													Ext.Msg.show({
														title		:'Setel ulang data',
														icon		: Ext.Msg.ERROR,
														msg			: msg[1],
														buttons		: Ext.Msg.OK
													});
												}
											}
										});
										Ext.getCmp('lbl_message').setText('S.E.L.A.M.A.T');
										clearTimeout(t);
									}
								}, 10);
							}
						}
					]
				});
		
			//	grid
				var sm 			= Ext.create('Ext.selection.CheckboxModel');
				var clock 		= Ext.create('Ext.toolbar.TextItem', {text: Ext.Date.format(new Date(), 'g:i:s A')});
				var griddata	= Ext.create('Ext.grid.Panel', {
					store		: datastore,
					columnLines	: true,
					multiSelect	: true,
					selModel	: sm,
					viewConfig	: {
						stripeRows			: true,
						enableTextSelection	: true
					},
					columns: [
						{ header: 'No.', xtype: 'rownumberer', width: 50, height: 40, sortable: false },
						{ text: 'N.I.K', dataIndex: 'empno', width: 80,	renderer: upsize, sortable: false,
								layout: { type: 'vbox', pack: 'center', align: 'stretch' },
								items : [{
									xtype			: 'textfield',
									id				: 'valempno',
									name			: 'valempno',
									margin 			: 2,
									height			: 25,
									emptyText 		: 'Search',
									enableKeyEvents	: true,
									listeners	: {
										change	: function(f,new_val) {
											f.setValue(new_val.toUpperCase());
										},
										specialkey : function(field, e) {
											if (e.getKey() == 13) {
												datastore.proxy.setExtraParam('valempno', 	Ext.getCmp('valempno').getValue());
												datastore.proxy.setExtraParam('valempname', Ext.getCmp('valempname').getValue());
												datastore.loadPage(1);
											}
										}
									}
								}]
						},
						{ text: 'Nama', dataIndex: 'empname', width: 500, renderer: upsize, sortable: false,
								layout: { type: 'vbox', pack: 'center', align: 'stretch' },
								items : [{
									xtype			: 'textfield',
									id				: 'valempname',
									name			: 'valempname',
									margin 			: 2,
									height			: 25,
									emptyText 		: 'Search',
									enableKeyEvents	: true,
									listeners	: {
										change	: function(f,new_val) {
											f.setValue(new_val.toUpperCase());
										},
										specialkey : function(field, e) {
											if (e.getKey() == 13) {
												datastore.proxy.setExtraParam('valempno', 	Ext.getCmp('valempno').getValue());
												datastore.proxy.setExtraParam('valempname', Ext.getCmp('valempname').getValue());
												datastore.loadPage(1);
											}
										}
									}
								}]
						},
						{ text: 'Department',	dataIndex: 'dept',			flex: 1, renderer: upsize },
						{ text: 'Hadiah',		dataIndex: 'hadiah',		flex: 1, renderer: upsize }
					],
					listeners: {
						render: {
							fn: function(){
								Ext.fly(clock.getEl().parent()).addCls('x-status-text-panel').createChild({cls:'spacer'});

							 Ext.TaskManager.start({
								 run: function(){
									 Ext.fly(clock.getEl()).update(Ext.Date.format(new Date(), 'g:i:s A'));
								 },
								 interval: 1000
							 });
							},
							delay: 100
						}
					},
					tbar		: [
						{
							xtype	: 'button',
							id		: 'btn_home',
							width	: 40,
							height 	: 30,
							margins	: '0 5 0 0', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/home.png" style="max-height:20px;" /> </div>',
							tooltip	: 'Back',
							handler : function (){
								location.href = "index.php";
							}
						}, {
							xtype	: 'button',
							id		: 'btn_refresh',
							width	: 130,
							height 	: 30,
							margins	: '0 0 0 5', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/refresh.png" style="max-height:20px;" /> Segarkan</div>',
							tooltip	: 'Segarkan',
							handler : function (){
								Ext.getCmp('valempno').reset();
								Ext.getCmp('valempname').reset();
								datastore.proxy.setExtraParam('valempno', '');
								datastore.proxy.setExtraParam('valempname','');
								datastore.loadPage(1);
								dsempno.loadPage(1);
							}
						}, {
							xtype	: 'button',
							id		: 'btn_hadir',
							width	: 130,
							height 	: 30,
							margins	: '0 0 0 5', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/hadir.png" style="max-height:20px;" /> Hadir</div>',
							tooltip	: 'Hadir',
							handler : function (){
								var rec 		= griddata.getSelectionModel().getSelection();
								var reclength 	= rec.length;
								var i 			= 0;
								for (var i=0; i < reclength; i++) {
									var valempno 		= rec[i].data.empno;
									var valhadiah 		= rec[i].data.hadiah;
									var valgelombangid 	= Ext.getCmp('gelombangid').getValue();
									var box 			= Ext.Msg.wait('sending data');
									Ext.Ajax.request({
										url		: 'resp/resp_ultah21.php',
										method	: 'POST',
										params	: 'empno='+valempno+'&hadiah='+valhadiah+'&gelombangid='+valgelombangid+'&typeform=hadir',
										success	: function(response, opts) {
											var obj = Ext.decode(response.responseText);
											var r 	= obj.msg;
											var msg = r.split(",");
											box.hide();
											if (obj.success == true) {
												//	refresh data
												Ext.getCmp('valempno').reset();
												Ext.getCmp('valempname').reset();
												datastore.proxy.setExtraParam('valempno',	'');
												datastore.proxy.setExtraParam('valempname',	'');
												datastore.loadPage(1);
												dsempno.loadPage(1);
											}else{
												//	refresh data
												Ext.getCmp('valempno').reset();
												Ext.getCmp('valempname').reset();
												datastore.proxy.setExtraParam('valempno',	'');
												datastore.proxy.setExtraParam('valempname',	'');
												datastore.loadPage(1);
												dsempno.loadPage(1);
												
												//	response dari database
												Ext.Msg.show({
													title		:'Response system',
													icon		: Ext.Msg.ERROR,
													msg			: msg[1],
													buttons		: Ext.Msg.OK
												});
											}
										}
									});
								}
							}
						}, {
							xtype	: 'button',
							id		: 'btn_tidakhadir',
							width	: 130,
							height 	: 30,
							margins	: '0 0 0 5', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/tidakhadir.png" style="max-height:20px;" /> Tidak Hadir</div>',
							tooltip	: 'Tidak Hadir',
							handler : function (){
								var rec 		= griddata.getSelectionModel().getSelection();
								var reclength 	= rec.length;
								var i 			= 0;
								for (var i=0; i < reclength; i++) {
									var valempno 		= rec[i].data.empno;
									var valhadiah 		= rec[i].data.hadiah;
									var valgelombangid 	= Ext.getCmp('gelombangid').getValue();
									var box 		= Ext.Msg.wait('sending data');
									Ext.Ajax.request({
										url		: 'resp/resp_ultah21.php',
										method	: 'POST',
										params	: 'empno='+valempno+'&hadiah='+valhadiah+'&gelombangid='+valgelombangid+'&typeform=tidakhadir',
										success	: function(response, opts) {
											var obj = Ext.decode(response.responseText);
											var r 	= obj.msg;
											var msg = r.split(",");
											box.hide();
											if (obj.success == true) {
												//	refresh data
												Ext.getCmp('valempno').reset();
												Ext.getCmp('valempname').reset();
												datastore.proxy.setExtraParam('valempno',	'');
												datastore.proxy.setExtraParam('valempname',	'');
												datastore.loadPage(1);
												dsempno.loadPage(1);
											}else{
												//	refresh data
												Ext.getCmp('valempno').reset();
												Ext.getCmp('valempname').reset();
												datastore.proxy.setExtraParam('valempno',	'');
												datastore.proxy.setExtraParam('valempname',	'');
												datastore.loadPage(1);
												dsempno.loadPage(1);
												
												//	response dari database
												Ext.Msg.show({
													title		:'Response system',
													icon		: Ext.Msg.ERROR,
													msg			: msg[1],
													buttons		: Ext.Msg.OK
												});
											}
										}
									});
								}
							}
						}, 
						'->',
						{
							xtype	: 'button',
							id		: 'btn_data',
							width	: 40,
							height 	: 30,
							margins	: '0 5 0 0', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/griddata.png" style="max-height:20px;" /> </div>',
							tooltip	: 'Data Karyawan',
							handler : function (){
								location.href = "index.php?content=ultah21employee";
							}
						}, {
							xtype	: 'button',
							id		: 'btn_reset',
							width	: 40,
							height 	: 30,
							margins	: '0 5 0 0', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/reset.png" style="max-height:20px;" /> </div>',
							tooltip	: 'Setel Ulang',
							handler : function (){
								var MsgBox = new Ext.window.MessageBox();
								MsgBox.textField.inputType = 'password';
								MsgBox.prompt('Konfirmasi', 'Silahkan masukkan sandi:', function(btn, text){
									if (btn == 'ok' && text == 'P@ssw0rd'){
										var box = Ext.Msg.wait('sending data');
										Ext.Ajax.request({
											url		: 'resp/resp_ultah21.php',
											method	: 'POST',
											params	: 'typeform=reset',
											success	: function(response, opts) {
												var obj = Ext.decode(response.responseText);
												var r 	= obj.msg;
												var msg = r.split(",");
												box.hide();
												if (obj.success == true) {
													//	refresh data
													Ext.getCmp('valempno').reset();
													Ext.getCmp('valempname').reset();
													datastore.proxy.setExtraParam('valempno',	'');
													datastore.proxy.setExtraParam('valempname',	'');
													datastore.loadPage(1);
													dsempno.loadPage(1);
												}else{
													//	refresh data
													Ext.getCmp('valempno').reset();
													Ext.getCmp('valempname').reset();
													datastore.proxy.setExtraParam('valempno',	'');
													datastore.proxy.setExtraParam('valempname',	'');
													datastore.loadPage(1);
													dsempno.loadPage(1);
													
													//	response dari database
													Ext.Msg.show({
														title		:'Setel ulang data',
														icon		: Ext.Msg.ERROR,
														msg			: msg[1],
														buttons		: Ext.Msg.OK
													});
												}
											}
										});
									}
									else{
										Ext.Msg.show({
											title		: 'Setel ulang data',
											icon		: Ext.Msg.ERROR,
											msg			: 'Proses reset diabaikan!',
											buttons		: Ext.Msg.OK
										});
									}
								});
							}
						}, 
						'-',
						{
							xtype		: 'label',
							text		: Ext.Date.format(new Date(), 'l, d F Y'),
							margins		: '20 5 0 0',
							style		: 'font-size: 8pt'
						}, 
						'-',
						clock
					],
					bbar		: Ext.create('Ext.PagingToolbar', {
						pageSize	: itemperpage,
						store		: datastore,
						displayInfo	: true,
						plugins		: Ext.create('Ext.ux.ProgressBarPager', {}),
						listeners	: {
							afterrender: function(cmp) {
								cmp.getComponent("refresh").hide();
							}
						}
					})
				});
			
			//	viewport
				Ext.create('Ext.Viewport', {
					renderTo	: 'panelgrid',
					layout: {
						type: 'border',
						padding: 2
					},
					defaults: {
						split: true
					},
					items: [
						{
							region		: 'north',
							height		: '40%',
							layout		: 'fit',
							bodyStyle	: 'background-image:url("icons/formbg.jpg"); background-size:100%',
							collapsible	: false,
							border		: false,
							split		: false,
							items		: formdata
						},
						{
							region		: 'center',
							layout		: 'fit',
							bodyStyle	: 'background:transparent;',
							border		: false,
							items		: griddata
						}
					]
				});
		//	----***----  //
	});
</script>
<!--
****	body
-->
<body></body>