<?php



// no direct access

defined('_JEXEC') or die;JHtml::_('behavior.framework', true);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >

<head>

<jdoc:include type="head" />



<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/cca.css" type="text/css" />

</head>

<body>

<a name="toptop" id="toptop"></a>

<?php if($this->countModules('absolute')) { ?>

<div id="absolute">

<jdoc:include type="modules" name="absolute" style="xhtml" />

</div>

<?php } ?>

<div id="container">

	<div id="top">

    <a href="index.php" class="clearlinkhome"><span class="hiddenlink">home</span></a>

    <a href="index.php?option=com_content&view=article&id=50&Itemid=128" class="clearlinkclinic"><span class="hiddenlink">looking for clinics</span></a>

		<jdoc:include type="modules" name="top" style="raw" />

        <div id="nav"><jdoc:include type="modules" name="nav" style="raw" /></div>

    </div>

  	<div id="mainbody">

        <div id="left"><jdoc:include type="modules" name="left" style="raw" /></div>

        <div id="right">

        	<div id="news"><jdoc:include type="modules" name="news" style="raw" /></div>

            <div id="textarea">

            <jdoc:include type="modules" name="premain" style="xhtml" />

        	<jdoc:include type="component" />

        	<jdoc:include type="modules" name="postmain" style="raw" />

            </div>

        </div>

    <br clear="all" />

    </div>

	<!--<br clear="all" />-->

	<div id="footer">

    <jdoc:include type="modules" name="footer" style="raw" />

	</div>

</div>



</body>

</html>

