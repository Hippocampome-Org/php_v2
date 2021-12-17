// JavaScript Document

var w = screen.width;
var h = screen.height;

//alert (h);

if ((w == 1280) && (h == 1024))
{
	 document.write("<link rel='stylesheet' type='text/css' href='style/style_1280_1024.css'>");
}
else if ((w == 1280) && (h == 800))
{
	 document.write("<link rel='stylesheet' type='text/css' href='style/style_1280_1024.css'>");
}
else if ((w == 1680) && (h == 1050))
{
	 document.write("<link rel='stylesheet' type='text/css' href='style/style_1680_1050.css'>");
}
else if ((w == 1152) && (h == 864))
{
	 document.write("<link rel='stylesheet' type='text/css' href='style/style_1152_864.css'>");
}
else if ((w == 1024) && (h == 768))
{
	 document.write("<link rel='stylesheet' type='text/css' href='style/style_1024_768.css'>");
}
else
{
	 document.write("<link rel='stylesheet' type='text/css' href='style/style.css'>");
}


