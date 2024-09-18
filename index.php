<?php
  include ("access_db.php");
  include ("page_counter.php");  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<?php
/* include("simphp-2.0.php"); */

//-------user login required check----------
$_SESSION['perm'] = 0;
$_SESSION['fp']=0;
$_SESSION['if']=0;
$_SESSION['im']=0;
$_SESSION['sy']=0;
$_SESSION['cg']=0;
$_SESSION['sp']=0;
$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user
$rs = mysqli_query($conn,$query);
list($permission) = mysqli_fetch_row($rs);
if ($permission == 1) { 
  $_SESSION['perm'] = 1;
}
else{
  $_SESSION['perm'] = 0;
}
//-------------------------------------------
//$_SESSION['perm'] = 0;
$permission1 = $_SESSION['perm'];
if ($_SESSION['perm'] == 0) {
  if (array_key_exists('password', $_REQUEST)) {
    $query = "SELECT permission FROM user WHERE password = '{$_REQUEST['password']}'";
    $rs = mysqli_query($conn,$query);
    while(list($permission) = mysqli_fetch_row($rs)) {
      if ($permission == 1) { 
        $permission1 = $permission;
        $_SESSION['perm'] = $permission1;
      }
      else;
    }
      $query = "SELECT permission FROM user WHERE id=5";
      $rs = mysqli_query($conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['im']=1;
          }
      }
      $query = "SELECT permission FROM user WHERE id=6";
      $rs = mysqli_query($conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['sy']=1;
          }
      }      
      $query = "SELECT permission FROM user WHERE id=7";
      $rs = mysqli_query($conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['cg']=1;
          }
      }
      $query = "SELECT permission FROM user WHERE id=8";
      $rs = mysqli_query($conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['sp']=1;
          }
      }	  
  }
}
// delete temporary table for the research: -----------------
include("function/remove_table_research.php");
remove_table_by_tyme();
// ------------------------------------------------------------
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>

<meta http-equiv="Content-Type" content="text/html" />
<script type="text/javascript" src="style/resolution.js"></script>
<link rel="stylesheet" href="function/menu_support_files/menu_main_style.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>

<style type="text/css">
#dvLoading {
  background-image: url(images/ajax-loader.gif);
  background-repeat: no-repeat;
  background-position: center;
  height: 100px;
  width: 100px;
  position: fixed;
  z-index: 1000;
  left: 70%;
  top: 15%;
  margin: -25px 0 0 -25px;
}
</style>

<script>
jQuery(document).ready(function() {
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_markers.php',
    success: function() {}
  }); 
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_ephys.php',
    success: function() {}
  }); 
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_morphology.php',
    success: function() {}
  });
  $.ajax({
      type: 'GET',
      cache: false,
      contentType: 'application/json; charset=utf-8',
      url: 'load_matrix_session_connectivity.php',
      success: function() {}
    });
	$.ajax({
		type: 'GET',
		cache: false,
		contentType: 'application/json; charset=utf-8',
		url: 'load_matrix_session_firing.php',
		success: function() {}
  });
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_firing_parameter.php',
    success: function() {}
  });
  $('div#menu_main_button_new_clr').css('display','block');
});
</script>

<?php
include("function/icon.html");
?>

<title id="title_id">Hippocampome</title>

<link rel="icon" href="images/Hippocampome Logo.png">

</head>

<body>

<?php 
include("function/title.php");
if ($permission1 != 0) {
include("function/menu_main.php");  
}
?>  
<script>
jQuery(document).ready(function() {
  $("#menu_main_button_new_clr").css("diplay","none");
});
</script>

<br /><br /><br /><br /><br /><br /><br />

