angular.module('mainCtrl', [])

	// inject the Destination service into our controller
	.controller('mainController', function($scope, $http, Destination) {
		// object to hold all the data for the destinations page
		$scope.data = {};

		// loading variable to show the spinning loading icon
		$scope.loading = true;

		// get all the destinations first and bind it to the $scope.destinations object
		// use the function we created in our service
		// GET ALL DESTINATIONS ====================================================
		Destination.get()
			.success(function(data) {
				$scope.data.destinations = data;
				$scope.loading = false;               
                                
			});

		// function to handle submitting the form
		// SAVE A DESTINATION ======================================================
		$scope.submitDestination = function() {
			$scope.loading = true;

			// save the destination. pass in destination data from the form
			// use the function we created in our service
			Destination.save($scope.destinationData)
				.success(function(data) {

					// if successful, we'll need to refresh the destinations list
					Destination.get()
						.success(function(getData) {
							$scope.destinations = getData;
							$scope.loading = false;
						});

				})
				.error(function(data) {
					console.log(data);
				});
		};

		// function to handle deleting a destination
		// DELETE A DESTINATION ====================================================
		$scope.deleteDestination = function(id) {
			$scope.loading = true; 

			// use the function we created in our service
			Destination.destroy(id)
				.success(function(data) {

					// if successful, we'll need to refresh the destination list
					Destination.get()
						.success(function(getData) {
							$scope.destinations = getData;
							$scope.loading = false;
						});

				});
		};

	});