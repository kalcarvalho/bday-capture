<!DOCTYPE>
<html lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
	<link href="css/estilo21.css" media="screen" rel="stylesheet">


	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
			<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
			<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->

	<title>Birthday Capture</title>
</head>

<body class="center clearfix">
	<section class="chamada">
		<br />
		<h3>Clique no botão <span>Fotografar</span> para tirar uma foto e publicar no grupo do aniversário!</h3>
	</section><!-- fim .chamada -->
	<section class="container">
		<div id="webcam"></div>
		<div id="galeria"></div>
		<div id="fotografar">
			<button type="submit" onclick="snap()" class="btn btn-primary">Fotografar</button>
		</div>
		<div id="publicar">
			<button type="submit" onclick="publish()" class="btn btn-primary">Publicar</button>
			<form method="post" enctype="multipart/form-data" action="upload.php" id="formUpload">
				<input type="hidden" name="img_value" id="img_value" value="" />
			</form>
		</div>
		<div id="upload"></div>
	</section><!-- fim .container -->
	<footer>
		<small class="copyright">
		</small><!-- fim .copyright -->
		<small class="desenvolvedor">
		</small><!-- fim .desenvolvedor -->
	</footer><!-- fim footer -->


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<!--<script src="http://code.jquery.com/jquery.js"></script>-->
	<script src="plugins/jquery/jquery-2.1.0.min.js"></script>
	<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="plugins/photobooth/photobooth_min.js"></script>
	<script src="js/script.js"></script>

	<script type="text/javascript">
		// When the document is ready
		$(document).ready(function() {



		});

		function snap() {
			var canvas = document.getElementsByTagName('canvas')[0];
			var context = canvas.getContext('2d');

			// save canvas image as data url (png format by default)
			var dataURL = canvas.toDataURL();

			$("#galeria").show().html('<img id="foto" src="' + dataURL + '" >');
			$("#webcam").hide();
			$("#fotografar").hide();
			$("#publicar").show();
		}

		function publish() {

			value = $("img#foto").attr("src");
			$("#img_value").val(value);

			var f = document.getElementById("formUpload");

			fileUpload(f, "upload.php", "upload");



			/*
        	$.post("upload.php", $("#formUpload").serialize(), 
			function (data) { 
				console.log(data);
			}, "json").fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.responseText);
				console.log(textStatus);
				console.log(errorThrown);
			}); */



			restart();
		}

		function restart() {
			$("#galeria").hide().html();
			$("#webcam").show();
			$("#fotografar").show();
			$("#publicar").hide();
		}
	</script>

	<script language="Javascript">
		function fileUpload(form, action_url, div_id) {

			var iframe = document.createElement("iframe");

			iframe.setAttribute("id", "upload_iframe");
			iframe.setAttribute("name", "upload_iframe");
			iframe.setAttribute("width", "0");
			iframe.setAttribute("height", "0");
			iframe.setAttribute("border", "0");
			iframe.setAttribute("style", "width: 0; height: 0; border: none;");
			form.parentNode.appendChild(iframe);
			window.frames['upload_iframe'].name = "upload_iframe";
			iframeId = document.getElementById("upload_iframe");

			var eventHandler = function() {

				if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
				else iframeId.removeEventListener("load", eventHandler, false);

				if (iframeId.contentDocument) {
					content = iframeId.contentDocument.body.innerHTML;
				} else if (iframeId.contentWindow) {
					content = iframeId.contentWindow.document.body.innerHTML;
				} else if (iframeId.document) {
					content = iframeId.document.body.innerHTML;
				}

				document.getElementById(div_id).innerHTML = content;
				setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
			}
			if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
			if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);
			form.setAttribute("target", "upload_iframe");
			form.setAttribute("action", action_url);
			form.setAttribute("method", "post");
			form.setAttribute("enctype", "multipart/form-data");
			form.setAttribute("encoding", "multipart/form-data");
			form.submit();
			document.getElementById(div_id).innerHTML = "Uploading...";
		}
	</script>





</body>

</html>