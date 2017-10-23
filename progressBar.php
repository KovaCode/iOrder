<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<title>jsProgressBarHandler AJAX Demo | Javascript Progress/Percentage Bar</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<!-- jsProgressBarHandler prerequisites : prototype.js -->
		<script type="text/javascript" src="js/prototype/prototype.js"></script>

	<!-- jsProgressBarHandler core -->
		<script type="text/javascript" src="js/bramus/jsProgressBarHandler.js"></script>

	<!-- main script : AJAX Demo -->
	<script type="text/javascript">
		// <![CDATA[

			if (!JS_BRAMUS) { var JS_BRAMUS = new Object(); }

			JS_BRAMUS.jsProgressBarAjaxHandler = Class.create();

			JS_BRAMUS.jsProgressBarAjaxHandler.prototype = {

				activeRequestCount			: 0,
				totalRequestCount			: 0,

				initialize					: function() {

					// Register Ajax Responders
						Ajax.Responders.register({
							onCreate: function() {
								this.activeRequestCount++;
								this.totalRequestCount++;
							}.bind(this),
							onComplete: function() {
								this.activeRequestCount--;
								myJsProgressBarHandler.setPercentage(
									'progress',
									parseInt((this.totalRequestCount - this.activeRequestCount) / this.totalRequestCount * 100)
								);
								if (this.activeRequestCount == 0) { alert("All Done!"); }
							}.bind(this)
						});

					// Perform some Ajax Calls
						new Ajax.Updater('box1', 'ajaxprogressbar.php', {
							parameters: { text: "call1", sleep: 1 }
						});

						new Ajax.Updater('box2', 'ajaxprogressbar.php', {
						  parameters: { text: "call2", sleep: 2 }
						});

						new Ajax.Updater('box3', 'ajaxprogressbar.php', {
						  parameters: { text: "call3", sleep: 3 }
						});

						new Ajax.Updater('box4', 'ajaxprogressbar.php', {
						  parameters: { text: "call4", sleep: 4 }
						});

						new Ajax.Updater('box5', 'ajaxprogressbar.php', {
						  parameters: { text: "call5", sleep: 5 }
						});

				}
			}

			function initProgressBarAjaxHandler() { myJsProgressBarAjaxHandler = new JS_BRAMUS.jsProgressBarAjaxHandler(); }
			Event.observe(window, 'load', initProgressBarAjaxHandler, false);

		// ]]>
	</script>

	<style type="text/css">

		/* General Links */
		a:link { text-decoration : none; color : #3366cc; border: 0px;}
		a:active { text-decoration : underline; color : #3366cc; border: 0px;}
		a:visited { text-decoration : none; color : #3366cc; border: 0px;}
		a:hover { text-decoration : underline; color : #ff5a00; border: 0px;}
		img { padding: 0px; margin: 0px; border: none;}

		body {
			margin : 0 auto;
			width:100%;
			font-family: 'Verdana';
			color: #40454b;
			font-size: 12px;
			text-align:center;
		}

		body h1 {
			font-size:14px;
			font-weight:bold;
			color:#CC0000;
			padding:5px;
			margin-left:10px;
			border-bottom:solid;
			border-bottom-width:1px;
			border-bottom-color:#333333;
		}

		#demo {
			margin : 0 auto;
			width:100%;
			margin:20px;
		}

		.code {
			font-family: "Courier New", Courier, monospace;
			font-size: 10px;
		}

	</style>

</head>

<body>

	<div style="width:600px; margin : 0 auto; text-align:left;" >

		<p style="background: #ffff99; text-align: center; color: #000; border: 1px solid #ff9900; padding: 5px; font-size: 12px; font-weight: bold;">Looking for the <a href="http://www.bram.us/demo/projects/jsprogressbarhandler/" title="">original demo</a>?</p>

		<h1>jsProgressBarHandler AJAX Demo | Javascript Progress/Percentage Bar</h1>

		<div id="demo">

			<p><span style="color:#006600;font-weight:bold;">Making 5 Ajax Calls...</span></p>

			<p><span class="progressBar percentImage1" id="progress">0%</span></p>

			<p><span style="color:#006600;font-weight:bold;">DEBUG:</span></p>

			<div class="code">
				<p id="box1">Making call1...</p>
				<p id="box2">Making call2...</p>
				<p id="box3">Making call3...</p>
				<p id="box4">Making call4...</p>
				<p id="box5">Making call5...</p>
			</div>

		</div>

		<p style="background: #ffff99; text-align: center; color: #000; border: 1px solid #ff9900; padding: 5px; font-size: 12px; font-weight: bold;">This page is a testpage of jsProgressBarHandler - see <a href="http://www.bram.us/projects/js_bramus/jsprogressbarhandler/" title="jsProgressBarHandler | Javascript Progress/Percentage Bar">http://www.bram.us/projects/js_bramus/jsprogressbarhandler/</a> for details</p>

	</div>

	<!-- STATS -->
	<script src="/mint/?js" type="text/javascript"></script>

	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
	<script type="text/javascript">
		// <![CDATA[
		_uacct = "UA-107008-4";
		urchinTracker();
		// ]]>
	</script>

</body>
</html>
