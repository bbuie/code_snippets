(function ($, angular) {

    /**
     * @ngdoc directive
     * @name someApp.directive:defaultDirective
     * @description
     * # defaultDirective

     Use: <div default-directive="" ></div>
     */
    angular.module('someApp').directive('defaultDirective', defaultDirective);

    function defaultDirective(){
        'use strict';

        var dbugThis = false; var dbugAll = false;
        if(dbugAll||dbugThis){console.log("%ccalled directive:defaultDirective()","color:orange");}

       return = {
            restrict: 'A',
            controller: defaultDirectiveController,
            controllerAs: 'vm',
            link: defaultDirectiveLink,
            //require:'',
            //scope:{},
            //templateUrl: 'template.html',
            //transclude: true,
        };

        function defaultDirectiveController(){
            var dbugThis = true;
            if(dbugAll||dbugThis){console.log("%ccalled defaultDirective.controller()","color:orange");}
            if(dbugAll||dbugThis){console.log("%c  this","color:grey",this);}

            var vm = this;

            function setup(){

            };
            setup();
        };
        function defaultDirectiveLink(){
            var dbugThis = true;
            if(dbugAll||dbugThis){console.log("%ccalled defaultDirective.link()","color:orange");}
            if(dbugAll||dbugThis){console.log("%c  $scope","color:grey",$scope);}
            if(dbugAll||dbugThis){console.log("%c  element","color:grey",element);}
            if(dbugAll||dbugThis){console.log("%c  attrs","color:grey",attrs);}

            var defaultDirectiveLink = {}; //private object

            function setup(){

            };
            setup();
        };
    };
}(window.jQuery || window.$, window.angular));