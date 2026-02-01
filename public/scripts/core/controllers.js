app.controller('projectCtrl', function($scope , $http, $timeout , DBService){
 
    $scope.loading = false;
   

    $scope.dataset = [];
    $scope.languages = [];
    $scope.countries = [];
    $scope.clients = [];
    $scope.currency = [];
    $scope.vendor = [];
    $scope.projects = [];
    $scope.formData = {};
    $scope.projectManagers = [];
    $scope.salesManagers = [];
    $scope.studyTypes = [];
    $scope.statusOptions = [];
    $scope.devices = [];
    $scope.securityChecklist = [];
    $scope.all_devices_ids = [];
    $scope.all_checklist_ids = [];
    $scope.dataset = [];
    $scope.stastics = {};
    $scope.surveyDetails = [];
    $scope.statusData = {};

    $scope.filter = {
        page_no : 1,
        max_per_page : 200,
        max_page: 1,
        order_by: '',
        order_type: 'ASC',
        client_id:'',
        project_name:'',
        status:'',
        parent_project_id : ''

    }
    $scope.total = 0;

    $scope.searchProject = '';
$scope.showDropdown = false;

$scope.filteredProjects = function () {
  if (!$scope.searchProject) return $scope.projects;
  return $scope.projects.filter(function (project) {
    return project.project_name.toLowerCase().includes($scope.searchProject.toLowerCase());
  });
};

$scope.selectProject = function (project) {
  $scope.formData.parent_project_id = project.id;
  $scope.searchProject = project.project_name;
  $scope.showDropdown = false;
  $scope.getProjectDetails(); // Trigger your function
};

$scope.hideDropdown = function () {
  setTimeout(function () {
    $scope.showDropdown = false;
    $scope.$apply();
  }, 200); // allow click to register
};


    $scope.formInit = function(project_id){
        $scope.loading = true;
        $scope.project_id = project_id;
        DBService.getCall('/projects/add-init/'+$scope.project_id).then(function(data){
            if (data.success) {
              $scope.languages = data.languages;
              $scope.countries = data.countries;
              $scope.clients = data.clients;
              $scope.currency = data.currency;
              $scope.vendor = data.vendor;
              $scope.projects = data.projects;
              $scope.projectManagers = data.projectManagers;
              $scope.salesManagers = data.salesManagers;
              $scope.studyTypes = data.studyTypes;
              $scope.statusOptions = data.statusOptions;
              $scope.devices = data.devices;
              $scope.securityChecklist = data.securityChecklist;
              $scope.stastics = data.stastics;
              if(data.project_data){
                  $scope.formData = data.project_data;
                  $scope.all_devices_ids = data.all_devices_ids;
                  $scope.all_checklist_ids = data.all_checklist_ids;
                } else {
                    $scope.formData.currency_id = 161;
                }
            } 
            $scope.loading = false;
        });
    };

    $scope.init = function(){
        $scope.loading = true;
        DBService.postCall($scope.filter,'/projects/index-init').then(function(data){
            if(data.success){
                $scope.dataset = data.projects;
                $scope.total = data.total;
                $scope.filter.max_page = Math.ceil($scope.total/$scope.filter.max_per_page);
            }
            $scope.loading = false;
        });
    }

    $scope.getProjectDetails = function(){
        DBService.postCall({project_id : $scope.formData.parent_project_id},'/projects/get-project-detail').then(function(data){
            if(data.success){
                if(data.projectDetailData){
                    $scope.formData = data.projectDetailData;
                    $scope.all_devices_ids = data.all_devices_ids;
                }
            }
        });
    }

    $scope.copyPoject = function(project_id){
        DBService.postCall({project_id : project_id},'/projects/copy-project').then(function(data){
            if(data.success){
                bootbox.alert(data.message);
            }
        });
    }

    $scope.getProjectFilterData = function(){
        DBService.getCall('/projects/get-project-filter-data').then(function(data){
            if(data.success){
                $scope.clients = data.clients;
                $scope.statusOptions = data.statusOptions;
                $scope.countries = data.countries;
                $scope.clients = data.clients;
                $scope.projects = data.projects;
                $scope.projectManagers = data.projectManagers;
                $scope.salesManagers = data.salesManagers;
            }
        });
    }

    $scope.searchInit = function(){

        $scope.filter.page_no = 1;
         $scope.init();


    }

    $scope.refresh = function(){
        $scope.filter = {
            page_no : 1,
            max_per_page : 200,
            max_page: 1,
            order_by: '',
            order_type: 'ASC',
            client_id:'',
            project_name:'',
            status:''

        }

        $scope.init();
    }

    $scope.saveProject = function(){
         $scope.ladda = true;
         $scope.formData.all_devices_ids  = $scope.all_devices_ids;
         $scope.formData.all_checklist_ids  = $scope.all_checklist_ids;
        DBService.postCall($scope.formData,'/projects/save-project').then(function(data){
            if (data.success) {
                bootbox.alert(data.message);
                 
            }else{
                bootbox.alert(data.message);
                $scope.userSubmitted = true;
                

            }
            $scope.ladda = false;
            $scope.init();
           
        });


    }

    $scope.addDevice = function(device_id){
        var index = $scope.all_devices_ids.indexOf(device_id);
        if(index > -1){
            $scope.all_devices_ids.splice(index,1);
        }else{
            $scope.all_devices_ids.push(device_id);
        }

        console.log($scope.all_devices_ids);

    }

    $scope.addChecklist = function(checklist_id){
        var index = $scope.all_checklist_ids.indexOf(checklist_id);
        if(index > -1){
            $scope.all_checklist_ids.splice(index,1);
        }else{
            $scope.all_checklist_ids.push(checklist_id);
        }

    }


    $scope.removePoject = function(id){
        $scope.project_id = id;
        console.log($scope.project_id);
        bootbox.confirm("Are you sure?", function(result){ 
            if(result){

                DBService.getCall('/projects/delete/'+$scope.project_id).then(function(data){
                    if (data.success) {
                        bootbox.alert(data.message);
                    }
                    $scope.indexInit();
                   
                });
            }
        });

    }

    $scope.showPojectSurveyDetails = function(project_id){

        DBService.postCall({project_id : project_id},'/projects/view-project-survey-details').then(function(data){
            if (data.success) {
                $scope.surveyDetails = data.surveyDetails;
            }
           
        });

    }

    $scope.changeStatus = function(project, $index){
        $scope.index = $index;
        $scope.statusData.project_id = project.id;
        $scope.statusData.status_id = project.status_id;
        $scope.statusData.status = project.status;
        $('#changeStatus').modal('show');
    }

    $scope.saveChangeStatus = function(){
        console.log($scope.statusData);
        DBService.postCall($scope.statusData,'/projects/save-status').then(function(data){
            if(data.success){
                bootbox.alert(data.message);
                $('#changeStatus').modal('hide');
                $scope.dataset[$scope.index].status_id = $scope.statusData.status_id;
                $scope.dataset[$scope.index].status = data.status;
            }

        });
    }



    $scope.setCompany = function(value, label){

        $scope.$apply(() => {
            $scope.filter.projectName = label;
            $("#projectName").val(label);
            $scope.filter.parent_project_id = value;
        });
    }
   
});


