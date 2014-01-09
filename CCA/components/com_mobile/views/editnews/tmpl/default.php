<style type="text/css">
    .adminlist1 tr th.class1{
       width:265px 
    }
    .adminlist1 tr th.class2{
        
    }
    .adminlist1 tr th.class3{
        width:105px 
    }
    .adminlist1 tr th.class4{
         width:105px 
    }
    .adminlist1 tr th.class5{
         width:85px 
    }
    .adminlist1 tr td.classtd5 input{width:60px}
    .adminlist1 tr td textarea{width:99%}
    .adminlist1 tr th.class6{
        width:70px  
    }
</style>

<?php

//echo "Edit Form Application";
defined("_JEXEC") or die("Restricted access");
$document = JFactory::getDocument();
$document->addScript(JURI::base().'components'.DS.'com_latestnewsurls'.DS.'js/jquery-1.6.4.js');
JHTML::_( 'behavior.calendar' );
JHTML::_( 'behavior.tooltip' );
$data = $this->newsUrls;
?>

<form action="index.php" method="POST" name="adminForm">
<div style="text-align:right"><input type="button" name="addnewRow" id="addnewRow" value="Add New Row"/></div>
<?php 
if(count($this->newsUrls)>0){?>
<table id="newsTable" class="adminlist adminlist1">
<tr class='row0'><th class="class1">Url</th><th class="class2">Description</th><th class="class3">Target</th><th class="class4">Status</th><th class="class5">Sequence</th><th class="class6">Action</th></tr>
<?php 
$i=1;
$k=0;
$startId='';
$endId='';
$targetArray = array("_blank"=>array('_blank','Opens the linked document in a new window or tab'),'_self'=>array('_self','Opens the linked document in the same frame as it was clicked (this is default)'),'_parent'=>array('_parent','Opens the linked document in the parent frame'),'_top'=>array('_top','Opens the linked document in the full body of the window'),'framename'=>array('framename','Opens the linked document in a named frame'));
foreach($this->newsUrls as $row){
	if($k==0){
		$startId=$row->id;
	}
	if($k==(count($this->newsUrls)-1)){
		$endId=$row->id;
	}	
 ?>
<tr class="row<?php echo $i%2;?>" id="row<?php echo $i;?>"><td><textarea type='text' name='newsUrl[]' id="newsUrl<?php echo $i;?>" rows="1" cols="40"><?php echo $row->url;?></textarea></td><td><textarea name='newsDesc[]' id="newsDesc<?php echo $i;?>" rows="3" cols="90"><?php echo $row->description;?></textarea></td><td><select name='newsTarget[]'>
<?php foreach($targetArray as $key=>$value){?>
<option value="<?php echo $key;?>" title="<?php echo $value[1];?>" <?php if($row->target==$key){ echo 'selected';}?>><?php echo $value[0];?></option>
<?php }?>
</select></td><td><select name='newsStatus[]' ><option value='1'>Publish</option><option value='0'>UnPublish</option></select></td><td class="classtd5"><input type='text' name='newsSequence[]' id="newsSequence<?php echo $i;?>" value="<?php echo $row->sequence;?>"/></td><td> --- <!--<a href='#' id="rowa<?php echo $i;?>">Delete</a>--><input type="hidden" name="newsId[]" value="<?php echo $row->id;?>"/></td></tr>

<script type="text/javascript">
$("#rowa<?php echo $i;?>").click(function(){
			$("#row<?php echo $i;?>").remove();
			if($("#newsTable > tbody > tr").length == 1){
				$("#newsTable").hide();
			}
		});
</script>
<?php 
$i++;
$k++;
}
?>
</table>
<?php
}else{ ?>
No Data To Edit.
<?php }?>
<input type="hidden" name="option" value="<?php echo JRequest::getVar('option');?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="boxchecked" value="0"/>
<input type="hidden" name="hidemainmenu" value="0"/>
<input type="hidden" name="pageStartId" value="<?php echo $startId;?>"/>
<input type="hidden" name="pageEndId" value="<?php echo $endId;?>"/>
<script type="text/javascript">
$(document).ready(function(){
	
});
$("#addnewRow").click(function(){
	//alert('new Row');
	$("#newsTable").show();
	//alert($("#newsTable > tbody > tr").length);
	var length=$("#newsTable > tbody > tr").length;
	var urlInput = "<textarea type='text' name='newsUrl[]' id='newsUrl"+length+"' rows='1' cols='40'></textarea>";	
        var urlDescriptionInput = "<textarea name='newsDesc[]' id='newsDesc"+length+"' rows='3' cols='90'></textarea>";
	var urlTargetSelect = "<select name='newsTarget[]'><option value='_blank' title='Opens the linked document in a new window or tab'>_blank</option><option value='_self' title='Opens the linked document in the same frame as it was clicked (this is default)'>_self</option><option value='_parent' title='Opens the linked document in the parent frame'>_parent</option><option value='_top' title='Opens the linked document in the full body of the window'>_top</option><option value='framename' title='Opens the linked document in a named frame'>framename</option></select>";
	var urlStatusSelect = "<select name='newsStatus[]' ><option value='1'>Publish</option><option value='0'>UnPublish</option></select>";
	var urlSequenceInput = "<input type='text' name='newsSequence[]' id='newsSequence"+length+"'/>";
	var reminder=(length)%2;
	$("#newsTable").append("<tr class='row"+reminder+"' id='row"+length+"'><td>"+urlInput+"</td><td>"+urlDescriptionInput+"</td><td>"+urlTargetSelect+"</td><td>"+urlStatusSelect+"</td><td class='classtd5'>"+urlSequenceInput+"</td><td><a href='#' id='rowa"+length+"'>Delete</a></td><input type='hidden' name='newsId[]'/></tr>");
	$("#rowa"+length).click(function(){
		$("#row"+length).remove();
		//$("#newsTable > tbody > tr").length;
		if($("#newsTable > tbody > tr").length == 1){
			$("#newsTable").hide();
		}
	});
});
</script>
</form>
<script>
/*window.addEvent('domready', function() {
        document.formvalidator.setHandler('newsUrlDesc',
                function (value) {
			if(value!=''){
				return true;
			}else{
				alert("Please Enter description");
				return false;
			}
                        //regex=/^[^0-9]+$/;
                        //return regex.test(value);
        });
});*/


