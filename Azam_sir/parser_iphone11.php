<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<?php
date_default_timezone_set('America/New_York');

$currentDay = date('d');
$currentMonth = date('m');
$currentYear = date('Y');

$months = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$days = range(1, 31);
$years = range($currentYear-2, $currentYear+2);

if(!empty($_GET['url']) || !empty($_REQUEST['station'])) {
	$stationId = $_REQUEST['station'];
	$url = isset($_GET['url']) ? trim($_GET['url']) : null;
	$month = isset($_POST['month']) ? $_POST['month'] : null;
	$day = isset($_POST['day']) ? $_POST['day'] : null;
	$year = isset($_POST['year']) ? $_POST['year'] : null;
	$range = isset($_POST['range']) ? $_POST['range'] : 1;
	$addParams = '';

	if($month || $day || $year) {
		$currentDay = $day ? str_pad($day, 2, '0', STR_PAD_LEFT) : $currentDay;
		$currentMonth = $month ? str_pad($month, 2, '0', STR_PAD_LEFT) : $currentMonth;
		$currentYear = $year ? $year : $currentYear;

		$timelength = ($range == 1) ? 'daily' : 'weekly';
		$addParams = "&bmon={$currentMonth}&bday={$currentDay}&byear={$currentYear}&timelength={$timelength}&format=Submit";
	}
	if(!$stationId) {
		preg_match('/Stationid=([A_Za-z0-9]+)/', $url, $matches);
		if(!empty($matches[1])) {
			$stationId = $matches[0];
		}
	}
	/*$url = "http://tidesandcurrents.noaa.gov/noaatidepredictions/viewDailyPredictions.jsp?Stationid={$stationId}{$addParams}";*/
	$url = "http://tidesandcurrents.noaa.gov/noaatidepredictions/viewDailyPredictions.jsp?Stationid={$stationId}";

	$xmlData = null;
	for($i=1;$i<5;$i++){
		$content = getContent($url);
        $attr = getAttr($content);
		var_dump($attr);

        if(!$attr) {
        	$error = 'Page was not found'; break;
        }

        $params = http_build_query($attr);
		var_dump($params);
    	$xmlUrl = "http://tidesandcurrents.noaa.gov/noaatidepredictions/NOAATidesFacade.jsp?datatype=XML&{$params}";
    	sleep(2);
		$xmlData = getContent($xmlUrl);
		
		if(false !== $xmlData) {
			break;
		}
	}

	if(!isset($error) && !$xmlData) {
		$error = '<span style="color:red;">NOAA Server is Unavailable. Please try again.</span>';
		if(isset($_GET['json'])) {
			$callback = filter_var('parseRequest', FILTER_SANITIZE_STRING);
			echo $callback .'('. json_encode($error) . ');'; die();
		}
	}
	if(!isset($error)) {
        $data = new SimpleXMLElement($xmlData);
        if(isset($_GET['json'])) {
        	$callback = filter_var('parseRequest', FILTER_SANITIZE_STRING);
        	echo $callback .'('. json_encode(getHtml($data)) . ');';  die();
        }
    	$pred = parseXML($data, $range);
	}
}

function getContent($url) {
	 $headers = array(
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Language: en-us;q=0.5,en;q=0.3",
        "Accept-Charset: utf-8;q=0.7,*;q=0.7",
        "Keep-Alive: 115",
        "Connection: keep-alive",
		"Cache-Control: no-cache, must-revalidate",
		"Expires: Sat, 26 Jul 1997 05:00:00 GMT"
    );

	$options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,     // return headers inline
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false,    // allow insecure ssl conns
        CURLOPT_ENCODING       => 'UTF-8',  // utf8 encoding
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
        CURLOPT_HTTPHEADER     => $headers
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err = curl_errno($ch);
    $errMsg = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($err == 0) {
        if ($httpCode == "200") {
            return $content;
        } else {
        	return false;
        }
    } else {
        return false;
    }
    return $result;
}

