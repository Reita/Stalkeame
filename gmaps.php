<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>
    Untitled Page
</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAANgu3GlobW5KtQorgXrnJ_xTHM4EYhrvsce8mdg4KdiCoPfCQKxSOZ_5sjy4O31twg6cxfZqam24TCw"
      type="text/javascript"></script>

    <script type="text/javascript">

     function load() {

    var map = new GMap2(document.getElementById("map"));


    var marker = new GMarker(new GLatLng(32.523251,35.816068));
    var marker2 = new GMarker(new GLatLng(31.977211,35.951729));
    var html="maen<br/>" +
         " maen tamemi";
    var html2="<img src='simplemap_logo.jpg' width='20' height='20'/> " +
         "maen<br/>" +
         " maen tamemi" + "Alper";
    map.setCenter(new GLatLng(32.523251,35.816068), 5);
    map.setMapType(G_HYBRID_MAP);
    map.addOverlay(marker);
    map.addOverlay(marker2);
    map.addControl(new GLargeMapControl());
    map.addControl(new GScaleControl());
    map.addControl(new GMapTypeControl());



    marker2.openInfoWindowHtml(html2);
    marker.openInfoWindowHtml(html);
    }

    //]]>
    </script>

    <script type="text/javascript">

      function pageLoad() {
      }

    </script>

</head>
<body onload = "load()">
    <form name="form1" method="post" action="Xhome.aspx" id="form1">
<div>
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUJNDI5NDcxNTY4ZGTjxbb38769ZB2N9Ow9kAzPz2PIqA==" />
</div>

    <div id="map" style="width:400px;height:300px" >

    </div>
    </form>
</body>
</html>