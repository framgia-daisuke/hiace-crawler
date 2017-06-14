<?php
$auction_field_list = array(
	"auction_id" => "Auction ID",
	"unique_number" => "Unique number",
	"year"		=> "Year",
	"distance"	=> "Distance(千km)",
	"point"		=> "Point",
	"start_price" => "Start Price(万円)",
	"result_price" => "End Price(万円)",
	"color"		=> "Color",
	"cooling"	=> "Cooling",
	"cubic_capacity"	=> "CC",
	"capacity"		=> "Capacity",
	"loading"	=> "Loading(Kg)",
	"shift"		=> "Shift",
	"equipment"	=> "Equipment",
	"body"		=> "Body",
	"fuel"		=> "Fuel",
	"venue"		=> "Venue",
	"corner"	=> "Corner",
	"comment"	=> "Comment",
	"img"		=> "IMG",
	
);

?>

<html>
	<head>
		<title>Auction viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!-- Ext JS -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url().'js/extjs/css/ext-all-access.css'?>" />		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>js/extjs/css/example.css" />
		<script type="text/javascript" src="<?php echo base_url()?>js/extjs/bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/extjs/auction.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js'?>"></script>
		<script type="text/javascript">
		var auction_field = {
			<?php
			//foreach($auction_field_list as $k => $v){
				//echo "$k: '$v',\n";
			//}
			?>
		};
		function on_maker_change(maker_id)
		{
			$("#type").load("<?php echo base_url().'db_view/get_type_list/'?>" + maker_id);
			$("#code").html("<option>--- Select Code ---</option>");
			$("#grade").html("<option>--- Select Grade ---</option>");	
		}
		function on_type_change(type_id)
		{
			$("#code").load("<?php echo base_url().'db_view/get_code_list/'?>" + type_id);
			$("#grade").html("<option>--- Select Grade ---</option>");			
		}	
		function on_code_change(code_id)
		{
			$("#grade").load("<?php echo base_url().'db_view/get_grade_list/'?>" + code_id);
		}

		// look up
		function look_up()
		{
			maker_id = $("#maker").val();
			type_id = $("#type").val();
			code_id = $("#code").val();
			grade_id = $("#grade").val();
			$("#looking_up").html("Looking up...");
			$.ajax({
				url: '<?php echo base_url()."db_view/look_up"?>',
				type: 'POST',
				data: 'maker_id=' + maker_id + '&type_id=' + type_id + '&code_id=' + code_id + '&grade_id=' + grade_id, 
				dataType: 'json',
				success: function(response){
					$("#detail").html("");
				    $("#looking_up").html(response.length + " results");	
				    if(response.length == 0) return;
				    Ext.QuickTips.init();

				    var bd = Ext.getBody();
				    var auction_detail = document.getElementById("detail");


				    var ds = Ext.create('Ext.data.Store', {
				        fields: [
				            {name: 'auction_id', type: 'int'},
				            {name: 'unique_number'},
				            //{name: 'grade',      type: 'string'},
				            {name: 'start_price',     type: 'float'},
				            {name: 'result_price',  type: 'float'},
				            {name: 'auction_day', type: 'date', dateFormat: 'Y-m-d'},
				            {name: 'grade', type: 'string'},
				            {name: 'year'},
				            {name: 'distance'},
				            {name: 'point'},
				            {name: 'color'},
				            {name: 'cooling'},
				            {name: 'fuel'},
				            {name: 'cubic_capacity'},
				            {name: 'body'},
				            {name: 'capacity'},
				            {name: 'loading'},
				            {name: 'shift'},
				            {name: 'equipment'},
				            {name: 'comment'},
				            {name: 'venue'},
				            {name: 'corner'},
				            {name: 'insert_date'},
				            {name: 'img'},
				            // Rating dependent upon performance 0 = best, 2 = worst

				        ],
				        data: response
				    });



				    var gridForm = Ext.create('Ext.form.Panel', {
				        id: 'company-form',
				        frame: true,
				        title: 'Auction list',
				        bodyPadding: 5,
				        width: 980,
				        layout: 'column',    // Specifies that the items will now be arranged in columns

				        fieldDefaults: {
				            labelAlign: 'left',
				            msgTarget: 'side'
				        },

				        items: [{
				            columnWidth: 0.40,
				            xtype: 'gridpanel',
				            store: ds,
				            height: 400,
				            //title:'Company Data',

				            columns: [
				                {
				                    id       :'Auction',
				                    text   : 'Auction',
				                    //flex: 1,
					                width: 75,
				                    sortable : true,
				                    dataIndex: 'auction_id',
				                },
				                {
				                    text   : 'Date',
				                    width    : 100,
				                    sortable : true,
				                    renderer : Ext.util.Format.dateRenderer('m/d/Y'),
				                    dataIndex: 'auction_day'
				                },
				                {
				                    text   : 'Start price',
				                    width    : 80,
				                    sortable : true,
				                    //renderer : change,
				                    dataIndex: 'start_price'
				                },
				                {
				                    text   : 'Result price',
				                    width    : 80,
				                    sortable : true,
				                    //renderer : pctChange,
				                    dataIndex: 'result_price'
				                },
				                
				            ],

				            listeners: {
				                selectionchange: function(model, records) {
				                    if (records[0]) {
				                        this.up('form').getForm().loadRecord(records[0]);
				                        display_img();
				                    }
				                }
				            }
				        }, {
				            columnWidth: 0.3,
				            margin: '0 0 0 5',
				            xtype: 'fieldset',
				            title:'Auction details',
				            defaults: {
				                width: 240,
				                labelWidth: 115
				            },
				            defaultType: 'textfield',
				            items: [
						    <?php $c = 1; foreach($auction_field_list as $k => $v):?>
						    {
				                fieldLabel: '<?php echo $v?>',
				                name: '<?php echo $k?>'
				            },
				            <?php $c++; if($c > 9) break; ?>
				            <?php endforeach;?>
						    {
				                fieldLabel: 'Comment',
				                name: 'comment',
				                height: 150,
				                xtype: 'textarea'
				            },	
				            				            
				            ]
			        },
			        {
			            columnWidth: 0.3,
			            margin: '5 0 0 5',
			            xtype: 'fieldset',
			            defaults: {
			                width: 240,
			                labelWidth: 90
			            },
			            defaultType: 'textfield',
			            items: [
					    <?php $c2 = 0; foreach($auction_field_list as $k => $v):?>
					    <?php  $c2++; if($c2 < 10) continue; if($c2 > 18) break;?>
					    {
			                fieldLabel: '<?php echo $v?>',
			                name: '<?php echo $k?>'
			            },
			            <?php endforeach;?>
					    {
			                fieldLabel: 'IMG',
			                name: 'img',
			                xtype: 'hidden',
			                id: 'auc_img',
			            },		            
			            ]
		        	}			        
				    ],
				        renderTo: auction_detail
				    });


				    gridForm.child('gridpanel').getSelectionModel().select(0);				
				}
			});
		}

		function display_img(img){
			img_val = $("#auc_img input:first-child").val();
			if(img_val != "")
			{
				img_src = "<?php echo base_url().'data/img/'?>" + img_val;
				auc_img_thumb = $("#auc_img_thumb").val();
				if(auc_img_thumb == undefined){				
					$("#auc_img").parent().append("<img id='auc_img_thumb' width='120' src='" + img_src + "' onclick='open_img(this.src)' style='cursor: pointer' title='click for full size' />");
				}
				else{
					$("#auc_img_thumb").attr("src", img_src);
				}
			}
		}
		function open_img(img_src)
		{
			window.open("<?php echo base_url().'db_view/img?src='?>" + img_src, "Auction_image", "width=640, height=480");
		}
		</script>
		
		<style type="text/css">
		#filter select{
			width: 150px;
		}
		</style>
	</head>
	<body>
		<div id="main_container">
			<div id="filter">
				<select name="maker" id="maker" onchange="on_maker_change(this.options[selectedIndex].value)">
					<option value="0">--- Select Maker ---</option>
					<?php foreach($maker_list as $maker):?>
					<option value="<?php echo $maker->id?>"><?php echo $maker->name_jp?></option>
					<?php endforeach;?>
				</select>
				<!-- Type -->
				<select name="type" id="type" onchange="on_type_change(this.options[selectedIndex].value)">
					<option value="0">--- Select Type ---</option>
					<?php foreach($type_list as $type):?>
					<option value="<?php echo $type->id?>"><?php echo $type->name?></option>
					<?php endforeach;?>
				</select>
				
				<!-- Code -->		
				<select name="code" id="code" onchange="on_code_change(this.options[selectedIndex].value)">
					<option value="0">--- Select Code ---</option>
					<?php foreach($code_list as $code):?>
					<option value="<?php echo $code->id?>"><?php echo $code->name?></option>
					<?php endforeach;?>
				</select>				
								
				<select name="grade" id="grade">
					<option value="0">--- Select Grade ---</option>
				</select>
				
				<button onclick="look_up()">Look up</button>
				<span id="looking_up" style="color: yellow"></span>
			</div>
			
			<div id="detail"></div>
		</div>
	</body>
</html>