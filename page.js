'use strict';

angular.module('app', ['angularFileUpload', 'ngCkeditor']).controller('AppController', ['$scope', 'FileUploader','$http',  function($scope, FileUploader,$http) {
     $scope.url = 'page.php'; // The url of our api
     
	/*** tap  **/
     this.tab = 1;
     this.selectTab = function(setTab){
         this.tab = setTab;
     };
     this.isSelected = function(checkTab){
         return this.tab === checkTab;
     };
	
	// Load all available data Project
	$scope.project={};
	getProject(); 
	function getProject(){
		$http.get($scope.url+"?project").success(function(data){
			// set default value if no data found
			if(data === 'false'){
				
				$scope.project.picture ='https://scontent-mrs1-1.xx.fbcdn.net/hphotos-xfl1/v/t1.0-9/10294511_961876703902262_1391347360913734571_n.jpg?oh=68fe2445eb387aa1d7fe1552f1d70437&oe=574C80CD',$scope.project.id='';
			}else{
				$scope.project = data;
			}
			
		});
	}
	
	// Load all available countrie Names
	getCountries();  
	function getCountries(){
		$http.get($scope.url+"?countries").success(function(data){
			$scope.countries = data;
		});
	}
	
	// get cathegories data values
     $http.get($scope.url+"?get_cathegorie").success(function(data){
 	    /** check box for selecting cathegories **/
 		    $scope.data = [
 		        {id: 'Animal Welfare', count: 0, checked: false},
 		        {id: 'Children', count: 0, checked: false},
 		        {id: 'Education', count: 0, checked: false},
 		        {id: 'Immigration & Refugees', count: 0, checked: false},
 		        {id: 'Homeless & Housing', count: 0, checked: false},
 		        {id: 'Humanitarian Relief', count: 0, checked: false},
 		        {id: 'Senior Citizen', count: 0, checked: false},
 		        {id: 'Youth Development', count: 0, checked: false},
 		        {id: 'Arts & Culture', count: 0, checked: false},
 		        {id: 'Community Development', count: 0, checked: false},
 		        {id: 'Environment', count: 0, checked: false},
 		        {id: 'Health', count: 0, checked: false},
 		        {id: 'Human & Civil Rights', count: 0, checked: false},
 		        {id: 'Peace', count: 0, checked: false},
 		        {id: 'Woman', count: 0, checked: false}

 		    ];
	  
     });

     $scope.increment = function(at) {
         $scope.data[at].count += 1;
     };
     $scope.selected = function() {
         var i, selectedCount = 0;
         for (i = 0; i < $scope.data.length; i++) {
             if ($scope.data[i].checked) {
                 selectedCount += 1;
             }
         }
         return selectedCount;
     };
	
   // initialitate ng-upload foruploading the pictue
    var uploader = $scope.uploader = new FileUploader({
        url: $scope.url
    });

    // FILTERS
    uploader.filters.push({
        name: 'customFilter',
        fn: function(item /*{File|FileLikeObject}*/,    options) {
            return this.queue.length < 1;
        }
    });

    // customer method to check status of the upload
    uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
        console.info('onWhenAddingFileFailed', item, filter, options);
    };
    uploader.onAfterAddingFile = function(fileItem) {
        console.info('onAfterAddingFile', fileItem);
    };
    uploader.onAfterAddingAll = function(addedFileItems) {
        console.info('onAfterAddingAll', addedFileItems);
    };
    uploader.onBeforeUploadItem = function(item) {
        console.info('onBeforeUploadItem', item);
    };
    uploader.onProgressItem = function(fileItem, progress) {
        console.info('onProgressItem', fileItem, progress);
    };
    uploader.onProgressAll = function(progress) {
        console.info('onProgressAll', progress);
    };
    uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
    };
    uploader.onErrorItem = function(fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
    };
    uploader.onCancelItem = function(fileItem, response, status, headers) {
        console.info('onCancelItem', fileItem, response, status, headers);
    };
    uploader.onCompleteItem = function(fileItem, response, status, headers) {
        console.info('onCompleteItem', fileItem, response, status, headers);
    };
    uploader.onCompleteAll = function() {
        console.info('onCompleteAll');
    };
    
    /*  Save or update project data */
    $scope.outputdata ={};
    $scope.saveProject = function() {
        if($scope.form.$valid){
	     var values = {
			     'id': $scope.project.id,
		  		'title':$scope.project.title,
		   		'short_blurd' :$scope.project.short_blurd,
		   		'picture':'',
		  		'country':$scope.project.country,
		   		'city':$scope.project.city,
			     'cathegories': $scope.data
	           };
	           $http.post($scope.url, values).success(function(data, status, headers, config)  {   
				
	               console.log(status + ' - ' + data);
				$scope.outputdata =data;
				getProject();
				$scope.showMessageSave = false;
	           }).error(function(data, status, headers, config)
	           {
	               console.log('error');
				$scope.showMessageError = false;
	           });
				 		 
        }else{
		   $scope.showMessageError = false;
            console.log('Unable to save. Validation error!');
   	   }
    };
    
    /*  Delete project data */
    $scope.deleteProject = function() {
		$http.get($scope.url+"?deleteProject="+$scope.project.id).success(function(data, status, headers, config){
			getProject();
			console.log(data);
		});
    };
    
    // add per in the db
    $scope.perks = [];
    
  
  	$http.get($scope.url+"?getperks").then(function(data) {
   	     $scope.perks = data.data;
	});
	    

    $scope.addPerk = function () {
        $scope.perks.push({ title: $scope.pTitle, cost: $scope.pCost, delivery: $scope.pdelivery, deliverydate: $scope.pdeliverydate, description: $scope.p_description, deleted: false, edit: false});
	   var data = { ptitle: $scope.pTitle, cost: $scope.pCost, delivery: $scope.pdelivery, deliverydate: $scope.pdeliverydate, description: $scope.p_description};
        
        $http.post($scope.url, data).success(function(data, status, headers, config)  {   
            console.log(status + ' - ' + data);
        }).error(function(data, status, headers, config)
        {
          console.log('error');
		$scope.showMessageError = false;
        });
	   
	 
	   $scope.pTitle = "";
        $scope.pCost = "";
        $scope.pdelivery= "";
        $scope.pdeliverydate= "";
        $scope.p_description= "";
    };
    
    // Delte perk
    $scope.deletePerk = function (perk) {
        //$scope.perks[perk].deleted = true;
	   //console.log(index);
	   var index = $scope.perks.indexOf(perk);
	     $scope.perks.splice(index, 1); 
		
	  	$http.get($scope.url+"?deleteperk="+perk.pid).then(function(data) {
	   	     $scope.perks = data.data;
		});
		alert(perk.pid);
				
				
    };

    // save Perk
    $scope.savePerk = function (index) {
        $scope.perks[index].edit = false;
    };

    /* accordinion defintion on perk */
    $scope.class = "glyphicon glyphicon-chevron-right";
    $scope.changeClass = function(){
        if ($scope.class === "glyphicon glyphicon-chevron-right")
            $scope.class = "glyphicon glyphicon-chevron-down";
        else
            $scope.class = "glyphicon glyphicon-chevron-right";

    };


}]).directive('ngThumb', ['$window', function($window) {
   // custom directive to show image preview before upload
    var helper = {
        support: !!($window.FileReader && $window.CanvasRenderingContext2D),
        isFile: function(item) {
            return angular.isObject(item) && item instanceof $window.File;
        },
        isImage: function(file) {
            var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
            return '|jpg|png|jpeg|gif|'.indexOf(type) !== -1;
        }
    };

    return {
        restrict: 'A',
        template: '<canvas/>',
        link: function(scope, element, attributes) {
            if (!helper.support) return;

            var params = scope.$eval(attributes.ngThumb);

            if (!helper.isFile(params.file)) return;
            if (!helper.isImage(params.file)) return;

            var canvas = element.find('canvas');
            var reader = new FileReader();

            reader.onload = onLoadFile;
            reader.readAsDataURL(params.file);

            function onLoadFile(event) {
                var img = new Image();
                img.onload = onLoadImage;
                img.src = event.target.result;
            }

            function onLoadImage() {
                var width = params.width || this.width / this.height * params.height;
                var height = params.height || this.height / this.width * params.width;
                canvas.attr({ width: width, height: height });
                canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
            }
        }
    };
}]).directive('ckEditor', function () {
	// CKEditor directive
    return {
        require: '?ngModel',
        link: function (scope, elm, attr, ngModel) {
            var ck = CKEDITOR.replace(elm[0]);
            if (!ngModel) return;
            ck.on('instanceReady', function () {
                ck.setData(ngModel.$viewValue);
            });
            function updateModel() {
                scope.$apply(function () {
                    ngModel.$setViewValue(ck.getData());
                });
            }
            ck.on('change', updateModel);
            ck.on('key', updateModel);
            ck.on('dataReady', updateModel);

            ngModel.$render = function (value) {
                ck.setData(ngModel.$viewValue);
            };
        }
    };
});

/***** bostrap accordion with chevron *****/
function toggleChevron(e) {
    $(e.target)
        .prev('.apanel-heading')
        .find("i.indicator")
        .toggleClass('glyphicon-chevron-down glyphicon-chevron-right');
}

function toggleChevron2(e) {
    $(e.target)
        .prev('.apanel-heading')
        .find("i.indicator")
        .toggleClass('glyphicon-chevron-down glyphicon-chevron-right');
}

$( document ).ready(function() {

    $('#sidebar').affix({
        offset: {
            top: 245
        }
    });

    var $body   = $(document.body);
    var navHeight = $('.navbar').outerHeight(true) + 10;

    $body.scrollspy({
        target: '#leftCol',
        offset: navHeight
    });

    $('#accordion').on('hidden.bs.collapse', toggleChevron);
    $('#accordion').on('shown.bs.collapse', toggleChevron);

    $('#accordio').on('hidden.bs.collapse', toggleChevron2);
    $('#accordio').on('shown.bs.collapse', toggleChevron2);

    console.log( "ProjectPie Dom is ready!" );
});