function getAttr($content) {
	if(!$content) {
        return false;
    }

	$pattern = array('~<noscript[^>]*?>.*?</noscript>~si','~<script[^>]*>.*?</script>~si','~<style[^>]*>.*?</style>~si');
	$content=preg_replace($pattern, '', $content);

	$dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($content);
    libxml_use_internal_errors(false);
    $xpath = new DOMXpath($dom);

	$attr = array();
	foreach($xpath->query("//form/@name") as $key => $element) {
        foreach($xpath->query("//input[@type='hidden']", $element) as $input) {
        	$name = $input->getAttributeNode('name')->nodeValue;
			$value = $input->getAttributeNode('value')->nodeValue;
			$attr[$name] = $value;
        }
	}
	return $attr;
}

function parseXML($xml, $range) {
	$pred = '[ ';
	$i = 0;
	foreach($xml->data->item as $item) {
		if ($i > 0) {
            $pred .= ', ';
        }
        $value = $item->pred;
    	$pred .= "[Date.parse('" . $item->date . ' ' . $item->time . " UTC'), {$value}]";
    	$i++;
    	if($range == 3 && $i > 12) {
    		break;
    	}
	}
	$pred .= ' ]';
	return $pred;
}

function getHtml($xml) {
	if(!$xml->data->item) {
		return "Data was not found";
	}
	$result = array();
	$html = <<<HTML
<h3>$xml->stationname</h3>
<table class="dataGrid">
	<tr colspan=4><input type="button" value="Reload Data" onClick="document.location.reload(true)"></tr>
	<tr>
		<th>Date</th>
		<th>Day</th>
		<th>Time</th>
		<th>Hgt</th>
	</tr>
HTML;
	// use above to reload data <tr colspan=4><input type="button" value="Reload Data" onClick="document.location.reload(true)"></tr>
	//$today = new DateTime(strftime("%Y/%m/%d", time()));
    $i = 1;
	foreach($xml->data->item as $key => $item) {
		/*$datetime = new DateTime($item->date);
		if($datetime->diff($today)->days) {
			continue;
		}*/
		if($i > 4) {
			break;
		}
		$date = strftime('%m/%d', strtotime($item->date));
    	$html .= <<<HTML
<tr>
	<td>$date</td>
	<td>$item->day</td>
	<td>$item->time</td>
	<td>$item->pred $item->highlow</td>
</tr>
HTML;
		$i++;
	}
	$html .= <<<HTML
</table>
<button type="button" class="MoreTides" onclick="window.location.href='http://www.nestides.com/tides/parser_iphone11.php?station=$xml->stationid'">View Graph - Change Dates</button>
HTML;
	$result['grid'] = $html;
	return $result;
}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<title></title>
		<script type="text/javascript" src="http://www.nestides.com/tides/js/jquery.js"></script>
		<script type="text/javascript" src="http://www.nestides.com/tides/js/highcharts/2.2.5/highcharts.src.js"></script>
        <!-- 11-1-2012 removed v from version number v2.2.5 -->
		<script>

			$(document).ready(function() {

				$('#loading').hide();

				$('#show').click(function(){
					$('#loading').show();
					chart.showLoading('Drawing Tidal Flow Charts');
				})

                <?php if(isset($data)) { ?>
					var chart;
					$(function() {
						var options = {
							global: {
								canvasToolsURL: 'http://www.nestides.com/tides/js/highcharts/modules/canvas-tools.js'
							},

							chart: {
								renderTo: 'container',
								type: 'spline',
								events: {
						            load: function(event) {
						                $('#loading').hide();
						            }
								}
							},
							title: {
								text: '<?php echo $data->stationname . ', ' . $data->state ?> StationId <?php echo  $data->stationid ?>'
							},

							xAxis: {
								type: 'datetime',
								tickWidth: 0,
								gridLineWidth: 1,
								gridLineDashStyle: 'ShortDash',
								title: {
									text: 'Date/Time (<?php echo  $data->Timezone ?>)'
								},
								labels: {
									enabled: true,
									align: 'center',
									formatter: function() {
										return Highcharts.dateFormat('%m/%d - %I %p', this.value);
									}
								},
							},

							yAxis: [{
								allowDecimals:true,
								showFirstLabel: false,
								title: {
									text: 'Height (<?php echo $data->dataUnits ?> relative to <?php echo $data->Datum ?>)'
								},
								labels: {
									align: 'left',
									x: 3,
									y: 16,
									formatter: function() {
										return Highcharts.numberFormat(this.value, 2);
									}
								},
							}, {
								linkedTo: 0,
								gridLineWidth: 0,
								opposite: true,
								showFirstLabel: false,
								title: {
									text: null
								},
								labels: {
									align: 'right',
									x: -3,
									y: 16,
									formatter: function() {
										return Highcharts.numberFormat(this.value, 2);
									}
								},
							}],

							legend: {
								align: 'right',
								verticalAlign: 'top',
								floating: true,
								borderWidth: 0,
								y:10
							},

							series: [{
								name: 'Subordinate Predictions',
								data: <?php echo $pred; ?>
							}],

							tooltip: {
								shared: true,
								crosshairs: true,
								formatter: function() {
									var s = Highcharts.dateFormat('%A, %b %e, %Y %I:%M %p', this.x);
									$.each(this.points, function(i, point) {
										s += '<br/>' + point.series.name + ': ' + '<strong>' + point.y + '</strong><br/>';
	                            	});
									return s;
								}
							},
						}
						Highcharts.setOptions({
		   					global: {
		      					canvasToolsURL: 'http://www.nestides.com/tides/js/highcharts/modules/canvas-tools.js'
		   					}
						});
						chart = new Highcharts.Chart(options);

					});
				<?php } ?>
			});
       </script>
       <style>
			.dataGrid {
                border-collapse: collapse;
                width: 100%;
            }

            .dataGrid th {
                font-weight: bold;
            }

            .dataGrid td,
            .dataGrid th {
                border: 1px solid #ccc;
                padding: 2px;
            }
            .MoreTides {
            	-moz-box-shadow:inset 0px 1px 0px 0px #bee2f9;
            	-webkit-box-shadow:inset 0px 1px 0px 0px #bee2f9;
            	box-shadow:inset 0px 1px 0px 0px #bee2f9;
            	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #63b8ee), color-stop(1, #468ccf) );
            	background:-moz-linear-gradient( center top, #63b8ee 5%, #468ccf 100% );
            	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#63b8ee', endColorstr='#468ccf');
            	background-color:#63b8ee;
            	-moz-border-radius:6px;
            	-webkit-border-radius:6px;
            	border-radius:6px;
            	border:1px solid #3866a3;
            	display:inline-block;
            	color:#14396a;
            	font-family:arial;
            	font-size:15px;
            	font-weight:bold;
            	padding:6px 24px;
            	text-decoration:none;
            	text-shadow:1px 1px 0px #7cacde;
            }.MoreTides:hover {
            	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #468ccf), color-stop(1, #63b8ee) );
            	background:-moz-linear-gradient( center top, #468ccf 5%, #63b8ee 100% );
            	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#468ccf', endColorstr='#63b8ee');
            	background-color:#468ccf;
            }.MoreTides:active {
            	position:relative;
            	top:1px;
            }		
       </style>
	</head>
	<body>
		<?php if(!empty($_REQUEST['station'])): ?>
        	<input type="button" class="MoreTides" value="Go Back" onClick="window.history.back();">
		<?php endif; ?>
		<?php if(isset($error)) { ?>
			<strong><?php echo $error ?></strong>
		<?php } ?>
    	<form method="post" id="chartForm" action="parser_iphone11.php">
     		<input name="station" type="hidden" value="<?php if(isset($stationId)) { echo $stationId; } ?>">
    		<input name="url" style="display:none;" type="text" value="<?php if(isset($_POST['url'])) { echo $_POST['url']; } ?>">
			Begin date:
			<select size="1" name="month">
				<option value="0">--select--</option>
				<?php foreach($months as $key => $month) { ?>
    				<option value="<?php echo $key ?>" <?php if($currentMonth == $key) { ?> selected="selected" <?php } ?>><?php echo $month ?></option>
    			<?php } ?>
		  </select>
			<select name="day">
				<option value="0">--select--</option>
				<?php foreach($days as $day) { ?>
    				<option value="<?php echo $day ?>" <?php if($currentDay == $day) { ?> selected="selected" <?php } ?>><?php echo $day ?></option>
    			<?php } ?>
			</select>
			<select name="year">
				<option value="0">--select--</option>
				<?php foreach($years as $year) { ?>
    				<option value="<?php echo $year ?>" <?php if($currentYear == $year) { ?> selected="selected" <?php } ?>><?php echo $year ?></option>
    			<?php } ?>
			</select>
    		<BR>Time Range:
			<select size="1" name="range">
				<option value="1" <?php if(isset($range) && $range == 1) { ?> selected="selected" <?php } ?> >24 hours</option>
				<option value="3" <?php if(isset($range) && $range == 3) { ?> selected="selected" <?php } ?> >3 days</option>
				<option value="7" <?php if(isset($range) && $range == 7) { ?> selected="selected" <?php } ?> >7 days</option>
			</select>
			<input type="button" class="MoreTides" value="Get Tides" id="show" onClick="$('#chartForm').submit();">
    	</form>
		<div id="loading" style="padding-left: 150px; <?php echo (!isset($data) ? 'display:none' : '') ?>">
	    	<img src="ajax-loader.gif" style="padding-left: 50px;"/> <br /><br />
	    	<strong>Drawing Tidal Flow Charts</strong>
	  	</div>
    	<?php if(isset($data)) { ?>
        	<div id="content">
        			<h3><?php echo $data->stationname . ', ' . $data->state ?> StationId <?php echo  $data->stationid ?></h3>
            	<div id="table">
            		<table class="dataGrid">
            			<tr>
            				<th>Date</th>
            				<th>Day</th>
            				<th>Time</th>
            				<th>Hgt</th>
            			</tr>
            			<?php $i = 0; ?>
            			<?php foreach($data->data->item as $item) : ?>
                			<tr>
                				<td><?php echo strftime('%m/%d', strtotime($item->date)) ?></td>
                				<td><?php echo $item->day ?></td>
                				<td><?php echo $item->time ?></td>
                				<td><?php echo $item->pred . ' ' . $item->highlow ?></td>
                			</tr>
                			<?php $i++;
                			if($range == 3 && $i > 12) {
                				break;
                			} ?>
                		<?php endforeach; ?>
            		</table>
            	</div>
                <div id="chart"><div id="container" style="width: 100%; height: 300px;"></div></div>
     		</div>
		<?php } ?>
    <table>
    <tr>
    <td>
    	<?php if(isset($data)) { ?>
                	<span>
                		<?php if($data->referencedToStationName) { ?> Referenced to Station: <?php echo $data->referencedToStationName ?> <?php } ?>
                		<?php if($data->referencedToStationId) { ?> (<?php echo $data->referencedToStationId ?>)</span> <?php } ?><br >
                	<span>
                		<?php if($data->HeightOffsetLow && $data->HeightOffsetHigh) { ?>
                			Height offset in feet (low: <?php echo $data->HeightOffsetLow?> high: <?php echo $data->HeightOffsetHigh ?>)  <br />
                		<?php } ?>
                		<?php if($data->TimeOffsetLow && $data->TimeOffsetHigh) { ?>
                			Time offset in mins ( low:<?php echo $data->TimeOffsetLow?> high: <?php echo $data->TimeOffsetHigh ?>)  <br />
                		<?php } ?>
                	</span>
                	<span>Daily Tide Prediction in <strong><?php echo $data->dataUnits?></strong></span><br/>
                	<span>Time Zone: <strong><?php echo $data->Timezone?></strong></span><br />
                	<span>Datum: <strong><?php echo $data->Datum?></strong></span></td></tr></table>
		<?php } ?>
    </body>
</html>