app.controller('userCtrl', function($scope , $http, $timeout , DBService){
 
    $scope.loading = false;
    $scope.userData = {};

    $scope.ladda = false;

    $scope.dataset = [];
    $scope.user_roles = [];
    $scope.filter = {
        page_no : 1,
        max_per_page : 100,
        max_page: 1,
        order_by: '',
        order_type: 'ASC',
        user_name:'',
        mobile:'',
        email:'',

    }


    $scope.total = 0;



    $scope.init = function(){
        $scope.loading = true;

        DBService.postCall($scope.filter, '/users/init').then(function(data){
            if (data.success) {
              $scope.dataset = data.users;
              $scope.user_roles = data.user_roles;
              console.log($scope.dataset);
              $scope.total = data.total;
              $scope.filter.max_page = Math.ceil($scope.total/$scope.filter.max_per_page);
            } 

            $scope.loading = false;

        });
    };

    $scope.searchInit = function(){

        $scope.filter.page_no = 1;
         $scope.init();


    }

    $scope.addUser = function(){
        $scope.userData = {};
        $('#adduser').modal('show');
    }

    $scope.editUser = function(user){
        $scope.userData = JSON.parse(JSON.stringify(user));
        console.log($scope.userData);
        $('#adduser').modal('show');

    }


    $scope.saveUser = function(){
         $scope.ladda = true;
        DBService.postCall($scope.userData,'/users/saveUser').then(function(data){
            if (data.success) {
                bootbox.alert(data.message);
                 $('#adduser').modal('hide');
                    $scope.init();
                 

            }else{
                bootbox.alert(data.message);
                // $scope.message = data.message;
                $scope.userSubmitted = true;


            }
            $scope.ladda = false;
           
        });



    }

    $scope.removeUser = function(id){
        $scope.user_id = id;
        console.log($scope.user_id);
        bootbox.confirm("Are you sure?", function(result){ 
            if(result){

                DBService.getCall('/users/removeUser/'+$scope.user_id).then(function(data){
                    if (data.success) {
                        bootbox.alert(data.message);
                    }
                    $scope.init();
                   
                });
            }
        });

    }

    $scope.refresh = function(){
        $scope.filter = {
            page_no : 1,
            max_per_page : 100,
            max_page: 1,
            order_by: '',
            order_type: 'ASC',
            user_name:'',
            mobile:'',
            email:'',
            level:''

        }

        $scope.init();
    }
});

