<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<style type="text/css">

	#body {
		margin: 0 15px 0 15px;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}

	.loading-mask{
		position: fixed;
		width: 100%;
		height: 100%;
		z-index: 999;
		background: rgba(0,0,0,0.4);
		display: -webkit-box;
		-webkit-box-align: center;
		-webkit-box-pack: center;
		font-size: 20px;
		color: white;
		display: none;
	}
	</style>
</head>
<body>
<div class="loading-mask">Transferring...</div>

<div id="container" style="width: 1900px;">
    <link rel="stylesheet" href="<?php echo base_url('www/_css/bootstrap.min.css')?>">
    <script src="<?php echo base_url('www/_js/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('www/_js/bootstrap.min.js')?>"></script>
	<div id="body">
  	  <div id="condition" class="row">
		<button type="button" class="btn btn-primary" id="transferBtn" style="margin-left:5px;margin-top:30px">Transfer</button>
  	  </div>
  	  <div class="row">
	  	  <div style="height:800px;overflow:auto" class="col-sm-6">
		  	  <h2>Accounts</h2>
			  <table class="table table-hover" id="accounts">
			    <thead>
			      <tr>
			      	<th><input type="checkbox" onclick="check_all(this,'account')"></th>
			        <th>id</th>
			        <th>business_name</th>
			        <th>business_phone</th>
			        <th>business_address</th>
			        <th>business_address_line_2</th>
			        <th>business_city</th>
			        <th>business_state</th>
			        <th>business_zip</th>
			        <th>business_logo_name</th>
			        <th>admin_email</th>
			        <th>admin_user_id</th>
			        <th>account_type</th>
			        <th>set_up_needed</th>
			        <th>number_of_users</th>
			        <th>active</th>
			        <th>has_contract</th>
			        <th>created</th>
			        <th>confirm_id</th>
			        <th>setup_needed</th>
			      </tr>
			    </thead>
			    <tbody>
			    </tbody>
			  </table>
		  </div>
	  	  <div style="height:800px;overflow:auto" class="col-sm-6">
	  	  	  <h2>Franchises</h2>
			  <table class="table table-hover" id="franchise">
			    <thead>
			      <tr>
			      	<th><input type="checkbox" onclick="check_all(this,'franchise')"></th>
			        <th>id</th>
			        <th>name</th>
			        <th>business_phone</th>
			        <th>phone</th>
			        <th>email</th>
			        <th>address</th>
			        <th>address_line_2</th>
			        <th>city</th>
			        <th>state</th>
			        <th>zip</th>
			      </tr>
			    </thead>
			    <tbody>
			    </tbody>
			  </table>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	$(document).ready(function(){
	    $.ajax({
            method : "post",
            dataType: 'json',
	    	url: "<?php echo base_url()?>index.php/welcome/getAccount",
	    	success: function(result){
	    		var html = "";
	    		for (var i = 0; i < result.length; i++){
	    			html +="<tr>";
	    			html +="<td><input type='checkbox' class=\"account_check\" value='"+result[i].id+"'></td>";
	    			html +="<td>";
	    			html +=result[i].id;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_name;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_phone;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_address;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_address_line_2;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_city;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_state;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_zip;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_logo_name;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_city;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].business_logo_name;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].admin_email;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].admin_user_id;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].account_type;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].set_up_needed;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].number_of_users;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].active;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].has_contract;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].created;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].confirm_id;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].setup_needed;
	    			html +="</td>";
	    			html +="</tr>";
	    		}

	    		$("#accounts > tbody").html(html);
		    }
		});
	    $.ajax({
            method : "post",
            dataType: 'json',
	    	url: "<?php echo base_url()?>index.php/welcome/getFranchise",
	    	success: function(result){
	    		var html = "";
	    		for (var i = 0; i < result.length; i++){
	    			html +="<tr>";
	    			html +="<td><input type='checkbox' class=\"franchise_check\" value='"+result[i].id+"'></td>";
	    			html +="<td>";
	    			html +=result[i].id;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].name;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].phone;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].email;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].address;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].address_line_2;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].city;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].state;
	    			html +="</td>";
	    			html +="<td>";
	    			html +=result[i].zip;
	    			html +="</td>";
	    			html +="</tr>";
	    		}

	    		$("#franchise > tbody").html(html);
		    }
		});
	});
	$("input[name='optradio']").on('change',function(){
		if($(this).val() == 1)
			$("#id").hide();
		else{
			$("#id").show();
			$("#account_id").val("");
			$("#franchise_id").val("");
		}
	});
	$("#transferBtn").on('click',function(){
		var account_checked = [];
		var franchise_checked = [];
		$(".account_check").each(function(idx,el){
			if($(el).prop('checked'))
				account_checked.push($(el).val());
		});
		$(".franchise_check").each(function(idx,el){
			if($(el).prop('checked'))
				franchise_checked.push($(el).val());
		});
		if (account_checked == "" && franchise_checked == ""){
				alert("Please select AccountId or FranchiseId");
				return;
		}
		else if (account_checked != "" && franchise_checked != ""){
				alert("Please select only one of AccountId or FranchiseId");
				return;
		}
		$(".loading-mask").css("display","-webkit-box");
	    $.ajax({
            method : "post",
	    	url: "<?php echo base_url()?>index.php/welcome/transfer",
	    	data:{account_id:account_checked,franchise_id:franchise_checked},
	    	success: function(result){
				$(".loading-mask").hide();
	    		alert("Finished!");
		    }
		});
	});

	function check_all(el,table)
	{
		table = "."+table+"_check";	
		$(table).prop('checked',$(el).prop('checked'));
	}
</script>
</body>
</html>