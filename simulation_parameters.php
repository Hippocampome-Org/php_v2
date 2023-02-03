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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
   $(document).on('change','input[type=checkbox]' ,function(){
   var postcontent={};
   var formData = new FormData(); 
   $('input[type=checkbox]:checked').each(function(){ 
      var id = $(this).attr('id');
      var check_name = $(this).attr('name');
      var check_val = $(this).val();

      postcontent[id] = check_val ;
      formData.append(check_name, check_val);
   });
   const url = './simulation_params/simulation_params.php';

   postcontent = JSON.stringify(postcontent);
   var xmlHttp = new XMLHttpRequest();
   xmlHttp.onreadystatechange = function()
   {
      if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
      {
         if(xmlHttp.responseText){
            var x = document.getElementById("results-table");
            if (x.style.display === "none") {
               $("#results-table").html(xmlHttp.responseText);
               x.style.display = "block";
            } else {
               document.getElementById("results-tabl").insertAdjacentHTML("afterend",xmlHttp.responseText);
               //$("#results-table").html = $("#results-table").html + xmlHttp.responseText;
              // x.style.display = "none";
            }
         }
      }
   }
   xmlHttp.open("post", url); 
   xmlHttp.send(formData);
});
</script>
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
         <p>
		   <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="all_neuron" name="all_neuron" id="all_neuron">
         All neuron types &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="dg" name="dg" id="dg">
         Dentate Gyrus (DG) &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="ca3" name="ca3" id="ca3">
         CA3 &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="ca2" name="ca2" id="ca2">
         CA2 &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="ca1" name="ca1" id="ca1">
         CA1 &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="sub" name="sub" id="sub">
         Subiculum (Sub) &nbsp;&nbsp;</input>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="ec" name="ec" id="ec">
         Entorhinal Cortex (EC) &nbsp;&nbsp;</input>
      </p>
      <p>
         &nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="v1_neurons" name="v1_neurons" id="v1_neurons">
         All v1.x neuron types &nbsp;&nbsp;</input>
      </p>
      <p>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="v13_neurons" name="v13_neurons" id="v13_neurons">
         All v1.x rank 1-3 neuron types &nbsp;&nbsp;</input>
      </p>
      <p>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="v1_canonical" name="v1_canonical" id="v1_canonical">
         All v1.x canonical neuron types &nbsp;&nbsp;</input>
      </p>
      <p>* Method for determining undefined Izhikevich parameters:</p>
      <p>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="defined_neurons" name="defined_neurons" id="defined_neurons">
         Average all defined neuron types &nbsp;&nbsp;</input>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="defined_neurons_glu_gaba" name="defined_neurons_glu_gaba" id="defined_neurons_glu_gaba">
         Average all defined (glutamatergic/GABAergic)neuron types &nbsp;&nbsp;</input>
      </p>
      <p>
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="defined_neurons_sub" name="defined_neurons_sub" id="defined_neurons_sub">
         Average all defined neuron types from the same subregion &nbsp;&nbsp;</input>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="defined_neurons_glu_gaba_sub" name="defined_neurons_glu_gaba_sub" id="defined_neurons_glu_gaba_sub">
         Average all defined (glutamatergic/GABAergic)neuron types from the same subregion&nbsp;&nbsp;</input>
      </p>
   </div>
   <div>
   <div>
   <div id="results-table" name="results-table" style="display:none;">

   </div>
   </body>
</html>