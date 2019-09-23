<?php

/**
 *	phpIPAM IP addresses class
 */

class dpdMeta extends Common_functions {

    /**
     * Last insert id
     *
     * (default value: false)
     *
     * @var bool
     * @access public
     */
    public $lastId = false;
    public $obj;
    public $data = array ();
    public $sizeof = -1;
    public $ref = NULL;
    public $refid = NULL;
    

	/**
	 * __construct function
	 *
	 * @access public
	 */
	public function __construct (Database_PDO $Database) {
		parent::__construct();

		# Save database object
		$this->Database = $Database;
		# initialize Result
		$this->Result = new Result ();

		# Log object
		$this->Log = new Logging ($this->Database);
	}

	public function setRef($ref, $refid) {
		$this->ref = $ref;
		$this->refid = $refid;
	}

	public function insert()
	{
		$data['ref'] = $this->ref;
		$data['refid'] = $this->refid;
		$this->Database->insertObject('dpdMeta', $data );
	}



	public function delete($id) 
	{
		 $this->Database->deleteObject('dpdMeta', $id);
	}

	public function inlineUpdate($id, $col, $v) 
	{ 
			 $this->Database->updateObject('dpdMeta', array ( $col => $v, 'id' => $id) );
	}


	public function fetch_all($ref = NULL, $refid = NULL) {
		if ( ! is_null ( $ref ) ) {
			$this->ref = $ref;
		}  else {
			$ref = $this->ref;
		}
		if ( ! is_null ( $refid ) ) {
			$this->refid = $refid;
		} else {
			$refid = $this->refid;
		}		 

		$sql = "select * from dpdMeta where ref = '$ref'";
		$this->obj = $this->Database->getObjectsQuery($sql);
		
		$this->sizeof = count($this->obj);
		foreach ( $this->obj as $o ) 
		{ 
			$id = $o->id;
			$name = $o->name;
			$key = $o->key;
			$value = $o->value;
			$refid = $o->refid;
			
			if ( ! isset ( $this->data[$refid] ) ) { $this->data[$refid] = array();  }
			if ( ! isset ( $this->data[$refid][$name] ) ) { $this->data[$refid][$name] = array();  }
			if ( ! isset ( $this->data[$refid][$name][$key] ) ) { $this->data[$refid][$name][$key] = array();  }			
			$this->data[$refid][$name][$key][] = array ( 'id' => $id, 'value' => $value );
			
		}
	
	}

	public function fetch_mutliple($ref = NULL, $refid = NULL) {
	
		if ( ! is_null ( $ref ) ) {
			$this->ref = $ref;
		}  else {
			$ref = $this->ref;
		}
		if ( ! is_null ( $refid ) ) {
			$this->refid = $refid;
		} else {
			$refid = $this->refid;
		}		 

		$sql = "select * from dpdMeta where ref = '$ref' and refid = $refid";
		$this->obj = $this->Database->getObjectsQuery($sql);
		
		$this->sizeof = count($this->obj);
		foreach ( $this->obj as $o ) 
		{ 
			$id = $o->id;
			$name = $o->name;
			$key = $o->key;
			$value = $o->value;
			
			if ( ! isset ( $this->data[$name] ) ) { $this->data[$name] = array();  }
			if ( ! isset ( $this->data[$name][$key] ) ) { $this->data[$name][$key] = array();  }			
			$this->data[$name][$key][] = array ( 'id' => $id, 'value' => $value );
			
		}
	
	}
	public function json() {
		print json_encode ( $this->data );
	}

	public function refreshView( $format = "table") {
		if ( $format == "table" ) 
		{
			$this->refreshViewTable();
		} else if ( $format == "dl" ) {
			$this->refreshViewDL();		
		}
	
	}

	public function refreshViewDL() {

			print "<div class=\"meta-main\">\n";
    		foreach($this->data as $name=>$key) {
    			$nl=true;
    				foreach ( $key as $k=>$values ) {
    				$kl=true;
    					foreach ( $values as $v ) {
    						if ( $nl ) {
    							$class="metaNL";
//								$nl=false;
    						} else {
    							$class="";
    							$name = "&nbsp;";
    						}
								print "<div class=\"meta-main-row\" >
										<span class=\"meta-span meta-inline meta-inline-name\" id=\"name\" data-type=\"text\" data-pk=\"" . $v['id'] . "\" data-url=\"app/dpdMeta/meta.php?q=1&ref=" . $this->ref . "&refid=" . $this->refid . "\" data-title=\"enter name\" >
											$name
										</span>
									";

    						if ( $kl ) {
//								$kl=false;
    						} else {
    							$k = "&nbsp;";
    						}

   							print "
   								<span class=\"meta-span meta-inline meta-inline-key\" 
   								id=\"key\" data-type=\"text\" data-pk=\"" . $v['id'] . "\" 
   								data-url=\"app/dpdMeta/meta.php?q=1&ref=" . $this->ref . "&refid=" . $this->refid . "\" 
   								data-title=\"enter key\" >$k</span>
	<span class=\"meta-span meta-inline meta-inline-value\" 
									id=\"value\" data-inputclass=\"metaInputValue\" 
									data-type=\"text\" data-pk=\"" . $v['id'] . "\" 
									data-url=\"app/dpdMeta/meta.php?q=1&ref=" . $this->ref . 
									"&refid=" . $this->refid . "\" data-title=\"enter value\" >" . $v['value'] . " </span>
									
									<span class=\"meta-span meta-span-last\"><a class=\"delete_dpdMeta btn btn-default btn-xs\" 
									meta-id=\"" . $v['id'] .  "\" 
									data-container=\"body\" title=\"\" data-original-title=\"Delete Meta Data\">
									<i class=\"fa fa-gray fa-times\"></i>
									</a></span>
									<span>&nbsp;</span>
								</div>\n";
							}
			    		}
		    		}
	       	print "</div>";
	
	}
	
