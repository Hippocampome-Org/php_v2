<?php
include ("permission_check.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<link rel="shortcut icon" href="#">
<meta http-equiv="Content-Type" content="text/html" />
<script type="text/javascript" src="plotlyjs/plotly-latest.min.js"></script>
</head>


<body>

<?php

try {
  $currentChosenNeuronName = "";
  $jsonStr = $_SESSION['Izhikevich_model_json_only'];
  $output = json_decode($jsonStr, true);
  //echo '<pre>';
  /*foreach($output as $key => $value){
	 echo  $key."*********************".sizeof($value)."--------------".$value[0]['id']."<br/>";
  }*/
   //echo '</pre>';
  //Reading the neurones from the session, JSON decoding and parsing
  //We create the dropdown menu for neuron types here
  echo '<b>Neuron Types:</b>&nbsp;&nbsp;<select name="modelIz" id="modelIz" onchange="modelSelected()" onclick="modelSelected()">';
  echo '<option value="">------------------------------------------------------------</option>';
  //var_dump($output);
  
 
  foreach($output as $key => $value){
	$selectedFlag = "";
	if(trim($_GET["neuronId"])== trim($value[0]["unique_id"])) {
		$selectedFlag = "selected";
		$currentChosenNeuronName = $key;
	}
	echo '<option value="'.$key.'||||'.sizeof($value).'" '.$selectedFlag.'>'.$key."</option>";
  }
  
  
  echo '</select>';
  //echo '</pre>';
  echo '<br/>';
  echo '<br/>';
  echo '<div id="modelIzSubDiv"><b>Sub Types:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  echo '<select id="modelIzSub" onchange="subModelSelected()" onclick="subModelSelected()">';
  echo '<option value="">------------------------------------------------------------</option>';
  
  //echo $_GET['modelsCount'];
  $currentSubIndex = intval($_GET["currentIndex"]);
  $currentCount = intval($_GET['modelsCount']);
  //echo ">>>>>>currentSubIndex $currentSubIndex";
  //echo ">>>>>>currentCount $currentCount";
  for($i=0;$i<$currentCount;$i++) {
	    $subselectedFlag = "";
		if($i==$currentSubIndex) {
			$subselectedFlag = "selected";
		}
		
		$encodedJSON = json_encode($output[$currentChosenNeuronName][$i]);
		echo '<option value="'.base64_encode($encodedJSON).'" '.$subselectedFlag.'>'.$currentChosenNeuronName.' SUB TYPE '.($i+1).'</option>';
  
		//echo '<option  value="'.$i.'">'.json_encode($output[$currentChosenNeuronName][$currentSubIndex]).'</option>';
  }
  
  echo '</select></div>';
   echo '<br/>';
  
  } catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
?>


<table>
<tr><td><b>Input Current (pA):</b></td><td><input type="text" id="inputCurrentText" /></td><tr>
<tr><td><b>Start time (ms):</b></td><td><input type="text" id="inputStartTimeText" /></td><tr>
<tr><td><b>End time (ms):</b></td><td><input type="text" id="inputEndTimeText" /></td><tr>
<tr><td></td><td></td><tr>
<tr><td></td><td></td><tr>
<tr><td><b>Model Parameters:</b></td><td></td><tr>
<tr><td><b>Parameter k</b></td><td><input value="<?php echo $_GET["paramK"]; ?>" id="input_k" type="text"/></td></tr>
<tr><td><b>Parameter a</b></td><td><input value="<?php echo $_GET["paramA"]; ?>" id="input_a" type="text"/></td></tr>
<tr><td><b>Parameter b</b></td><td><input value="<?php echo $_GET["paramB"]; ?>" id="input_b" type="text"/></td></tr>
<tr><td><b>Parameter d</b></td><td><input value="<?php echo $_GET["paramD"]; ?>" id="input_d" type="text"/></td></tr>
<tr><td><b>Parameter Cm</b></td><td><input value="<?php echo $_GET["paramC"]; ?>" id="input_Cm" type="text"/></td></tr>
<tr><td><b>Parameter vr</b></td><td><input value="<?php echo $_GET["paramVr"]; ?>" id="input_vr" type="text"/></td></tr>
<tr><td><b>Parameter vt</b></td><td><input value="<?php echo $_GET["paramVt"]; ?>" id="input_vt" type="text"/></td></tr>
<tr><td><b>Parameter vmin</b></td><td><input value="<?php echo $_GET["paramVmin"]; ?>" id="input_vmin" type="text"/></td></tr>
<tr><td><b>Parameter vpeak</b></td><td><input value="<?php echo $_GET["paramVpeak"]; ?>" id="input_vpeak" type="text"/></td></tr>
<tr><td></td><td></td><tr>
<tr><td></td><td></td><tr>
<tr><td><b>Add a Refactory Period:</b></td><td><input id="refactoryPeriod" type="checkbox" onchange="showWarning(this)"/></td></tr>
</table>
<div id="warningDiv" style="visibility: hidden;">
<table>
<tr><td><b>Refractory Period Parameters:</b></td><td></td></tr>
<tr><td><b>Refractory Period</b></td><td><input value="1" id="input_refrac" type="text"/></td></tr>
<!--<tr><td><b>refrac_c</b></td><td><input value="0" id="input_refrac_c" type="text"/></td></tr>-->
</table>
<br/>
<b style="color:red;">Caution: a refractory period was not originally part of the Izhikevich model formulation.</b>
</div><br/>

<button type="button" id="simulateButton"  onclick="runPLOT();">Simulate Model</button>&nbsp;
<button type="button" id="clearButton"  onclick="clearPLOT();">Clear</button>&nbsp;
<button type="button" id="dataButton" style="visibility:hidden;" onclick="downloadData();">Download Data</button>
 
<br/>

<div id="plotlyDiv" style="width:800px;height:550px;"></div>

<br/>
 

<br/>	

 

<br/>

<script type="text/javascript">

function showWarning(checkboxElem) {
  var warningDiv = document.getElementById("warningDiv");
  if (checkboxElem.checked) {
    warningDiv.style.visibility='visible';
  } else {
    warningDiv.style.visibility='hidden';
  }
}

var refactoryPeriodEnabled = false;


var globalJSON = <?php echo $_SESSION['Izhikevich_model_json_only']; ?>
 
var dropDownValues;

var refrac;// = 1000;
// var refrac_c = 0;
var spk_tDiff = 0;
var lastSpikeTime = -1;
 
 
var k=<?php echo $_GET["paramK"]; ?>+0;//1.2833102565689956;
var a=<?php echo $_GET["paramA"]; ?>+0;//0.006380990562354527;
var b=<?php echo $_GET["paramB"]; ?>+0;//57.941038132372135;
var d=<?php echo $_GET["paramD"]; ?>+0;//-58.0;
var Cm=<?php echo $_GET["paramC"]; ?>+0;//74.0;
var vr=<?php echo $_GET["paramVr"]; ?>+0;//-59.006040705399336;
var vt=<?php echo $_GET["paramVt"]; ?>+0;//-50.53342176093605;
var vmin=<?php echo $_GET["paramVmin"]; ?>+0;//-56.97945472527379;
var vpeak=<?php echo $_GET["paramVpeak"]; ?>+0;//0.5706428111684687;
 
 
 
 
function subModelSelected() {
	var val=null;
	try {
		val = JSON.parse(document.getElementById("modelIzSub").value);
	} catch(ex) {
		val = JSON.parse(atob(document.getElementById("modelIzSub").value));
		//alert(val);
	}
	//console.log(">>>>>"+val.id);//Add log logic here
	//console.log(">>>>>"+val.k);//Add log logic here
	//console.log(JSON.stringify(val));//Add log logic here
	
	 document.getElementById("input_k").value=val.k;
	 document.getElementById("input_a").value=val.a;
	 document.getElementById("input_b").value=val.b;
	 document.getElementById("input_d").value=val.d;
	 document.getElementById("input_Cm").value=val.C;
	 document.getElementById("input_vr").value=val.Vr;
	 document.getElementById("input_vt").value=val.Vt;
	 document.getElementById("input_vpeak").value=val.Vpeak;
	 document.getElementById("input_vmin").value=val.Vmin;
}



function modelSelected() {
 clearPLOT();
 var fromDropDown=true;
 var val=document.getElementById("modelIz").value;
 
 //alert(JSON.stringify(globalJSON));
 
 
 
 var numberOfChilds = 0;
 var splitted = val.split("||||");
 var key = splitted[0];
 numberOfChilds = parseInt(splitted[1]);
 //alert(numberOfChilds);
 
 if(numberOfChilds > 0) {
	document.getElementById("modelIzSubDiv").style.visibility = "visible";
	//console.log(JSON.stringify(globalJSON[key]));		
	var select = document.getElementById("modelIzSub");
	select.innerHTML="";
	
	
	for (let i = 0; i < globalJSON[key].length; i++) {
		//console.log("DEBUG_HERE:----------------------------->"+globalJSON[key][i]['id']);//Add log logic here
		  
		if(i===0) {
			 document.getElementById("input_k").value=globalJSON[key][i]["k"];
			 document.getElementById("input_a").value=globalJSON[key][i]["a"];
			 document.getElementById("input_b").value=globalJSON[key][i]["b"];
			 document.getElementById("input_d").value=globalJSON[key][i]["d"];
			 document.getElementById("input_Cm").value=globalJSON[key][i]["C"];
			 document.getElementById("input_vr").value=globalJSON[key][i]["Vr"];
			 document.getElementById("input_vt").value=globalJSON[key][i]["Vt"];
			 document.getElementById("input_vpeak").value=globalJSON[key][i]["Vpeak"];
			 document.getElementById("input_vmin").value=globalJSON[key][i]["Vmin"];
		}
		
		var option = document.createElement("option");
		option.text = key+" SUB TYPE "+(i+1);
		option.value = JSON.stringify(globalJSON[key][i]);
		select.appendChild(option);
		
	}	
	
	
 }
 
 
 //dropDownValues = val.split(" ");
 //alert("split="+dropDownValues)
 
 /*
 document.getElementById("input_k").value=dropDownValues[0];
 document.getElementById("input_a").value=dropDownValues[1];
 document.getElementById("input_b").value=dropDownValues[2];
 document.getElementById("input_d").value=dropDownValues[3];
 document.getElementById("input_Cm").value=dropDownValues[4];
 document.getElementById("input_vr").value=dropDownValues[5];
 document.getElementById("input_vt").value=dropDownValues[6];
 document.getElementById("input_vpeak").value=dropDownValues[7];
 document.getElementById("input_vmin").value=dropDownValues[8];
 */
//# input current
 /*
	 k=parseFloat(document.getElementById("input_k").value);
	 a=parseFloat(document.getElementById("input_a").value);
	 b=parseFloat(document.getElementById("input_b").value);
	 d=parseFloat(document.getElementById("input_d").value);
	 Cm=parseFloat(document.getElementById("input_Cm").value);
	 vr=parseFloat(document.getElementById("input_vr").value);
	 vt=parseFloat(document.getElementById("input_vt").value);
	 vmin=parseFloat(document.getElementById("input_vpeak").value);
	 vpeak=parseFloat(document.getElementById("input_vmin").value);
	 */
}




var xs = new Array();
var ys = new Array();
var global = new Array();
var data = new Array();

var v0=vr;
var u0=0;

function rk4(index,x, y, dx, derivs, inputCurrent) {
	
	spk_tDiff = index - lastSpikeTime;
	if (lastSpikeTime != -1 && spk_tDiff < refrac && y[0] >= vt && y[0] < vpeak)
	{
		y[0] = y[0];
		y[1] = y[1];
	}
	else 
	{
		
		//console.log("<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>x="+x+"|y="+y);
		if(index===0) {
			return yStart;
		}
		var dimension = yStart.length;//derivs.length;
		var i, _y = [];
		var _k1,_k2,_k3,_k4;
		
		_k1 = derivs(x, y, inputCurrent);
        for (i = 0; i < dimension; i++) {
            _y[i] = y[i] + dx * 0.5 * _k1[i];
        }
		
        _k2 = derivs(x + dx * 0.5, _y, inputCurrent);
        for (i = 0; i < dimension; i++) {
            _y[i] = y[i] + dx * 0.5 * _k2[i];
        }
        _k3 = derivs(x + dx * 0.5, _y, inputCurrent);

        for (i = 0; i < dimension; i++) {
            _y[i] = y[i] + dx * _k3[i];
        }
        _k4 = derivs(x + dx, _y, inputCurrent);

        for (i = 0; i < dimension; i++) {
            y[i] += dx / 6 * (_k1[i] + 2 * _k2[i] + 2 * _k3[i] + _k4[i]);
        }
		x += dx;
	}
    
	return y;
}

var derives2 = function(x, y, inputCurrent) {
    var dydx = [];

	
	//console.log("INPUT CURRENT>>>>>>>"+inputCurrent);
 
	dydx[0] = (k*(y[0]-vr)*(y[0]-vt)-y[1]+inputCurrent)/Cm;
	
	
	dydx[1] = a*(b*(y[0]-vr) - y[1]);
	
	if (y[0] >= vpeak) {
		//console.log("WARNING"+y[0]);
		if (refactoryPeriodEnabled === false) {
			y[0] = vmin;
			y[1] += d;
		} else { // (refactoryPeriodEnabled === true)
			// if (refrac_c <= 0) {
			// 	refrac_c = refrac;
				lastSpikeTime = steps;
				y[0] = vmin;
				y[1] += d;
			// } else { // (refrac_c > 0)
			// 	// y[0] = vpeak;
			// }
		}
	}

	//console.log("returned============================>"+dydx);

    return dydx;
}

var xStart = 0.0;
var yStart = [v0, u0];
 
var   x1 = 0.0;
var    step = 0.001;
var    steps = 0;
var    maxSteps = 1000001;

var init_refrac = 1000;
var init_refrac_c = 0;

function calculate(inputCurrent,startIndex,endIndex) {

	var savedInputCurrent = inputCurrent;
	var endTimeIndex =parseFloat(document.getElementById("inputEndTimeText").value);
	
	maxSteps=Math.ceil((endTimeIndex/step)+100001);
	
	
	while (steps < maxSteps) {
		
		if(steps<=startIndex || steps >=endIndex) {
			inputCurrent=0;
		} else {
			inputCurrent=savedInputCurrent;
		}
		
		var returnedVal = rk4(steps,xStart, yStart, step, derives2, inputCurrent);

		// if(refactoryPeriodEnabled === true) {
		// 	// var refrac = 2000;
		// 	// var refrac_c = 0;
			
		// 	if (returnedVal[0] >= vpeak) {
		// 		if (refrac_c <= 0) {
		// 			refrac_c = refrac;
		// 			returnedVal[0] = vmin;
		// 		} else {
		// 			returnedVal[0] = vpeak;
		// 		}

		// 		//else { // (refrac_c > 0)
		// 		// 	refrac_c -= 1;
		// 		// // returnedVal[0] = vmin;
		// 		// }
		// 	}
		// }

		// refrac_c -= 1;
		
		// if(refactoryPeriodEnabled === true) {
		// 	if (returnedVal[0] >= vpeak) {
		// 		refrac_c = refrac;
		// 	}
		// 	if (refrac_c > 0) {
		// 		refrac_c -= 1;
		// 		returnedVal[0] = vmin;
		// 	}
		// }
		
		xs.push(x1);
		ys.push(returnedVal[0]);
		

		x1=((x1 * 10) + (step * 10)) / 10;
		steps += 1;
	}
}



function runPLOT() {
	clearPLOT();
	refactoryPeriodEnabled = document.getElementById("refactoryPeriod").checked;
	
     refrac = parseFloat(document.getElementById("input_refrac").value)*1000;//2000;
	 refrac_c = 0;//parseFloat(document.getElementById("input_refrac_c").value);//0;
	
	 k=parseFloat(document.getElementById("input_k").value);
	 a=parseFloat(document.getElementById("input_a").value);
	 b=parseFloat(document.getElementById("input_b").value);
	 d=parseFloat(document.getElementById("input_d").value);
	 Cm=parseFloat(document.getElementById("input_Cm").value);
	 vr=parseFloat(document.getElementById("input_vr").value);
	 vt=parseFloat(document.getElementById("input_vt").value);
	 vmin=parseFloat(document.getElementById("input_vmin").value);
	 vpeak=parseFloat(document.getElementById("input_vpeak").value);
	 
	 //alert("k="+k+"|a="+a+"|b="+b+"|d="+d+"|Cm="+Cm+"|vr="+vr+"|vt="+vt+"|vmin="+vmin+"|vpeak="+vpeak);
	
	TESTER = document.getElementById("plotlyDiv");
	
	//alert(document.getElementById("toto").value);
	document.getElementById("plotlyDiv").innerHTML="";
	var  I2 = parseFloat(document.getElementById("inputCurrentText").value);
	var startTimeIndex =parseFloat(document.getElementById("inputStartTimeText").value);
	var endTimeIndex =parseFloat(document.getElementById("inputEndTimeText").value);
	
	startStepIndex = startTimeIndex/step;
	endStepIndex = endTimeIndex/step;
	
	calculate(I2,startStepIndex,endStepIndex);

	var x = [];
	var y = [];

	data = [{ x: xs, y: ys }];
	
	var layout = {
	  title: {
		text:'Voltage vs Time',
		font: {
		  family: 'Courier New, monospace',
		  size: 24
		},
		xref: 'paper',
		x: 0.05,
	  },
	  xaxis: {
		title: {
		  text: 'Time (ms)',
		  font: {
			family: 'Courier New, monospace',
			size: 18,
			color: '#7f7f7f'
		  }
		},
	  },
	  yaxis: {
		title: {
		  text: 'Voltage(mV)',
		  font: {
			family: 'Courier New, monospace',
			size: 18,
			color: '#7f7f7f'
		  }
		}
	  }
	  ,
	  margin: { t: 0 }
	  
	};
	
	
	Plotly.plot( TESTER, data, layout);
	document.getElementById("dataButton").style.visibility = "visible";
}

function clearPLOT() {
	x1 = 0.0;
	step = 0.001;
	steps = 0;
	//maxSteps = 10001;

	xStart = 0.0;
	yStart = [v0, u0];
	
	xs = [];
	ys = [];
	
	xs = new Array();
	ys = new Array();
	
	data = new Array();
	
	TESTER2 = document.getElementById("plotlyDiv");
	
	Plotly.purge(TESTER2);
	TESTER2.innerHTML="";
	
}


 

function downloadData() {
	var csvContent = "";

	csvContent += "time,voltage,\r\n";
	
	for(i=0;i<data[0].x.length;i++) {
		csvContent+=data[0].x[i]+","+data[0].y[i]+"\r\n";
	}
	
	
	csvData = new Blob([csvContent], { type: 'text/csv' }); 
	var csvUrl = URL.createObjectURL(csvData);

 
	var link = document.createElement("a");
	link.setAttribute("href", csvUrl);
	link.setAttribute("download", "export.csv");
	document.body.appendChild(link); // Required for FF

	link.click();
	
}

 
</script>

 


</body>
</html>
 
