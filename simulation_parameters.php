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

function clear_checkboxes(){
   $('#results-table input:checkbox').each(function() {
      this.checked = '';
   });
}

function clear_radiobuttons(){
   $('#neuron_types_div input:radio').each(function() {
      this.checked = '';
   });
}

function default_radiobuttons(){
   $('#neuron_types_div input:radio').each(function() {
      if(this.id == 'v1_neurons'){
         this.checked = 'TRUE';
      }else{
         this.checked = '';
      }
   });
}

$(document).ready(function(){

   $('#selectall_neuron').click(function(event) {
      $('#subregions_div input:checkbox').each(function() {
         if(this.name=='unselectall_neuron'){
            this.checked = '';
         }else{
            this.checked = 'TRUE';
         }
      });
      $('#neuron_types_div input:radio').each(function() {
         if(this.id == 'v1_neurons'){
            this.checked = 'TRUE';
         }else{
            this.checked = '';
         }
      });
      subregion_selected();
   });

   $('#unselectall_neuron').click(function(event) {
      $('#subregions_select input:checkbox').each(function() {
         if(this.name=='unselectall_neuron'){
            if(this.checked =='TRUE'){
               this.checked =='';
            }else{
               this.checked = 'TRUE';
               clear_checkboxes();//To clear checkboxes in Sub regions result table
               clear_radiobuttons();
               $('#subregions_div input:checkbox').each(function() {
                    this.checked = '';
               });
            }
         }else{
            this.checked = '';
            
            clear_checkboxes();//To clear checkboxes in Sub regions result table
            clear_radiobuttons();
         }
      });
      
      $('#neuron_types_div input:radio').each(function() {
         this.checked = '';
      });
      refreshPage();
    });

    $('input[type=radio][name=v1_neurons]').change(function() {
        subregion_selected();
    });
    $('#subregions_div input:checkbox').change(function() {
        subregion_selected();
    });
});

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
   var neurons = [];
   var synaptic = [];
      $('#results-table input:checked').each(function() {
         var neuron_name = $(this).closest('td').find('span').first().text();
         neurons.push(neuron_name);//Based on neuron name list when creating zip file get the data
      });

   alert("Line 129 Neurons:"+neurons);

   var selectedsubvalues = 'neurons='+neurons;

   alert("Selected Sub Values:"+selectedsubvalues);
   var xmlHttp = new XMLHttpRequest();
   const url_call = './simulation_params/temp_zipfile_creation.php';

   xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState == 4) {
         if (xmlHttp.status == 200) {
            if(xmlHttp.responseText == 'Please select Neurons to create zip file.'){
               alert(xmlHttp.responseText);
            }else{
               window.location.href = xmlHttp.responseText;
            }
         }
      }
   }
   xmlHttp.open("post", url_call, true); 
   xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
   xmlHttp.send(selectedsubvalues);
   //xmlHttp.send("selectedsubvalues="+selectedsubvalues);
}
function OptionsSelected(me)
{
   var id_val = me.id;
   var sub_key = id_val.substring(0, id_val.indexOf("_"));
   var span_name = "countVal_"+sub_key.toLowerCase();
   
   if(!me.checked){
      if(document.getElementById(span_name)){
         var span_details = Number(document.getElementById(span_name).textContent);
         document.getElementById(span_name).innerHTML = span_details-1; //To update count
      }
      me.checked='';
   }
   if(me.checked){
      if(document.getElementById(span_name)){
         var span_details = Number(document.getElementById(span_name).textContent);
         document.getElementById(span_name).innerHTML = span_details+1;
      }
      me.checked=true;
   }
}
//$(document).on('change',function(){

//$('#subregions_div input:checkbox').each(function() {

