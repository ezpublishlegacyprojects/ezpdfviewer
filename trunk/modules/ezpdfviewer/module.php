<?php
//developping a specific  module  
$Module = array( 'name' => 'Ezpdfviewer' ); 
$ViewList = array();
 
// new View list with 2 fixed parameters and 
// 2 parameters in order 
// http://.../modul1/list/ $Params['ParamOne'] /
// $Params['ParamTwo']/ param4/$Params['4Param'] /param3/$Params['3Param'] 
 
$ViewList['view'] = array( 'script' => 'view.php', 
                           'functions' => array( 'read' ), 
                           'unordered_params' => array('attribute_id' => 'attribute_id',
							   'attribute_version' => 'attribute_version' ,
							   'attribute_name' => 'attribute_name' ,
							   'node_id' => 'node_id' )
						   );

$ViewList['create'] = array( 'script' => 'create.php', 
                           'functions' => array( 'read' ), 
                           'unordered_params' => array('attribute_id' => 'attribute_id',
							   'attribute_version' => 'attribute_version' 
							   )
						   );
// The entries in the user rights 
// are used in the View definition, to assign rights to own View functions 
// in the user roles
 
$FunctionList = array(); 
$FunctionList['view'] = array(); 
$FunctionList['create'] = array(); 
?>
