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
<link rel="stylesheet" href="simulation_params/css/main.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="jqGrid-4/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="jquery-ui-1.10.2.custom/js/jquery.jqGrid.src-custom.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
   function newWindow(url, width, height) {     myWindow=window.open(url,'','width=' + width + ',height=' + height); }
   var selected_arr = [];
   $(document).ready(function(){
      console.log('this is run on page load');
      refreshPage();
   });

   function refreshPage() {
      simulationdataGet();
   }

   function simulationdataGet() {
      var xmlHttp = new XMLHttpRequest();
      const url_call = './simulation_params/simulation_params.php';
      xmlHttp.open("GET", url_call, true);
      xmlHttp.onreadystatechange = function () {
         if (xmlHttp.readyState == 4) {
            if (xmlHttp.status == 200) {
               //alert(xmlHttp.responseText);
               $("#results-table").html("<div>"+xmlHttp.responseText+"</div>");
            }
         }
      }
      xmlHttp.send();
   }

   function create_or_linkfile(){
      var selectedsubvalues = document.getElementById('selectedsubvalues').value;
      alert(selectedsubvalues);
      var xmlHttp = new XMLHttpRequest();
      const url_call = './simulation_params/temp_zipfile_creation.php';

      xmlHttp.onreadystatechange = function () {
         if (xmlHttp.readyState == 4) {
            if (xmlHttp.status == 200) {
               alert(xmlHttp.responseText);
               //$("#results-table").html("<div>"+xmlHttp.responseText+"</div>");
            }
         }
      }
      xmlHttp.open("post", url_call, true); 
      xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xmlHttp.send(selectedsubvalues);
   }

   function clean(obj) {
      for (var propName in obj) {
        if(typeof obj[propName]=="object")
          clean(obj[propName])
        if (obj[propName] === null || obj[propName] === undefined) 
          delete obj[propName];
       }
    }

   $(document).on('change','input[type=checkbox]' ,function(){
      //var postcontent={};
      var formData = new FormData(); 
      $('input[type=checkbox]:checked').each(function(){ 
         var id = $(this).attr('id');
         var check_name = $(this).attr('name');
         var check_val = $(this).val();
        // postcontent[id] = check_val ;
         formData.append(check_name, check_val);
      });
      const url = './simulation_params/simulation_params.php';

     // postcontent = JSON.stringify(postcontent);
      var xmlHttp = new XMLHttpRequest();
      xmlHttp.onreadystatechange = function()
      {
         if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
         {
            if(xmlHttp.responseText){
                  var selected_arr = JSON.parse(xmlHttp.responseText);
                  document.getElementById('param_count').innerHTML = selected_arr[0];//To update the param count on UI
                  result_synaptome_array = selected_arr[2];// So when popup- we need to get data from here
                  console.log("In line 108 "+result_synaptome_array);
                  selected_arr = selected_arr[1];

                  //To clear all tds background
                  const table = document.getElementById("results-table");
                  const cells = table.getElementsByTagName("td");
                  var selected_neurons = [];
                  $('#results-table input:checked').each(function() {
                     //selected_neurons.push($(this).attr('name'));//getting DG_1000
                     var neuron_name = $(this).closest('td').find('span').first().text();
                     selected_neurons.push(neuron_name);//Based on neuron name list when creating zip file get the data
                  });
                  document.getElementById('selectedsubvalues').value = selected_neurons;
                  //alert(selected_neurons);

                  for (const cell of cells) {
                     cell.style.backgroundColor = "rgb(255, 255, 255)";
                  }
                  //Till Here

                  for (const key in selected_arr) {
                     if(selected_arr[key].length > 0){
                        //var class_name = key.toLowerCase()+"_th_color";        
                        //To update the count next to the sub region
                        var span_name = "countVal_"+key.toLowerCase();
                        if(document.getElementById(span_name)){
                           var span_details = document.getElementById(span_name).textContent;
                           document.getElementById(span_name).innerHTML = selected_arr[key].length;
                           //Till Here

                           //To update the grey color if the text matches
                           var rowVal = selected_arr[key];
                           for (const rowkey in rowVal) {
                              var td_name = key.toLowerCase()+"_"+rowVal[rowkey]["id"];
                              var detail_name = "detail_div"+key.toLowerCase()+"_"+rowVal[rowkey]["id"];

                              if(document.getElementById(td_name)){
                                 //document.getElementById(td_name).style.backgroundColor = "rgb(211, 211, 211)";
                                 if(rowVal[rowkey]["synaptome_details"]){
                                    document.getElementById(detail_name).style.display = "block";
                                 }else{
                                    document.getElementById(detail_name).style.display = "none";
                                 }
                              }
                           }//for loop
                        }
                     }//If ex DG have data or not
               }//For loop const key
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
            <font class="font1">Simulation Parameters Selection Screen</font>
            <p>Download a pre-computed parameter set zip file: </p>
         </div>
         <div class="div-row">
            <div class="div-column" style="float:left;width:12.28%;">
            <button  type="button" style="width:97%" ><a href="./data/default_zipfiles/full_scale_DG_snn.zip">DG</a></button>
            </div>
            <div class="div-column" style="float:left;width:12.28%;">
            <button  type="button" style="width:97%" ><a href="./data/default_zipfiles/full_scale_CA3_snn.zip">CA3</a></button>
            </div>
            <div class="div-column" style="float:left;width:12.28%;">
            <button  type="button" style="width:97%" ><a href="./data/default_zipfiles/full_scale_CA2_snn.zip">CA2</a></button>
            </div>
            <div class="div-column" style="float:left;width:12.28%;">
            <button  type="button" style="width:97%" ><a href="./data/default_zipfiles/full_scale_CA1_snn.zip">CA1</a></button>
            </div>
            <div class="div-column" style="float:left;width:12.28%;">
            <button  type="button" style="width:97%" ><a href="./data/default_zipfiles/full_scale_SUB_snn.zip">Sub</a></button>
            </div>
            <div class="div-column" style="float:left;width:12.28%;:w
            ">
            <button  type="button" style="width:97%" ><a href="./data/default_zipfiles/full_scale_EC_snn.zip">EC</a></button>
            </div>
            <div class="div-column" style="float:left;width:12.28%;">
            <button  type="button" style="width:97%" ><a href="./data/default_zipfiles/full_scale_HPF_snn.zip">ALL</a></button>
            </div>
            <div class="div-column" style="float:left;width:12.28%;">
            <p></p>
            </div>
         </div>
         <div class="div-row">
            <div class="div-column" style="float:left;width:40.33%;">
            <p> Select a user-defined parameter set: </p>
            </div>
            <div class="div-column" style="float:left;width:40.33%;">
               <p id="current_params" name="current_params"><b>Current parameters: 
               <span id="param_count" name="param_count">0</span></b></p>
            </div>
            
            <div class="div-column" style="float:left;width:18.33%;">
            <p><input type="hidden" name="selectedsubvalues" id="selectedsubvalues" value=""/><button  type="button" onclick="create_or_linkfile()" >Generate Zip file</button></p>
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
         </div>
         <div class="div-row">
            <p>Method for determining undefined synaptice probabilities for E->E, E->I, I->E, and I->I connections between neuron types based on known values:</p>  
            <p><div class="div-column" style="float:left;">
            <input type="checkbox" style="background-color: rgb(0, 0, 153);" 
            value="mean" name="mean" id="mean">
            Mean</input>
            </div>
            <div class="div-column" style="float:left;">
            <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="median" name="median" id="median">
            Median</input>
            </div>
            <div class="div-column" style="float:left;">
            <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="minimum" 
            name="minimum" id="minimum">
            Minimum &nbsp;&nbsp;</input>
            </div>
            <div class="div-column" style="float:left;">
            <input type="checkbox" style="background-color: rgb(0, 0, 153);" 
            value="maximum" name="maximum" id="maximum">
            Maximum&nbsp;&nbsp;</input>
            </div>
            </p>
         </div>
      <div>
   </div>
   <div class="div-row" style="margin-top:80px;width:100%;">
   <div id="results-table" name="results-table" style="overflow-x: hidden;">
   </div>
   </div>  
   </body>
</html>