<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$custompage = NULL; // Initialize page object first

class ccustompage {

	// Page ID
	var $PageID = 'custompage';

	// Project ID
	var $ProjectID = "{CA10B90D-3931-4AF0-B685-152BAA02AD32}";

	// Page object name
	var $PageObjName = 'custompage';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			$html .= "<p class=\"ewMessage\">" . $sMessage . "</p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewWarningIcon\"></td><td class=\"ewWarningMessage\">" . $sWarningMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewSuccessIcon\"></td><td class=\"ewSuccessMessage\">" . $sSuccessMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewErrorIcon\"></td><td class=\"ewErrorMessage\">" . $sErrorMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}		
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// User table object (users)
		if (!isset($GLOBALS["users"])) $GLOBALS["users"] = new cusers;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'custompage', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();

		// Uncomment codes below for security

		
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn())
			$this->Page_Terminate("login.php");
		

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		}
		$gsExport = $this->Export; // Get export parameter, used in header

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;

		//$this->setSuccessMessage("Welcome " . CurrentUserName());
		//$this->setSuccessMessage("Welcome " . CurrentUserID());
		// Put your custom codes here

	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($custompage)) $custompage = new ccustompage();

// Page init
$custompage->Page_Init();

// Page main
$custompage->Page_Main();
?>
<?php include_once "dashboardheader.php" ?>
<?php
$custompage->ShowMessage();
?>
<!-- Put your custom html here -->
<?php
	//Get the data from the tables
	$user_id = CurrentUserID();
	$org_id = ew_ExecuteScalar("SELECT org_id FROM users where user_id = " . CurrentUserID()); 
	if ($org_id > 0) {
	//We have a valid org id
	} else {
	$user_id = 8;
	$org_id = ew_ExecuteScalar("SELECT org_id FROM users where user_id = " . CurrentUserID()); 
	}
	$dbh = null;  //Disconnect
		
	$dbh = new PDO("mysql:host=".EW_CONN_HOST.";dbname=".EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS);
	$sql = "SELECT 
				a.org_name,
				b.building_name, b.id as building_id,
				c.id as floorplan_id,
				e.make, e.model,
				d.budgeted_blk, d.budgeted_color,
				g.black_meter as actual_blk, g.color_meter as actual_color
			FROM users u
			LEFT OUTER JOIN `organization` a  on a.id = u.org_id
			LEFT OUTER JOIN `buildings` b ON a.id = b.org_id
			LEFT OUTER JOIN `floorplans` c ON b.id = c.building_id
			LEFT OUTER JOIN `floorplan_machines` d ON c.id = d.floorplan_id
			LEFT OUTER JOIN `machines` e ON d.model_id = e.id
			LEFT OUTER JOIN `machine_types` f ON e.type_id = f.id
			LEFT OUTER JOIN `meter` g ON d.id = g.machine_id AND g.date_timestamp = (SELECT max( i.date_timestamp )FROM meter i WHERE i.machine_id = d.id )
			LEFT OUTER JOIN `machine_status` h ON d.id = h.machine_id AND h.date_timestamp = (select max(j.date_timestamp) from machine_status j where j.machine_id = d.id)
			where u.user_id = :user_id";
	$sqlprep = $dbh->prepare($sql);        // Prepares and stores the SQL statement in $sqlprep
	// Set the array value that will be used in the SQL statement.
	$ar_val = array('user_id'=>$user_id);
	$alternateRow = 'Off';
	$firstPass = "yes";
	$ary_count = 0;
	if($sqlprep->execute($ar_val)) 
	{
		while($row = $sqlprep->fetch()) 
		{
			if ($firstPass == 'yes') {
				$building_name = $row['building_name'];
				$firstPass = 'no';
			}
			if ($building_name <> $row['building_name']) {
				$building_name = $row['building_name'];
				$ary_count += 1;
			}

			$total_building_array[$ary_count] = $row['building_name'];
			$total_building_ID_array[$ary_count] = $row['building_id'];
			$total_budgeted_blk_array[$ary_count]   +=  $row['budgeted_blk'];
			$total_budgeted_color_array[$ary_count] +=  $row['budgeted_color'];
			$total_actual_blk_array[$ary_count]     +=  $row['actual_blk'];
			$total_actual_color_array[$ary_count]   +=  $row['actual_color'];
				
			$org_name = $row['org_name'];
			$building_array[] = $row['building_name'];
			$make_array[] = $row['make'];
			$model_array[] = $row['model'];
			$budgeted_blk_array[] = $row['budgeted_blk'];
			$budgeted_color_array[] = $row['budgeted_color'];
			$actual_blk_array[] = $row['actual_blk'];
			$actual_color_array[] = $row['actual_color'];
		}
	}
	$dbh = null;  //Disconnect
?>
<?php 
// Compute the percentage of days passed for the current fiscal year
$today = getdate();
$currentYear = $today['year'];
//Get the fiscal starting date (7/1/yyyy)
if ($today['mon'] <= 6) {
	$tempDate = '07/01/'.($currentYear-1);
	$startingDate = new DateTime($tempDate);
} else {
	$tempDate = '07/01/'.($currentYear);
	$startingDate = new DateTime($tempDate);
}
//Get the fiscal ending date (6/30/yyyy)
$endingDate = new DateTime($tempDate);
$endingDate->add(new DateInterval('P1Y'));
$endingDate->sub(new DateInterval('P1D'));

