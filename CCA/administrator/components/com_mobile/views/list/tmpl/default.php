<?php
defined("_JEXEC") or die("Restricted access");
$document = JFactory::getDocument();
$document->addScript(JURI::base().'components'.DS.'com_latestnewsurls'.DS.'js/jquery-1.6.4.js');
?>
<form action="index.php" method="POST" name="adminForm">
<?php 
//echo count($this->latestNewsUrls);
if(count($this->latestNewsUrls)>0){ ?>
<table class="adminlist adminlist1">
<thead>
<tr>
<th>
<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->latestNewsUrls);?>)"/>
</th>
<th>
Url
</th>
<th>
Description
</th>
<th>
Published
</th>
<th>
Sequence
</th>
</thead>
<tbody>
<?php 
$k = 0;
$i = 0;
$startId='';
$endId='';
foreach($this->latestNewsUrls as $row){
	if($i==0){
		$startId=$row->id;
	}
	if($i==(count($this->latestNewsUrls)-1)){
		$endId=$row->id;
	}
	$checked = JHTML::_('grid.id',$i,$row->id);
	$link = JRoute::_("index.php?option=".JRequest::getVar('option')."&task=edit&cid[]=".$row->id."&hidemainmenu=1");
?>
<tr class="<?php echo 'row'.$k;?>">
<td><?php echo $checked;?></td>
<td><?php echo $row->url;?></td>
<td><?php echo $row->description;?></td>
<td class="jgrid" style="text-align:center"><a  href="#" ><span class="state <?php if($row->status==1){ echo 'publish';}else{ echo 'unpublish'; }?>" id="publish<?php echo $row->id;?>"><span class="text">Published</span></span></a></td>
<td style="text-align:center"><?php echo $row->sequence;?></td>
</tr>
<script type="text/javascript">
$("#publish<?php echo $row->id;?>").click(function(){
	var status="";
	if($(this).hasClass("publish")){
		status = 0;
	}else{
		status = 1;
	}
	//alert(status);
	$.ajax({
	        type: "POST",
	        url: "index.php?option="+"<?php echo JRequest::getVar('option');?>&task=dopublish",
	        async:true,
		data: {id:"<?php echo $row->id;?>",status:status},
	        success : function(data){
			if(data.search('success')!=-1){				
			if(status==0){
				$("#publish<?php echo $row->id;?>").removeClass("publish");
				$("#publish<?php echo $row->id;?>").addClass("unpublish")
			}else{
				$("#publish<?php echo $row->id;?>").removeClass("unpublish");
				$("#publish<?php echo $row->id;?>").addClass("publish");
			}
			}else{
				alert("error");
			}	            
	        },
	        error : function(XMLHttpRequest, textStatus, errorThrown) {
	           // alert('internal error occured --'+requestURL);	          
	        }
	});
});
</script>
<?php 
$k=1-$k;
$i++;
}
?>
</tbody>
</table>
<div style="text-align: center; display: table; margin: auto;"><?php echo $this->pagination->getListFooter();?></div>
<?php }else{ ?>
<table  class="adminlist"><tr><td style="text-align: center">No Latest News.</td></tr></table>
<?php }?>
<input type="hidden" name="option" value="<?php echo JRequest::getVar('option');?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="boxchecked" value="0"/>
<input type="hidden" name="hidemainmenu" value="0"/>
<input type="hidden" name="pageStartId" value="<?php echo $startId;?>"/>
<input type="hidden" name="pageEndId" value="<?php echo $endId;?>"/>
</form>
<script type="text/javascript">
$(document).ready(function(){
    <?php if(count($this->latestNewsUrls)>0){ ?>
	$("#toolbar-edit").children(".toolbar").attr("onclick","Joomla.submitbutton('editnews');");
    <?php }else{ ?>
            $("#toolbar-edit").hide();
    <?php }?>
});
Joomla.submitbutton = function(task)
{
	if(task=='edit'){
		Joomla.submitform(task);
		return true;
	}
	
        if (task == '')
        {
                return false;
        }
        else
        {
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

function checkData(){
	alert("check");
}
	
</script>

