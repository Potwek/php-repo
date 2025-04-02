<?php
	/*
	 * Admin-home.php
	 * This is the landing page of the Administrator account
	 *
	 */
?>	 
<?php// include("./templates/header.php");?>	
<?php //include("./templates/sidebar.php");?>	
	<!--<div id="main-container">
		<?php// echo "Welcome Admin!";?>
		<ul>
		<li><a href='#'>Home</a></li>
		<li><a href='#'>Accounts</a></li>
		<li><a href='#'>Operations</a></li>
		<li><a href='./index.php'>Logout</a></li>
		</ul>
	</div> -->
<?php //include("./templates/footer.php");?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>OpenLayers Demo</title>
    <style type="text/css">
      html, body, #basicMap {
          width: 100%;
          height: 100%;
          margin: 0;
      }
    </style>
    <script src="OpenLayers.js"></script>
    <script>
      function init() {
        map = new OpenLayers.Map("basicMap");
        var mapnik         = new OpenLayers.Layer.OSM();
        var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
        var position       = new OpenLayers.LonLat(13.41,52.52).transform( fromProjection, toProjection);
        var zoom           = 15; 
 
        map.addLayer(mapnik);
        map.setCenter(position, zoom );
      }
    </script>
  </head>
  <body onload="init();">
    <div id="basicMap"></div>
  </body>
</html>