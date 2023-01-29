<?php
session_start();
include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<script type="text/javascript" src="style/resolution.js"></script>
<link rel="stylesheet" href="function/menu_support_files/menu_main_style.css" type="text/css" />
<link rel="stylesheet" href="function/simulation_params.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="jqGrid-4/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="jquery-ui-1.10.2.custom/js/jquery.jqGrid.src-custom.js" type="text/javascript"></script>
<?php
$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user
$rs = mysqli_query($conn,$query);
list($permission) = mysqli_fetch_row($rs);
?>

<title>Simulation Parameters Selection Screen</title>
</head>
   <body>
   <?php
   include ("function/title.php");
   include ("function/menu_main.php");
   ?>
   <div class='title_area' style="width:100%;">
      <div class="div-row">
      <div class="div-column" style="float:left;width:33.33%;">
         <font class="font1">Simulation Parameters Selection Screen</font>
      </div>
      <div class="div-column" style="float:left;width:33.33%;">
         <p id="current_params" name="current_params">Current parameters: 15,237</p>
      </div>
      <div class="div-column" style="float:left;width:33.33%;">
         <p><button  type="button" onclick ="evidencetoggle()" >Generate Zip file</button></p>
      </div>
      </div>
      <div class="div-row">
      <form>
         <p>
		   <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="all_neuron">
         All neuron types &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="dg">
         Dentate Gyrus (DG) &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="ca3">
         CA3 &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="ca2">
         CA2 &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="ca1">
         CA1 &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="sub">
         Subiculum (Sub) &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="ec">
         Entorhinal Cortex (EC) &nbsp;&nbsp;</input>
      </p>
      <p>
         &nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="1_neurons">
         All v1.x neuron types &nbsp;&nbsp;</input>
      </p>
      <p>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="1_neurons">
         All v1.x rank 1-3 neuron types &nbsp;&nbsp;</input>
      </p>
      <p>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="1_neurons">
         All v1.x canonical neuron types &nbsp;&nbsp;</input>
      </p>
      <p>* Method for determining undefined Izhikevich parameters:</p>
      <p>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="1_neurons">
         Average all defined neuron types &nbsp;&nbsp;</input>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="1_neurons">
         Average all defined (glutamatergic/GABAergic)neuron types &nbsp;&nbsp;</input>
      </p>
      <p>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="1_neurons">
         Average all defined neuron types from the same subregion &nbsp;&nbsp;</input>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="1_neurons">
         Average all defined (glutamatergic/GABAergic)neuron types from the same subregion&nbsp;&nbsp;</input>
      </p>
   </form>
   </div>
   </div>
   

  
   </body>
</html>