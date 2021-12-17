<?php


  include ("permission_check.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html" />
<script type="text/javascript" src="plotlyjs/plotly-latest.min.js"></script>
</head>

<body>
<table>
<tr><td><b>Input Current (pA):</b></td><td><input type="text" id="inputCurrentText" /></td><tr>
<tr><td><b>Start time (ms):</b></td><td><input type="text" id="inputStartTimeText" /></td><tr>
<tr><td><b>End time (ms):</b></td><td><input type="text" id="inputEndTimeText" /></td><tr>
</table>
<button type="button" id="simulateButton"  onclick="runPLOT();">Simulate Model</button>&nbsp;
<button type="button" id="dataButton" style="visibility:hidden;" onclick="downloadData();">Download Data</button>
 
<br/>

<div id="plotlyDiv" style="width:800px;height:550px;"></div>

<br/>
 

<br/>	

 

<br/>

<script type="text/javascript">



var xs = new Array();
var ys = new Array();
var global = new Array();
var data = new Array();

//# model parameters
var k=<?php echo $_GET["paramK"]; ?>;//1.2833102565689956;
var a=<?php echo $_GET["paramA"]; ?>;//0.006380990562354527;
var b=<?php echo $_GET["paramB"]; ?>;//57.941038132372135;
var d=<?php echo $_GET["paramD"]; ?>;//-58.0;
var Cm=<?php echo $_GET["paramC"]; ?>;//74.0;
var vr=<?php echo $_GET["paramVr"]; ?>;//-59.006040705399336;
var vt=<?php echo $_GET["paramVt"]; ?>;//-50.53342176093605;
var vmin=<?php echo $_GET["paramVmin"]; ?>;//-56.97945472527379;
var vpeak=<?php echo $_GET["paramVpeak"]; ?>;//0.5706428111684687;
 
//# input current
 

//# model definition

 

//# initial condition
var v0=vr;
var u0=0;

 
function rk4(index,x, y, dx, derivs, inputCurrent) {
 
		
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

        return y;
}

		

var derives2 = function(x, y, inputCurrent) {
    var dydx = [];

	
	
	//console.log("INPUT CURRENT>>>>>>>"+inputCurrent);
 
	dydx[0] = (k*(y[0]-vr)*(y[0]-vt)-y[1]+inputCurrent)/Cm;
	

	
	dydx[1] = a*(b*(y[0]-vr) - y[1]);
	
	if(y[0]>vpeak) {
		//console.log("WARNING"+y[0]);
		y[0]=vmin;
		y[1]+=d;
	}

	//console.log("returned============================>"+dydx);

    return dydx;
}
 

 
 
 
var   x1 = 0.0;
var    step = 0.001;
var    steps = 0;
var    maxSteps = 1000001;


var xStart = 0.0;
var yStart = [v0, u0];
 
function calculate(inputCurrent,startIndex,endIndex) {
	//console.log("TEST RANDOM="+inputCurrent);
	
	var savedInputCurrent = inputCurrent;
	
	var endTimeIndex =parseFloat(document.getElementById("inputEndTimeText").value);
	
	maxSteps=Math.ceil((endTimeIndex/step)+100001);
	
	
	
	while (steps < maxSteps) {

		//TODO:Uncomment this
		/*if(steps<=1000 || steps >=5000) {
			I=0;
		} else {
			I=-274.0;
		}*/
		
		
		
		if(steps<=startIndex || steps >=endIndex) {
			inputCurrent=0;
		} else {
			inputCurrent=savedInputCurrent;
		}
		
		
		if(steps===100) {
			//console.log("HERE");
		}
		
		//console.log("STEP+++++++>>"+steps);
	 
		var returnedVal = rk4(steps,xStart, yStart, step, derives2, inputCurrent);

		
		//y=v_prev;
	 
		//console.log("END=============================== y(" + x1 + ") =  \t" + JSON.stringify(returnedVal)  );
	 
		xs.push(x1);
		ys.push(returnedVal[0]);
		
		//global.push(x+"|"+y+"|"+u_prev);
		

		// using integer math for the step addition
		// to prevent floating point errors as 0.2 + 0.1 != 0.3
		//x = x+step;
		x1=((x1 * 10) + (step * 10)) / 10;
		

		
		steps += 1;
		

	}

}



function runPLOT() {
	clearPLOT();
	
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
	
	////console.log(JSON.stringify(xs));
	////console.log(JSON.stringify(ys));
	
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

 
 
  
  <!-- TODO: 
  When we click on simulate ask user to input:
  
  1)Input Current, Duration of Input current in ms, 
  Optional, Dellay we have that already in commented block
  
  2) Two compartmental models to be added for 2 type of nerves PSTUT and TSTUT.NASP
  
  3) Store spike array (when we reset equation)
  	if(y[0]>vpeak) {
		//console.log("WARNING"+y[0]);
		y[0]=vmin;
		y[1]+=d;
	}

  
  -->

</body>
</html>
 
