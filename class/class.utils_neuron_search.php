<?php

class utils_neuron_search{
    private $_type_id;
    private $_id;
    private $_letter;
    private $_neuron;
    private $_nickname;
    private static $_table_name;
    
    function __construct() {
    }
    // fetch the searched neuron records from temporary table
    public function retriveSearchedNeurons(){
        $searched_neurons_array=array();
        $index=0; 
        $temp_table=$this->get_table_name();
        $query_to_get_searched_neuron="SELECT id,type_id,letter,neuron FROM $temp_table";
        $rs = mysqli_query($GLOBALS['conn'],$query_to_get_searched_neuron);
        if (!$rs) {
            die("<p>Error in Listing Neuron Tables." . mysql_error() . "</p>");
        }
        while($row=mysqli_fetch_array($rs, MYSQLI_ASSOC))
        {
            $id = $row['id'];
            $type_id = $row['type_id'];
            $letter=$row['letter'];
            $name=$row['neuron'];
            $searched_neurons_array[$index]=new utils_neuron_search();
            $searched_neurons_array[$index]->set_id($id);
            $searched_neurons_array[$index]->set_type_id($type_id);
            $searched_neurons_array[$index]->set_letter($letter);
            $searched_neurons_array[$index]->set_neuron($name);
            $index++;   
        }
        return $searched_neurons_array;
    }
    public function retriveSearchedFP(){
        $searched_neurons_array=array();
        $index=0; 
        $temp_table=$this->get_table_name();
        $query_to_get_searched_neuron="SELECT id,type_id,neuron FROM $temp_table";
        $rs = mysqli_query($GLOBALS['conn'],$query_to_get_searched_neuron);
        if (!$rs) {
            die("<p>Error in Listing Neuron Tables." . mysql_error() . "</p>");
        }
        while($row=mysqli_fetch_array($rs, MYSQLI_ASSOC))
        {
            $id = $row['id'];
            $type_id = $row['type_id'];
            $name=$row['neuron'];
            $searched_neurons_array[$index]=new utils_neuron_search();
            $searched_neurons_array[$index]->set_id($id);
            $searched_neurons_array[$index]->set_type_id($type_id);
            $searched_neurons_array[$index]->set_neuron($name);
            $index++;   
        }
        return $searched_neurons_array;
    }
    // create temporary table to poplulate search table on find neuron name page.
    public function create_temp_table ()
    { 
        $temp_table=$this->get_table_name();      
        $drop_table ="DROP TABLE $temp_table";
        $query = mysqli_query($GLOBALS['conn'],$drop_table);
        $query= "CREATE TABLE IF NOT EXISTS  $temp_table(                    
                       id int(4) NOT NULL AUTO_INCREMENT,
                       type_id varchar(22),
                       letter varchar(3),
                       neuron varchar(512),
                       PRIMARY KEY (id));";
        $rs = mysqli_query($GLOBALS['conn'],$query);
        if (!$rs) {
                die("<p>Unable to Create Search Table.</p>");
        }
    }
    // insert new search record for neuron in temporary table
    public function insert_temporary($type_id,$letter, $neuron)
    {
        $temp_table=$this->get_table_name();
        //set_magic_quotes_runtime(0);
        if (get_magic_quotes_gpc()) {
            $neuron = stripslashes($neuron);    
        }
        $neuron= mysqli_real_escape_string($GLOBALS['conn'],$neuron);            
        $query = "INSERT INTO $temp_table (id,type_id, letter, neuron) VALUES (NULL,'$type_id', '$letter', '$neuron')";
        $rs = mysqli_query($GLOBALS['conn'],$query); 
        if (!$rs) {
            die("<p>Unable to Add Records to Search Table </p>");
        }
    }
    // update existing neuron record at index $id with new neuron record in temporary table.
    public function update_temporary($id,$type_id,$letter, $neuron, $flag)
    {
        $temp_table=$this->get_table_name();
        //set_magic_quotes_runtime(0);   
        if (get_magic_quotes_gpc()) {
            $neuron = stripslashes($neuron);    
        }
        $neuron= mysqli_real_escape_string($GLOBALS['conn'],$neuron);   
        if ($flag == 1) // Update letter:
        {
            $query = "UPDATE $temp_table SET type_id='$type_id', letter = '$letter', neuron = '$neuron' WHERE id='$id'";               
        }
        if ($flag == 2) // Update neuron:
        {
            $query = "UPDATE $temp_table SET type_id='$type_id', neuron = '$neuron' WHERE id='$id'";   
        }
        print($query);
        $rs = mysqli_query($GLOBALS['conn'],$query);
    }
    // remove the neuron record at index $id.
    public function remove($id)
    {
        $temp_table=$this->get_table_name();
        $query = "DELETE FROM $temp_table WHERE id='$id'";
        $rs = mysqli_query($GLOBALS['conn'],$query);
    }
    // remove all neuron records from temporary table.
    public function flushTempNeuronSearchTable(){
        $temp_table=$this->get_table_name();
        $query = "DELETE FROM $temp_table";
        $rs = mysqli_query($GLOBALS['conn'],$query);
    }
    public function get_type_id(){
        return $this->_type_id;
    }

    public function set_type_id($_type_id){
        $this->_type_id = $_type_id;
    }

    public function get_id(){
        return $this->_id;
    }

    public function set_id($_id){
        $this->_id = $_id;
    }

    public function get_letter(){
        return $this->_letter;
    }

    public function set_letter($_letter){
        $this->_letter = $_letter;
    }

    public function get_neuron(){
        return $this->_neuron;
    }

    public function set_neuron($_neuron){
        $this->_neuron = $_neuron;
    }

    public function get_nickname(){
        return $this->_nickname;
    }

    public function set_nickname($_nickname){
        $this->_nickname = $_nickname;
    }
    public function set_table_name($tab_name){
        self::$_table_name=$tab_name;
    }
    public function get_table_name(){
        return self::$_table_name;
    }
}
?>