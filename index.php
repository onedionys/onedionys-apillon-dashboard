<?php
date_default_timezone_set('Asia/Jakarta');
$baseUrl = getBaseUrl();

if (!isset($_COOKIE['onedionys_apillon_api_key']) || !isset($_COOKIE['onedionys_apillon_api_key_secret']) || !isset($_COOKIE['onedionys_apillon_authentication']) || !isset($_COOKIE['onedionys_apillon_storage_uuid']) || !isset($_COOKIE['onedionys_apillon_hosting_uuid'])) {
    if (isset($_COOKIE['onedionys_apillon_api_key'])) {
        setcookie('onedionys_apillon_api_key', '', time() - 3600, '/');
    }

    if (isset($_COOKIE['onedionys_apillon_api_key_secret'])) {
        setcookie('onedionys_apillon_api_key_secret', '', time() - 3600, '/');
    }

    if (isset($_COOKIE['onedionys_apillon_authentication'])) {
        setcookie('onedionys_apillon_authentication', '', time() - 3600, '/');
    }

    if (isset($_COOKIE['onedionys_apillon_storage_uuid'])) {
        setcookie('onedionys_apillon_storage_uuid', '', time() - 3600, '/');
    }

    if (isset($_COOKIE['onedionys_apillon_hosting_uuid'])) {
        setcookie('onedionys_apillon_hosting_uuid', '', time() - 3600, '/');
    }
}

function getBaseUrl() {
    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $protocol = $isHttps ? 'https://' : 'http://';
    $serverName = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $portSuffix = (($isHttps && $port == 443) || (!$isHttps && $port == 80)) ? '' : ':' . $port;
    $baseUrlPath = dirname($_SERVER['PHP_SELF']);
    $baseUrl = $protocol . $serverName . $portSuffix . $baseUrlPath;

    return $baseUrl.'/';
}

