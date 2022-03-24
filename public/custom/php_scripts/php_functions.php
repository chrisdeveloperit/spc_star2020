<?php


/*Set the session variable, then return to the calling pg*/
function setSelectedSessionVariable($goToUrl, $varName, $thisVar){
	$_SESSION["{$varName}"] = $thisVar;
	
	//print("<script>page_direct('" . $goToUrl. "', '" . $thisVar . "')</script");

}
?>