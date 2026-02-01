// var app = angular.module('app', [
//   'ngSanitize',
//   'ngFileUpload',
// 	'jcs-autoValidate',
//   'selectize',
//   'ngRoute',
// ]);

// angular.module('jcs-autoValidate')
//     .run([
//     'defaultErrorMessageResolver',
//     function (defaultErrorMessageResolver) {
//         defaultErrorMessageResolver.getErrorMessages().then(function (errorMessages) {
//           errorMessages['patternInt'] = 'Please fill a numeric value';
//           errorMessages['patternFloat'] = 'Please fill a numeric/decimal value';
//         });
//     }
// ]);


// app.directive('convertToNumber', function() {
//   return {
//     require: 'ngModel',
//     link: function(scope, element, attrs, ngModel) {
//       ngModel.$parsers.push(function(val) {
//         return val != null ? parseInt(val, 10) : null;
//       });
//       ngModel.$formatters.push(function(val) {
//         return val != null ? '' + val : null;
//       });
//     }
//   };
// });

// app.directive('autoCompleteTrigger', function() {
//     return {
//         restrict: 'A',
//         link: function(scope, elem, attr, ctrl) {
//             elem.autocomplete({
//                 source: base_url+'/api/triggers/get-triggers',
//                 position: {
//                      my: "left top-3",
//                 },
//                 minLength: 3,
//                 select: function (event, ui) {
//                     event.preventDefault();
                    
//                     var label = ui.item.label;
//                     var value = ui.item.value;
//                     console.log(ui.item);
//                     scope.setTrigger(value, label);
//                 },
//                 focus: function (event, ui) {
//                     event.preventDefault();
//                 }
//             });
//         }
//     };
// });


// app.directive('autoCompleteCompany', function() {
//     return {
//         restrict: 'A',
//         link: function(scope, elem, attr, ctrl) {
//             elem.autocomplete({
//                 source: base_url+'/api/getCompanies',
//                 position: {
//                      my: "left top-3",
//                 },
//                 minLength: 3,
//                 select: function (event, ui) {
//                     event.preventDefault();
                    
//                     var label = ui.item.label;
//                     var value = ui.item.value;
//                     console.log(ui.item);
//                     scope.setCompany(value, label);
//                 },
//                 focus: function (event, ui) {
//                     event.preventDefault();
//                 }
//             });
//         }
//     };
// });


// app.directive('autoSesCompleteCompany', function() {
//     return {
//         restrict: 'A',
//         link: function(scope, elem, attr, ctrl) {
//             elem.autocomplete({
//                 source: base_url+'/api/getSesCompanies',
//                 position: {
//                      my: "left top-3",
//                 },
//                 minLength: 3,
//                 select: function (event, ui) {
//                     event.preventDefault();
                    
//                     var label = ui.item.label;
//                     var value = ui.item.value;
//                     console.log(ui.item);
//                     scope.setCompany(value, label);
//                 },
//                 focus: function (event, ui) {
//                     event.preventDefault();
//                 }
//             });
//         }
//     };
// });

// app.directive('eChart', ['$compile', function ($compile) {
//     return {
//       restrict: 'EA',
//       template: '<div class="chartarea" style="width:220px; height:220px"></div>',
//       link: function (scope, element, attrs) {
//           var regions = element[0].querySelectorAll('.chartarea');

//           var division_id = attrs.dataid;
//           var data_link = attrs.datagraph;
//           var data = scope[data_link];

//           var name = attrs.dataname;
//           var title = name;

//           var titlehide = attrs.titlehide;
//           console.log(name, titlehide);
//           if(titlehide == "true") title = '';

//           var colors = (attrs.colors) ? scope[attrs.colors] : scope.colors;
          
//           angular.forEach(regions, function (path, key) {
//             var regionElement = angular.element(path);
//             regionElement.attr("id", division_id);
//           });

//           var options = {
//                 title : {
//                   text: title,
//                   x: 'center',
//                   y: 96,
//                   textStyle: {
//                       color: 'rgba(0, 0, 0, 0.7)',
//                       fontSize: 13
//                   }
//               },
//                 tooltip: {
//                   trigger: 'item',
//                   formatter: "{b} - {d}%"
//               },
//                 series : [
//                   {
//                       name: name,
//                       type:'pie',
//                       radius : ['50%','75%'],
//                       data: data,
//                       label: {
//                           normal: {
//                               show: false,
//                               position: 'outside',
//                               formatter: "{b}",
//                               textStyle: {
//                                   color: 'rgba(0, 0, 0, 0.9)',
//                                   fontSize: 14
//                               }
//                           },
//                       },
//                       labelLine: {
//                           normal: {
//                               show: true
//                           }
//                       },
//                       itemStyle: {
//                           normal: {
//                               shadowBlur: 20,
//                               shadowColor: 'rgba(0, 0, 0, 0.1)'
//                           }
//                       },

