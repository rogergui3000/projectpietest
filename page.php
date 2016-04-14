<?php

/*
 * @author     Mekeidje Roger
 * @copyright  2016
 * @license    
 */
 /*
 * Please fill this according to your database
 * Create an empty array to store constants for config
 * uncomment line 410-418 to create the table and populate the table by running page.php onli
 * then delete.
 */
 $C = array();

/*
 * The database host URL
 */
$C['DB_HOST'] = 'localhost';

/*
 * The database username
 */
$C['DB_USER'] = 'root';

/*
 * The database password
 */
$C['DB_PASS'] = '';

/*
 * The name of the database to work with
 */
$C['DB_NAME'] = 'projectpie';

/*
 * Define constants for configuration info
 */
foreach ( $C as $name => $val )
{
    define($name, $val);
}

/*
 * Create a PDO object
 */
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
$dbo = new PDO($dsn, DB_USER, DB_PASS);

/*
 * class BD_Connect
 * 
 *     
 */
class DB_Connect {

    /**
     * Stores a database object
     *
     * @var object A database object
     */
    protected $db;

    /**
     * Checks for a DB object or creates one if one isn't found
     *
     * @param object $dbo A database object
     */
    protected function __construct($db=NULL)
    {
        if ( is_object($db) )
        {
            $this->db = $db;
        }
        else
        {
            // Constants are defined in /sys/config/db-cred.inc.php
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            try
            {
                $this->db = new PDO($dsn, DB_USER, DB_PASS);
            }
            catch ( Exception $e )
            {
                // If the DB connection fails, output the error
                die ( $e->getMessage() );
            }
        }
    }

}

/*
 * @author
 * @copyright
 */
class Api extends DB_Connect
{   /*
     * @param object $dbo a database object
     * @param string $useDate the date to use to build the calendar
     * @return void
     */
    public function __construct($db=NULL)
    {
        /*
         * Call the parent constructor to check for
         * a database object
         */
        parent::__construct($db);
    }
    
    /*
     *  public function create table for projects
     *  @param 
     *
     */
    public function createTable_projects(){
	    
	    $sql = "CREATE TABLE IF NOT EXISTS projects (
	    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	    title VARCHAR(155) NOT NULL,
	    short_blurd VARCHAR(255) NOT NULL,
	    picture VARCHAR(5000) NOT NULL DEFAULT 'https://scontent-mrs1-1.xx.fbcdn.net/hphotos-xfl1/v/t1.0-9/10294511_961876703902262_1391347360913734571_n.jpg?oh=68fe2445eb387aa1d7fe1552f1d70437&oe=574C80CD',
	    country VARCHAR(155) NOT NULL,
	    city VARCHAR(155) NOT NULL,
	    wproject VARCHAR(11) NOT NULL DEFAULT 'false',
	    cathegories varchar(5000) NOT NULL DEFAULT ' [   {id: ''Animal Welfare'', count: 0, checked: false},         {id: ''Children'', count: 0, checked: false},         {id: ''Education'', count: 0, checked: false},         {id: ''Immigration & Refugees'', count: 0, checked: false},         {id: ''Homeless & Housing'', count: 0, checked: false},         {id: ''Humanitarian Relief'', count: 0, checked: false},         {id: ''Senior Citizen'', count: 0, checked: false},         {id: ''Youth Development'', count: 0, checked: false},         {id: ''Arts & Culture'', count: 0, checked: false},         {id: ''Community Development'', count: 0, checked: false},         {id: ''Environment'', count: 0, checked: false},         {id: ''Health'', count: 0, checked: false},         {id: ''Human & Civil Rights'', count: 0, checked: false},         {id: ''Peace'', count: 0, checked: false},         {id: ''Woman'', count: 0, checked: false}      ]',
	    cre_date TIMESTAMP
	    )";
	    