function validateGridValues(){
	var tableLength = $("#newsTable > tbody > tr").length;
	if(tableLength>1){
	for(var i=1;i<=tableLength;i++){
		var message="";
		var id="";
		var reg = /^\d+$/;
		//alert($("#newsUrl"+i).attr('value'));
		if(document.getElementById("row"+i)!=null){
		if($("#newsUrl"+i).attr('value')==''){
			message="Please Enter News Url";
			id="newsUrl"+i;			
		}else if($("#newsDesc"+i).attr('value')==''){
			message="Please Enter News Description";
			id="newsDesc"+i;			
		}else if($("#newsSequence"+i).attr('value')==''){
			message="Please Enter Sequence Number";
			id="newsSequence"+i;						
		}else{
			if(document.getElementById('newsSequence'+i)!=null){
			if(reg.test($("#newsSequence"+i).attr('value'))){				
			}else{
				message="Sequence allows digits only.";
				id="newsSequence"+i;
			}
			}
		}
		if(message!=''){
			alert(message);	
			//alert(id);		
			document.getElementById(id).focus();
			return false;
			break;
		}
		}
		
	}}else{
		alert("Please add no of rows you want to insert");
		return false;
	}
	return true;
	
	
}


Joomla.submitbutton = function(task)
{
	
        if (task == '')
        {
                return false;
        }
        else
        {
		if(task=='saveNews'){
			var returnValue = validateGridValues();
			//alert(returnValue+"===="+typeof returnValue);
			if(returnValue==false){				
				return false;
			}
			
		}
                var isValid=true;
                var action = task.split('.');
                if (action[1] != 'cancel' && action[1] != 'close')
                {
                        var forms = $$('form.form-validate');
                        for (var i=0;i<forms.length;i++)
                        {
                                if (!document.formvalidator.isValid(forms[i]))
                                {
                                        isValid = false;
                                        break;
                                }
                        }
                }
 
                if (isValid)
                {
                        Joomla.submitform(task);
                        return true;
                }
                else
                {
                        alert(Joomla.JText._('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE',
                                             'Some values are unacceptable'));
                        return false;
                }
        }
}
</script>

<!--
<table>
<tr><td>Description : </td><td><input type="text" id="newsUrlDesc" name="newsUrlDesc" value="<?php echo $row->description;?>"/></td></tr>
<tr><td>Url : </td><td><input type="text" id="newsUrl" name="newsUrl" value="<?php echo $row->url;?>"/></td></tr>
<tr><td>Target : </td><td><select id="newsUrlTarget" name="newsUrlTarget"><option value="_blank">_BLANK</option><option value="_parent">_PARENT</option></select></td></tr>
<!--<tr><td>DATE</td><td><input type="text" class="calendar hasTip" name="stafrtDate" id="startfDate" title="My cool Title::This is a tip" size="25" value="<?php echo $this->startDate->startDate; ?>" /></td></tr>
<tr><td><?php JHTML::_('behavior.calendar'); ?>

<input class='inputbox' type='text' name='build_date' id='build_date' disabled='disabled' />
<img src='templates/system/images/calendar.png' alt='Calendar' onclick="return showCalendar('build_date','%Y-%m-%d');"/></td><td></td></tr>
<tr><td>Start Publishing Date : </td><td>
<?php
//echo JHtml::calendar(date('Y-m-d',strtotime($row->startPublishTime)), 'startDate', 'startDate'); ?>

</td></tr>
<tr><td>End Publishing Date : </td><td><?php //echo JHtml::calendar(date('Y-m-d',strtotime($row->endPublishTime)), 'endDate', 'endDate');
?></td></tr>
<tr><td></td><td>


<!--<img class="calendar" src="templates/system/images/calendar.png" alt="calendar" id="deliverydate"/>
<input type="text" class="inputbox" size="40" name="delivery_date_time" id="delivery_date_time_input" value=""/>
<script type="text/javascript">
    Calendar.setup({
        inputField      :   "delivery_date_time_input",
        ifFormat      :   "%d-%m-%Y %H:%S %tt",
      button         : "deliverydate",
        showsTime      :   true,
      timeFormat      :   "12",
      singleClick      :   false,
      dateStatusFunc  :   function (date) {
                              var myDate = new Date();
                       if (date.getTime() < myDate.setDate(myDate.getDate() - 1)) return true;
                       }
   });
</script>



</td></tr>
</table>

-->