//                       animationType: 'scale',
//                       animationEasing: 'elasticOut',
//                       animationDelay: function (idx) {
//                           return Math.random() * 200;
//                       }
//                   }
//               ],
//               color : colors
//             };

//             setTimeout(function(){
//               var myChart = echarts.init(document.getElementById(division_id));
//               myChart.setOption(options);
//             }, 2000);
//       }
//     }
// }]);

// app.directive('circleProgress', ['$compile', function ($compile) {
//     return {
//       restrict: 'EA',
//       template: '',
//       link: function (scope, element, attrs) {

//         var division_id = attrs.id;
//         var value = attrs.value;
//         var color1 = attrs.color1;
//         var color2 = attrs.color2;

//         setTimeout(function(){
//           $('#'+division_id).circleProgress({
//             value: value/100,
//             size: 80,
//             fill: {
//               gradient: [color1, color2]
//             }
//           });
//         }, 2000);

//       }
//     }
// }]);


// app.run(function($rootScope) {
//   $rootScope.getformat = function(number, type){
//         var number_return = number;
//         var suffix = "";
//         if(number < 1000){
//             number_return = number;
//         } else if ( number < 1000000){
//             // number_return = Math.round(number/1000);
//             number_return = (number/1000).toFixed(2);
//             suffix = "thousand";
//         } else if ( number < 100000000){
//             // number_return = Math.round(number/1000000);
//             number_return = (number/100000).toFixed(2);
//             suffix = "lacs";
//         } else {
//             // number_return = Math.round(number/1000000);
//             number_return = (number/10000000).toFixed(2);
//             if(number > 0){
//                 suffix = "crore";
//             }
//         }
//         if(type == 1){
//             return number_return+' '+suffix;
//         } else {
//             return suffix;
//         }
//     }
// });
// app.directive('tablePaginate', ['$compile', function ($compile) {
//     return {
//       restrict: 'EA',
//       template: '<div class="row">\
//         <div class="col-md-6 col-6" >\
//         <div class="total-count" ng-if="filter.max_page > 0">Showing <span>{{filter.max_per_page*(filter.page_no-1) + 1}} - {{filter.max_per_page*filter.page_no < total ? filter.max_per_page*filter.page_no : total}}</span> of <span>{{total}}</span></div>\
//         </div>\
//         <div class="col-md-6 col-6" style="text-align: right;">\
//           <button class="btn fl-btn" ng-click="filter.show = (filter.show ? false:true )" ng-class=" filter.show ? \'open\' :\'\' "><i class="icons icon-grid"></i> Filter</button>\
//           <ul class="pagination" ng-if="filter.max_page > 1">\
//             <li class="page-item">\
//               <a class="page-link" href="javascript:;" ng-click="setPage(1)"> << </a>\
//             </li>\
//             <li class="page-item">\
//               <a class="page-link" href="javascript:;" ng-click="setPage(filter.page_no - 1)"> < </a>\
//             </li>\
//             <li class="page-item" ng-repeat="page in pages">\
//               <a class="page-link" href="javascript:;" ng-click="setPage(page)" ng-class="page == filter.page_no ? \'active\' : \'\' ">{{page}}</a>\
//             </li>\
//             <li class="page-item">\
//               <a class="page-link" href="javascript:;" ng-click="setPage(filter.page_no + 1)"> > </a>\
//             </li>\
//             <li class="page-item">\
//               <a class="page-link" href="javascript:;" ng-click="setPage(filter.max_page)"> >> </a>\
//             </li>\
//           </ul>\
//       </div>\
//       </div>',
//       link: function (scope, element, attrs) {
          
//           scope.setPagination = function(){
//             var pages = [];
//             if(scope.filter.page_no == 1){
//                 pages.push(1);    
//                 pages.push(2);    
//                 if(scope.filter.max_page > 2) pages.push(3);    
//             } else {
//                 if(scope.filter.max_page == scope.filter.page_no && scope.filter.max_page > 2){
//                     pages.push(scope.filter.page_no - 2);
//                 }
//                 pages.push(scope.filter.page_no - 1);    
//                 pages.push(scope.filter.page_no);
//                 if(scope.filter.max_page != scope.filter.page_no){
//                     pages.push(scope.filter.page_no + 1);
//                 }
//             }
//             scope.pages = pages;
//           }

//           scope.setPagination();

//           scope.setPage = function(page_number){
//             if(page_number < 1 || page_number > scope.filter.max_page || page_number == scope.page_number){
//               return;
//             }
//             scope.filter.page_no = page_number;
//             scope.setPagination();
//             scope.init();
//           }
//       }
//     }
// }]);