app.controller('suplierCtrl', function($scope , $http, $timeout , DBService){
 
    $scope.loading = false;
    $scope.suplierData = {
        data_redirect_ids:[],
    };

    $scope.ladda = false;
   
    $scope.dataset = [];
    $scope.statusOptions = [];
    $scope.data_redirect_ids = [];
    $scope.vendors = [];
    $scope.filter = {
        page_no : 1,
        max_per_page : 100,
        max_page: 1,
        order_by: '',
        order_type: 'ASC',
        user_name:'',
        mobile:'',
        email:'',

    }

    $scope.info = {};
    $scope.total = 0;
    $scope.project_id = 0;

    $scope.init = function(project_id){
        $scope.project_id = project_id;
        $scope.loading = true;

        DBService.postCall({project_id : project_id}, '/supliers/init').then(function(data){
            if (data.success) {
              $scope.dataset = data.suppliers;
              $scope.project = data.project;
            } 

            $scope.loading = false;

        });
    };


    $scope.addEditInit = function(){
        DBService.postCall({},'/supliers/add-edit-init-data').then(function(data){
            if (data.success) {
              $scope.vendors = data.vendors;
              $scope.statusOptions = data.statusOptions;
              $scope.dataToAskOnRedirect = data.dataToAskOnRedirect;
            } 

        });
    };

    $scope.addEditInit();


    $scope.addSuplier = function(){
        $scope.suplierData = {};
        $('#add_suplier').modal('show');
    }

    $scope.editSuplier = function(supplier){
        $scope.suplierData = JSON.parse(JSON.stringify(supplier));
        $('#add_suplier').modal('show');

    }


    $scope.saveSuplier = function(){
         $scope.ladda = true;
         $scope.suplierData.project_id = $scope.project_id;
         $scope.suplierData.data_redirect_ids = $scope.data_redirect_ids;
        DBService.postCall($scope.suplierData,'/supliers/saveSuplier').then(function(data){
            if (data.success) {
                bootbox.alert(data.message);
                 $('#add_suplier').modal('hide');

            }else{
                bootbox.alert(data.message);

            }
            $scope.ladda = false;
            $scope.init($scope.project_id);

           
        });


    }

    $scope.adddataToAskRedirect = function(data_redirect_ids, redirect_id){
        var index = data_redirect_ids.indexOf(redirect_id);
        if(index > -1){
            data_redirect_ids.splice(index,1);
        }else{
            data_redirect_ids.push(redirect_id);
        }

        $scope.data_redirect_ids = data_redirect_ids;

        console.log(data_redirect_ids);

    }

    $scope.removeSuplier = function(id){
        $scope.suplier_id = id;
        console.log($scope.suplier_id);
        bootbox.confirm("Are you sure?", function(result){ 
            if(result){

                DBService.getCall('/supliers/removeSuplier/'+$scope.suplier_id).then(function(data){
                    if (data.success) {
                        bootbox.alert(data.message);
                    }
                     $scope.init($scope.project_id);
                });
            }
        });

    }

    $scope.refresh = function(){
        $scope.filter = {
            page_no : 1,
            max_per_page : 100,
            max_page: 1,
            order_by: '',
            order_type: 'ASC',
            user_name:'',
            mobile:'',
            email:'',
            level:''

        }

        $scope.init();
    }

    $scope.checkCPI = function(){ // vikram
        var cost_per_complete = $scope.suplierData.cost_per_complete;
        var cpc = $scope.project.cpc;

        if(cpc*0.6 < cost_per_complete){
            $scope.suplierData.cost_per_complete = null;
        }
    }

    // $scope.checkCPI = function(){ // devesh
    //     var cost_per_complete = $scope.suplierData.cost_per_complete;
    //     if(cost_per_complete > $scope.project.cpc){
    //         $scope.suplierData.cost_per_complete = null;
    //     }
    // }


    $scope.getVendorDetails = function(){
        DBService.postCall({
            vendor_id : $scope.suplierData.vendor_id, 
            project_id : $scope.project_id
        },'/supliers/get-vendor-details').then(function(data){
            if (data.success) {
                $scope.suplierData.completeLink = data.vendor.completeLink;
                $scope.suplierData.disqualifyLink = data.vendor.disqualifyLink;
                $scope.suplierData.qoutafullLink = data.vendor.qoutafullLink;
                $scope.suplierData.securityTermlink = data.vendor.securityTermlink;
            }
        });
    }

    $scope.viewSurveyDetails = function(supplier,status){
        $scope.info.newUrl = supplier.newUrl;
        $scope.info.newTestUrl = supplier.newTestUrl;;
        DBService.postCall({
            pid : supplier.project_id,
            gid : supplier.id,
            status : status
        },'/supliers/show-project-suplier-survey-details').then(function(data){
            if (data.success) {
                $scope.suplierSurveyDetails = data.suplierSurveyDetails;
                $('#suplier_survey_info').modal('show');
            }
        });
    }

    $scope.exportSurveyExcel = function(){
        $scope.export = true;
        DBService.postCall($scope.suplierSurveyDetails,'/supliers/export').then(function(data){
            if (data.success) {
                window.open(data.excel_link,"_blank");
            } 
            $scope.export = false;
        });
    }

});

