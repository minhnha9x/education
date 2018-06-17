angular.module('educationApp', ['ngFileUpload', 'smart-table'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
