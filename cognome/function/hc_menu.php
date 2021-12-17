<script>
jQuery(document).ready(function() {
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: '../../load_matrix_session_markers.php',
    success: function() {}
  }); 
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: '../../load_matrix_session_ephys.php',
    success: function() {}
  }); 
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: '../../load_matrix_session_morphology.php',
    success: function() {}
  });
  $.ajax({
      type: 'GET',
      cache: false,
      contentType: 'application/json; charset=utf-8',
      url: '../../load_matrix_session_connectivity.php',
      success: function() {}
    });
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: '../../load_matrix_session_firing.php',
    success: function() {}
  });
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: '../../load_matrix_session_firing_parameter.php',
    success: function() {}
  });
  /*
  $('div#menu_main_button_new_clr').css('display','block');
  */
});
</script>

<div id="menu_main_button_new_clr">
  <ul id="css3menu0" class="topmenu">
    <li class="topfirst"><a href="http://www.hippocampome.org/phpdev/morphology.php" style="height:32px;line-height:32px;"><span><img src="../../function/menu_support_files/news.png" alt="" id="image_news"/>Browse</span></a>
      <ul>
        <li class="subfirst"><a href="http://www.hippocampome.org/phpdev/morphology.php">Morphology</a></li>
        <li><a href="http://www.hippocampome.org/phpdev/markers.php">Molecular markers</a></li>
        <li><a href="http://www.hippocampome.org/phpdev/ephys.php">Membrane biophysics</a></li>
        <li><a href="http://www.hippocampome.org/phpdev/connectivity.php">Connectivity</a></li>
        <li><a href="http://www.hippocampome.org/phpdev/synaptome.php">Synaptic physiology</a></li>
         <!--?php 
          if ($permission != 1 && $_SESSION["fp"]==1) {
        ?-->
        <li><a href="http://www.hippocampome.org/phpdev/firing_patterns.php">Firing patterns</a></li>
         <!--?php   
          }
        ?--> 
          <!--?php 
          if ($permission != 1 && $_SESSION["im"]==1) {
        ?-->
        <li><a href="http://www.hippocampome.org/phpdev/Izhikevich_model.php">Izhikevich models</a></li>
        <!--?php   
          }
        ?--> 
        <li><a href="index.php">Cognome</a></li>        
        <li><a href="http://synapt.22web.org">Synaptome</a></li>
      </ul>
    </li>
    <li class="topmenu"><a href="http://www.hippocampome.org/phpdev/search.php?searching=1" style="height:32px;line-height:32px;"><span><img src="../../function/menu_support_files/find.png" alt="" id="image_find"/>Search</span></a>
      <ul>
        <li><a href="http://www.hippocampome.org/phpdev/find_author.php?searching=1">Author</a></li>
        <li><a href="http://www.hippocampome.org/phpdev/find_neuron_name.php?searching=1">Neuron Name/Synonym</a></li>
        <?php 
          if ($permission != 1 && $_SESSION["fp"]==1) {
        ?>
        <li><a href="http://www.hippocampome.org/phpdev/find_neuron_fp.php?searching=1">Original Firing Pattern</a></li>
        <?php   
          }
        ?> 
        <li><a href="http://www.hippocampome.org/phpdev/find_neuron_term.php?searching=1">Neuron Term (Neuron ID)</a></li>
        <li class="subfirst"><a href="http://www.hippocampome.org/phpdev/search.php?searching=1">Neuron Type</a></li>
        <li><a href="http://www.hippocampome.org/phpdev/find_pmid.php?searching=1">PMID/ISBN</a></li>
        <li><a href="http://www.hippocampome.org/phpdev/search_engine_custom.php">Search Engine</a></li>
      </ul>
    </li>
    <li class="toplast"><a href="http://www.hippocampome.org/phpdev/help.php" style="height:32px;line-height:32px;"><img src="../../function/menu_support_files/help.png" alt=""/>Help</a></li>
  </ul>
</div>

<script>
/*
jQuery(document).ready(function() {
  $("#menu_main_button_new_clr").css("diplay","none");
});
*/
</script>