app.controller('projectDetailCtrl', function($scope , $http, $timeout , DBService){
 
    $scope.loading = false;
    $scope.ladda = false;
    $scope.dataset = [];
    $scope.filter = {
        page_no : 1,
        max_per_page : 200,
        max_page: 1,
    }
    $scope.total = 0;

    $scope.init = function(project_id, status){
        $scope.project_id = project_id;
        $scope.filter.project_id = $scope.project_id;
        $scope.filter.status = status;
        $scope.loading = true;
        DBService.postCall($scope.filter, '/projects/show-project-survey-details').then(function(data){
            if (data.success) {
                if($scope.filter.export == 1){
                    window.open(data.excel_link,"_blank");
                } else {
                    $scope.dataset = data.surveyInformations;
                    $scope.total = data.total;
                    $scope.filter.max_page = Math.ceil($scope.total/$scope.filter.max_per_page);
                }
              
            } 
            $scope.loading = false;
            $scope.export = false;
            $scope.filter.export = 0;

        });
    };


    $scope.filterSurveyData = function(){
        DBService.getCall('/projects/get-project-survey-filter-data').then(function(data){
            if(data.success){
                $scope.countries = data.countries;
                $scope.surveyStatusOptions = data.surveyStatusOptions;
            }
        });
    }

    $scope.exportExcel = function(){
        $scope.export = true;
        $scope.filter.export = 1;
        $scope.init($scope.project_id, $scope.filter.status);
    }

    $scope.searchData = function(){
        $scope.init($scope.project_id, $scope.filter.status);
    }

    $scope.filterSurveyData();


    $scope.refresh = function(){
        $scope.filter = {
            page_no : 1,
            max_per_page : 200,
            max_page: 1,
        }

        $scope.init($scope.project_id, $scope.filter.status);
    }
});


