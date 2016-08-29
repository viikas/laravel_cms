var limoApp = angular.module('limoApp', ['mainCtrl', 'destinationService'],function($interpolateProvider)
{
    $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
});



