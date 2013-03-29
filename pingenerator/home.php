<?php session_start();?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

	<meta http-equiv="content-script-type" content="text/javascript">

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
 <script type="text/javascript" src="http://joffesystems.com/pingenerator/js/general.js"></script>
	<title>Random Number Generator</title>
</head>


<body> 

<table border='0' align='center' style="background-color:#ffffff;">

<tr><td colspan=2 ><?php include('header.php');?></td></tr>

</table>

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});

</script>

<table border='0' align='center' width='895' style="background-color:#ffffff;">

<tr>
	

<td valign='top' style='padding-top:15px; padding-left:35px;' width='100%'>

   			<div id="tabs" style='width:695px;'>
	<ul>
		<li><a href="#tabs-1">Generator</a></li>
	</ul>
	<div id="tabs-1">
		<p>
		
		

		<table border='0'>	            

				     <tr>
					    <td>Total No. Of Random numbers to Generate:</td>	
						<td><input name='trn' id='trn' type='text' size='10'/></td>
					    <td>&nbsp;&nbsp;&nbsp;Digit:</td>	
						<td>&nbsp;
						       <select name='digit' id='digit' style="width:75px">
							     <option value='-'>-</option>
								 <option value='9'>9</option>
								 <option value='11'>11</option>
							   </select>
					    </td>
						<td>&nbsp;&nbsp;&nbsp;Block PIN:</td>	
						<td>&nbsp;
						       <select name='pin' id='pin' style="width:75px">
							     <option value='-'>-</option>
								 <option value='yes'>Yes</option>
								 <option value='no'>No</option>
							   </select>
						</td>
					  </tr>

					 
					 
					 <tr>
					   <td colspan = 6><br/>
					          <a href='#' onClick="javascript:generate();"><img src='images/generate.png' border='0'/></a>
					   </td>
					 </tr>
				 </table></p>
	</div>
</div>			

    <p id='test'></p>
  	<div id='rdnumber_div' style='display:block; height:350px; width:690px; position:relative;'>
	</div> 

	

</td>
</tr>
</table>

</div>  

   <?php include('footer.php');?>



</body></html>