app.controller('qualificationCtrl', function($scope , $http, $timeout , DBService){
 
    $scope.loading = false;

    $scope.ladda = false;
   
    $scope.dataset = [];

    $scope.options = [$scope.data = {}];

    $scope.qualificationData = {};
    $scope.total = 0;
    $scope.project_id = 0;

    $scope.question_ids = [];
    $scope.questions = [];

    $scope.init = function(project_id){
        $scope.project_id = project_id;
        $scope.loading = true;

        DBService.postCall({project_id : $scope.project_id},'/qualifications/init').then(function(data){
            if(data.success) {
                $scope.dataset = data.questions;
                $scope.question_ids = data.question_ids;

                // if(data.surveyId && data.project.client_api_data){
                //     $scope.fetchApiQuestion();
                // }
            } 

            $scope.loading = false;

        });
    };


    $scope.addQalification = function(){
        $scope.question_id = 0;
        $scope.qualificationData = {};
        $scope.options = [$scope.data = {}];
        $('#add_qalification').modal('show');
    }

    $scope.editQalification = function(question){
        DBService.postCall({question_id : question.id},'/qualifications/edit-data').then(function(data){
            if (data.success) {
                $scope.qualificationData = data.qualificationData;
                $scope.options = data.options;
                $scope.question_id = $scope.qualificationData.id;
                 $('#add_qalification').modal('show');
            }
            $scope.ladda = false;
        });
    }

    $scope.addMoreOptoin = function(){
        $scope.options.push($scope.data = {});
    }

    $scope.removeOptoin = function(index){
        $scope.options.splice(index,1);
    }

    $scope.checkAll = function(){

        if($scope.check_all){
          for (var i = 0; i < $scope.dataset.length; i++) {
             $scope.question_ids.push($scope.dataset[i].id);
          }
        } else {
          $scope.question_ids = [];
        }
    }

    $scope.addItem = function(value){
        
        var index = $scope.question_ids.indexOf(value);
        if( index > -1 ){
          $scope.question_ids.splice(index, 1);
        } else {
          $scope.question_ids.push(value);
        }

        console.log($scope.question_ids);
    }




    $scope.saveQualification = function(){
        $scope.ladda = true;
        $scope.qualificationData.question_id = $scope.question_id;
        DBService.postCall({
            qualificationData : $scope.qualificationData,
            options : $scope.options
        },'/qualifications/store').then(function(data){
            if (data.success) {
                bootbox.alert(data.message);
                $scope.init();
                 $('#add_qalification').modal('hide');

            }else{
                bootbox.alert(data.message);

            }
            $scope.ladda = false;
        });
    }

    $scope.removeQualification = function(id,index){
        bootbox.confirm("Are you sure?", function(result){ 
            if(result){
                DBService.getCall('/qualifications/delete/'+id).then(function(data){
                    if (data.success) {
                        bootbox.alert(data.message);
                    }
                     $scope.dataset.splice(index,1);
                });
            }
        });
    }

    $scope.applyQualification = function(){
        bootbox.confirm("Are you sure?", function(result){ 
            if(result){
                DBService.postCall({question_ids : $scope.question_ids, project_id : $scope.project_id},'/qualifications/apply-qualification').then(function(data){
                    if (data.success) {
                        bootbox.alert(data.message);
                    }
                });
            }
        });
    }

    $scope.fetchApiQuestion = function(){
        $scope.question_processing = true;
        DBService.postCall({project_id : $scope.project_id},'/qualifications/fetch-api-question').then(function(data){
            if (data.success) {
                $scope.questions = data.questions;
                window.location.reload();
            }
        $scope.question_processing = false;

        });
    }

    $scope.manageOption = function(){
        $scope.option_processing = true;
        DBService.postCall({
            questions : $scope.questions,
            project_id : $scope.project_id},
            '/qualifications/manage-option').then(function(data){
            if (data.success) {
                window.location.reload();
            }
        $scope.option_processing = false;

        });
    }

    $scope.manageOptionAnswer = function(){
        $scope.option_answer_processing = true;
        DBService.postCall({project_id : $scope.project_id},'/qualifications/manage-option-answer').then(function(data){
            if (data.success) {
                window.location.reload();
            } else {
                bootbox.alert(data.message);
            }
        $scope.option_answer_processing = false;

        });
    }

    $scope.fetchQuestions = function(){
        DBService.postCall({project_id : $scope.project_id},'/qualifications/fetch-question').then(function(data){
            if (data.success) {
                $scope.questions = data.questions;
                $('#question_model').modal('show');
            }
        });
    }
        

});

