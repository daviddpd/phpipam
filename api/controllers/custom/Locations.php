<?php

/**
 *	phpIPAM API class to work with Addresses
 *
 *
 */
class Locations_controller extends Common_api_functions  {


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
		// init required objects
		$this->init_object ("Subnets", $Database);
		$this->init_object ("Addresses", $Database);
		// set valid keys
		$this->set_valid_keys ("ipaddresses");
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
								array("href"=>"/api/".$this->_params->app_id."/locations/", 	"methods"=>array(array("rel"=>"options", "method"=>"OPTIONS"))),
								array("href"=>"/api/".$this->_params->app_id."/locations/{id}/","methods"=>array(array("rel"=>"read", 	"method"=>"GET"))),
							);
		# result
		return array("code"=>200, "data"=>$result);
	}

	/**
	 * Read address functions
	 *
	 *	identifiers can be:
	 *		- /								             // returns all addresses in all sections
	 *		- /addresses/{id}/
	 *		- /all/							             // returns all addresses in all sections
	 *
	 * @access public
	 * @return void
	 */
	public function GET () {
		// all
		if (!isset($this->_params->id) || $this->_params->id == "all") {
			$result = $this->Tools->fetch_all_objects ("locations");
			if ($result===false)
			{ 
				$this->Response->throw_exception(500, "Unable to read addresses"); 
			}
			else
			{ 
				return array("code"=>200, "data"=>$this->prepare_result($result, "locations", true, true)); 
			}
		} elseif ( isset($this->_params->id) ) {
			$result =  $this->Tools->fetch_object ("locations", "id", $this->_params->id);
			if ($result===false)
			{ 
				$this->Response->throw_exception(500, "Unable to read addresses"); 
			}
			else
			{ 
				return array("code"=>200, "data"=>$this->prepare_result($result, "locations", true, true)); 
			}
		
		}
}

}

?>