function subregion_selected(){
   const getFormDataSize = (formData) => [...formData].reduce((size, [name, value]) => size + (typeof value === 'string' ? value.length : value.size), 0);

   const inputFieldsCheckboxes = ["all_neuron", "dg", "ca3", "ca2", "ca1", "sub", "ec",
                                       "v1_neurons", "v13_neurons", "v1_canonoical",
                                       "mean", "median", "minimum", "maximum"];
   var formData = new FormData();
   var checkboxes = $('input[type=checkbox]:checked');
   //alert("cjeckboxes length: "+checkboxes.length);
   $('input[type=checkbox]:checked').each(function(){ 
      var id = $(this).attr('id');
      var check_name = $(this).attr('name');
      var check_val = $(this).val();

      if(["dg", "ca3", "ca2", "ca1", "sub", "ec"].indexOf(check_name) !== -1){
         if(document.getElementById('unselectall_neuron').checked){
            document.getElementById('unselectall_neuron').checked = '';
         }
         //if(document.getElementById('selectall_neuron').checked){
           // document.getElementById('selectall_neuron').checked = '';
        // }
         if ($('input[type="radio"]:checked').length === 0 ){
            default_radiobuttons();
         }
      }
      if(inputFieldsCheckboxes.includes(check_name)){
         formData.append(check_name, check_val);
      }
   });
   //Added on Apr 5 2023
   $('input[type=radio]:checked').each(function(){ 
      var id = $(this).attr('id');
      var check_name = $(this).attr('name');
      var check_val = $(this).val();
      if(inputFieldsCheckboxes.includes(check_name)){
         formData.append(check_name, check_val);
      }
   });

   //To update the neurons selected so that when "generate zip file is created values can be used
   const table = document.getElementById("results-table");
   const cells = table.getElementsByTagName("td");
   const url = './simulation_params/simulation_params.php';

   var xmlHttp = new XMLHttpRequest();
   xmlHttp.onreadystatechange = function()
   {
      if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
      {
         if(xmlHttp.responseText){
            var selected_neurons =[];
            var selected_arr = JSON.parse(xmlHttp.responseText);
            //Commented onMay 9 2023 as we removed "Count Parameters"
            //document.getElementById('param_count').innerHTML = selected_arr[0];//To update the param count on UI
            selected_arr = selected_arr[1];
            clear_checkboxes();//To clear checkboxes in Sub regions result table
            for (const key in selected_arr) {
               if(selected_arr[key].length == 0){
                  var span_name = "countVal_"+key.toLowerCase();
                  if(document.getElementById(span_name)){
                     var span_details = document.getElementById(span_name).textContent;
                     document.getElementById(span_name).innerHTML = selected_arr[key].length;
                     //Till Here
                  }
               }
               if(selected_arr[key].length > 0){
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
                        var td_name_checkbox = key.toLowerCase()+"_"+rowVal[rowkey]["id"]+"_"+"checkbox";
                        var detail_name = "detail_div"+key.toLowerCase()+"_"+rowVal[rowkey]["id"];
                        if(document.getElementById(td_name)){
                           document.getElementById(td_name_checkbox).checked = true;
                        }
                     }//for loop
                  }
               }//If ex DG have data or not
            }//For loop const key
         }
      }
   }
   if(getFormDataSize(formData) > 0){ //Kept this condition as if the neurons are selected
      //this is 0 but we are triggering the ajax call
      //so to avoid that call we kept this condition
      xmlHttp.open("post", url);
      xmlHttp.send(formData);
   }
}
</script>
<?php
$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user
$rs = mysqli_query($conn,$query);
list($permission) = mysqli_fetch_row($rs);
?>

<title>Simulation Parameters Selection</title>
</head>
   <body>
   <?php
   include ("function/title.php");
   include ("function/menu_main.php");
   ?>
   <div class='title_area' style="width:100%;">
      <div class="div-row">
            <font class="font1">Simulation Parameters Selection</font>
         </div>
         <div class="div-row">
            <p style="margin-top:10px;">Download a pre-computed parameter set zip file: </p>
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
            <div class="div-column" style="float:left;width:12.28%;">
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
            <div class="div-column" style="float:left;width:100%;">
            <p> OR select a user-defined parameter set: </p>
            </div>
           <!-- <div class="div-column" style="float:left;width:40.33%;">
               <p id="current_params" name="current_params"><b>Current parameters: 
               <span id="param_count" name="param_count">0</span></b></p>
            </div> -->
         </div>
         <div class="div-row" id="subregions_select" name="subregions_select">
            <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="selectall_neuron" name="selectall_neuron" id="selectall_neuron">
            Select All &nbsp;&nbsp;</input>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" style="background-color: rgb(0, 0, 153);" value="unselectall_neuron" name="unselectall_neuron" id="unselectall_neuron">
            Unselect All &nbsp;&nbsp;</input>
            </p>
         </div>
         <div class="div-row" id="subregions_div" name="subregions_div">
            <p>
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
         </div>
         <div class="div-row" id="neuron_types_div" name="neuron_types_div">
            <p>
            &nbsp;&nbsp;&nbsp;
            <input type="radio" style="background-color: rgb(0, 0, 153);" value="v1_neurons" name="v1_neurons" id="v1_neurons">
            All v1.x neuron types &nbsp;&nbsp;</input>
            </p>
            <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" style="background-color: rgb(0, 0, 153);" value="v13_neurons" name="v1_neurons" id="v13_neurons">
            All v1.x rank 1-3 neuron types &nbsp;&nbsp;</input>
            </p>
            <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" style="background-color: rgb(0, 0, 153);" value="v1_canonical" name="v1_neurons" id="v1_canonical">
            All v1.x canonical neuron types &nbsp;&nbsp;</input>
            <input type="hidden" name="selectedsubvalues" id="selectedsubvalues" value=""/>
            <button style="margin-left:20%;padding-right:0px;" type="button" onclick="create_or_linkfile()" >Generate Zip file</button>
            </p>
         </div>
      
         <!--
         <div class="div-row" id="synaptic_options_div" name="synaptic_options_div">
            <p>Method for determining undefined synaptic probabilities for E->E, E->I, I->E, and I->I connections between neuron types based on known values:</p>
            <p><div class="div-column" style="float:left;">
            <input type="radio" style="background-color: rgb(0, 0, 153);" 
            value="mean" name="synap_prob" id="mean">
            Mean</input>
            </div>
            <div class="div-column" style="float:left;">
            <input type="radio" style="background-color: rgb(0, 0, 153);" value="median" name="synap_prob" id="median">
            Median</input>
            </div>
            <div class="div-column" style="float:left;">
            <input type="radio" style="background-color: rgb(0, 0, 153);" value="minimum" 
            name="synap_prob" id="minimum">
            Minimum &nbsp;&nbsp;</input>
            </div>
            <div class="div-column" style="float:left;">
            <input type="radio" style="background-color: rgb(0, 0, 153);" 
            value="maximum" name="synap_prob" id="maximum">
            Maximum&nbsp;&nbsp;</input>
            </div>
            </p>
         </div>-->

   <div class="div-row" style="margin-top:50px;width:100%;">
   <div id="results-table" name="results-table" style="overflow-x: hidden;">
   </div>
   </div>  
   </body>
</html>