app.controller('dashboardCtrl', function($scope , $http, $timeout , DBService){
 
    $scope.loading = false;

    $scope.ladda = false;
   
    $scope.dataset = [];

    $scope.complets = [];
    $scope.disqualifies = [];
    $scope.quotaFulls = [];
    $scope.securityTerm = [];
    $scope.drops = [];
    $scope.todayDetails = [];


    $scope.completsMonthly = [];
    $scope.disqualifiesMonthly = [];
    $scope.quotaFullsMonthly = [];
    $scope.securityTermMonthly = [];
    $scope.dropsMonthly = [];
    $scope.todayDetailsMonthly = [];

    $scope.biddings = [];
    $scope.testings = [];
    $scope.runnings = [];
    $scope.holds = [];
    $scope.completed = [];
    $scope.awaitings = [];
    $scope.closed = [];

    $scope.completPercentage = 0;
    $scope.disqualifyPercentage = 0;
    $scope.quotaFullPercentage = 0;
    $scope.securityTermPercentage = 0;


    $scope.init = function(){
        $scope.loading = true;

        DBService.postCall({},'/dashboard-init').then(function(data){
            if(data.success) {
              $scope.dataset = data.surveyInformations;
              $scope.complets = [];
              $scope.disqualifies = [];
              $scope.quotaFulls = [];
              $scope.securityTerm = [];
              $scope.drops = [];
              $scope.todayDetails = [];
              $scope.dailyStastics();
            } 

            $scope.loading = false;

        });
    };

    setInterval(function(){
      $scope.init();
    }, 60000);

    $scope.dailyStastics = function(){


        for (var i = 0; i < $scope.dataset.length; i++) {
            if($scope.dataset[i].status == 0){
                $scope.drops.push($scope.dataset[i]);
            }

            if($scope.dataset[i].status == 1){
                $scope.complets.push($scope.dataset[i]);
            }

            if($scope.dataset[i].status == 2){
                $scope.disqualifies.push($scope.dataset[i]);
            }

            if($scope.dataset[i].status == 3){
                $scope.quotaFulls.push($scope.dataset[i]);
            }

            if($scope.dataset[i].status == 4){
                $scope.securityTerm.push($scope.dataset[i]);
            }
        }
    }

    $scope.showDailyFullDetails = function(type){ 
        if(type == 1){
            $scope.type = "Complete";
            $scope.todayDetails = $scope.complets;
        }if(type == 2){
            $scope.type = "Disqualify";
            $scope.todayDetails = $scope.disqualifies;
        }if(type == 3){
            $scope.type = "Quota Full";
            $scope.todayDetails = $scope.quotaFulls;
        }if(type == 4){
            $scope.type = "Security Term";
            $scope.todayDetails = $scope.securityTerm;
        }if(type == 0){
            $scope.type = "Drop";
            $scope.todayDetails = $scope.drops;
        }
        $('#daily_survey_model').modal('show');
    }

    $scope.projectStatus = function(){

         DBService.postCall({},'/dashboard-project-status-init').then(function(data){
            if(data.success) {
              $scope.projectStatus = data.projectStatus;
              $scope.projectStatusInfo();
            } 

            $scope.loading = false;

        });

    }

    $scope.projectStatus();

    $scope.projectStatusInfo = function(){

        for (var i = 0; i < $scope.projectStatus.length; i++) {

            if($scope.projectStatus[i].status == 1){
                $scope.biddings.push($scope.projectStatus[i]);
            }

            if($scope.projectStatus[i].status == 2){
                $scope.testings.push($scope.projectStatus[i]);
            }

            if($scope.projectStatus[i].status == 3){
                $scope.runnings.push($scope.projectStatus[i]);
            }

            if($scope.projectStatus[i].status == 4){
                $scope.holds.push($scope.projectStatus[i]);
            }

            if($scope.projectStatus[i].status == 5){
                $scope.completed.push($scope.projectStatus[i]);
            }

            if($scope.projectStatus[i].status == 6){
                $scope.awaitings.push($scope.projectStatus[i]);
            }

            if($scope.projectStatus[i].status == 7){
                $scope.closed.push($scope.projectStatus[i]);
            }

        }
    }

    $scope.showDailyFullProjectDetails = function(projectType){ 
        if(projectType == 1){
            $scope.projectType = "Biddings";
            $scope.todayProjectDetails = $scope.biddings;
        }if(projectType == 2){
            $scope.projectType = "Testings";
            $scope.todayProjectDetails = $scope.testings;
        }if(projectType == 3){
            $scope.projectType = "Runnings";
            $scope.todayProjectDetails = $scope.runnings;
        }if(projectType == 4){
            $scope.projectType = "Holds";
            $scope.todayProjectDetails = $scope.holds;
        }if(projectType == 5){
            $scope.projectType = "Completed";
            $scope.todayProjectDetails = $scope.completed;
        }if(projectType == 6){
            $scope.projectType = "Awaitings - IDs";
            $scope.todayProjectDetails = $scope.awaitings;
        }if(projectType == 7){
            $scope.projectType = "Closed";
            $scope.todayProjectDetails = $scope.closed;
        }

        $('#daily_survey_project_model').modal('show');

    }


    $scope.monthlyStastic = function(){

         DBService.postCall({},'/dashboard-monthly-stastics').then(function(data){
            if(data.success) {
              $scope.monthlyStastics = data.monthlyStastics;
              $scope.projectmonthlyStastic();
            } 

        });

    }

    $scope.monthlyStastic();

    $scope.projectmonthlyStastic = function(){


        for (var i = 0; i < $scope.monthlyStastics.length; i++) {
            if($scope.monthlyStastics[i].status == 0){
                $scope.dropsMonthly.push($scope.monthlyStastics[i]);
            }

            if($scope.monthlyStastics[i].status == 1){
                $scope.completsMonthly.push($scope.monthlyStastics[i]);
            }

            if($scope.monthlyStastics[i].status == 2){
                $scope.disqualifiesMonthly.push($scope.monthlyStastics[i]);
            }

            if($scope.monthlyStastics[i].status == 3){
                $scope.quotaFullsMonthly.push($scope.monthlyStastics[i]);
            }

            if($scope.monthlyStastics[i].status == 4){
                $scope.securityTermMonthly.push($scope.monthlyStastics[i]);
            }
        }

        $scope.completPercentage = ($scope.completsMonthly.length/$scope.monthlyStastics.length)*100;
        $scope.disqualifyPercentage = ($scope.disqualifiesMonthly.length/$scope.monthlyStastics.length)*100;
        $scope.quotaFullPercentage = ($scope.quotaFullsMonthly.length/$scope.monthlyStastics.length)*100;
        $scope.securityTermPercentage = ($scope.securityTermMonthly.length/$scope.monthlyStastics.length)*100;
    }

    $scope.exportTodayStasticsExcel = function(){
        $scope.export = true;
        DBService.postCall($scope.todayDetails,'/dashboard-daily-stats-export').then(function(data){
            if (data.success) {
                window.open(data.excel_link,"_blank");
            } 
            $scope.export = false;
        });
    }

});

