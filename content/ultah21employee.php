<?php
	/*
	****	create by Mohamad Yunus
	****	on 05 November 2017
	****	revise: -
	*/
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
				Ext.define('ultah21employee',{
					extend:'Ext.data.Model',
					fields:[ 'empno', 'empname', 'division', 'dept', 'status', 'hadiah', 'attdstatus', 'input_user', 'input_date', 'update_user', 'update_date' ]
				});
				var datastore = Ext.create('Ext.data.JsonStore', {
					model       : 'ultah21employee',
					autoLoad    : true,
					pageSize    : itemperpage,
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_ultah21employee.php',
						reader	: {
							type			: 'json',
							root			: 'rows',
							totalProperty	: 'totalcount'
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
						}
					]
				});
		
			//	grid
				var clock 		= Ext.create('Ext.toolbar.TextItem', {text: Ext.Date.format(new Date(), 'g:i:s A')});
				var griddata	= Ext.create('Ext.grid.Panel', {
					title		: 'Data Karyawan',
					store		: datastore,
					columnLines	: true,
					multiSelect	: true,
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
						{ text: 'Nama', dataIndex: 'empname', width: 400, renderer: upsize, sortable: false,
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
						{ text: 'Divisi',		dataIndex: 'division',		flex: 1, renderer: upsize },
						{ text: 'Department',	dataIndex: 'dept',			flex: 1, renderer: upsize },
						{ text: 'Hadiah',		dataIndex: 'hadiah',		flex: 1, renderer: upsize },
						{ text: 'Kehadiran',	dataIndex: 'attdstatus',	flex: 1, renderer: upsize }
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
							text	: '<div style="font-size:15px !important; font-weight:bold !important;"><img src="icons/undian.png" style="max-height:20px;" /> </div>',
							tooltip	: 'Back',
							handler : function (){
								location.href = "index.php?content=ultah21";
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
						}, 
						'->',
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
							height		: '15%',
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