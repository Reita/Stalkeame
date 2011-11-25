<?php
/*
 * Twitpic Gallery
 * Produces a list of Twitpic.com images for a given screenname
 *
 * @author Mike Carter <http://twitter.com/buddaboy>
 */
 
// Change this to grab a Twitter users photos
// Rubular.com for Regex testing
// http://rakaz.nl/2007/01/having-fun-with-geotagged-photos.html

include 'geo.php';
$screenname = $_GET["twitter"];
$screenname = preg_replace('/[^A-Za-z0-9_]/i', '', $screenname);

function get_photos($screenname, $page_num) {
$matches = array();
$matches2 = array();

$page = @file_get_contents ('http://twitpic.com/photos/' . $screenname . '?page=' . $page_num);
preg_match_all('/<a href="\/(\w{2,})"><img /', $page, $matches);

$results = $matches[1];
$counter = count($matches[1]);

while ($counter == 20) {
$page_num++;

$page = @file_get_contents ('http://twitpic.com/photos/' . $screenname . '?page=' . $page_num);
preg_match_all('/<a href="\/(\w{2,})"><img /', $page, $matches); 
$counter = count($matches[1]);
$results = array_merge($results, $matches[1]);
}

return $results;
}

function get_img_url($value) {
$page = @file_get_contents ('http://twitpic.com/' . $value . '/full');
preg_match_all('/src="http:[\'"]?([^\'" >]+)/', $page, $photo_url);
return $photo_url;
}

echo "\t<div id='who'>\n";
if ($screenname != null) {
//echo "\t<h2><a href=''>@". $screenname. "</a></h2>\n";
echo "\t<h2>@". $screenname. "</h2>\n";
echo "\t<ol>\n";
}
else {
echo "\t<h2>I can haz username?</h2>\n";
}

foreach (get_photos($screenname,1) as $value) {
//echo "<li>http://twitpic.com/". $value. "/full</li>";
$url_extract = get_img_url($value);
$photo_url = "http:". $url_extract[1][0];
//echo "<p>Url: ".$photo_url."</p>";

$findme = '.jpg?';
$pos = strpos($photo_url, $findme);

$timeout++;
echo "\t<!-- This is my position: " . $timeout . " -->\n";

if ($timeout == "200") {
break;
}

if ($pos === false) {
//echo "Archivo no es JPG!";
} else {
//echo "Archivo es JPG!";
$coordenadas = getCoordinates($photo_url);
if ($coordenadas == null) {
//echo "<p><strong>Not geotagged</strong></p>";
}
else {
$geotaggedphotos++;
echo "\t<li><a href='http://twitpic.com/". $value ."/'>http://twitpic.com/". $value. "/</a> <em>" . $coordenadas[0] . ", " . $coordenadas[1] . "</em></li>\n";
if ($coordenadas[0] != "0.000000" && $coordenadas[1] != "0.000000") { 
$gmaps_cord .= "\tnew google.maps.LatLng( ". $coordenadas[0] . ", " . $coordenadas[1] ."),\n";
}
}
}
}

$gmaps_cord = substr($gmaps_cord,0,-2);
if ($screenname != null) {
if ($timeout == null || $timeout == "0") {
$userexists = "no";
echo "\t<li id='notfound'>I'm sorry but I couldn't find <strong>any geotagged</strong> photos; are you sure you typed the correct Twitter username?</li>\n";
}
if ($userexists != "no") {
if ($geotaggedphotos == null || $geotaggedphotos == "0") {
echo "\t<li id='notfound'>I'm sorry but I couldn't find <strong>any geotagged</strong> photos for <a href='http://twitter.com/" . $screenname . "/'>" . $screenname . "</a>.</li>\n";
}
}
}

if ($screenname != null) {
echo "\t</ol>\n";
}
echo "\t</div>\n";
//$coordenadas = getCoordinates($filename);
//echo $coordenadas[0];
//echo $coordenadas[1];

//echo "<a href='http://www.google.com/maps?z=16&ll=".$coordenadas[0].",".$coordenadas[1]."&t=k'>Mapa aqui</a>";
echo "\t<div id='map1div'></div>\n";
?>

<script type="text/javascript"> 
var map1;
function map1_initialize( )
{
var latlng = [
<?php echo $gmaps_cord . "\n"; ?>
];
if ( google.maps.BrowserIsCompatible( ) )
{
map1 = new google.maps.Map2( document.getElementById( 'map1div' ) );
map1.addControl( new google.maps.LargeMapControl3D( ) );
map1.addControl( new google.maps.MenuMapTypeControl( ) );
map1.setCenter( new google.maps.LatLng( 0, 0 ), 0 );
for ( var i = 0; i < latlng.length; i++ )
{
var marker = new google.maps.Marker( latlng[ i ] );
map1.addOverlay( marker );
}
var latlngbounds = new google.maps.LatLngBounds( );
for ( var i = 0; i < latlng.length; i++ )
{
latlngbounds.extend( latlng[ i ] );
}
map1.setCenter( latlngbounds.getCenter( ), map1.getBoundsZoomLevel( latlngbounds ) );
}
}
google.setOnLoadCallback( map1_initialize );
</script>