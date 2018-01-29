(function ($, angular) {
'use strict';
/**
 * @ngdoc service
 * @name someApp.defaultFactory
 * @description
 * # defaultFactory
 * Factory in the someApp.
 */
angular.module('someApp').factory('defaultFactory', defaultFactory);

function defaultFactory(){

	var defaultFactory = {};//object returned from factory

	return defaultFactory;
}

}(window.jQuery || window.$, window.angular));