app.controller('clientApiDataCtrl', function($scope , $http, $timeout , DBService){
 
    $scope.loading = false;

    $scope.ladda = false;
    $scope.settingData = {};
    $scope.dataset = [];
    $scope.countries = [];
    $scope.project_ids = [];
    $scope.formData = {};

    $scope.filter = {
        page_no : 1,
        max_per_page : 200,
        max_page: 1,
        order_by: '',
        order_type: 'ASC',
        client_id:'',
        project_name:'',
        status:'',
        parent_project_id : ''
    }

    $scope.total = 0;

    $scope.fetchData = function(project_id){
        $scope.loading = true;

        DBService.getCall('/client-api-data/fetch-data').then(function(data){
            if(data.success) {
                $scope.init();
                bootbox.alert(data.message);
            } else {
                bootbox.alert(data.message);
            }

            $scope.loading = false;

        });
    };

    $scope.checkProject = function(id){

        var idx = $scope.project_ids.indexOf(id);
        if(idx == -1){
            $scope.project_ids.push(id);
        } else {
            $scope.project_ids.splice(idx,1);
        }
    }

    $scope.selectAllProject = function(){

        if($scope.formData.select_all){

            for (var i = 0; i < $scope.dataset.length; i++) {
                $scope.project_ids.push($scope.dataset[i].id);
            }

        } else {
            $scope.project_ids = [];
        }
        console.log($scope.project_ids);
    }

    $scope.init = function(){
        $scope.loading = true;
        DBService.postCall($scope.filter,'/client-api-data/init').then(function(data){
            if(data.success) {
              $scope.dataset = data.clientData;
              $scope.total = data.total;
              $scope.filter.max_page = Math.ceil($scope.total/$scope.filter.max_per_page);
            } 
            $scope.loading = false;
        });
    }

    $scope.bulkOperation = function(type){
        bootbox.confirm("Are you sure?", function(result){ 
            if(result){
                if(type == 1) $scope.processing_delete = true;
                if(type == 2) $scope.processing_approved = true;
                if(type == 3) $scope.processing_disapproved = true;
                DBService.postCall({type : type, project_ids : $scope.project_ids},'/client-api-data/operation').then(function(data){
                    if(data.success) {
                      bootbox.alert(data.message);
                      $scope.init();
                    } 
                    $scope.processing_delete = false;
                    $scope.processing_approved = false;
                    $scope.processing_disapproved = false;
                });
            }
        });
    }

    $scope.initClient = function(){
        DBService.postCall({},'/client-api-data/get-clients').then(function(data){
            if(data.success) {
              $scope.clients = data.clients;
            } 
        });
    }

    $scope.initClient();

    $scope.allSettings = function(){
        DBService.postCall({},'/client-api-data/all-settings').then(function(data){
            if(data.success) {
              $scope.countries = data.countries;
            } 
        });
    }

    $scope.allSettings();

    $scope.apiSettings = function(){
        $("#setting_modal").modal("show");   
    }

    $scope.saveAPISettings = function(){
        DBService.postCall($scope.settingData,'/client-api-data/save-api-settings').then(function(data){
            if(data.success) {
              bootbox.alert(data.message);
              $("#setting_modal").modal("hide");   
            } 
        });
    }

    $scope.apiCountries = function(){
        DBService.getCall('/client-api-data/client-wise-country').then(function(data){
            if(data.success) {
                $scope.countries = data.countries;
                $("#country_modal").modal("show");   
            } else {
              bootbox.alert(data.message);
            }
        });
    }

    $scope.getCountries = function(){
        $scope.country_processing = true;
        DBService.getCall('/client-api-data/get-country').then(function(data){
            if(data.success) {
                $scope.countries = data.countries;
            } else {
              bootbox.alert(data.message);
            }
        $scope.country_processing = false;
        });
    }

    $scope.removeClientProject = function(id,index){
        $scope.project_id = id;
        bootbox.confirm("Are you sure?", function(result){ 
            if(result){

                DBService.getCall('/client-api-data/delete/'+$scope.project_id).then(function(data){
                    if (data.success) {
                        bootbox.alert(data.message);
                    }
                    $scope.dataset.splice(index,1);
                   
                });
            }
        });
    }

    $scope.changeClientProjectStatus = function(survey){
        $scope.project_id = survey.id;
        bootbox.confirm("Are you sure?", function(result){ 
            if(result){

                DBService.getCall('/projects/approved/'+$scope.project_id).then(function(data){
                    if (data.success) {
                        survey.approved = data.approve;
                    }
                   
                });
            }
        });
    }
});

