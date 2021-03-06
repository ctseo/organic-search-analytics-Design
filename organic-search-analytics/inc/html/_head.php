<?php
if( !strpos( $_SERVER['SCRIPT_NAME'], "upgrade.php" ) ) {
	include_once realpath(dirname(__FILE__).'/../code/globalIncludes.php'); /* Load classes */
	$GLOBALS['scriptName'] = str_replace( "/".$GLOBALS['appInstallDir'], "", $_SERVER['SCRIPT_NAME'] );
}
?>

<html>
	<head>
		<title><?php echo $titleTag; ?></title>

		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/custom.css">
		<link href='https://fonts.googleapis.com/css?family=Roboto:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Lemon' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/lib/jquery/jquery-ui-1.11.2.css">

		<script language="javascript" type="text/javascript" src="js/lib/jquery/jquery-1.11.3.min.js"></script>
		<script src="js/lib/jquery/jquery-ui-1.11.2.js"></script>
		<script type="text/javascript" src="js/script.js"></script>

		<?php if( isset( $GLOBALS['scriptName'] ) && $GLOBALS['scriptName'] == "report-custom.php" ) { ?>
			<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/lib/jqplot/excanvas.js"></script><![endif]-->
			<script language="javascript" type="text/javascript" src="js/lib/jqplot/jquery.jqplot.min.js"></script>
			<script language="javascript" type="text/javascript" src="js/lib/jqplot/plugins/jqplot.cursor.min.js"></script>
			<script language="javascript" type="text/javascript" src="js/lib/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
			<script language="javascript" type="text/javascript" src="js/lib/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
			<script language="javascript" type="text/javascript" src="js/lib/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
			<script language="javascript" type="text/javascript" src="js/lib/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
			<script language="javascript" type="text/javascript" src="js/lib/jqplot/plugins/jqplot.highlighter.min.js"></script>
			<link rel="stylesheet" type="text/css" href="css/lib/jqplot/jquery.jqplot.css" />
			
		<?php } ?>

		<?php if( isset( $GLOBALS['scriptName'] ) && $GLOBALS['scriptName'] == "settings.php" ) { ?>
			<script type="text/javascript" src="js/settings.js"></script>
		<?php } ?>
	</head>

	<body>
		<header>
			<div id="menu">
				<div class="logo"><a href="index.php">Organic Search Analytics</a></div>
				<div class="primary">
				<a href="index.php">Home</a>
				<a href="data-capture.php">Data Capture</a>
				<a href="settings.php">Settings</a>
				<a href="report.php">Reports</a>
				</div>
			</div>
			<div class="floatright">
				<span class="donate">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="P5WHT23LSGLE4">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
				</span>
			</div>
			<div class="clear"></div>
		</header>

		<div id="siteContent">