<table width=1100 class='index_table' id="table_load">
  <tr>    
    <td width="50%">
    <!-- ****************  BODY **************** -->
      <font class='font1' color='#000000'>
      WELCOME TO THE HIPPOCAMPOME PORTAL
      </font>
        <BR>
        <font class='font2' color='#000000'>
        v2.0 - Released: 05/24/2023
        <br>
        528,945 Pieces of Knowledge (PoK) & 46,292 Pieces of Evidence (PoE)
        <br>
        <br>
        The Hippocampome is a curated knowledge base of the circuitry
        of the hippocampus of normal adult, or adolescent, rodents at
        the mesoscopic level of neuronal types. Knowledge concerning
        dentate gyrus, CA3, CA2, CA1, subiculum, and entorhinal cortex
        is distilled from published evidence and is continuously updated
        as new information becomes available. Each reported neuronal
        property is documented with a pointer to, and excerpt from,
        relevant published evidence, such as citation quotes or illustrations.
        <br><br>
        The goal of the Hippocampome is dense coverage of available data
        characterizing neuronal types. The Hippocampome is a public and
        free resource for the neuroscience community, and the knowledge
        is presented for user-friendly browsing and searching and for
        machine-readable downloading.
        <br><br>
        If you have feedback on either functionality or content, or if you
        would like to be informed when the first official version is released,
        please fill out the
        <a href="user_feedback_form_entry.php">feedback form</a>
        or email us at
        <a href="mailto:Hippocampome.org@gmail.com">Hippocampome.org@gmail.com</a>.
        <br><br>
        The release of v1.0 on 09/23/2015 includes 3,697 PoK and 13,888 PoE. Reference: <b>Wheeler et al., 2015</b>.
        <a href="http://elifesciences.org/content/4/e09960">
        <i>Hippocampome.org: A knowledge base of neuron types in the rodent hippocampus</i></a>.
        eLife 2015;4:e09960.
        <br><br>
        The release of v1.1 on 10/17/2016 includes 3,697 PoK, 13,888 PoE, and the Neuron Term Portal, which allows one to view definitions for 
        terms and phrases used on this website. Reference: <b>Hamilton et al., 2016</b>
        <a href="http://link.springer.com/article/10.1007/s40708-016-0053-3">
        <i>Name-calling in the hippocampus (and beyond): coming to terms with neuron types and properties</i></a>.
        Brain Informatics 2017 Mar;4(1):1-12; doi:10.1007/s40708-016-0053-3.
        <br><br>
        The release of v1.2 on 11/06/2016 includes 3,936 PoK, 14,399 PoE, and a clickable Connectivity Matrix, an interactive Connectivity Navigator, and the
        ability to Search by Connectivity. Reference: <b>Rees et al., 2016</b>
        <a href="http://www.eneuro.org/content/3/6/ENEURO.0205-16.2016">
        <i>Graph theoretic and motif analyses of the hippocampal neuron type
        potential connectome</i></a>. eNeuro Nov 2016, ENEURO.0205-16.2016; DOI: 10.1523/ENEURO.0205-16.2016.
        <br><br>
        The release of v1.3 on 06/30/2017 includes 10,822 PoK, 21,285 PoE, and a downloadable list of Allen Brain Atlas (ABA) predictions of marker
        expressions and a utility for viewing the effects of thresholds on ABA marker expression predictions.
        Reference: <b>Hamilton et al., 2017</b>
        <a href = "http://www.sciencedirect.com/science/article/pii/S073170851730794X">
        <i>Molecular fingerprinting of principal neurons in the rodent hippocampus: a neuroinformatics approach.</i></a>
        Journal of Pharmaceutical and Biomedical Analysis 2017 Sep 10;144:269-278; doi: 10.1016/j.jpba.2017.03.062.
        <br><br>
        The release of v1.4 on 08/15/2019 includes an additional 7,946 PoK, 8,486 PoE, and the ability to
        access the Synapse Knowledge Base.
        Reference: <b>Moradi and Ascoli, 2019</b>
        <a href = "https://doi.org/10.1002/hipo.23148">
        <i>A comprehensive knowledge base of synaptic electrophysiology in the rodent hippocampal formation.</i></a>
        Hippocampus 2020 Apr;30(4):314-331; doi: https://doi.org/10.1002/hipo.23148.
        <br><br>
        The release of v1.5 on 09/06/2019 includes an additional 830 PoK, 77 PoE, and relational
        expression inferences in the knowledge base.
        Reference: <b>White, et al., 2019</b>
        <a href = "https://onlinelibrary.wiley.com/doi/full/10.1002/hipo.23165">
        <i>Molecular Expression Profiles of Morphologically Defined Hippocampal Neuron Types: Empirical Evidence and
        Relational Inferences.</i></a>
        Hippocampus 2020 May;30(5):472-487; doi: 10.1002/hipo.23165.
        <br><br>
        The release of v1.6 on 09/20/2019 includes an additional 3,640 PoK, 187 PoE, and firing pattern
        phenotypes in the knowledge base.
        Reference: <b>Komendantov, et al., 2019</b>
        <a href = "https://www.nature.com/articles/s41598-019-52611-w">
        <i>Quantitative firing pattern phenotyping of hippocampal neuron type.</i></a>
        Scientific Reports 2019 Nov 29;9(1):17915; doi: 10.1038/s41598-019-52611-w.
      </font>

      <br><br>

      <?php
        if ($permission1 == 0) {
      ?>

      <form action="index.php" method="post" id="form_load">
        <font class='font2'> Please insert password: </font><br />
        <input type="password" size="50" name='password' class='select1' id="password_load"/>
        <input type="submit" name='ok' value=' OK ' id="submit_load"/>
      </form>

      <?php
        }
        else;
      ?>

      <br>
    </td>

    <td width="50%" style='vertical-align:top; padding-top:0px; padding-left:50px'>
      <img src='images/brain6.png' width='450px' id="image_brain"/>
      <font class='font2' color='#000000'>
        <br>
        The release of v1.7 on 10/08/2019 includes Izhikevich models for most of the neuron types,
        downloadable parameter and CARLSim4-simulation files, and the ability to perform simulations of the firing
        patterns.
        Reference: <b>Venkadesh, et al., 2019</b>
        <a href = "https://journals.plos.org/ploscompbiol/article?id=10.1371/journal.pcbi.1007462">
        <i>Simple models of quantitative firing phenotypes in hippocampal neurons: comprehensive coverage of intrinsic
        diversity.</i></a>
        PLOS Computational Biology 2019 Oct 28;15(10):e1007462; doi: 10.1371/journal.pcbi.1007462.
        <br><br>
        The release of v1.8 on 12/28/2020 includes an additional 5,152 PoK, 6,055 PoE, and new browsable matrices for neurite lengths, somatic path distances, numbers of potential synapses, numbers of contacts, and connection probabilities. 
        Reference: <b>Tecuatl, et al., 2020</b>
        <a href = "https://www.jneurosci.org/content/41/8/1665">
        <i>Comprehensive estimates of potential synaptic connections in local circuits of the rodent hippocampal formation by axonal-dendritic overlap.</i></a>
        Journal of Neuroscience 2021 Feb 24;41(8):1665-1683; doi: 10.1523/JNEUROSCI.1193-20.2020.
        <br><br>
        The release of v1.9 on 02/27/2021 includes an additional 91 PoK, 768 PoE, and a new browsable matrix for in vivo recordings. 
        Reference: <b>Sanchez-Aguilera, et al., 2021</b>
        <a href = "https://journals.plos.org/plosbiology/article?id=10.1371/journal.pbio.3001213">
        <i>An update to Hippocampome.org by integrating single-cell phenotypes with circuit function in vivo.</i></a>
        PLoS Biology 2021 May 6;19(5):e3001213; doi: 10.1371/journal.pbio.3001213.
        <br><br>
        The release of v1.10 on 08/03/2021 includes the Cognome, a literature review and knowledge base of spiking neural circuit and network simulations of the hippocampal formation. 
        Reference: <b>Sutton and Ascoli, 2021</b>
        <a href = "https://www.sciencedirect.com/science/article/abs/pii/S1389041721000589">
        <i>Spiking neural networks and hippocampal function: A web-accessible survey of simulations, modeling methods, and underlying theories.</i></a>
        Cognitive Systems Research 2021 70:80-92. doi: 10.1016/j.cogsys.2021.07.008.
        <br><br>
        The release of v1.11 on 03/01/2022 includes 121 PoK, 651 PoE, and a new browsable matrix of neuron type census values for rat and mouse. 
        Reference: <b>Attili et al., 2022</b>
        <a href = "https://onlinelibrary.wiley.com/doi/10.1111/ejn.15639">
        <i>Quantification of neuron types in the rodent hippocampal formation by data mining and numerical optimization.</i></a>
        European Journal of Neuroscience 2022 55:1724-1741. doi: 10.1111/ejn.15639.
        <br><br>
        The release of v1.12 on 05/05/2022 includes 499,200 PoK, 8,495 PoE, and new browsable matrices of synaptic physiology parameter values for combinations of species, sex, age, temperature, and recording mode. 
        Reference: <b>Moradi et al., 2022</b>
        <a href = "https://www.nature.com/articles/s42003-022-03329-5">
        <i>Normalized unitary synaptic signaling of the hippocampus and entorhinal cortex predicted by deep learning of experimental recordings.</i></a>
        Communications Biology 2022 5(418):1-19. doi: 10.1038/s42003-022-03329-5.
        <br><br>
        <b>*NEW*</b> The release of v2.0 on 05/24/2023 includes 1,143 PoK, 288 PoE, and a new GUI for selecting neuron types for running spiking neural network simulations. 
        Reference: <b>Wheeler et al., 2023</b>
        <a href = "https://www.biorxiv.org/content/10.1101/2023.05.12.540597v1">
        <i>Hippocampome.org v2.0: a knowledge base enabling data-driven spiking neural network simulations of rodent hippocampal circuits.</i></a>
        bioRxiv. doi: 10.1101/2023.05.12.540597.
      </font>
    </td>
  </tr>

  <tr>
    <td colspan="2">
        <!--      <div class='version'> -->
        <div class='version2'>
          <!--  <a href='http://peg.gd/2yN' target="_blank">http://peg.gd/2yN</a> -->
    		  <!-- <a class="twitter-timeline" data-lang="en" data-width="400" data-height="500" data-theme="light" href="https://twitter.com/Hippocampome?ref_src=twsrc%5Etfw">Tweets by Hippocampome</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
          <hr class='hr2'/>
          <font class='font3' color='#000000'>
          <a href="Help_Terms_of_Use.php">Terms of Use</a>
          <br><br>
            NOTICE: Non-licensed copyrighted content that may be incorporated into this not-for-profit, educational web
            portal was vetted using the "fair use" criteria defined in
            <a href="http://www.copyright.gov/title17/92chap1.html#107" target="_blank">Title 17 of the U.S. Code,
            &sect; 107</a>. This content, cited throughout this portal, may be protected by Copyright Law and unavailable
            for reuse.  Except otherwise noted, this web portal is &copy; 
<?php call_user_func(function($y){$c=date('Y');echo $y.(($y!=$c)?'-'.$c:'');}, 2015); ?>
 by George Mason University, under a
            <a href =' http://creativecommons.org/licenses/by-sa/3.0/' target="_blank">Creative Commons
            Attribution-ShareAlike [CC BY-SA] license</a>. 

          <br>
          <br>
          528,945 Pieces of Knowledge (PoK) and 46,292 Pieces of Evidence (PoE)
          <br>
          <br />Last Update: 24 Apr 2024 (<a href="Help_Release_Notes.php">v2.0 R 1A</a>)</font>
          <br />

          <!-- <br /><p><?php echo $info; ?> -->
<!--          <br /><p><?php $webpage_id_number = 1; include('report_hits.php'); ?> -->
        </div>
    </td>   
  </tr>
</table>

</body>

</html>
