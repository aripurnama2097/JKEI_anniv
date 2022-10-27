<?php
	/*
	****	create by Mohamad Yunus
	****	on 2 November 2021
	****	revise: -
	*/
	//	connection open
	include('../ADODB/con_jeinultah.php');
	
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
				Ext.define('ultah25',{
					extend:'Ext.data.Model',
					fields:[ 'empno', 'empname', 'division', 'dept','hadiah' ]
				});
				var datastore = Ext.create('Ext.data.JsonStore', {
					model       : 'ultah25',
					autoLoad    : true,
					pageSize    : itemperpage,
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_ultah25.php',
						reader	: {
							type			: 'json',
							root			: 'rows',
							totalProperty	: 'totalcount'
						}
					}
				});
				Ext.define('ultah25empno',{
					extend:'Ext.data.Model',
					fields:[ 'empno' ]
				});
				var dsempno = Ext.create('Ext.data.JsonStore', {
					model       : 'ultah25empno',
					autoLoad    : true,
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_ultah25empno.php',
						reader	: {
							type	: 'json',
							root	: 'rows'
						}
					}
				});
				Ext.define('ultah25cekbarang',{
					extend:'Ext.data.Model',
					fields:[ 'barangid', 'totalemp' ]
				});
				var cek_barang = Ext.create('Ext.data.JsonStore', {
					model       : 'ultah25cekbarang',
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_ultah25cekbarang.php',
						reader	: {
							type	: 'json',
							root	: 'rows'
						}
					},
					listeners   : {
						load    : function(store, records) {
							var totalemp = store.getAt(0).get('totalemp');
							if (totalemp > 0){
								Ext.getCmp('btn_play').setDisabled(true);
							}
							else{
								Ext.getCmp('btn_play').setDisabled(false);
							}
						}
					}
				});
			//	combobox
				Ext.define('ultah25cbxbarang',{
					extend:'Ext.data.Model',
					fields:[ 'barangid', 'empstatus', 'barangtotal', 'nama' ]
				});
				var dscbx_barang = Ext.create('Ext.data.JsonStore', {
					model       : 'ultah25cbxbarang',
					autoLoad    : true,
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_ultah25cbxbarang.php',
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
							text		: 'JKEI ANNIVERSARY 25th',
							anchor		: '100%',
							style		: 'font-weight:bold; text-align:center; font-size:15pt; color:blue;'
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
							id					: 'barangid',
							name				: 'barangid',
							queryMode			: 'local',
							displayField		: 'barangid',
							valueField			: 'barangid',
							emptyText			: 'Barang',
							width				: 250,
							height 				: 35,
							editable			: false,
							allowBlank			: false,
							store				: dscbx_barang,
							listConfig			: {
								getInnerTpl: function() {
									return '<div data-qtip="{nama}">{barangid} - {nama}</div>';
								}
							},
							listeners			: {
								change : function(){
									datastore.proxy.setExtraParam('valhadiah', Ext.getCmp('barangid').getValue());
									datastore.loadPage(1);
								},
								select	: function(combo, records) {
									Ext.getCmp('empstatus').setValue(records[0].get('empstatus'));
									Ext.getCmp('barangtotal').setValue(records[0].get('barangtotal'));
							
									cek_barang.proxy.setExtraParam('valhadiah', records[0].get('barangid'));

									cek_barang.loadPage(1);
								}
							}
						}, {
							xtype	: 'hiddenfield',
							id		: 'empstatus',
							name	: 'empstatus'
						}, {
							xtype	: 'hiddenfield',
							id		: 'barangtotal',
							name	: 'barangtotal'
						}, 
						{
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
									/*menampilkan data pemenang */
									var box = Ext.Msg.wait('sending data');
									var valbarangid 	= Ext.getCmp('barangid').getValue();
									var valempstatus 	= Ext.getCmp('empstatus').getValue();
									var valbarangtotal	= Ext.getCmp('barangtotal').getValue(); 
									Ext.Ajax.request({
										url		: 'resp/resp_ultah25.php',
										method	: 'POST',
										params	: 'barangid='+valbarangid+'&empstatus='+valempstatus+'&barangtotal='+valbarangtotal+'&typeform=undian',
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
												datastore.proxy.setExtraParam('valhadiah',	valbarangid);
												datastore.loadPage(1);
												cek_barang.proxy.setExtraParam('valhadiah', valbarangid);
												cek_barang.loadPage(1);
											}else{
												//	refresh data
												Ext.getCmp('valempno').reset();
												Ext.getCmp('valempname').reset();
												datastore.proxy.setExtraParam('valempno',	'');
												datastore.proxy.setExtraParam('valempname',	'');
												datastore.proxy.setExtraParam('valhadiah', valbarangid);
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
						{ text: 'Name', dataIndex: 'empname', width: 500, renderer: upsize, sortable: false,
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
						{ text: 'Division',		dataIndex: 'division',	flex: 1, renderer: upsize },
						{ text: 'Department',	dataIndex: 'dept',	flex: 1, renderer: upsize },
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
								datastore.proxy.setExtraParam('valhadiah', Ext.getCmp('barangid').getValue());
								datastore.loadPage(1);
								dsempno.loadPage(1);
							}
						}, {
							xtype	: 'button',
							id		: 'btn_download_all',
							width	: 180,
							height 	: 30,
							margins	: '0 0 0 5', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/download.png" style="max-height:20px;" /> Unduh Per Hadiah</div>',
							tooltip	: 'Unduh',
							handler : function (){
								var valempno 	= Ext.getCmp('valempno').getValue();
								var valempname 	= Ext.getCmp('valempname').getValue();
								var valhadiah 	= Ext.getCmp('barangid').getValue();
								if (valhadiah == null){
									Ext.Msg.show({
										title		: 'Download data gagal',
										icon		: Ext.Msg.ERROR,
										msg			: 'Silahkan isi Barang terlebih dahulu.',
										buttons		: Ext.Msg.OK
									});
								}
								else{
									datastore.loadPage(1);
									dsempno.loadPage(1);
									window.open('resp/down_ultah25_hadiah.php?valempno='+valempno+'&valempname='+valempname+'&valhadiah='+valhadiah+'&typeform=Download');	
								}
							}
						}, {
							xtype	: 'button',
							id		: 'btn_download',
							width	: 180,
							height 	: 30,
							margins	: '0 0 0 5', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/download.png" style="max-height:20px;" /> Unduh Semua Data</div>',
							tooltip	: 'Unduh',
							handler : function (){
								datastore.loadPage(1);
								dsempno.loadPage(1);
								window.open('resp/down_ultah25.php?typeform=Download');	
							}
						}, 
						'->',
						{
							xtype	: 'button',
							id		: 'btn_flowchart',
							width	: 180,
							height 	: 30,
							margins	: '0 0 0 5', // top right bottom left
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/flowchart.png" style="max-height:20px;" /> Flowchart</div>',
							tooltip	: 'Unduh',
							handler : function (){
								window.open('25th/flowchart_2.jpg');	
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
											url		: 'resp/resp_ultah25.php',
											method	: 'POST',
											params	: 'typeform=reset',
											success	: function(response, opts) {
												var obj = Ext.decode(response.responseText);
												var r 	= obj.msg;
												var msg = r.split(",");
												box.hide();
												location.reload();
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