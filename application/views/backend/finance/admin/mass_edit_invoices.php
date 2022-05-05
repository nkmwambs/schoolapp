<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//print_r($payments);
?>
<style>

#send_single_balance_sms {
	cursor: pointer;
}

.editable {
	background-color: turquoise;
}
.add_editable{
	background-color:lightsalmon;
}

.table-fixed  {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td {
    border: 1px solid #FFA07A;
    text-align: right;
    padding: 8px;
}

.table-fixed thead th
{
	position: sticky;
    position: -webkit-sticky;
    top: 0;
    z-index: 999;
    background-color: #FFA07A;
    color: #fff;
    border: 1px solid #ccc;
    height: 75px;
    width: 50px;
    text-align:left;
}


tbody td:nth-child(-n+1)
{
  position:sticky;
  left:0px;
 background-color:#ccc;
}

thead th:nth-child(-n+2)
{
  position:sticky;
  left:0px;
}

tfoot th:nth-child(-n+1)
{
  position:sticky;
  left:0px;

}

 tbody td:first-child
 {
  background-color:#ccc;
 }

 tfoot td:first-child
 {
  background-color:#FFA07A;
 }



/**Freeze top row**/
.table-fixed thead {
  position: sticky;
  position: -webkit-sticky;
  top: 0;
  z-index: 999;
  background-color: #000;
  color: #fff;
}
</style>

<div class="row">
<!-- <div class="col-xs-1">
		<a class="scroll_tabs" href="<?= base_url(); ?>index.php?finance/mass_edit_invoices/<?= $year - 1; ?>"><i style="font-size: 60pt;" class="fa fa-minus-circle"></i></a>
	</div> -->

	<div class="col-xs-12">
		<?php echo form_open(base_url() . 'index.php?finance/mass_edit_invoices/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
				<div class="form-group">
						<label class="control-label col-xs-2"><?=get_phrase('choose_invoices');?></label>

            <div class="col-xs-2">
							<select class="form-control" name="class_id" id="class_id" required="required">
									<option value=""><?=get_phrase('select_class');?></option>
							    <?php foreach($class as $class){?>
                      <option value="<?=$class->class_id;?>" <?php if($class->class_id == $class_id) echo "selected";?> ><?=$class->name;?></option>
                  <?php }?>
              </select>
						</div>

            <div class="col-xs-2">
              <select class="form-control" name="invoice_status" id="invoice_status"  required="required">
                  <option value=""><?=get_phrase('select_status');?></option>
                  <option value="unpaid" <?php if($invoice_status == 'unpaid') echo 'selected';?> ><?=get_phrase('unpaid');?></option>
                  <option value="paid"  <?php if($invoice_status == 'paid') echo 'selected';?>  ><?=get_phrase('paid');?></option>
                  <option value="excess"  <?php if($invoice_status == 'excess') echo 'selected';?>  ><?=get_phrase('excess');?></option>
                  <option value="cancelled"  <?php if($invoice_status == 'cancelled') echo 'selected';?>  ><?=get_phrase('cancelled');?></option>
              </select>
            </div>

			<div class="col-xs-2">
              <select class="form-control" name="invoice_year" id="year"  required="required">
				  <?php 
				 	$years = range(date('Y') - 3, date('Y') + 3); 
				  ?>
                  <option value=""><?=get_phrase('select_year');?></option>
				  
				  <?php 
				  		foreach($years as $year){
					?>
						<option value='<?=$year;?>' <?php if($year == date('Y')) echo "selected";?> ><?=$year;?></option>
				  <?php }?>
				  
			  </select>
            </div>

			<div class="col-xs-2">
              <select class="form-control" name="invoice_term" id="term"  required="required">
                  <option value=""><?=get_phrase('select_term');?></option>
				  <option value='1' <?php if($term == 1) echo "selected";?> >Term 1</option>
				  <option value='2' <?php if($term == 2) echo "selected";?> >Term 2</option>
				  <option value='3' <?php if($term == 3) echo "selected";?> >Term 3</option>
			  </select>
            </div>


						<div class="col-xs-2">
							<input type="submit" class="btn btn-default" value="<?=get_phrase('go');?>"/>
						</div>
				</div>
		</form>
	</div>

	<!-- <div class="col-xs-1">
    <a class="scroll_tabs" href="<?= base_url(); ?>index.php?finance/mass_edit_invoices/<?= $year + 1; ?>"><i style="font-size: 60pt;" class="fa fa-plus-circle"></i></a>
  	</div> -->
</div>

<hr/>

<div class="row">
	<div class="col-xs-12 text-center">
		Double click on any of the <span style="color:turquoise;font-weight:bold;">turquoise</span> colored cell to edit and <span style="color:lightsalmon;font-weight:bold;"> light salmon </span> to add an item to invoice
	</div>

	<div class="col-xs-12">
		<table class="table table-bordered datatable">
			<thead>
				<tr>
					<th nowrap="nowrap" rowspan="2"><?=get_phrase('student_name');?></th>
					<th rowspan="2"><?=get_phrase('class');?></th>
					<th rowspan="2"><?=get_phrase('roll_number');?></th>

					<?php
						foreach($fees_structure_vote_heads as $category){
					?>
						<th colspan="3" nowrap="nowrap"><?=$category->name;?></th>

					<?php
						}
					?>
					<th colspan="3"><?=get_phrase('total');?></th>
				</tr>
				<tr>

					<?php
						foreach($fees_structure_vote_heads as $category){
					?>
						<th><?=get_phrase('due');?></th>
						<th><?=get_phrase('paid');?></th>
						<th><?=get_phrase('balance');?></th>
					<?php
						}
					?>
          <th><?=get_phrase('due');?></th>
          <th><?=get_phrase('paid');?></th>
          <th><?=get_phrase('balance');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$total_due = 0;
					$total_paid = 0;
					$total_balance = 0;
					foreach($payments as $student=>$payment){
				?>
					<tr>
						<td nowrap="nowrap" id='<?=$payment['student']['student_id'];?>'> <?=$payment['student']['name'];?> <i id='send_single_balance_sms' data-invoice_id = "<?=$payment['student']['invoice_id'];?>" class="fa fa-envelope" title="<?=get_phrase('send_balance_text');?>"></i></td>
						<td><?=$payment['student']['class'];?></td>
						<td><?=$payment['student']['roll'];?></td>

						<?php
							$due = 0;
							$paid = 0;
							$balance = 0;

							foreach($fees_structure_vote_heads as $category){
						?>
							<td class="<?php if($invoice_status == 'unpaid' && isset($payment['fees'][$category->name]['invoice_id']) ) echo 'editable';?> <?php if($invoice_status == 'unpaid' && !isset($payment['fees'][$category->name]['invoice_id'])) echo 'add_editable';?>"
								data-feesdetailid = "<?=$category->detail_id;?>"
								data-invoiceid = "<?=$payment['student']['invoice_id'];?>"
                id = "<?=isset($payment['fees'][$category->name]['invoice_details_id'])?$payment['fees'][$category->name]['invoice_details_id']:0;?>">
								<?=number_format(isset($payment['fees'][$category->name]['due'])?$payment['fees'][$category->name]['due']:0,2);?>
						 	</td>

							<td>
								<?=number_format(isset($payment['fees'][$category->name]['paid'])?$payment['fees'][$category->name]['paid']:0,2);?>
							</td>
							<td>
								<?=number_format(isset($payment['fees'][$category->name]['balance'])?$payment['fees'][$category->name]['balance']:0,2);?>
							</td>
						<?php
								$due += isset($payment['fees'][$category->name]['due'])?$payment['fees'][$category->name]['due']:0;
								$paid += isset($payment['fees'][$category->name]['paid'])?$payment['fees'][$category->name]['paid']:0;
								$balance += isset($payment['fees'][$category->name]['balance'])?$payment['fees'][$category->name]['balance']:0;
							}
						?>
						<td class="aggregate_due"><?=number_format($due,2);?></td>
						<td class="aggregate_paid"><?=number_format($paid,2);?></td>
						<td class="aggregate_balance"><?=number_format($balance,2);?></td>
					</tr>
				<?php
					$total_due += $due;
					$total_paid +=$paid;
					$total_balance+=$balance;
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3">Total</th>

					<?php
						//print_r($fees_structure_vote_heads);
						foreach($fees_structure_vote_heads as $category){
					?>
						<th><?=number_format(isset($payments['fees'],$category->name)?array_sum(array_column(array_column($payments['fees'],$category->name),'due')):0,2);?></th>
						<th><?=number_format(isset($payments['fees'],$category->name)?array_sum(array_column(array_column($payments['fees'],$category->name),'paid')):0,2);?></th>
						<th><?=number_format(isset($payments['fees'],$category->name)?array_sum(array_column(array_column($payments['fees'],$category->name),'balance')):0,2);?></th>
					<?php
						}
					?>
					<th><?=number_format($total_due,2);?></th>
					<th><?=number_format($total_paid,2);?></th>
					<th><?=number_format($total_balance,2);?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<script>

$('td').click(function(){
	//alert($(this).attr('data-feesdetailid'));
});

$(".editable,.add_editable").dblclick(function(){

	//Get the value of the cell
	var amount = accounting.unformat($(this).html().trim());

	//Get value of the aggregate due
	var original_aggregate_due_amount = accounting.unformat($(this).parent().find('.aggregate_due').html().trim());

  //Invoice details id for the updated item
  var invoice_details_id = $(this).attr('id');
  var invoice_id = $(this).attr('data-invoiceid');
	var feesdetailid = $(this).attr('data-feesdetailid');
	//alert(feesdetailid);

	//Change the inner content of the cell to a textbox
	var textbox = '<input style="min-width:75px;" onchange="update_invoice_amount_due(this,'+amount+','+original_aggregate_due_amount+','+invoice_details_id+','+invoice_id+','+feesdetailid+');" type="textbox" class="form-control" value="'+amount+'"/>'

	// Only change the inner html if their is not textbox in the cell
	if($(this).find('.form-control').length == 0 ){
		$(this).html(textbox);
	}

});

function update_invoice_amount_due(el,original_due_amount,original_aggregate_due_amount,invoice_details_id,invoice_id,feesdetailid){

	//Get new input value
	var updated_due_amount = $(el).val();

	//Get the category balance for the student
	var category_balance = $(el).parent().next().next().html();
	var category_balance_amount = accounting.unformat(category_balance.trim());

	//Get value of category paid
	var category_paid = $(el).parent().next().html();
	var category_paid_amount = accounting.unformat(category_paid.trim());

	//Get value of the aggregate Due
	// var aggregate_due = $(el).parent().parent().find('.aggregate_due').html();
	// var aggregate_due_amount = accounting.unformat(aggregate_due.trim());

	//Get value of aggregate paid
	var aggregate_paid = $(el).parent().parent().find('.aggregate_paid').html();
	var aggregate_paid_amount = accounting.unformat(aggregate_paid.trim());

	//Get value of aggregate balance
	var aggregate_balance = $(el).parent().parent().find('.aggregate_balance').html();
	var aggregate_balance_amount = accounting.unformat(aggregate_balance.trim());

	//Compute if the update amount due is not below the category_paid_amount

	if(parseFloat(updated_due_amount) < parseFloat(category_paid_amount)){
			alert('You cannot edit the amount due below the paid amount of '+accounting.format(category_paid_amount));
			$(el).val(original_due_amount);

			//Resolve the updated_due_amount to the original_due_amount
			updated_due_amount = original_due_amount;
	}

		//Compute the new category Balance
		var updated_category_balance_amount = parseFloat(updated_due_amount) - parseFloat(category_paid_amount);
		$(el).parent().next().next().html(accounting.format(updated_category_balance_amount));

		//Compute aggregate amount due
		var updated_aggregate_due_amount = (parseFloat(original_aggregate_due_amount) - parseFloat(original_due_amount)) + parseFloat(updated_due_amount);
		$(el).parent().parent().find('.aggregate_due').html(accounting.format(updated_aggregate_due_amount));

		//Compute the new aggregate balance
		var updated_aggregate_balance_amount = parseFloat(updated_aggregate_due_amount) - parseFloat(aggregate_paid_amount);
		$(el).parent().parent().find('.aggregate_balance').html(accounting.format(updated_aggregate_balance_amount));

		post_updated_invoice_amount_due(updated_due_amount,invoice_details_id,invoice_id,feesdetailid);

}

function post_updated_invoice_amount_due(new_due_amount,invoice_details_id,invoice_id,feesdetailid){
	//	alert(feesdetailid);
	var url = "<?=base_url();?>index.php?finance/mass_update_invoice_amount_due/";
	var data = {'amount_due':new_due_amount,'invoice_details_id':invoice_details_id,'invoice_id':invoice_id,'fees_details_id':feesdetailid};

	//alert(feesdetailid);

	$.ajax({
		url:url,
		data:data,
		type:"POST",
		success:function(resp){
      if(resp!==""){
        alert(resp);
      }

		},
		error:function(){
			alert('Error Occurred!');
		}
	});

}

$("#send_single_balance_sms").on('click',function() {

	// const class_id = $("#class_id").val()
	// const invoice_status = $("#invoice_status").val()
	// const year = $("#year").val()
	// const term = $("#term").val()
	const student_id = $(this).closest('td').attr('id')

	const invoice_id = $(this).data('invoice_id');

	const data = {invoice_id: invoice_id, student_id: student_id}

	const url = "<?=base_url();?>index.php?finance/sms_single_balance/"
	

	$.post(url,data, (response) => {
		alert(response);
	})
});
</script>