//Get the difference in days using SQL
$startDate= date_format($startingDate,'Y-m-d');
$endDate= date_format($endingDate,'Y-m-d');
$sql = "select datediff('".$endDate."','".$startDate."')";
$fiscalDays = ew_ExecuteScalar($sql); 
$fiscalDays +=1;
$todayDateTime = new DateTime();
$currDate= date_format($todayDateTime,'Y-m-d');
$sql = "select datediff('".$currDate."','".$startDate."')";
$diffDays = ew_ExecuteScalar($sql); 
$diffDays += 1;
$diffPercent = $diffDays / $fiscalDays;
//Compute projected amounts
$projected_black = round(array_sum($actual_blk_array)/$diffPercent);
$projected_color = round(array_sum($actual_color_array)/$diffPercent);
?>

<div class="gridHeading">
<?php echo $org_name; ?>
</div>
<div class="gridWrapper">
<div class="divSummary">
<table class="summaryTableBlack">
	<tr>
		<td colspan="2">Overall Black</td>
	</tr>
	<tr>
	<?php
		echo '<td>Budgeted: </td>';
		echo '<td>'.number_format(array_sum($budgeted_blk_array)).'</td>';	
	echo '</tr><tr>';
		echo '<td>Consumed: </td>';
		echo '<td>'.number_format(array_sum($actual_blk_array)).'</td>';
	echo '</tr><tr>';
		echo '<td>Projected: </td>';
		if ($projected_black > array_sum($budgeted_blk_array)) {
			$spanClass = ' class="overbudget"';
		} else {
			$spanClass = '';
		}
		echo '<td><span'.$spanClass.'>'.number_format($projected_black).'</span></td>';
?>
	</tr>
</table>
<table class="summaryTableColor">
	<tr>	
		<td colspan="2">Overall Color</td>
	</tr>
	<tr>
<?php
		echo '<td>Budgeted: </td>';
		echo '<td>'.number_format(array_sum($budgeted_color_array)).'</td>';
	echo '</tr><tr>';
		echo '<td>Consumed: </td>';
		echo '<td>'.number_format(array_sum($actual_color_array)).'</td>';
	echo '</tr><tr>';
		echo '<td>Projected: </td>';
		if ($projected_color > array_sum($budgeted_color_array)) {
			$spanClass = ' class="overbudget"';
		} else {
			$spanClass = '';
		}
		echo '<td><span'.$spanClass.'>'.number_format($projected_color).'</span></td>';
	?>
	</tr>
</table>
</div>
<div class="divDetail">
<div class="buildingTitleDiv">
	<table class="buildingTitleTable">
		<tr>
			<td></td><td>Budgeted Black</td><td>Consumed Black</td><td>Projected Black</td><td>Budgeted Color</td><td>Consumed Color</td><td>Projected Color</td><td>Go to live floorplan</td>
		</tr>
	</table>
</div>
<?php
$X=0;
$Y=0;
foreach ($total_building_array as $_total_building) {
	echo '<div class="msg_head">';
	echo '<table class="buildingHeadingTable">';
	$projected_black = round($total_actual_blk_array[$X]/$diffPercent);
	$projected_color = round($total_actual_color_array[$X]/$diffPercent);
	echo "<tr>";
		echo '<td>'.$_total_building.'</td>';
		echo '<td>'.number_format($total_budgeted_blk_array[$X]).'</td>';
		echo '<td>'.number_format($total_actual_blk_array[$X]).'</td>';
		if ($projected_black > $total_budgeted_blk_array[$X]) {
			$spanClass = ' class="overbudget"';
		} else {
			$spanClass = '';
		}
		echo '<td><span'.$spanClass.'>'.number_format($projected_black).'</span></td>';
		echo '<td>'.number_format($total_budgeted_color_array[$X]).'</td>';
		echo '<td>'.number_format($total_actual_color_array[$X]).'</td>';
		if ($projected_color > $total_budgeted_color_array[$X]) {
			$spanClass = ' class="overbudget"';
		} else {
			$spanClass = '';
		}
		echo '<td><span'.$spanClass.'>'.number_format($projected_color).'</span></td>';
		echo '<td><a href="fp_page.php?page=proposed&bi='.$total_building_ID_array[$X].'">Floorplan</a></td>'; 
		$X += 1;
	echo '</tr>';
	echo '</table>';
	echo '</div>';
?>
	<div class="msg_body">
	<table class="buildingDetailTable">
	<?php
	
	foreach ($building_array as $_building) {
		//echo $_building."::".$_total_building;
		if ($_building == $_total_building) {
			//If there isn't a printer on this floor then skip the record.
			if ($make_array[$Y] == '') {
				$Y += 1;
				continue;
			}
			$projected_black = round($actual_blk_array[$Y]/$diffPercent);
			$projected_color = round($actual_color_array[$Y]/$diffPercent);
			echo "<tr>";
				echo '<td>'.$make_array[$Y].' - '.$model_array[$Y].'</td>';
				echo '<td>'.number_format($budgeted_blk_array[$Y]).'</td>';
				echo '<td>'.number_format($actual_blk_array[$Y]).'</td>';
				if ($projected_black > $budgeted_blk_array[$Y]) {
					$spanClass = ' class="overbudget"';
				} else {
					$spanClass = '';
				}
				echo '<td><span'.$spanClass.'>'.number_format($projected_black).'</span></td>';
				echo '<td>'.number_format($budgeted_color_array[$Y]).'</td>';
				echo '<td>'.number_format($actual_color_array[$Y]).'</td>';
				if ($projected_color > $budgeted_color_array[$Y]) {
					$spanClass = ' class="overbudget"';
				} else {
					$spanClass = '';
				}
				echo '<td><span'.$spanClass.'>'.number_format($projected_color).'</span></td>';
				$Y += 1;
			echo '</tr>';
		}
	}
	?>
	</table>
	</div>	
<?php
}
?>

</div>
</div>		
<div class="gridFooting">
</div>

<?php include_once "footer.php" ?>
					  
<?php
$custompage->Page_Terminate();
?>
