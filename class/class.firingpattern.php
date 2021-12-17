<?php
class firingpattern
{
	private $_name_table;
	private $_id;
	private $_overall_fp;
	private $_n_id;
	private $_id_array;                          
	private $_delay_ms;                            
	private $_pfs_ms;                         
	private $_swa_mv;                              
	private $_nisi;                        
	private $_isiav_ms;                            
	private $_sd_ms;                               
	private $_max_isi_ms;                         
	private $_min_isi_ms;                          
	private $_first_isi_ms;                        
	private $_isiav1_2_ms;                         
	private $_isiav1_3_ms;                         
	private $_isiav1_4_ms;                         
	private $_last_isi_ms;                         
	private $_isiavn_n_1_ms;                       
	private $_isiavn_n_2_ms;                       
	private $_isiavn_n_3_ms;                       
	private $_maxisi_minisi;                       
	private $_maxisin_isin_m1;                      
	private $_maxisin_isin_p1;                     
	private $_ai;                                  
	private $_rdmax;                               
	private $_df;                                 
	private $_sf;                                  
	private $_tmax_scaled;                         
	private $_isimax_scaled;                       
	private $_isiav_scaled;                       
	private $_sd_scaled;                           
	private $_slope;                               
	private $_intercept;                           
	private $_slope1;                              
	private $_intercept1;                          
	private $_css_yc1;                             
	private $_xc1;                                 
	private $_slope2;                              
	private $_intercept2;                          
	private $_slope3;                              
	private $_intercept3;                          
	private $_xc2;                                 
	private $_yc2;                                 
	private $_f1_2;                                
	private $_f1_2crit;                            
	private $_f2_3;                               
	private $_f2_3crit;                            
	private $_f3_4;                                
	private $_f3_4crit;                            
	private $_p1_2;                                
	private $_p2_3;                                
	private $_p3_4;                                
	private $_p1_2uv;                              
	private $_p2_3uv;                              
	private $_p3_4uv;                              
	private $_isii_isii_m1;                        
	private $_i;                                   
	private $_isiav_i_n_isi1_i_m1;                 
	private $_maxisij_isij_m1;                     
	private $_maxisij_isij_p1;                     
	private $_nisi_c;                              
	private $_isiav_ms_c;                          
	private $_maxisi_ms_c;                         
	private $_minisi_ms_c;                         
	private $_first_isi_ms_c;                      
	private $_tmax_scaled_c;                       
	private $_isimax_scaled_c;                     
	private $_isiav_scaled_c;                      
	private $_sd_scaled_c;                         
	private $_slope_c;                             
	private $_intercept_c;                         
	private $_slope1_c;                           
	private $_intercept1_c;                        
	private $_css_yc1_c;                           
	private $_xc1_c;                              
	private $_slope2_c;                            
	private $_intercept2_c;                        
	private $_slope3_c;                          
	private $_intercept3_c;                        
	private $_xc2_c;                               
	private $_yc2_c;                               
	private $_f1_2_c;                             
	private $_f1_2crit_c;                          
	private $_f2_3_c;                              
	private $_f2_3crit_c;                          
	private $_f3_4_c;                              
	private $_f3_4crit_c;                          
	private $_p1_2_c;                              
	private $_p2_3_c;                              
	private $_p3_4_c;                              
	private $_p1_2uv_c;                            
	private $_p2_3uv_c;                            
	private $_p3_4uv_c; 

	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}
	
	function retrieve_by_id($id)
	{
		$table=$this->getName_table();	
	
		$query = "SELECT overall_fp FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($fp) = mysqli_fetch_row($rs))
		{	
			$this->setOverall_fp($fp);
		}	
	}
	
	function retrieve_by_overall_fp($fp)
	{
		$table=$this->getName_table();	
	
		$query = "SELECT id FROM $table WHERE overall_fp = '$fp' and definition_parameter = 'parameter'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setid_array($id,$n);
			$n=$n+1;
		}	
		$this->setN_id($n);
	}
	function retrieve_parameter_to_show_from_id($fp,$fp_id){
		$table=$this->getName_table();
		
		$query="SELECT delay_ms, pfs_ms, swa_mv, nisi, isiav_ms, sd_ms, max_isi_ms, min_isi_ms, first_isi_ms, isiav1_2_ms, isiav1_3_ms, isiav1_4_ms, last_isi_ms, isiavn_n_1_ms, isiavn_n_2_ms, isiavn_n_3_ms, 
				maxisi_minisi, maxisin_isin_m1, maxisin_isin_p1, ai, rdmax, df, sf, tmax_scaled, isimax_scaled, isiav_scaled, sd_scaled, slope, intercept, slope1, intercept1, css_yc1, xc1, slope2, intercept2, slope3, intercept3, xc2, yc2, f1_2, f1_2crit, 
				f2_3, f2_3crit, f3_4, f3_4crit, p1_2, p2_3, p3_4, p1_2uv, p2_3uv, p3_4uv, isii_isii_m1, i, isiav_i_n_isi1_i_m1, maxisij_isij_m1, maxisij_isij_p1, nisi_c, isiav_ms_c, maxisi_ms_c, 
				minisi_ms_c, first_isi_ms_c, tmax_scaled_c, isimax_scaled_c, isiav_scaled_c, sd_scaled_c, slope_c, intercept_c, slope1_c, intercept1_c, css_yc1_c, xc1_c, slope2_c, intercept2_c, slope3_c, 
				intercept3_c, xc2_c, yc2_c, f1_2_c, f1_2crit_c, f2_3_c, f2_3crit_c, f3_4_c, f3_4crit_c, p1_2_c, p2_3_c, p3_4_c, p1_2uv_c, p2_3uv_c, p3_4uv_c
				FROM $table WHERE overall_fp = '$fp' and definition_parameter = 'parameter' and id='$fp_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($delay_ms, $pfs_ms, $swa_mv, $nisi, $isiav_ms, $sd_ms, $max_isi_ms, $min_isi_ms, $first_isi_ms, $isiav1_2_ms, $isiav1_3_ms, $isiav1_4_ms, $last_isi_ms, $isiavn_n_1_ms, $isiavn_n_2_ms, $isiavn_n_3_ms, $maxisi_minisi, $maxisin_isin_m1, $maxisin_isin_p1, $ai, $rdmax, $df, $sf, $tmax_scaled, $isimax_scaled, $isiav_scaled, $sd_scaled, $slope, $intercept, $slope1, $intercept1, $css_yc1, $xc1, $slope2, $intercept2, $slope3, $intercept3, $xc2, $yc2, $f1_2, $f1_2crit, $f2_3, $f2_3crit, $f3_4, $f3_4crit, $p1_2, $p2_3, $p3_4, $p1_2uv, $p2_3uv, $p3_4uv, $isii_isii_m1, $i, $isiav_i_n_isi1_i_m1, $maxisij_isij_m1, $maxisij_isij_p1, $nisi_c, $isiav_ms_c, $maxisi_ms_c, $minisi_ms_c, $first_isi_ms_c, $tmax_scaled_c, $isimax_scaled_c, $isiav_scaled_c, $sd_scaled_c, $slope_c, $intercept_c, $slope1_c, $intercept1_c, $css_yc1_c, $xc1_c, $slope2_c, $intercept2_c, $slope3_c, $intercept3_c, $xc2_c, $yc2_c, $f1_2_c, $f1_2crit_c, $f2_3_c, $f2_3crit_c, $f3_4_c, $f3_4crit_c, $p1_2_c, $p2_3_c, $p3_4_c, $p1_2uv_c, $p2_3uv_c, $p3_4uv_c) = mysqli_fetch_row($rs))
		{
			$this->set_delay_ms($delay_ms);
			$this->set_pfs_ms($pfs_ms);
			$this->set_swa_mv($swa_mv);
			$this->set_nisi($nisi);
			$this->set_isiav_ms($isiav_ms);
			$this->set_sd_ms($sd_ms);
			$this->set_max_isi_ms($max_isi_ms);
			$this->set_min_isi_ms($min_isi_ms);
			$this->set_first_isi_ms($first_isi_ms);
			$this->set_isiav1_2_ms($isiav1_2_ms);
			$this->set_isiav1_3_ms($isiav1_3_ms);
			$this->set_isiav1_4_ms($isiav1_4_ms);
			$this->set_last_isi_ms($last_isi_ms);
			$this->set_isiavn_n_1_ms($isiavn_n_1_ms);
			$this->set_isiavn_n_2_ms($isiavn_n_2_ms);
			$this->set_isiavn_n_3_ms($isiavn_n_3_ms);
			$this->set_maxisi_minisi($maxisi_minisi);
			$this->set_maxisin_isin_m1($maxisin_isin_m1);
			$this->set_maxisin_isin_p1($maxisin_isin_p1);
			$this->set_ai($ai);
			$this->set_rdmax($rdmax);
			$this->set_df($df);
			$this->set_sf($sf);
			$this->set_tmax_scaled($tmax_scaled);
			$this->set_isimax_scaled($isimax_scaled);
			$this->set_isiav_scaled($isiav_scaled);
			$this->set_sd_scaled($sd_scaled);
			$this->set_slope($slope);
			$this->set_intercept($intercept);
			$this->set_slope1($slope1);
			$this->set_intercept1($intercept1);
			$this->set_css_yc1($css_yc1);
			$this->set_xc1($xc1);
			$this->set_slope2($slope2);
			$this->set_intercept2($intercept2);
			$this->set_slope3($slope3);
			$this->set_intercept3($intercept3);
			$this->set_xc2($xc2);
			$this->set_yc2($yc2);
			$this->set_f1_2($f1_2);
			$this->set_f1_2crit($f1_2crit);
			$this->set_f2_3($f2_3);
			$this->set_f2_3crit($f2_3crit);
			$this->set_f3_4($f3_4);
			$this->set_f3_4crit($f3_4crit);
			$this->set_p1_2($p1_2);
			$this->set_p2_3($p2_3);
			$this->set_p3_4($p3_4);
			$this->set_p1_2uv($p1_2uv);
			$this->set_p2_3uv($p2_3uv);
			$this->set_p3_4uv($p3_4uv);
			$this->set_isii_isii_m1($isii_isii_m1);
			$this->set_i($i);
			$this->set_isiav_i_n_isi1_i_m1($isiav_i_n_isi1_i_m1);
			$this->set_maxisij_isij_m1($maxisij_isij_m1);
			$this->set_maxisij_isij_p1($maxisij_isij_p1);
			$this->set_nisi_c($nisi_c);
			$this->set_isiav_ms_c($isiav_ms_c);
			$this->set_maxisi_ms_c($maxisi_ms_c);
			$this->set_minisi_ms_c($minisi_ms_c);
			$this->set_first_isi_ms_c($first_isi_ms_c);
			$this->set_tmax_scaled_c($tmax_scaled_c);
			$this->set_isimax_scaled_c($isimax_scaled_c);
			$this->set_isiav_scaled_c($isiav_scaled_c);
			$this->set_sd_scaled_c($sd_scaled_c);
			$this->set_slope_c($slope_c);
			$this->set_intercept_c($intercept_c);
			$this->set_slope1_c($slope1_c);
			$this->set_intercept1_c($intercept1_c);
			$this->set_css_yc1_c($css_yc1_c);
			$this->set_xc1_c($xc1_c);
			$this->set_slope2_c($slope2_c);
			$this->set_intercept2_c($intercept2_c);
			$this->set_slope3_c($slope3_c);
			$this->set_intercept3_c($intercept3_c);
			$this->set_xc2_c($xc2_c);
			$this->set_yc2_c($yc2_c);
			$this->set_f1_2_c($f1_2_c);
			$this->set_f1_2crit_c($f1_2crit_c);
			$this->set_f2_3_c($f2_3_c);
			$this->set_f2_3crit_c($f2_3crit_c);
			$this->set_f3_4_c($f3_4_c);
			$this->set_f3_4crit_c($f3_4crit_c);
			$this->set_p1_2_c($p1_2_c);
			$this->set_p2_3_c($p2_3_c);
			$this->set_p3_4_c($p3_4_c);
			$this->set_p1_2uv_c($p1_2uv_c);
			$this->set_p2_3uv_c($p2_3uv_c);
			$this->set_p3_4uv_c($p3_4uv_c);
		}
	}
	
	function retrieve_parameter_to_show($fp)
	{
		$table=$this->getName_table();
		
		$query="SELECT delay_ms, pfs_ms, swa_mv, nisi, isiav_ms, sd_ms, max_isi_ms, min_isi_ms, first_isi_ms, isiav1_2_ms, isiav1_3_ms, isiav1_4_ms, last_isi_ms, isiavn_n_1_ms, isiavn_n_2_ms, isiavn_n_3_ms, 
				maxisi_minisi, maxisin_isin_m1, maxisin_isin_p1, ai, rdmax, df, sf, tmax_scaled, isimax_scaled, isiav_scaled, sd_scaled, slope, intercept, slope1, intercept1, css_yc1, xc1, slope2, intercept2, slope3, intercept3, xc2, yc2, f1_2, f1_2crit, 
				f2_3, f2_3crit, f3_4, f3_4crit, p1_2, p2_3, p3_4, p1_2uv, p2_3uv, p3_4uv, isii_isii_m1, i, isiav_i_n_isi1_i_m1, maxisij_isij_m1, maxisij_isij_p1, nisi_c, isiav_ms_c, maxisi_ms_c, 
				minisi_ms_c, first_isi_ms_c, tmax_scaled_c, isimax_scaled_c, isiav_scaled_c, sd_scaled_c, slope_c, intercept_c, slope1_c, intercept1_c, css_yc1_c, xc1_c, slope2_c, intercept2_c, slope3_c, 
				intercept3_c, xc2_c, yc2_c, f1_2_c, f1_2crit_c, f2_3_c, f2_3crit_c, f3_4_c, f3_4crit_c, p1_2_c, p2_3_c, p3_4_c, p1_2uv_c, p2_3uv_c, p3_4uv_c
				FROM $table WHERE overall_fp = '$fp' and definition_parameter = 'definition'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($delay_ms, $pfs_ms, $swa_mv, $nisi, $isiav_ms, $sd_ms, $max_isi_ms, $min_isi_ms, $first_isi_ms, $isiav1_2_ms, $isiav1_3_ms, $isiav1_4_ms, $last_isi_ms, $isiavn_n_1_ms, $isiavn_n_2_ms, $isiavn_n_3_ms, $maxisi_minisi, $maxisin_isin_m1, $maxisin_isin_p1, $ai, $rdmax, $df, $sf, $tmax_scaled, $isimax_scaled, $isiav_scaled, $sd_scaled, $slope, $intercept, $slope1, $intercept1, $css_yc1, $xc1, $slope2, $intercept2, $slope3, $intercept3, $xc2, $yc2, $f1_2, $f1_2crit, $f2_3, $f2_3crit, $f3_4, $f3_4crit, $p1_2, $p2_3, $p3_4, $p1_2uv, $p2_3uv, $p3_4uv, $isii_isii_m1, $i, $isiav_i_n_isi1_i_m1, $maxisij_isij_m1, $maxisij_isij_p1, $nisi_c, $isiav_ms_c, $maxisi_ms_c, $minisi_ms_c, $first_isi_ms_c, $tmax_scaled_c, $isimax_scaled_c, $isiav_scaled_c, $sd_scaled_c, $slope_c, $intercept_c, $slope1_c, $intercept1_c, $css_yc1_c, $xc1_c, $slope2_c, $intercept2_c, $slope3_c, $intercept3_c, $xc2_c, $yc2_c, $f1_2_c, $f1_2crit_c, $f2_3_c, $f2_3crit_c, $f3_4_c, $f3_4crit_c, $p1_2_c, $p2_3_c, $p3_4_c, $p1_2uv_c, $p2_3uv_c, $p3_4uv_c) = mysqli_fetch_row($rs))
		{
			$this->set_delay_ms($delay_ms);
			$this->set_pfs_ms($pfs_ms);
			$this->set_swa_mv($swa_mv);
			$this->set_nisi($nisi);
			$this->set_isiav_ms($isiav_ms);
			$this->set_sd_ms($sd_ms);
			$this->set_max_isi_ms($max_isi_ms);
			$this->set_min_isi_ms($min_isi_ms);
			$this->set_first_isi_ms($first_isi_ms);
			$this->set_isiav1_2_ms($isiav1_2_ms);
			$this->set_isiav1_3_ms($isiav1_3_ms);
			$this->set_isiav1_4_ms($isiav1_4_ms);
			$this->set_last_isi_ms($last_isi_ms);
			$this->set_isiavn_n_1_ms($isiavn_n_1_ms);
			$this->set_isiavn_n_2_ms($isiavn_n_2_ms);
			$this->set_isiavn_n_3_ms($isiavn_n_3_ms);
			$this->set_maxisi_minisi($maxisi_minisi);
			$this->set_maxisin_isin_m1($maxisin_isin_m1);
			$this->set_maxisin_isin_p1($maxisin_isin_p1);
			$this->set_ai($ai);
			$this->set_rdmax($rdmax);
			$this->set_df($df);
			$this->set_sf($sf);
			$this->set_tmax_scaled($tmax_scaled);
			$this->set_isimax_scaled($isimax_scaled);
			$this->set_isiav_scaled($isiav_scaled);
			$this->set_sd_scaled($sd_scaled);
			$this->set_slope($slope);
			$this->set_intercept($intercept);
			$this->set_slope1($slope1);
			$this->set_intercept1($intercept1);
			$this->set_css_yc1($css_yc1);
			$this->set_xc1($xc1);
			$this->set_slope2($slope2);
			$this->set_intercept2($intercept2);
			$this->set_slope3($slope3);
			$this->set_intercept3($intercept3);
			$this->set_xc2($xc2);
			$this->set_yc2($yc2);
			$this->set_f1_2($f1_2);
			$this->set_f1_2crit($f1_2crit);
			$this->set_f2_3($f2_3);
			$this->set_f2_3crit($f2_3crit);
			$this->set_f3_4($f3_4);
			$this->set_f3_4crit($f3_4crit);
			$this->set_p1_2($p1_2);
			$this->set_p2_3($p2_3);
			$this->set_p3_4($p3_4);
			$this->set_p1_2uv($p1_2uv);
			$this->set_p2_3uv($p2_3uv);
			$this->set_p3_4uv($p3_4uv);
			$this->set_isii_isii_m1($isii_isii_m1);
			$this->set_i($i);
			$this->set_isiav_i_n_isi1_i_m1($isiav_i_n_isi1_i_m1);
			$this->set_maxisij_isij_m1($maxisij_isij_m1);
			$this->set_maxisij_isij_p1($maxisij_isij_p1);
			$this->set_nisi_c($nisi_c);
			$this->set_isiav_ms_c($isiav_ms_c);
			$this->set_maxisi_ms_c($maxisi_ms_c);
			$this->set_minisi_ms_c($minisi_ms_c);
			$this->set_first_isi_ms_c($first_isi_ms_c);
			$this->set_tmax_scaled_c($tmax_scaled_c);
			$this->set_isimax_scaled_c($isimax_scaled_c);
			$this->set_isiav_scaled_c($isiav_scaled_c);
			$this->set_sd_scaled_c($sd_scaled_c);
			$this->set_slope_c($slope_c);
			$this->set_intercept_c($intercept_c);
			$this->set_slope1_c($slope1_c);
			$this->set_intercept1_c($intercept1_c);
			$this->set_css_yc1_c($css_yc1_c);
			$this->set_xc1_c($xc1_c);
			$this->set_slope2_c($slope2_c);
			$this->set_intercept2_c($intercept2_c);
			$this->set_slope3_c($slope3_c);
			$this->set_intercept3_c($intercept3_c);
			$this->set_xc2_c($xc2_c);
			$this->set_yc2_c($yc2_c);
			$this->set_f1_2_c($f1_2_c);
			$this->set_f1_2crit_c($f1_2crit_c);
			$this->set_f2_3_c($f2_3_c);
			$this->set_f2_3crit_c($f2_3crit_c);
			$this->set_f3_4_c($f3_4_c);
			$this->set_f3_4crit_c($f3_4crit_c);
			$this->set_p1_2_c($p1_2_c);
			$this->set_p2_3_c($p2_3_c);
			$this->set_p3_4_c($p3_4_c);
			$this->set_p1_2uv_c($p1_2uv_c);
			$this->set_p2_3uv_c($p2_3uv_c);
			$this->set_p3_4uv_c($p3_4uv_c);
		}
	}
	
	
	
	//SET----------------------
	public function setId($var)
    {
		  $this->_id = $var;
    }
	public function setOverall_fp($var)
    {
		  $this->_overall_fp = $var;
    }
	public function setid_array($var,$n)
	{
		$this->_id_array[$n]=$var;
	}
	public function setN_id($var)
	{
		$this->_n_id=$var;
	}
	public function set_delay_ms($delay_ms){
		$this->_delay_ms = $delay_ms;
	}
	public function set_pfs_ms($pfs_ms){
		$this->_pfs_ms = $pfs_ms;
	}
	public function set_swa_mv($swa_mv){
		$this->_swa_mv = $swa_mv;
	}
	public function set_nisi($nisi){
		$this->_nisi = $nisi;
	}
	public function set_isiav_ms($isiav_ms){
		$this->_isiav_ms = $isiav_ms;
	}
	public function set_sd_ms($sd_ms){
		$this->_sd_ms = $sd_ms;
	}
	public function set_max_isi_ms($max_isi_ms){
		$this->_max_isi_ms = $max_isi_ms;
	}
	public function set_min_isi_ms($min_isi_ms){
		$this->_min_isi_ms = $min_isi_ms;
	}
	public function set_first_isi_ms($first_isi_ms){
		$this->_first_isi_ms = $first_isi_ms;
	}
	public function set_isiav1_2_ms($isiav1_2_ms){
		$this->_isiav1_2_ms = $isiav1_2_ms;
	}
	public function set_isiav1_3_ms($isiav1_3_ms){
		$this->_isiav1_3_ms = $isiav1_3_ms;
	}
	public function set_isiav1_4_ms($isiav1_4_ms){
		$this->_isiav1_4_ms = $isiav1_4_ms;
	}
	public function set_last_isi_ms($last_isi_ms){
		$this->_last_isi_ms = $last_isi_ms;
	}
	public function set_isiavn_n_1_ms($isiavn_n_1_ms){
		$this->_isiavn_n_1_ms = $isiavn_n_1_ms;
	}
	public function set_isiavn_n_2_ms($isiavn_n_2_ms){
		$this->_isiavn_n_2_ms = $isiavn_n_2_ms;
	}
	public function set_isiavn_n_3_ms($isiavn_n_3_ms){
		$this->_isiavn_n_3_ms = $isiavn_n_3_ms;
	}
	public function set_maxisi_minisi($maxisi_minisi){
		$this->_maxisi_minisi = $maxisi_minisi;
	}
	public function set_maxisin_isin_m1($maxisin_isin_m1){
		$this->_maxisin_isin_m1 = $maxisin_isin_m1;
	}
	public function set_maxisin_isin_p1($maxisin_isin_p1){
		$this->_maxisin_isin_p1 = $maxisin_isin_p1;
	}
	public function set_ai($ai){
		$this->_ai = $ai;
	}
	public function set_rdmax($rdmax){
		$this->_rdmax = $rdmax;
	}
	public function set_df($df){
		$this->_df = $df;
	}
	public function set_sf($sf){
		$this->_sf = $sf;
	}
	public function set_tmax_scaled($tmax_scaled){
		$this->_tmax_scaled = $tmax_scaled;
	}
	public function set_isimax_scaled($isimax_scaled){
		$this->_isimax_scaled = $isimax_scaled;
	}
	public function set_isiav_scaled($isiav_scaled){
		$this->_isiav_scaled = $isiav_scaled;
	}
	public function set_sd_scaled($sd_scaled){
		$this->_sd_scaled = $sd_scaled;
	}
	public function set_slope($slope){
		$this->_slope = $slope;
	}
	public function set_intercept($intercept){
		$this->_intercept = $intercept;
	}
	public function set_slope1($slope1){
		$this->_slope1 = $slope1;
	}
	public function set_intercept1($intercept1){
		$this->_intercept1 = $intercept1;
	}
	public function set_css_yc1($css_yc1){
		$this->_css_yc1 = $css_yc1;
	}
	public function set_xc1($xc1){
		$this->_xc1 = $xc1;
	}
	public function set_slope2($slope2){
		$this->_slope2 = $slope2;
	}
	public function set_intercept2($intercept2){
		$this->_intercept2 = $intercept2;
	}
	public function set_slope3($slope3){
		$this->_slope3 = $slope3;
	}
	public function set_intercept3($intercept3){
		$this->_intercept3 = $intercept3;
	}
	public function set_xc2($xc2){
		$this->_xc2 = $xc2;
	}
	public function set_yc2($yc2){
		$this->_yc2 = $yc2;
	}
	public function set_f1_2($f1_2){
		$this->_f1_2 = $f1_2;
	}
	public function set_f1_2crit($f1_2crit){
		$this->_f1_2crit = $f1_2crit;
	}
	public function set_f2_3($f2_3){
		$this->_f2_3 = $f2_3;
	}
	public function set_f2_3crit($f2_3crit){
		$this->_f2_3crit = $f2_3crit;
	}
	public function set_f3_4($f3_4){
		$this->_f3_4 = $f3_4;
	}
	public function set_f3_4crit($f3_4crit){
		$this->_f3_4crit = $f3_4crit;
	}
	public function set_p1_2($p1_2){
		$this->_p1_2 = $p1_2;
	}
	public function set_p2_3($p2_3){
		$this->_p2_3 = $p2_3;
	}
	public function set_p3_4($p3_4){
		$this->_p3_4 = $p3_4;
	}
	public function set_p1_2uv($p1_2uv){
		$this->_p1_2uv = $p1_2uv;
	}
	public function set_p2_3uv($p2_3uv){
		$this->_p2_3uv = $p2_3uv;
	}
	public function set_p3_4uv($p3_4uv){
		$this->_p3_4uv = $p3_4uv;
	}
	public function set_isii_isii_m1($isii_isii_m1){
		$this->_isii_isii_m1 = $isii_isii_m1;
	}
	public function set_i($i){
		$this->_i = $i;
	}
	public function set_isiav_i_n_isi1_i_m1($isiav_i_n_isi1_i_m1){
		$this->_isiav_i_n_isi1_i_m1 = $isiav_i_n_isi1_i_m1;
	}
	public function set_maxisij_isij_m1($maxisij_isij_m1){
		$this->_maxisij_isij_m1 = $maxisij_isij_m1;
	}
	public function set_maxisij_isij_p1($maxisij_isij_p1){
		$this->_maxisij_isij_p1 = $maxisij_isij_p1;
	}
	public function set_nisi_c($nisi_c){
		$this->_nisi_c = $nisi_c;
	}
	public function set_isiav_ms_c($isiav_ms_c){
		$this->_isiav_ms_c = $isiav_ms_c;
	}
	public function set_maxisi_ms_c($maxisi_ms_c){
		$this->_maxisi_ms_c = $maxisi_ms_c;
	}
	public function set_minisi_ms_c($minisi_ms_c){
		$this->_minisi_ms_c = $minisi_ms_c;
	}
	public function set_first_isi_ms_c($first_isi_ms_c){
		$this->_first_isi_ms_c = $first_isi_ms_c;
	}
	public function set_tmax_scaled_c($tmax_scaled_c){
		$this->_tmax_scaled_c = $tmax_scaled_c;
	}
	public function set_isimax_scaled_c($isimax_scaled_c){
		$this->_isimax_scaled_c = $isimax_scaled_c;
	}
	public function set_isiav_scaled_c($isiav_scaled_c){
		$this->_isiav_scaled_c = $isiav_scaled_c;
	}
	public function set_sd_scaled_c($sd_scaled_c){
		$this->_sd_scaled_c = $sd_scaled_c;
	}
	public function set_slope_c($slope_c){
		$this->_slope_c = $slope_c;
	}
	public function set_intercept_c($intercept_c){
		$this->_intercept_c = $intercept_c;
	}
	public function set_slope1_c($slope1_c){
		$this->_slope1_c = $slope1_c;
	}
	public function set_intercept1_c($intercept1_c){
		$this->_intercept1_c = $intercept1_c;
	}
	public function set_css_yc1_c($css_yc1_c){
		$this->_css_yc1_c = $css_yc1_c;
	}
	public function set_xc1_c($xc1_c){
		$this->_xc1_c = $xc1_c;
	}
	public function set_slope2_c($slope2_c){
		$this->_slope2_c = $slope2_c;
	}
	public function set_intercept2_c($intercept2_c){
		$this->_intercept2_c = $intercept2_c;
	}
	public function set_slope3_c($slope3_c){
		$this->_slope3_c = $slope3_c;
	}
	public function set_intercept3_c($intercept3_c){
		$this->_intercept3_c = $intercept3_c;
	}
	public function set_xc2_c($xc2_c){
		$this->_xc2_c = $xc2_c;
	}
	public function set_yc2_c($yc2_c){
		$this->_yc2_c = $yc2_c;
	}
	public function set_f1_2_c($f1_2_c){
		$this->_f1_2_c = $f1_2_c;
	}
	public function set_f1_2crit_c($f1_2crit_c){
		$this->_f1_2crit_c = $f1_2crit_c;
	}
	public function set_f2_3_c($f2_3_c){
		$this->_f2_3_c = $f2_3_c;
	}
	public function set_f2_3crit_c($f2_3crit_c){
		$this->_f2_3crit_c = $f2_3crit_c;
	}
	public function set_f3_4_c($f3_4_c){
		$this->_f3_4_c = $f3_4_c;
	}
	public function set_f3_4crit_c($f3_4crit_c){
		$this->_f3_4crit_c = $f3_4crit_c;
	}
	public function set_p1_2_c($p1_2_c){
		$this->_p1_2_c = $p1_2_c;
	}
	public function set_p2_3_c($p2_3_c){
		$this->_p2_3_c = $p2_3_c;
	}
	public function set_p3_4_c($p3_4_c){
		$this->_p3_4_c = $p3_4_c;
	}
	public function set_p1_2uv_c($p1_2uv_c){
		$this->_p1_2uv_c = $p1_2uv_c;
	}
	public function set_p2_3uv_c($p2_3uv_c){
		$this->_p2_3uv_c = $p2_3uv_c;
	}
	public function set_p3_4uv_c($p3_4uv_c){
		$this->_p3_4uv_c = $p3_4uv_c;
	}
	
	
	
	
	
	//GET----------------------
	public function getName_table()
    {
		  return $this->_name_table;
    }
	public function getId()
    {
		  return $this->_id;
    }
	public function getOverall_fp()
    {
		  return $this->_overall_fp;
    }
	public function getid_array($i)
	{
		return $this->_id_array[$i];
	}
	public function getN_id()
	{
		return $this->_n_id;
	}
	public function get_delay_ms(){
		return $this->_delay_ms;
	}
	public function get_pfs_ms(){
		return $this->_pfs_ms;
	}
	public function get_swa_mv(){
		return $this->_swa_mv;
	}
	public function get_nisi(){
		return $this->_nisi;
	}
	public function get_isiav_ms(){
		return $this->_isiav_ms;
	}
	public function get_sd_ms(){
		return $this->_sd_ms;
	}
	public function get_max_isi_ms(){
		return $this->_max_isi_ms;
	}
	public function get_min_isi_ms(){
		return $this->_min_isi_ms;
	}
	public function get_first_isi_ms(){
		return $this->_first_isi_ms;
	}
	public function get_isiav1_2_ms(){
		return $this->_isiav1_2_ms;
	}
	public function get_isiav1_3_ms(){
		return $this->_isiav1_3_ms;
	}
	public function get_isiav1_4_ms(){
		return $this->_isiav1_4_ms;
	}
	public function get_last_isi_ms(){
		return $this->_last_isi_ms;
	}
	public function get_isiavn_n_1_ms(){
		return $this->_isiavn_n_1_ms;
	}
	public function get_isiavn_n_2_ms(){
		return $this->_isiavn_n_2_ms;
	}
	public function get_isiavn_n_3_ms(){
		return $this->_isiavn_n_3_ms;
	}
	public function get_maxisi_minisi(){
		return $this->_maxisi_minisi;
	}
	public function get_maxisin_isin_m1(){
		return $this->_maxisin_isin_m1;
	}
	public function get_maxisin_isin_p1(){
		return $this->_maxisin_isin_p1;
	}
	public function get_ai(){
		return $this->_ai;
	}
	public function get_rdmax(){
		return $this->_rdmax;
	}
	public function get_df(){
		return $this->_df;
	}
	public function get_sf(){
		return $this->_sf;
	}
	public function get_tmax_scaled(){
		return $this->_tmax_scaled;
	}
	public function get_isimax_scaled(){
		return $this->_isimax_scaled;
	}
	public function get_isiav_scaled(){
		return $this->_isiav_scaled;
	}
	public function get_sd_scaled(){
		return $this->_sd_scaled;
	}
	public function get_slope(){
		return $this->_slope;
	}
	public function get_intercept(){
		return $this->_intercept;
	}
	public function get_slope1(){
		return $this->_slope1;
	}
	public function get_intercept1(){
		return $this->_intercept1;
	}
	public function get_css_yc1(){
		return $this->_css_yc1;
	}
	public function get_xc1(){
		return $this->_xc1;
	}
	public function get_slope2(){
		return $this->_slope2;
	}
	public function get_intercept2(){
		return $this->_intercept2;
	}
	public function get_slope3(){
		return $this->_slope3;
	}
	public function get_intercept3(){
		return $this->_intercept3;
	}
	public function get_xc2(){
		return $this->_xc2;
	}
	public function get_yc2(){
		return $this->_yc2;
	}
	public function get_f1_2(){
		return $this->_f1_2;
	}
	public function get_f1_2crit(){
		return $this->_f1_2crit;
	}
	public function get_f2_3(){
		return $this->_f2_3;
	}
	public function get_f2_3crit(){
		return $this->_f2_3crit;
	}
	public function get_f3_4(){
		return $this->_f3_4;
	}
	public function get_f3_4crit(){
		return $this->_f3_4crit;
	}
	public function get_p1_2(){
		return $this->_p1_2;
	}
	public function get_p2_3(){
		return $this->_p2_3;
	}
	public function get_p3_4(){
		return $this->_p3_4;
	}
	public function get_p1_2uv(){
		return $this->_p1_2uv;
	}
	public function get_p2_3uv(){
		return $this->_p2_3uv;
	}
	public function get_p3_4uv(){
		return $this->_p3_4uv;
	}
	public function get_isii_isii_m1(){
		return $this->_isii_isii_m1;
	}
	public function get_i(){
		return $this->_i;
	}
	public function get_isiav_i_n_isi1_i_m1(){
		return $this->_isiav_i_n_isi1_i_m1;
	}
	public function get_maxisij_isij_m1(){
		return $this->_maxisij_isij_m1;
	}
	public function get_maxisij_isij_p1(){
		return $this->_maxisij_isij_p1;
	}
	public function get_nisi_c(){
		return $this->_nisi_c;
	}
	public function get_isiav_ms_c(){
		return $this->_isiav_ms_c;
	}
	public function get_maxisi_ms_c(){
		return $this->_maxisi_ms_c;
	}
	public function get_minisi_ms_c(){
		return $this->_minisi_ms_c;
	}
	public function get_first_isi_ms_c(){
		return $this->_first_isi_ms_c;
	}
	public function get_tmax_scaled_c(){
		return $this->_tmax_scaled_c;
	}
	public function get_isimax_scaled_c(){
		return $this->_isimax_scaled_c;
	}
	public function get_isiav_scaled_c(){
		return $this->_isiav_scaled_c;
	}
	public function get_sd_scaled_c(){
		return $this->_sd_scaled_c;
	}
	public function get_slope_c(){
		return $this->_slope_c;
	}
	public function get_intercept_c(){
		return $this->_intercept_c;
	}
	public function get_slope1_c(){
		return $this->_slope1_c;
	}
	public function get_intercept1_c(){
		return $this->_intercept1_c;
	}
	public function get_css_yc1_c(){
		return $this->_css_yc1_c;
	}
	public function get_xc1_c(){
		return $this->_xc1_c;
	}
	public function get_slope2_c(){
		return $this->_slope2_c;
	}
	public function get_intercept2_c(){
		return $this->_intercept2_c;
	}
	public function get_slope3_c(){
		return $this->_slope3_c;
	}
	public function get_intercept3_c(){
		return $this->_intercept3_c;
	}
	public function get_xc2_c(){
		return $this->_xc2_c;
	}
	public function get_yc2_c(){
		return $this->_yc2_c;
	}
	public function get_f1_2_c(){
		return $this->_f1_2_c;
	}
	public function get_f1_2crit_c(){
		return $this->_f1_2crit_c;
	}
	public function get_f2_3_c(){
		return $this->_f2_3_c;
	}
	public function get_f2_3crit_c(){
		return $this->_f2_3crit_c;
	}
	public function get_f3_4_c(){
		return $this->_f3_4_c;
	}
	public function get_f3_4crit_c(){
		return $this->_f3_4crit_c;
	}
	public function get_p1_2_c(){
		return $this->_p1_2_c;
	}
	public function get_p2_3_c(){
		return $this->_p2_3_c;
	}
	public function get_p3_4_c(){
		return $this->_p3_4_c;
	}
	public function get_p1_2uv_c(){
		return $this->_p1_2uv_c;
	}
	public function get_p2_3uv_c(){
		return $this->_p2_3uv_c;
	}
	public function get_p3_4uv_c(){
		return $this->_p3_4uv_c;
	}



}
?>