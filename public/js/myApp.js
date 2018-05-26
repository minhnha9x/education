angular.module('educationApp', ['ngFileUpload', 'ui.bootstrap', 'ui.utils'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