function getIpAddress(): string
{
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    $client = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : null;
    $forward = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : null;
    $remote = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    if (isset($client) && filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (isset($forward) && filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

function getClientBrowser(): string
{
    $browser = '';
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
        $browser = 'Netscape';
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
        $browser = 'Firefox';
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
        $browser = 'Chrome';
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
        $browser = 'Opera';
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
        $browser = 'Internet Explorer';
    } else {
        $browser = 'Other';
    }

    return $browser;
}

function insertLog($logData)
{
    $logFile = 'log.json';
    if (!file_exists($logFile)) {
        file_put_contents($logFile, '[]');
    }

    $existingData = file_get_contents($logFile);
    $logs = json_decode($existingData, true);

    $logs[] = $logData;
    $jsonData = json_encode($logs, JSON_PRETTY_PRINT);
    file_put_contents($logFile, $jsonData);
}

function calculateTotalPerDate()
{
    $logFile = 'log.json';
    if (file_exists($logFile)) {
        $existingData = file_get_contents($logFile);
        $logs = json_decode($existingData, true);

        $totalsPerDate = [];
		if(!empty($logs)) {
			foreach ($logs as $log) {
				$date = date('Y-m-d', strtotime($log['created_at']));
				if (!isset($totalsPerDate[$date])) {
					$totalsPerDate[$date] = 0;
				}
				$totalsPerDate[$date]++;
			}

			ksort($totalsPerDate);

			$lastSevenDates = array_slice($totalsPerDate, -7, 7, true);
	
			return $lastSevenDates;
		}

		return [];
    } else {
        return [];
    }
}

$totalsPerDate = calculateTotalPerDate();
$reindexTotal = [
    'date' => [],
    'total' => [],
];

foreach ($totalsPerDate as $date => $total) {
    $reindexTotal['date'][] = $date;
    $reindexTotal['total'][] = $total;
}
$reindexTotal['date'][] = date('Y-m-d', strtotime(date('Y-m-d') . '+1 days'));
$reindexTotal['total'][] = 0;

$postData = [];
$postData['ip_address'] = getIpAddress();
$postData['browser'] = getClientBrowser();
$postData['web_browser'] = $_SERVER['HTTP_USER_AGENT'];
$postData['operating_system'] = php_uname();
$postData['created_at'] = date('Y-m-d H:i:s');

$insertLog = insertLog($postData);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<meta content="One Dionys, a crypto enthusiast, navigates the dynamic world of digital assets with curiosity and determination, driven by a passion for blockchain technology and market trends." name="description">
	<meta content="crypto enthusiast, blockchain technology, digital assets, market trends, curiosity, determination, onedionys, one dionys" name="keywords">
	<meta content="One Dionys" name="author">
	<meta content="index" name="robots">
	<meta content="article" property="og:type">
	<meta content="https://quest.onedionysapillon.xyz/" property="og:url">
	<meta content="Unraveling Cryptocurrency: Journeys With One Dionys" property="og:title">
	<meta content="assets/img/favicon.png" property="og:image">
	<meta content="image/jpeg" property="og:image:type">
	<meta content="Unraveling Cryptocurrency: Journeys With One Dionys" property="og:image:alt">
	<meta content="Unraveling Cryptocurrency: Journeys With One Dionys" property="og:image:title">
	<meta content="800" property="og:image:width">
	<meta content="800" property="og:image:height">
	<meta content="One Dionys, a crypto enthusiast, navigates the dynamic world of digital assets with curiosity and determination, driven by a passion for blockchain technology and market trends." property="og:description">
	<meta content="summary_large_image" name="twitter:card">
	<meta content="One Dionys, a crypto enthusiast, navigates the dynamic world of digital assets with curiosity and determination, driven by a passion for blockchain technology and market trends." name="twitter:description">
	<meta content="assets/img/favicon.png" name="twitter:image">
	<meta content="assets/img/favicon.png" name="twitter:image:src">
	<meta content="Unraveling Cryptocurrency: Journeys With One Dionys" name="twitter:title">
	<title>Unraveling Cryptocurrency: Journeys With One Dionys</title>
	<link href="assets/img/favicon.png" rel="image_src">
	<link href="https://quest.onedionysapillon.xyz/" rel="canonical">
	<link rel="shortcut icon" type="image/x-icon" sizes="96x96" href="assets/img/favicon.png">
	<link rel="stylesheet" href="vendor/stisla/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/stisla/fontawesome/css/all.css">
	<link rel="stylesheet" href="vendor/bootstrap-social/bootstrap-social.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/components.css">
	<link rel="stylesheet" href="assets/css/custom/app.css">
</head>

<body>
	<div id="app">
		<div class="main-wrapper">
			<div class="navbar-bg"></div>
			<nav class="navbar navbar-expand-lg main-navbar">
				<form class="form-inline mr-auto">
					<ul class="navbar-nav mr-3">
						<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
					</ul>
				</form>
				<ul class="navbar-nav navbar-right"></ul>
			</nav>
			<div class="main-sidebar">
				<aside id="sidebar-wrapper">
					<div class="sidebar-brand">
						<a href="<?= $baseUrl ?>">One Dionys</a>
					</div>
					<div class="sidebar-brand sidebar-brand-sm">
						<a href="<?= $baseUrl ?>">OD</a>
					</div>
					<ul class="sidebar-menu">
						<li class="active"><a class="nav-link" href="<?= $baseUrl ?>"><i class="fas fa-home"></i> <span>Home</span></a></li>
						<li><a class="nav-link" href="<?= $baseUrl ?>apillon"><i class="fas fa-fire"></i> <span>Apillon</span></a></li>
					</ul>
					<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
						<a href="https://github.com/onedionys" class="btn btn-primary btn-lg btn-block btn-icon-split">
							<i class="fab fa-github"></i> Follow
						</a>
					</div>
				</aside>
			</div>
			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>Home</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-lg-4 col-md-12">
								<div class="hero bg-primary text-white">
									<div class="hero-inner">
										<h2>Welcome Back!</h2>
										<p class="lead">Simple features. You can complete some missions through the menu on the side.</p>
										<div class="mt-4">
											<a href="<?= $baseUrl ?>apillon" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="fas fa-tasks"></i> Complete a Mission</a>
										</div>
									</div>
								</div>
								<div class="card author-box card-primary mt-4">
									<div class="card-body">
										<div class="author-box-left">
											<img alt="image" src="assets/img/favicon.png" alt="One Dionys - Avatar" class="rounded-circle author-box-picture">
											<div class="clearfix"></div>
											<a href="https://github.com/onedionys" class="btn btn-primary mt-3">Follow</a>
										</div>
										<div class="author-box-details">
											<div class="author-box-name">
												<a href="https://github.com/onedionys">One Dionys</a>
											</div>
											<div class="author-box-job">Crypto Enthusiast</div>
											<div class="author-box-description">
												<p>a crypto enthusiast, navigates the dynamic world of digital assets with curiosity and determination, driven by a passion for blockchain technology and market trends.</p>
											</div>
											<div class="mb-2 mt-3">
												<div class="text-small font-weight-bold">Follow One Dionys On</div>
											</div>
											<a href="https://www.facebook.com/theonedionys/" class="btn btn-social-icon mr-1 btn-facebook">
												<i class="fab fa-facebook-f"></i>
											</a>
											<a href="https://twitter.com/onedionys" class="btn btn-social-icon mr-1 btn-twitter">
												<i class="fab fa-twitter"></i>
											</a>
											<a href="https://github.com/onedionys" class="btn btn-social-icon mr-1 btn-github">
												<i class="fab fa-github"></i>
											</a>
											<a href="https://www.instagram.com/onedionys/" class="btn btn-social-icon mr-1 btn-instagram">
												<i class="fab fa-instagram"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-8 col-md-12">
								<div class="card card-primary">
									<div class="card-header">
										<h4>Visitor Graph</h4>
									</div>
									<div class="card-body">
										<canvas id="myChart" height="150"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<footer class="main-footer">
				<div class="footer-left">
					Copyright &copy; 2024 <div class="bullet"></div> Develop By <a href="https://github.com/onedionys">One Dionys</a>
				</div>
				<div class="footer-right">
					1.0.0
				</div>
			</footer>
		</div>
	</div>
	<script src="vendor/stisla/jquery-3.3.1.min.js"></script>
	<script src="vendor/stisla/popper.min.js"></script>
	<script src="vendor/stisla/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script src="vendor/sweetalert/docs/assets/sweetalert/sweetalert.min.js"></script>
	<script src="vendor/chart.js/dist/Chart.min.js"></script>
	<script src="assets/js/stisla.js"></script>
	<script src="assets/js/scripts.js"></script>
	<script src="assets/js/custom.js"></script>
	<script type="text/javascript">
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?php echo json_encode($reindexTotal['date']); ?>,
				datasets: [{
					label: 'Visitor',
					data: <?php echo json_encode($reindexTotal['total']); ?>,
					borderWidth: 2,
					backgroundColor: 'rgba(63,82,227,.8)',
					borderWidth: 0,
					borderColor: 'transparent',
					pointBorderWidth: 0,
					pointRadius: 3.5,
					pointBackgroundColor: 'transparent',
					pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
				}, ]
			},
			options: {
				legend: {
					display: false
				},
				tooltips: {
					callbacks: {
						label: function(tooltipItem, data) {
							var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
							value = value.toString();
							value = value.split(/(?=(?:...)*$)/);
							value = value.join(',');
							return data.datasets[tooltipItem.datasetIndex].label + ": " + value;
						}
					}
				},
				scales: {
					yAxes: [{
						gridLines: {
							drawBorder: false,
							color: '#f2f2f2',
						},
						ticks: {
							userCallback: function(value, index, values) {
								value = value.toString();
								value = value.split(/(?=(?:...)*$)/);
								value = value.join(',');
								return value;
							}
						}
					}],
					xAxes: [{
						gridLines: {
							display: false
						}
					}]
				},
			}
		});
	</script>
</body>

</html>
