angular.module('destinationService', [])

	.factory('Destination', function($http) {

		return {
			// get all the destinations
			get : function() {
				return $http.get('/admin/destinations/getAllDestinations');
			},

			// save a destination
			save : function(destinationData) {
				return $http({
					method: 'POST',
					url: '/admin/destinations/create',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(destinationData)
				});
			},

			// destroy a destination
			destroy : function(id) {
				return $http.delete('/admin/destinations/destroy/' + id);
			}
		}

	});
	