	    try
	    {
		    $stmt = $this->db->prepare($sql);
		    $stmt->execute();
		    print("Created projects Table.\n");
	    }
	    catch( Exception $e)
	    {
	    	    die ( $e->getMessage() );
	    }
    }
    
    /*
     *  public function create Table structure for table `countries`
     *  @param 
     *
     */
    public function createTable_countries(){
	    $sql = "CREATE TABLE IF NOT EXISTS countries (
	    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	    country_name VARCHAR(90) NOT NULL
	    )";
	    
	    try
	    {
		    $stmt = $this->db->prepare($sql);
		    $stmt->execute();
		    print("Created countries Table.\n");
	    }
	    catch( Exception $e)
	    {
	    	    die ( $e->getMessage() );
	    }
    }
    
    /*
     *Insert multiple rows in one query using PDO MySQL prepared statements
     */
    public function insert_countries($countries) {
	    foreach($countries as $item => $val)
	    {   
		     $sql = " INSERT INTO `countries`( `country_name`) VALUES ('$val') ";
	 	    try
	 	    {
	 		    $stmt = $this->db->prepare($sql);
	 		    $stmt->execute();
	 	    }
	 	    catch( Exception $e)
	 	    {
	 	    	    die ( $e->getMessage() );
	 	    }
	    }
    }
    
    /*
     *  public function create Table structure for table `perks`
     *  @param 
     *
     */
    public function createTable_perks(){
	    $sql = "CREATE TABLE IF NOT EXISTS perks (
	    pid INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	    pTitle VARCHAR(155) NOT NULL,
	    cost VARCHAR(255) NOT NULL,
	    delivery VARCHAR(155) NOT NULL,
	    delivery_date VARCHAR(155) NOT NULL,
	    description VARCHAR(155) NOT NULL,
	    cre_date TIMESTAMP,
	    projectId INT(11)
	    )";
	    
	    try
	    {
		    $stmt = $this->db->prepare($sql);
		    $stmt->execute();
		    print("Created  perks Table.\n");
	    }
	    catch( Exception $e)
	    {
	    	    die ( $e->getMessage() );
	    }
    }
    
    /*
     *  public function to get `perks`
     *  @param 
     *  return json
     */
    
    public function get_project() {
	    	   
     	$sql = " SELECT * FROM projects ";
    	 	try
    	 	  {
	    	    $stmt = $this->db->prepare($sql);
	    	    $stmt->execute();
		    $row = $stmt->fetch();
    	         #  JSON-encode the response
    	         echo $json_response = json_encode($row);
            }
            catch( Exception $e)
    	       {
    	         die ( $e->getMessage() );
            }
    }
    
    // get countries
    public function get_countries() {
	    
	    $sql = "SELECT * FROM countries" ;
   	 	try
   	 	  {
    	    	     $stmt = $this->db->prepare($sql);
    	    		$stmt->execute();
	          $row = $stmt->fetchAll();
   	         #  JSON-encode the response
   	         echo $json_response = json_encode($row);
           }
           catch( Exception $e)
   	      {
   	         die ( $e->getMessage() );
           }
    }
    
    // get cathegories
    public function get_cathegorie() {
	   
	    $sql = "SELECT cathegories FROM projects LIMIT 1 " ;
   	 	try
   	 	  {
    	    	     $stmt = $this->db->prepare($sql);
    	    		$stmt->execute();
	          $row = $stmt->fetch();
   	 	     $a = '['.$row['cathegories'].']';
			
			//echo json_encode($a);
           }
           catch( Exception $e)
   	      {
   	         die ( $e->getMessage() );
           }
   }
    
    // save or update project
    public function save_project( $id, $title, $short_blurd, $picture, $country, $city,  $cathegories) {
  
	    if(!empty($id)){
		$sql = "SELECT count(*) FROM `projects` WHERE id = '$id' "; 
		$result = $this->db->prepare($sql); 
		$result->execute(); 
		$number_of_rows = $result->fetchColumn(); 

		// if number row greater than 1 update
  	 	     if($number_of_rows[0] >= 1){
			$query ="UPDATE `projects` SET title='$title',short_blurd='$short_blurd',country='$country',city='$city' WHERE title = '$title' OR short_blurd = '$short_blurd' ";
	   	 	try
	   	 	  {
	      	    	  $stm = $this->db->prepare($query);
	      	    	  $stm->execute();
				  $array= array('Success'=>'true',  'Message'=>'Updated Project.');
				  echo $res = json_encode($array);
	            }
	            catch( Exception $e)
	    	       {
	    	         die ( $e->getMessage() );
	            }
  	 	     }// else insert new row
		else {
			$query ="INSERT INTO `projects`( `title`, `short_blurd`, `country`, `city`) VALUES ('$title', '$short_blurd',  '$country', '$city')";
			
	   	 	try
	   	 	  {    
	      	    	  $stm = $this->db->prepare($query);
	      	    	  $stm->execute();
				  $array= array( 'Success'=>'true',  'Message'=>'New Project added.');
				  echo $res = json_encode($array);
				 
	            }
	            catch( Exception $e)
	    	       {
	    	         die ( $e->getMessage() );
	            }
  	 	     }
			
	    }else{
		$query ="INSERT INTO `projects`( `title`, `short_blurd`, `country`, `city`) VALUES ('$title', '$short_blurd',  '$country', '$city')";
		
   	 	try
   	 	  {    
      	    	  $stm = $this->db->prepare($query);
      	    	  $stm->execute();
			  $array= array( 'Success'=>'true',  'Message'=>'New Project added.');
			  echo $res = json_encode($array);
			 
            }
            catch( Exception $e)
    	       {
    	         die ( $e->getMessage() );
            }
	    }
		
    }
    

    // delete project
    public function deleteProject($id) {
	     $query =" DELETE FROM `projects` WHERE id='$id' ";
	
  	 	try
  	 	  {    
     	    	  $stm = $this->db->prepare($query);
     	    	  $stm->execute();
		  	  $array= array( 'Success'=>'true',  'Message'=>'The  Project have been Delete.');
		       echo $res = json_encode($array);
		 
           }
           catch( Exception $e)
   	       {
   	         die ( $e->getMessage() );
           }

    }
    
    // get perks
    public function getPerks() {
          $sql = "SELECT * FROM perks  " ;
  	 	try
  	 	  {
   	    	     $stmt = $this->db->prepare($sql);
   	    		$stmt->execute();
               $row = $stmt->fetchAll();
  	 	     echo $res = json_encode($row);
          }
          catch( Exception $e)
  	     {
  	         die ( $e->getMessage() );
          }

    }
    
    // save or update perks
    public function savePerk($pTitle, $cost, $delivery, $delivery_date, $description, $cre_date, $projectId) {
         $sql = "INSERT INTO `perks`( `pTitle`, `cost`, `delivery`, `delivery_date`, `description`, `cre_date`, `projectId`) VALUES ('$pTitle', '$cost', '$delivery', '$delivery_date', '$description', '$cre_date', '$projectId') " ;
 	 	try
 	 	  {
  	    	     $stmt = $this->db->prepare($sql);
  	    		$stmt->execute();
              $row = $stmt->fetchAll();
 	 	     echo $res = json_encode($row);
         }
         catch( Exception $e)
 	     {
 	         die ( $e->getMessage() );
         }

    }
    
    // delete perks
    public function deletePerk($id) {
         $sql = "DELETE FROM `perks` WHERE  pid='$id' " ;
 	 	try
 	 	  {
     	    	  $stm = $this->db->prepare($sql);
     	    	  $stm->execute();
		  	  $array= array( 'Success'=>'true',  'Message'=>'The  Perk have been Delete.');
		       echo $res = json_encode($array);
         }
         catch( Exception $e)
 	     {
 	         die ( $e->getMessage() );
         }
   
    }
    

}



