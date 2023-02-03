<!DOCTYPE html>
<head>
    <style>
        body {
            font-family: sans-serif;
	}
	    tr:nth-child(odd){
            background-color:#eeeeee;
        }
        table {
            width:70%;
            text-align:left;
            margin: auto;
        }
        td, th {
            vertical-align:top;
            padding:6px;
        }
	h4 {
	    color: #d64161;
	    font-size: 20px;
	}
	h5 {
	    color: #6b5b95;
	    font-size: 18px;
	    margin-bottom: -4px;
	}
	.input-submit {
	    background: #016ABC;
	    color: #fff;
	    border: 1px solid #eee;
	    border-radius: 20px;
	}
	    input, select, textarea {
	    font-size: 1em;
	}
    </style>
</head>
<body>
<h4>Weather CSV to HTML</h4>

<form id="weather_form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select id="site" name="site">
	<option value="" disabled selected>Select a weather station ...</option>
	<option value="http://www.martynhicks.uk/weather">Horfield (Bristol)</option>
	<option value="http://www.thornburyweather.co.uk/weatherstation">Thornbury (Bristol)</option>
	<option value="https://www.glosweather.com">Gloucestershire</option>
	<option value="http://www.newquayweather.com">Newquay (Cornwall)</option>
    </select>
	<input class="input-submit" type="submit" name="submit" value="get data"/>
</fomm>

<?php
# very imporatant
date_default_timezone_set('Europe/London');

define ('WINDSPEED',1); 
define ('WINDDIRECTION',3); 
define('TEMPERATURE',4); 
define('TIMEHH',29); 
define ('TIMEMM',30); 
define('STATION',32); 
define('SUMMARY',49); 

if (isset($_GET['site'])) {
    $site = $_GET["site"]; 
    $rawdatafile = $site . "/clientraw.txt"; 
    $csv = file_get_contents($rawdatafile); 
    $data = explode(' ',$csv); 
	
    $station = explode('_', $data[STATION]);
    $sta = explode('-', $station[0]);
    $sta[0] = str_replace(",","",$sta[0]);
    $sum = str_replace("_"," ",$data[SUMMARY]);
	
    echo '<h5>Weather Data from ' . $sta[0] . '</h5>';
    echo '<p>' .  date('l jS M Y') . '</p>';
    echo '<p><strong>Weather at ' . $data[TIMEHH] . ':' . $data[TIMEMM] . '</strong></p>'; 
    echo '<p>Summary:' . ucfirst($sum) . '</p>';
    echo '<p>' .  'Temperature: ' . $data[TEMPERATURE] . '&#0176;C.</p>';
    echo '<p>Wind: ' . $data[WINDSPEED] . ' knots from ' . degree_to_compass_point($data[WINDDIRECTION]) . ' direction.</p>'; 
}

function degree_to_compass_point($d) {
    $dp = $d + 11.25;
    $dp = $dp % 360;
    $dp = floor($dp / 22.5) ;
    $points = array("N","NNE","NE","ENE","E","ESE","SE" ,"SSE" ,"S", "SSW","SW","WSW","W", "WNW","NW","NNW","N");
    $dir = $points[$dp];
    return $dir;
}
?>
 </body>
</html>