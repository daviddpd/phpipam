<?php

/**
 *	phpIPAM API class to work with Addresses
 *
 *
 */
 
require_once( dirname(__FILE__) . '/../../functions/classes/class.dpdMeta.php' );		// functions and objects from phpipam

class Meta_controller extends Common_api_functions  {


	/**
	 * Input parameters
	 *
	 * @var mixed
	 * @access public
	 */
	public $_params;

	/**
	 * Custom address fields
	 *
	 * @var mixed
	 * @access public
	 */
	public $custom_fields;

	/**
	 * Database object
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $Database;

	/**
	 * Sections object
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $Sections;

	/**
	 * Response handler
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $Response;

	/**
	 * Tools object from master Tools class
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $Tools;


	/**
	 * dpdMeta object 
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $meta;


	/**
	 * Subnets object from master Subnets class
	 *
	 * @var mixed
	 * @access protected
	 */
	public $Subnets;

	/**
	 * Addresses object from master Addresses class
	 *
	 * @var mixed
	 * @access public
	 */
	public $Addresses;

	/**
	 * Admin class form master Admin class
	 *
	 * @var mixed
	 * @access public
	 */
	public $Admin;

	/**
	 * Saves details of currnt subnet
	 *
	 * @var mixed
	 * @access private
	 */
	private $subnet_details;

	/**
	 * Old address values
	 *
	 * @var mixed
	 * @access private
	 */
	private $old_address;


	/**
	 * __construct function
	 *
	 * @access public
	 * @param class $Database
	 * @param class $Tools
	 * @param mixed $params		// post/get values
	 */
	public function __construct($Database, $Tools, $params, $Response) {
		$this->Database = $Database;
		$this->Tools 	= $Tools;
		$this->_params 	= $params;
		$this->Response = $Response;
		$this->meta = new dpdMeta($Database);
		
		// error_log ( "[meta controler] construct\n");
		
	}





	/**
	 * Returns json encoded options
	 *
	 * @access public
	 * @return void
	 */
	public function OPTIONS () {
		// validate
		$this->validate_options_request ();

		// methods
		$result = array();
		$result['methods'] = array(
								array("href"=>"/api/".$this->_params->app_id."/meta/", 	"methods"=>array(array("rel"=>"options", "method"=>"OPTIONS"))),
								array("href"=>"/api/".$this->_params->app_id."/meta/{id}/","methods"=>array(array("rel"=>"read", 	"method"=>"GET"),
//																												 array("rel"=>"create", "method"=>"POST"),
//																												 array("rel"=>"update", "method"=>"PATCH"),
//																												 array("rel"=>"delete", "method"=>"DELETE")
							)));
		# result
		return array("code"=>200, "data"=>$result);
	}



	/**
	 * Read address functions
	 *
	 *	identifiers can be:
	 *		- /								             // returns all addresses in all sections
	 *		- /all/							             // returns all addresses in all sections
	 *
	 * @access public
	 * @return void
	 */
	public function GET () {
		// all
		if (!isset($this->_params->id) || $this->_params->id == "all") {
			// fetch all
			$this->meta->fetch_all("ipaddresses", 0);
			$result = $this->meta->data;
			// error_log ( "[meta.php api]" . print_r ( $result, 1 ) );
			// check result
			if ($result===false)						{ $this->Response->throw_exception(500, "Unable to read meta data"); }
			else										{ return array("code"=>200, "data"=>$result); }
		}
	}

}