// Initialize the database
$connect = new Api($dbo);

/*************************  Please uncomment here to create default ********************
************************** table and load country name into db     **********************/

/*/ PHParray containing list of countries names
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

//Create tables colllumns and insert default data

$connect->createTable_projects();
$connect->createTable_perks();
$connect->createTable_countries();
$connect->insert_countries($countries); */

/************************  Please After delete  ********************
************************** this code above    **********************/

//Get project
if(isset($_GET['project'])){
	echo $connect->get_project();
}

//Get Perk
if(isset($_GET['deleteProject'])){
	$p = $_GET['deleteProject'];
	echo $connect->deleteProject($p);
}


//Get Country name
if(isset($_GET['countries'])){
	echo $connect->get_countries();
}

//Get Cathegory Name
if(isset($_GET['get_cathegorie'])){
	//echo $connect->get_cathegorie();
}


//Get Perk
if(isset($_GET['getperks'])){
	$id = $_GET['getperks'];
	echo $connect->getPerks();
}

//Get Perk
if(isset($_GET['deleteperk'])){
	$id = $_GET['deleteperk'];
	echo $connect->deletePerk($id);
}



//Upload file
if(isset($_FILES['file'])){
    $errors= array();
    $file_name = $_FILES['file']['name'];
    $file_size =$_FILES['file']['size'];
    $file_tmp ="/Applications/XAMPP/xamppfiles/htdocs/";
    $file_type=$_FILES['file']['type'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $extensions = array("jpeg","jpg","png");
    if(in_array($file_ext,$extensions )=== false){
        $errors[]="image extension not allowed, please choose a JPEG or PNG file.";
    }
    if($file_size > 2097152){
        $errors[]='File size cannot exceed 2 MB';
    }
    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"projectpie/".$file_name);
	   
        //echo " uploaded file: " . "images/" . $file_name;
    }else{
        //print_r($errors);
    }
}
else{
    //$errors= array();
    //$errors[]="No image found";
    //print_r($errors);
}



