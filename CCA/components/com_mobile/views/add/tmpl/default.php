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
<table id="newsTable" class="adminlist" style="display:none">
<tr class='row0'><th width="30">Url</th><th width="30">Description</th><th width="10">Target</th><th width="10">Status</th><th width="10">Sequence</th><th width="10">Action</th></tr>
</table>
<input type="hidden" name="option" value="<?php echo JRequest::getVar('option');?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="boxchecked" value="0"/>
<input type="hidden" name="hidemainmenu" value="0"/>
<script type="text/javascript">
$("#addnewRow").click(function(){
	//alert('new Row');
	$("#newsTable").show();
	//alert($("#newsTable > tbody > tr").length);
	var length=$("#newsTable > tbody > tr").length;
	var urlInput = "<textarea type='text' name='newsUrl[]' id='newsUrl"+length+"' cols='40' rows='1'></textarea>";
	var urlDescriptionInput = "<textarea name='newsDesc[]' id='newsDesc"+length+"' rows='3' cols='90'></textarea>";
	var urlTargetSelect = "<select name='newsTarget[]'><option value='_blank' title='Opens the linked document in a new window or tab'>_blank</option><option value='_self' title='Opens the linked document in the same frame as it was clicked (this is default)'>_self</option><option value='_parent' title='Opens the linked document in the parent frame'>_parent</option><option value='_top' title='Opens the linked document in the full body of the window'>_top</option><option value='framename' title='Opens the linked document in a named frame'>framename</option></select>";
	var urlStatusSelect = "<select name='newsStatus[]' ><option value='1'>Publish</option><option value='0'>UnPublish</option></select>";
	var urlStatusSelect = "<select name='newsStatus[]' ><option value='1'>Publish</option><option value='0'>UnPublish</option></select>";
	var urlSequenceInput = "<input type='text' name='newsSequence[]' id='newsSequence"+length+"'/>";
	var reminder=(length)%2;
	$("#newsTable").append("<tr class='row"+reminder+"' id='row"+length+"'><td>"+urlInput+"</td><td>"+urlDescriptionInput+"</td><td>"+urlTargetSelect+"</td><td>"+urlStatusSelect+"</td><td>"+urlSequenceInput+"</td><td><a href='#' id='rowa"+length+"'>Delete</a></td></tr>");
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
		if(task=='save'){
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
