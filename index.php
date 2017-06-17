<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Doctor Batch</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container" ng-app="doctorApp" ng-controller="doctorCtrl">
	<h2>Batch 001</h2>

	<div class="row">
		<div class="col-md-7 col-lg-offset-8">
			<div class="form-group">
				<input class="form-control input-sm" type="text" ng-model="search" placeholder="search">
			</div>
		</div>
	</div>

	<!-- wait icon -->
	<div class="container" ng-hide="loading">
		<div class="row text-center">
			<img src="./images/loading.gif" alt="loading image" width="50" height="50">
		</div>
	</div>

	<!-- Doctor Table -->
	<div class="table-responsive" ng-show="doctor" style="max-height: 480px;">
		<table id="example" class="table table-striped table-bordered">
			<thead>
			<tr>
				<th>#</th>
				<th>Doctor Name</th>
				<th>Hospital Name</th>
				<th>Qualification</th>
				<th>Location</th>
				<th>Last Update</th>
			</tr>
			</thead>

			<tbody>
			<tr ng-repeat="record in result | filter : search">
				<td>{{ $index + 1 }}.</td>
				<td>{{ record.doctor_name }}</td>
				<td>{{ record.hospital_name }}</td>
				<td>{{ record.qualification }}</td>
				<td>{{ record.location }}</td>
				<td>{{ record.last_updated_date }}</td>
			</tr>
			</tbody>
		</table>
	</div>

	<!-- No record alert -->
	<div class="alert alert-danger alert-dismissable text-center" ng-show="norecord">
		No records
	</div>
</div>

</div>

<script src="js/angular.js"></script>
<script src="js/index.js"></script>

</body>
</html>