// The request is a JSON request.
// We must read the input.

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if($request){
	$id = '';
	$title = '';
	$short_blurd = '';
	$picture = '';
	$country = '';
	$city = '';
	$cathegories = '';
	
 	$pTitle = '';
 	$Cost = '';
 	$delivery= '';  
 	$deliverydate = ''; 
	$description = '';
 	$cre_date='';
 	$projectId ='';
 
	if(isset($request->title)){
		$id = $request->id;
		$title = $request->title;
		$short_blurd = $request->short_blurd;
		$picture = $request->picture;
		$country = $request->country;
		$city = $request->city;
		$cathegories = $request->cathegories;
	}
		
	
	if(isset($request->ptitle)){
    	 $pTitle = $request->ptitle; 
    	 $Cost = $request->cost; 
    	 $delivery= $request->delivery;  
    	 $deliverydate = $request->deliverydate; 
    	 $description = $request->description;
    	 $cre_date='';
    	 $projectId ='';
	}
	 
	 
	 if( $pTitle ||  $Cost)	{
	 	$connect->savePerk($pTitle, $Cost, $delivery, $deliverydate, $description, $cre_date, $projectId);
	 }
	
		
      
	// save or update project
	if ($title || $short_blurd || $id){
		$response = $connect->save_project( $id, $title, $short_blurd, $picture, $country, $city,  $cathegories);
		echo $response;
		
	}
	
	// save or update Perk
	//if (){
		//$res = 	$connect->savePerks($pTitle, $cost, $delivery, $delivery_date, $description, $cre_date, $projectId);
		//}
}






/* $sql="INSERT INTO `projects` (`id`, `title`, `short_blurd`, `picture`, `location`, `city`, `wproject`, `cat1`, `cat2`, `cat3`, `cre_date`) VALUES ('1', 'Project PIE: People Impacting Everyone', 'Project PIE anpower People Impacting EveryoneLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporveniam. ', 'https://scontent-mad1-1.xx.fbcdn.net/hphotos-xfl1/v/t1.0-9/10294511_961876703902262_1391347360913734571_n.jpg?oh=68fe2445eb387aa1d7fe1552f1d70437&oe=574C80CD', 'Malaysia', 'KL', '0', 'Youth Development', 'Community Development', 'Peace', CURRENT_TIMESTAMP)";*/






?>
