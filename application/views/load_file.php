<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Astroid NEO Stats</title>
		<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
		<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-datepicker.css'); ?>">
		<link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
	</head>
	<body>
		<div class="header">
			<h3><center>Astroid NEO Stats</center></h3>
		</div>
		<div class="container">
			<div class="">
				<center><p>Neo stands for Near Earth Objects. Nasa provides an open API and in this problem we will be using the Asteroid NeoWs API.</p></center>
			</div>
			<div class="error_msg"></div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
				    <label for="StartDate">Start Date</label>
				    <input type="text" class="form-control" id="StartDate">
				    <small class="form-text text-muted">choose start date for statistics.</small>
				  </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				    <label for="EndDate">End Date</label>
				    <input type="text" class="form-control" id="EndDate">
				    <small class="form-text text-muted">choose end date for statistics.</small>
				  </div>
				</div>
			</div>
			<center><button type="submit" id="submitDate" class="btn btn-primary">Submit <span> <img class="img_loader" src="<?= base_url('assets/img/loading.gif'); ?>" alt=""> </span> </button></center>
			<hr>
			<div class="p20">
				<center>
					<h3>Graph Statistics</h3>
				</center>
			</div>
			<div class='canvas_details' style=''>
				<p><b>Fastest Astroid : <span class="fastest_astroid">-</span> Astroid ID : <span class="fastest_astroid_id">-</span> </b></p>
				<p><b>Closest Astroid : <span class="closest_astroid">-</span> Astroid ID : <span class="closest_astroid_id">-</span> </b></p>
				<p><b>Average Size : <span class="average_size">-</span> </b></p>
			</div>
			<canvas id="myChart" width="400" height="200">

			</canvas>
		</div>



	<script type="text/javascript" src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/app.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/Chart.min.js'); ?>"></script>
	<script type="text/javascript">
		function base_url(path) {
			var base_url = '<?=base_url(); ?>';
			if (path != '') {
				return base_url+path;
			}else{
				return base_url;
			}
		}
	</script>
	</body>
</html>
