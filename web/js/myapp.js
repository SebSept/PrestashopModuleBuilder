function formCtrl($scope, $http) {
    $scope.token = 'zer';
     $http({method: 'GET', url: 'csrfp'}).
        success(function(data, status, headers, config) {
             $scope.token = data.csrfp;
        }
    );
}; 