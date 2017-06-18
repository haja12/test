var doctorapp = angular.module("doctorApp", []);

doctorapp.controller("doctorCtrl", function ($scope, $http) { //alert("Doctor");

    // call connection.php to fetch the records from DB
    $http({
        method: 'GET',
        url: 'connection.php',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).
    success(function(response){ //alert(response);
        if(response == 0){
            $scope.doctor = false;
            $scope.norecord = true;
        }
        else {
            $scope.loading = true;
            $scope.result = response;
            $scope.doctor = true;
        }
    }).error(function(response) {
        alert("Error Result: " + response);
    });

});