	public function refreshViewTable() {

			print "<table class=\"breset\" >\n";
    		foreach($this->data as $name=>$key) {
    			$nl=true;
    				foreach ( $key as $k=>$values ) {
    				$kl=true;
    					foreach ( $values as $v ) {
    						if ( $nl ) {
    							$class="metaNL";
								$nl=false;
    						} else {
    							$class="";
//    							$name = "&nbsp; &nbsp; &nbsp; &nbsp;";
    						}
								print "<tr id=\"meta-id-" . $v['id'] . "\" class=\"" . $class . "\" >
									<th>
										<span class=\"meta-inline meta-inline-name\" id=\"name\" data-type=\"text\" data-pk=\"" . $v['id'] . "\" data-url=\"app/dpdMeta/meta.php?q=1&ref=" . $this->ref . "&refid=" . $this->refid . "\" data-title=\"enter name\" >
											$name
										</span>
									</th>";

    						if ( $kl ) {
								$kl=false;
    						} else {
  //  							$k = "&nbsp;";
    						}

   							print "<td>
   									<span class=\"meta-inline meta-inline-key\" id=\"key\" data-type=\"text\" data-pk=\"" . $v['id'] . "\" data-url=\"app/dpdMeta/meta.php?q=1&ref=" . $this->ref . "&refid=" . $this->refid . "\" data-title=\"enter key\" >$k</span>
   								</td>";
							print "<td 
									<span class=\"meta-inline meta-inline-value\" id=\"value\" data-inputclass=\"metaInputValue\" data-type=\"text\" data-pk=\"" . $v['id'] . "\" data-url=\"app/dpdMeta/meta.php?q=1&ref=" . $this->ref . "&refid=" . $this->refid . "\" data-title=\"enter value\" >" . $v['value'] . "</span>
								</td>
									<td>
										<span><a class=\"delete_dpdMeta btn btn-default btn-xs\" 
										meta-id=\"" . $v['id'] .  "\" 
										data-container=\"body\" title=\"\" data-original-title=\"Delete Meta Data\">
										<i class=\"fa fa-gray fa-times\"></i>
										</a>
										</span>
									</td>							
							</tr>\n";
							}
			    		}
		    		}
	       	print "</table>";

	}
	
	public function indexView() 
	{

?>
<style> 
	.breset {
	
		width: 50%;
	}
	
	.breset tr {
		vertical-align: middle;
	}
	.breset td.meta-inline-key { 
		width: 25%;
		height: 40px;
	}      			
	.breset td.meta-inline-value { 
		height: 40px;
	}      			

	.breset tr:hover { 
		background-color: #000;
	}

	.breset th { 
		width: 25%;
	}      			
	.metaNL {
		border-top: 1px solid #aaa; 
	
	}
	td.meta-inline-name { 
		height: 45px;
		vertical-align: middle;
		
	}  
	td.meta-inline-key { 
		border-top: 1px solid #dddddd; 
	}
	
	#customMetaData div.meta-main {
		width: 50%;
	}
	#customMetaData div span.meta-span {
		width: 33%;
		display: block;
		border: solid 0px black;
		float: left;
	}
	

	div.editable-input  input.metaInputValue {
		width: 350px;	
	}
	div.popover-content > div > form > div > div:nth-child(1) > div.editable-input > input {
		width: 350px;
	}
	
	.red {
		color: red;
	}
	
	
	
</style>
<tr><td colspan='2'>
<h4 style='padding-top:20px;'>Custom Meta Data
	<button id="add_meta" 
	class="btn btn-xs btn-default btn-success" 
	rel="tooltip" data-container="body" 
	data-placement="top" 
	title="" 
	meta-refid="<?= $this->refid ?>" 
	meta-action="add"  meta-ref="<?= $this->ref ?>"
	data-original-title="Add new meta data">
	<i class="fa fa-sm fa-plus"></i>
	</button></h4>
</tr>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
$.fn.editable.defaults.mode = 'inline'; // popup or inline
$.fn.editable.defaults.onblur = 'submit'; // cancel|submit|ignore


function customMetaInitAdd()
{
	$('#add_meta').on("click", function() {
		var sectionData = {};
		sectionData.pk = $(this).attr('meta-id');
		sectionData.action = 'add';
		$.post('app/dpdMeta/meta.php?ref=<?= $this->ref ?>&refid=<?= $this->refid ?>', sectionData).done(
			function( data ) {
				$( "#customMetaData" ).empty().append( data );
				customMetaInit();
			}
		);		
		return false;
	});
} 

function customMetaDelete() {

	var sectionData = {};
	sectionData.pk = $(this).attr('meta-id');
	sectionData.action = 'delete';
	$.post('app/dpdMeta/meta.php?ref=<?= $this->ref ?>&refid=<?= $this->refid ?>', sectionData).done(
		function( data ) {
			$( "#customMetaData" ).empty().append( data );
			customMetaInit();
		}
	);
	

}

function customMetaInit() 
{
    $('#customMetaData .meta-inline').editable();

	$('#customMetaData .delete_dpdMeta').on("click", function() {	
		var i = $(this).find(".fa-gray");
		console.error (i);
		i.removeClass( "fa-gray" ).addClass( "red" );
		
		$(this).on("click", customMetaDelete);
		return false;
	});
}
$(document).ready(customMetaInit);
$(document).ready(customMetaInitAdd);


</script>
<?php
	       	print "\n<tr><td colspan='2'>
	       	<div id=\"customMetaData\">";
	       		
			$this->refreshView("table");
	       	print "</div></td></tr>";

	}	



}
?>

