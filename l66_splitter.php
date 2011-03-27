Split big text files in multiple small ones

<?php 

class filesplit{ 
   
    function filesplit()
		{ 
			 
		} 

    var $_source = 'logs.txt'; 

    function Getsource()
		{ 
			return $this->_source; 
		} 

    function Setsource($newValue)
		{ 
			$this->_source = $newValue; 
		} 
    // how much lines per file 
    var $_lines = 1000; 
 
    function Getlines()
		{ 
			return $this->_lines; 
		} 
 
    function Setlines($newValue)
		{ 
			$this->_lines = $newValue; 
		} 
     
    /** 
     * Folder to create splitted files with trail slash at end 
     * @access private 
     * @var string 
     **/ 
    var $_path = 'logs/'; 
     
    /** 
     * 
     * @access public 
     * @return string 
     **/ 
    function Getpath(){ 
        return $this->_path; 
    } 
     
    /** 
     * 
     * @access public 
     * @return void 
     **/ 
    function Setpath($newValue){ 
        $this->_path = $newValue; 
    } 

    /** 
     * Configure the class 
     * @access public 
     * @return void 
     **/ 
    function configure($source = "",$path = "",$lines = ""){ 
        if ($source != "") { 
            $this->Setsource($source); 
        } 
        if ($path!="") { 
            $this->Setpath($path); 
        } 
        if ($lines!="") { 
            $this->Setlines($lines); 
        } 
    } 
     
     
    /** 
     * 
     * @access public 
     * @return void 
     **/ 
    function run(){ 
        $i=0; 
        $j=1; 
        $date = date("m-d-y"); 
        unset($buffer); 
         
        $handle = @fopen ($this->Getsource(), "r"); 
        while (!feof ($handle)) { 
          $buffer .= @fgets($handle, 4096); 
          $i++; 
              if ($i >= $split) { 
              $fname = $this->Getpath()."part.$date.$j.txt"; 
               if (!$fhandle = @fopen($fname, 'w')) { 
                    print "Cannot open file ($fname)"; 
                    exit; 
               } 
             
               if (!@fwrite($fhandle, $buffer)) { 
                   print "Cannot write to file ($fname)"; 
                   exit; 
               } 
               fclose($fhandle); 
               $j++; 
               unset($buffer,$i); 
                } 
        } 
        fclose ($handle); 
    } 
     

} 

?> 


<?php 

/** 
* Sample usage of the filesplit class 
*/ 

require_once("filesplit.class.php"); 

$s = new filesplit; 

/* 
$s->Setsource("logs.txt"); 
$s->Setpath("logs/"); 
$s->Setlines(100); //number of lines that each new file will have after the split. 
*/ 

$s->configure("logs.txt", "logs/", 2000); 
$s->run(); 

?>
