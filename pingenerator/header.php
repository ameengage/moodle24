    <link rel="stylesheet" href="styles/general.css" type="text/css" media="screen">
	<link rel="stylesheet" href="styles/styles.css">	
	<link rel="stylesheet" href="styles/style_002.css">
	<link rel="stylesheet" href="styles/gpo_menu.css">
	<link href="jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css"/>

		<script type="text/javascript" src="js/general.js"></script>
		<script src="jquery-ui/jquery.min.js"></script>
        <script src="jquery-ui/jquery-ui.min.js"></script>
		<script type="text/javascript" src="jquery-ui/jquery.ui.tabs.js"></script>


<link type='text/css' href='login/stylesheet.css' rel='stylesheet' media='screen' />
<link type='text/css' href='login/basic.css' rel='stylesheet' media='screen' />


	
<?php 
if(!isset($_SESSION['username']))
{
	echo "<script type='text/javascript'>window.location = 'index.php';</script>";
}
else if (isset($_SESSION['username']))
{
include('conn_string.php'); 
?>

    <table border='0' >
	 <tr>
	   <td>
	   <img src='images/logo.gif' border='0'/>
	      <!-- <table border='0' width='100%'>
		    <tr>
			  <td></td>	
			  <td align='right' valign='bottom'><img src='images/tag.jpg' border='0'/></td>
			</tr>
		   </table> -->
		</td>
		<td valign="bottom" style='padding-bottom:3px;' id="grid_item_h">
	   <?php
	   if (isset($_SESSION['username']))
       {
	   ?>    <table align='right' border='0' height='26'>
		     <tbody>
			   <tr><td valign="bottom" colspan='11' align='right'>Welcome <b><?php  echo $_SESSION['username'];?></b></td></tr>
			   <tr>	   
				   <td valign="bottom" width='55%' align='right'><a href="logout.php"><img src="images/icon_logout.gif" border='0'></a></td>
				   <td valign="bottom" align='right'><a href="logout.php">Logout</a></td>
			   </tr>
			 </tbody>
			</table>&nbsp;
		 <?php
	     }
		 ?>
	     
	   </td>
	 </tr>

	 <tr><td></td></tr>

	 <tr>
	  <td colspan=2>

	     <div id="tray">

            <ul>
			<?php
		    if (!isset($_SESSION['username']))
		    {
		    ?> 
			<li><a id="login_link" href="#">Login</a></li>
			<?php
			}
			?>
			<li id="tray-active"><a href="home.php">Code Generator</a></li>
          </ul>       

        </div>
	     
	  </td>
	 </tr>

	
	</table>

<?php
}
?>