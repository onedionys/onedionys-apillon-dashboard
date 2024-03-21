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

function insertLog($logData) {
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
						<li><a class="nav-link" href="<?= $baseUrl ?>"><i class="fas fa-home"></i> <span>Home</span></a></li>
						<li class="active"><a class="nav-link" href="<?= $baseUrl ?>apillon"><i class="fas fa-fire"></i> <span>Apillon</span></a></li>
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
						<h1>Apillon</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-lg-6 col-md-12">
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="card loading-card">
											<div class="card-header">
												<h4>Apillon's Quest</h4>
											</div>
											<div class="card-body">
												<?php if(isset($_COOKIE['onedionys_apillon_api_key'])) { ?>
												<form role="form" action="#" method="POST" enctype="multipart/form-data" id="data-cookie">
													<div class="row">
														<div class="col-lg-12 col-md-12">
															<div class="form-group">
																<p>You can simply press the button below to complete the mission.</p>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12 col-md-12" align="center">
															<button type="submit" id="cookie" class="btn btn-danger btn-save"><i class="fas fa-trash-alt"></i> Reset Cookie</button>
															<button type="button" id="hosting" class="btn btn-primary btn-save"><i class="fas fa-server"></i> Hosting Quest</button>
															<button type="button" id="storage" class="btn btn-success btn-save"><i class="fas fa-database"></i> Storage Quest</button>
															<button type="button" id="nfts" class="btn btn-warning btn-save"><i class="fas fa-dragon"></i> Mint NFTs Quest</button>
															<button type="button" id="identity" class="btn btn-info btn-save"><i class="fas fa-user"></i> Identity Quest</button>
														</div>
													</div>
												</form>
												<?php }else { ?>
												<form role="form" action="#" method="POST" enctype="multipart/form-data" id="data-form">
													<div class="row">
														<div class="col-lg-12 col-md-12">
															<div class="form-group">
																<p>Simply fill out the form below and the data will be stored in cookies.</p>
															</div>
														</div>
														<div class="col-lg-6 col-md-12">
															<div class="form-group">
																<label for="api_key" class="input-required">Api Key</label>
																<input type="text" name="api_key" id="api_key" class="form-control" autocomplete="off" placeholder="Enter Api Key" required="" autofocus="">
															</div>
														</div>
														<div class="col-lg-6 col-md-12">
															<div class="form-group">
																<label for="api_key_secret" class="input-required">Api Key Secret</label>
																<input type="text" name="api_key_secret" id="api_key_secret" class="form-control" autocomplete="off" placeholder="Enter Api Key Secret" required="" autofocus="">
															</div>
														</div>
														<div class="col-lg-12 col-md-12">
															<div class="form-group">
																<label for="authentication" class="input-required">Authentication</label>
																<input type="text" name="authentication" id="authentication" class="form-control" autocomplete="off" placeholder="Enter Authentication" required="" autofocus="">
															</div>
														</div>
														<div class="col-lg-6 col-md-12">
															<div class="form-group">
																<label for="storage_uuid" class="input-required">Storage UUID</label>
																<input type="text" name="storage_uuid" id="storage_uuid" class="form-control" autocomplete="off" placeholder="Enter Storage UUID" required="" autofocus="">
															</div>
														</div>
														<div class="col-lg-6 col-md-12">
															<div class="form-group">
																<label for="hosting_uuid" class="input-required">Hosting UUID</label>
																<input type="text" name="hosting_uuid" id="hosting_uuid" class="form-control" autocomplete="off" placeholder="Enter Hosting UUID" required="" autofocus="">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12 col-md-12" align="center">
															<button type="submit" class="btn btn-primary btn-save"><i class="fas fa-save"></i> Submit</button>
														</div>
													</div>
												</form>
												<?php } ?>
											</div>
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
	<script src="assets/js/stisla.js"></script>
	<script src="assets/js/scripts.js"></script>
	<script src="assets/js/custom.js"></script>
	<script type="text/javascript">
		$("#data-form").submit(function(e) {
			e.preventDefault();

			var data = new FormData(this);

			$('button[type=submit]', this).attr('disabled', 'disabled');
			let save_button = $(this).find('.btn-save'),
				that = this,
				card = $('.loading-card');

			let card_progress = $.cardProgress(card, {
				spinner: false
			});
			save_button.addClass('btn-progress');

			setTimeout(function() {
				$.ajax({
					type: "POST",
					url: "setCookie.php",
					data: data,
					processData: false,
					contentType: false,
					success: function(response) {
						var result = JSON.parse(response);
						if (result.status_code == 200) {
							swal({
								title: "Notice",
								text: result.message,
								icon: "success"
							}).then(function() {
								window.location.reload();
							});
						} else {
							swal('Warning', result.message, 'error');
						}

						card_progress.dismiss(function() {
							$('html, body').animate({
								scrollTop: 0
							});
						});

						save_button.removeClass('btn-progress');
						$('button[type=submit]', that).removeAttr('disabled');
					}
				});
			}, 1000);
			return false;
		});
	</script>
	<script type="text/javascript">
		$("#data-cookie").submit(function(e) {
			e.preventDefault();

			var data = new FormData(this);

			$('button[type=submit]', this).attr('disabled', 'disabled');
			let save_button = $(this).find('.btn-save'),
				that = this,
				card = $('.loading-card');

			let card_progress = $.cardProgress(card, {
				spinner: false
			});
			save_button.addClass('btn-progress');

			setTimeout(function() {
				$.ajax({
					type: "POST",
					url: "deleteCookie.php",
					data: data,
					processData: false,
					contentType: false,
					success: function(response) {
						var result = JSON.parse(response);
						if (result.status_code == 200) {
							swal({
								title: "Notice",
								text: result.message,
								icon: "success"
							}).then(function() {
								window.location.reload();
							});
						} else {
							swal('Warning', result.message, 'error');
						}

						card_progress.dismiss(function() {
							$('html, body').animate({
								scrollTop: 0
							});
						});

						save_button.removeClass('btn-progress');
						$('button[type=submit]', that).removeAttr('disabled');
					}
				});
			}, 1000);
			return false;
		});

		$('#hosting').on('click', function(e) {
			e.preventDefault();

			var data = new FormData();
			data.append('type', 'websites');

			$('#cookie').attr('disabled', 'disabled');
			$('#hosting').attr('disabled', 'disabled');
			$('#storage').attr('disabled', 'disabled');
			$('#nfts').attr('disabled', 'disabled');
			$('#identity').attr('disabled', 'disabled');

			let card = $('.loading-card');

			let card_progress = $.cardProgress(card, {
				spinner: false
			});
			$('#cookie').addClass('btn-progress');
			$('#hosting').addClass('btn-progress');
			$('#storage').addClass('btn-progress');
			$('#nfts').addClass('btn-progress');
			$('#identity').addClass('btn-progress');

			setTimeout(function() {
				$.ajax({
					type: "POST",
					url: "upload.php",
					data: data,
					processData: false,
					contentType: false,
					success: function(response) {
						var result = JSON.parse(response);
						if (result.status_code == 200) {
							swal({
								title: "Notice",
								text: result.message,
								icon: "success"
							}).then(function() {
								window.location.reload();
							});
						} else {
							swal('Warning', result.message, 'error');
						}

						card_progress.dismiss(function() {
							$('html, body').animate({
								scrollTop: 0
							});
						});

						$('#cookie').removeClass('btn-progress');
						$('#hosting').removeClass('btn-progress');
						$('#storage').removeClass('btn-progress');
						$('#nfts').removeClass('btn-progress');
						$('#identity').removeClass('btn-progress');

						$('#cookie').removeAttr('disabled');
						$('#hosting').removeAttr('disabled');
						$('#storage').removeAttr('disabled');
						$('#nfts').removeAttr('disabled');
						$('#identity').removeAttr('disabled');
					}
				});
			}, 1000);
			return false;
		});

		$('#storage').on('click', function(e) {
			e.preventDefault();

			var data = new FormData();
			data.append('type', 'buckets');

			$('#cookie').attr('disabled', 'disabled');
			$('#hosting').attr('disabled', 'disabled');
			$('#storage').attr('disabled', 'disabled');
			$('#nfts').attr('disabled', 'disabled');
			$('#identity').attr('disabled', 'disabled');

			let card = $('.loading-card');

			let card_progress = $.cardProgress(card, {
				spinner: false
			});
			$('#cookie').addClass('btn-progress');
			$('#hosting').addClass('btn-progress');
			$('#storage').addClass('btn-progress');
			$('#nfts').addClass('btn-progress');
			$('#identity').addClass('btn-progress');

			setTimeout(function() {
				$.ajax({
					type: "POST",
					url: "upload.php",
					data: data,
					processData: false,
					contentType: false,
					success: function(response) {
						var result = JSON.parse(response);
						if (result.status_code == 200) {
							swal({
								title: "Notice",
								text: result.message,
								icon: "success"
							}).then(function() {
								window.location.reload();
							});
						} else {
							swal('Warning', result.message, 'error');
						}

						card_progress.dismiss(function() {
							$('html, body').animate({
								scrollTop: 0
							});
						});

						$('#cookie').removeClass('btn-progress');
						$('#hosting').removeClass('btn-progress');
						$('#storage').removeClass('btn-progress');
						$('#nfts').removeClass('btn-progress');
						$('#identity').removeClass('btn-progress');

						$('#cookie').removeAttr('disabled');
						$('#hosting').removeAttr('disabled');
						$('#storage').removeAttr('disabled');
						$('#nfts').removeAttr('disabled');
						$('#identity').removeAttr('disabled');
					}
				});
			}, 1000);
			return false;
		});

		$('#nfts').on('click', function(e) {
			e.preventDefault();

			var data = new FormData();

			$('#cookie').attr('disabled', 'disabled');
			$('#hosting').attr('disabled', 'disabled');
			$('#storage').attr('disabled', 'disabled');
			$('#nfts').attr('disabled', 'disabled');
			$('#identity').attr('disabled', 'disabled');

			let card = $('.loading-card');

			let card_progress = $.cardProgress(card, {
				spinner: false
			});
			$('#cookie').addClass('btn-progress');
			$('#hosting').addClass('btn-progress');
			$('#storage').addClass('btn-progress');
			$('#nfts').addClass('btn-progress');
			$('#identity').addClass('btn-progress');

			setTimeout(function() {
				$.ajax({
					type: "POST",
					url: "nfts.php",
					data: data,
					processData: false,
					contentType: false,
					success: function(response) {
						var result = JSON.parse(response);
						if (result.status_code == 200) {
							swal({
								title: "Notice",
								text: result.message,
								icon: "success"
							}).then(function() {
								window.location.reload();
							});
						} else {
							swal('Warning', result.message, 'error');
						}

						card_progress.dismiss(function() {
							$('html, body').animate({
								scrollTop: 0
							});
						});

						$('#cookie').removeClass('btn-progress');
						$('#hosting').removeClass('btn-progress');
						$('#storage').removeClass('btn-progress');
						$('#nfts').removeClass('btn-progress');
						$('#identity').removeClass('btn-progress');

						$('#cookie').removeAttr('disabled');
						$('#hosting').removeAttr('disabled');
						$('#storage').removeAttr('disabled');
						$('#nfts').removeAttr('disabled');
						$('#identity').removeAttr('disabled');
					}
				});
			}, 1000);
			return false;
		});

		$('#identity').on('click', function(e) {
			e.preventDefault();

			var data = new FormData();

			$('#cookie').attr('disabled', 'disabled');
			$('#hosting').attr('disabled', 'disabled');
			$('#storage').attr('disabled', 'disabled');
			$('#nfts').attr('disabled', 'disabled');
			$('#identity').attr('disabled', 'disabled');

			let card = $('.loading-card');

			let card_progress = $.cardProgress(card, {
				spinner: false
			});
			$('#cookie').addClass('btn-progress');
			$('#hosting').addClass('btn-progress');
			$('#storage').addClass('btn-progress');
			$('#nfts').addClass('btn-progress');
			$('#identity').addClass('btn-progress');

			setTimeout(function() {
				$.ajax({
					type: "POST",
					url: "identity.php",
					data: data,
					processData: false,
					contentType: false,
					success: function(response) {
						var result = JSON.parse(response);
						if (result.status_code == 200) {
							swal({
								title: "Notice",
								text: result.message,
								icon: "success"
							}).then(function() {
								window.location.reload();
							});
						} else {
							swal('Warning', result.message, 'error');
						}

						card_progress.dismiss(function() {
							$('html, body').animate({
								scrollTop: 0
							});
						});

						$('#cookie').removeClass('btn-progress');
						$('#hosting').removeClass('btn-progress');
						$('#storage').removeClass('btn-progress');
						$('#nfts').removeClass('btn-progress');
						$('#identity').removeClass('btn-progress');

						$('#cookie').removeAttr('disabled');
						$('#hosting').removeAttr('disabled');
						$('#storage').removeAttr('disabled');
						$('#nfts').removeAttr('disabled');
						$('#identity').removeAttr('disabled');
					}
				});
			}, 1000);
			return false;
		});
	</script>
</body>

</html>