app.controller("SettingsController", function($scope, $http, DBService, Upload) {
    
    $scope.formData = {};
    $scope.settings = [];

    $scope.uploadFile = function (file, name, object) {
        object.uploading = true;
        var url = base_url+'/upload-file';
        Upload.upload({
            url: url,
            data: {
                media: file
            }
        }).then(function (resp) {
            console.log(resp);
            if(resp.data.success){
                object[name] = resp.data.media;
            } else {
                alert(resp.data.message);
            }
            object.uploading = false;
        }, function (resp) {
            console.log('Error status: ' + resp.status);
            object.uploading = false;
        }, function (evt) {
            $scope.uploading_percentage = parseInt(100.0 * evt.loaded / evt.total) + '%';
        });
    }

    $scope.removeFile = function(name){
        $scope.formData[name] = '';
        console.log($scope.formData);
    }

    $scope.onSubmit = function(){
        $scope.processing = true;
        DBService.postCall($scope.formData,'/setting/store').then(function(data){
            if(data.success) {
              bootbox.alert(data.message);
            } 
        $scope.processing = false;
        });
    }

    $scope.init = function(){
        $scope.loading = true;
        DBService.postCall({},'/setting/init').then(function(data){
            if(data.success) {
                $scope.settings = data.settings;
                for (var i = 0; i < $scope.settings.length; i++) {
                    var paramName = $scope.settings[i].param;
                    $scope.formData[paramName] = $scope.settings[i].value;
                }
            } 
        $scope.loading = false;
        });
    }



});




































