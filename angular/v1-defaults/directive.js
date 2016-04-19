

/**
 * @ngdoc directive
 * @name someApp.directive:defaultDirective
 * @description
 * # defaultDirective

 Use: <div default-directive="" ></div>
 */
angular.module('someApp')
.directive('defaultDirective', function() {
    'use strict';

    var dbugThis = false; var dbugAll = false;
    if(dbugAll||dbugThis){console.log("%ccalled directive:defaultDirective()","color:orange");}

    var defaultDirective = {
        restrict: 'A',
        controllerAs: 'vm',
        //require:'',
        //scope:{},
        //templateUrl: 'template.html',
        //transclude: true,
    };

    defaultDirective.controller = function(){

        var dbugThis = true;
        if(dbugAll||dbugThis){console.log("%ccalled defaultDirective.controller()","color:orange");}
        if(dbugAll||dbugThis){console.log("%c  this","color:grey",this);}

        var vm = this;
        var defaultDirectiveController = {};

        defaultDirectiveController.setup = function(){
        };
        defaultDirectiveController.setup();
    };

    defaultDirective.link = function($scope, element, attrs){

        var dbugThis = true;
        if(dbugAll||dbugThis){console.log("%ccalled defaultDirective.link()","color:orange");}
        if(dbugAll||dbugThis){console.log("%c  $scope","color:grey",$scope);}
        if(dbugAll||dbugThis){console.log("%c  element","color:grey",element);}
        if(dbugAll||dbugThis){console.log("%c  attrs","color:grey",attrs);}

        var defaultDirectiveLink = {}; //private object

        defaultDirectiveLink.setup = function(){
        };
        defaultDirectiveLink.setup();
    };

    return defaultDirective;
});