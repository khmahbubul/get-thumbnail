<!DOCTYPE html>
<html>
<head>
	<title>Get thumbnail</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<p>Insert URL</p>
	<input type="url" id="url_field">
	<input type="button" id="get_data" value="get">
	<br><br><br>

	<div id="thumbnail">
		<img src="image-not-found.gif" alt="">
		<h1>Site title</h1>
		<p>Wesite description</p>
	</div>

	<script>
		$(document).on("click", "#get_data", function(){
			var turl = $("#url_field").val();

			$.post("http://localhost/testing/get_url_data.php", {url: turl}, function(data, status){
				if(status == "success") {
					var obj = JSON.parse(data);
					$("#thumbnail").html('<img src="'+obj.image+'" alt=""><h1>'+obj.title+'</h1><p>'+obj.description+'</p>');
				}
		    });
		});
	</script>
</body>
</html>