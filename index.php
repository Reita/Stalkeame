<?php 
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $starttime = $mtime; 
;?>
<!DOCTYPE html>

<html lang="en" class="no-js">

<head class="html5reset-kitchensink-clean">

  <meta charset="utf-8" />
	
  <!--[if IE]><![endif]-->
	
  <title>Stalkeame.com<?php if($_GET["twitter"]!= null) { echo " | " . $_GET["twitter"];} ?></title>
	
  <meta name="description" content="Stalkeame scans the pictures Twitter users upload to TwitPic, analyzes each picture's EXIF data and displays the location where each photo was taken on a nifty little map, all for your stalking pleasure. No data is saved during this scan which is why Stalkeame may take a few minutes to load. Please be patient (and please don't use it to actually stalk anyone!)." />
	
  <meta name="author" content="Ale Tello" />
  <meta name="copyright" content="Copyright Treebit 2010. All Rights Reserved." />

  <meta name="DC.title" content="Stalkeame" />
  <meta name="DC.subject" content="Stalkeame scans the pictures Twitter users upload to TwitPic, analyzes each picture's EXIF data and displays the location where each photo was taken on a nifty little map, all for your stalking pleasure. No data is saved during this scan which is why Stalkeame may take a few minutes to load. Please be patient (and please don't use it to actually stalk anyone!)." />
  <meta name="DC.creator" content="Ale Tello" />
	
  <meta name="google-site-verification" content="4EC-WD48s2ButFfCajqJzYxroDh6z_BJBD83vTKfIEQ" />
	
  <link rel="shortcut icon" href="http://stalkeame.com/_/img/favicon.png"/>
	
  <link rel="apple-touch-icon" href="http://stalkeame.com/_/img/custom_icon.png"/>
	
  <!--
  <meta name="viewport" content="width=device-width, user-scalable=no" />
  -->

  <link rel="stylesheet" href="http://stalkeame.com/_/css/main.css" />

  <!--[if IE 7]>
  <link rel="stylesheet" href="http://stalkeame.com/_/css/patches/win-ie7.css" />
  <![endif]-->

  <!--[if lt IE 7]>
  <script type="text/javascript"> 
  /*Load jQuery if not already loaded*/ if(typeof jQuery == 'undefined'){ document.write("<script type=\"text/javascript\"   src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js\"></"+"script>"); var __noconflict = true; } 
  var IE6UPDATE_OPTIONS = { icons_path: "http://stalkeame.com/_/img/" }
  </script>
  <script type="text/javascript" src="http://stalkeame.com/_/js/ie6update.js"></script>
  <link rel="stylesheet" href="http://stalkeame.com/_/css/patches/win-ie-old.css" />
  <![endif]-->

  <!--[if lt IE 8]>
  <script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE8.js"></script>
  <![endif]-->
	
  <script src="http://stalkeame.com/_/js/modernizr-1.6.min.js"></script>
	
  <!-- Grab Google CDN's jQuery. fall back to local if necessary	-->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.4.2.js"%3E%3C/script%3E'))</script>

  <!-- Google API	--> 
  <script src="https://www.google.com/jsapi?key=ABQIAAAAJ9D2w25tBuBthznr7aAzQhQUemqOmbROGShQ12A0rJJ4SUd84xShJNYSfyPZZwgQsubO96LkG_tceQ" type="text/javascript"></script> 
  <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAJ9D2w25tBuBthznr7aAzQhQUemqOmbROGShQ12A0rJJ4SUd84xShJNYSfyPZZwgQsubO96LkG_tceQ&sensor=false" type="text/javascript"></script> 

  <!-- jQuery Browser History	--> 
  <script src="http://stalkeame.com/_/js/jquery.history.js"></script>

  <!-- Google Analytics	--> 
  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1271844-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  </script>

  <!-- Clear Form	-->
  <script type="text/javascript">
  function Focused(element) {
     if (element.value == element.defaultValue) {
       element.value = '';
     }
   }
   function NotFocused(element) {
     if (element.value == '') {
       element.value = element.defaultValue;
     }
   }
  </script>

  <!-- Twitter @Anywhere	-->
  <script src="http://platform.twitter.com/anywhere.js?id=EgSW2Umcfcbd78UFzILl5A&amp;v=1"></script>
  
  <!-- jQuery Loader	-->
  <script type="text/javascript">
  $(document).ready(function () {
  
    var hash = window.location;
    hash = "" + hash;
    hash = hash.match(/#(\w{2,})/);

    if (hash != null) {
      $(pageload);
    }
    
    $('input[id=submit]').click(function () {
      var hash = window.location;
      hash = "" + hash;
      hash = hash.match(/#(\w{2,})/);
      hash = hash[1];

      $('#reload').hide();
      $('.loading').show();

      getPage();
      return false;
    });	
  });
	
  function pageload(hash) {
    if (hash) {
    $('#reload').hide();
    $('.loading').show();
    getPage();
    hash = null;
    }
  }
		
  function getPage() {
    var data = 'twitter=' + encodeURIComponent(document.location.hash);
    hash = null;
    $.ajax({
      url: "loader.php",	
      type: "GET",		
      data: data,		
      cache: false,
      success: function (html) {	
        $('.loading').hide();				
        $('#details').html(html);
        $('#reload').fadeIn('slow');
        map1_initialize();
        GUnload();
        //twttr.anywhere(function(twitter) {
        //twitter.hovercards();
        //});
      }
    });
  }
  </script>

  <!-- Styles needed for the loader	-->
  <style>
  .loading {
    padding: 10px;
    background: url("http://stalkeame.com/_/img/load.gif") no-repeat center 40px;
    height:48px;
    display:none;
  }

  .loading:after {
    content: "Please be patient while I gather all the data; this can take up to 5 minutes.";
    text-align: center;
    display: block;
    color: #0970a3;
    font-size: 16px;
    font-weight: bold;
  }
  </style>
</head>

<body>
<div id="stalkeame">
  <header>
  <h1><a href="/">Stalkeame</a></h1>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" autocomplete="on" onsubmit="return false">
    <input type="text" id="twitter_name" name="twitter" onfocus="Focused(this);" onblur="NotFocused(this);" value="<?php echo $_GET["twitter"]; if ($_GET["twitter"] == null) {echo "I need a Twitter username...";}?>" />
    <input type="submit" id="submit" onClick="window.location.href='http://stalkeame.com/#'+ twitter_name.value" />
  </form>
  </header>

  <div id="content">
    <div class="loading"></div>
    <div id="reload">
    <div id="details">
    <!-- Auto Generated Code Starts Here -->

    <!-- Auto Generated Code Ends Here -->
    </div>
    </div>
  
    <div id="what">
    <h2>What is Stalkeame?</h2>
    <p>Stalkeame scans the pictures Twitter users upload to TwitPic, analyzes each picture&apos;s EXIF data and displays the location where each photo was taken on a nifty little map, all for your stalking pleasure. No data is saved during this scan which is why Stalkeame may take a few minutes to load. Please be <em>patient</em> (and please don&apos;t use it to actually stalk anyone!).</p>
    </div>

    <div id="social">
    <p id="twitter"><a href="http://twitter.com/Reita" title="Reita's Twitter Profile"><span>Twitter</span></a></p>
    <p id="facebook"><a href="#"><span>Facebook</span></a></p>  
    </div>
  </div>
</div>

<div id="disclaimer">
  <h2>Disclaimer</h2>
  <p>All mapped geotagged coordinates have been extracted from <strong>public TwitPic</strong> photographs. If you are concerned for your privacy, you can choose either to delete them or re-submit them without the geotag information. I believe TwitPic has an option to remove geotag data but I’m not sure.</p>
  <p>At <em>no point</em> is this data saved: it is processed only as the script finds it. I might choose to start caching or saving the data in order to speed up the scanning process but first I must investigate whether there are any legal issues regarding the manipulation of said data.</p>
  <p>For performance reasons I have limited each search to the <strong>200 most recent photographs</strong> on TwitPic; otherwise the script might take very long when it comes to “<em>photo happy</em>” users.</p>
  <p>At the present time this service is limited to TwitPic photographs. I might think about expanding it depending on how similar services (yfrog, Plixi, etc.) work.</p>
</div>

<div id="credits">
  <h2>Credits</h2>
  <ul>
  <li>Thanks to <a href="http://twitter.com/buddaboy" title="Buddaboy">Mike Carter</a> for giving me the idea on how to scan users' Twitpic pictures.</li>
  <li>Thanks to <a href="http://rakaz.nl/" title="Rakaz">Rakaz</a> for creating a <a href="http://rakaz.nl/2007/01/having-fun-with-geotagged-photos.html" title="Having fun with geotagged photos">great script</a> to translate EXIF Geotag data into Coordinates.</li>
  <li>Thanks to the good folks at <a href="http://rubular.com/" title="Rubular">Rubular</a> where I tested every regex I created in order to make this thing work.</li>
  <li>Thanks to <a href="http://twitter.com/sexypekk">Gregory</a> for helping me with those hard to get regular expressions.</li>
  <li>Thanks to <a href="http://www.profimagazin.cz/" title="Lenka Melcakova">Lenka Melcakova</a> for creating the Facebook and Twitter icons I'm using.</li>
  <li>Thanks to <a href="http://basstar.deviantart.com/" title="Basstar">Basstar</a> for the pretty orb part of his <a href="http://basstar.deviantart.com/art/Inspiration-Orb-Icon-Packet-65579465" title="Inspiration Orb Icon Packet">Inspiration Orb</a> package.</li>
  <li>Thanks a lot to <a href="http://twitter.com/jeffscott/" title="Jeffscott">Jeff Scott</a> for helping me improve the text/redaction on Stalkeame in order to make it more <em>human friendly</em> instead of robot friendly.</li>
  <li>And most importantly thanks to you for posting all that yummy geotagged data into Twitpic. <strong>OM NOM NOM</stronger>.</li>
  </ul>
</div>

<footer>
  <h2>Want to go somewhere else?</h2>
  <ul>
  <li><a href="http://logit42.com/" title="Logit42">Logit42</a></li>
  <li><a href="http://twitter.com/Reita" title="Reita's Twitter Profile">Reita</a></li>
  <li><a href="#disclaimer" title="Disclaimer and Legalese">Disclaimer</a></li>
  <li><a href="#credits" title="Credits">Credits</a></li>
  <li id="treebit"><a href="http://treebit.fm/" title="Treebit">Treebit</a></li>
</ul>

</footer>
<?php 
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "<!-- This page was created in ".$totaltime." seconds. -->\n"; 
;?>
</body>
</html>