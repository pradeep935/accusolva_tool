@extends('admin.layout')
@section('content')
<style type="text/css">
   .lds-facebook {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
 }
 .lds-facebook div {
    display: inline-block;
    position: absolute;
    left: 8px;
    width: 16px;
    background: linear-gradient(45deg,grey,grey);
    animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
 }
 .lds-facebook div:nth-child(1) {
    left: 8px;
    animation-delay: -0.24s;
 }
 .lds-facebook div:nth-child(2) {
    left: 32px;
    animation-delay: -0.12s;
 }
 .lds-facebook div:nth-child(3) {
    left: 56px;
    animation-delay: 0;
 }
 @keyframes lds-facebook {
    0% {
     top: 8px;
     height: 64px;
  }
  50%, 100% {
     top: 24px;
     height: 32px;
  }
}

.col-xl-3 {
  flex: 0 0 25% !important;
  max-width: 14% !important;
}

.sticky-table-header {
 overflow: scroll;
 max-height: 450px;
}

.sticky-table-header thead {
 position: sticky;
 top: 0;
 background-color: #f2f2f2;
}

</style>
<div class="container-flued mt-1 p-1" ng-controller="dashboardCtrl" ng-init="init()" >
   <div class="card">
      <div class="card-header">
         <div class="row">
            <div class="col-md-6">
               <h3 class="text-muted">Today's Project Statistics</h3>
            </div>
            <div class="col-md-6 text-right">
               <a href="{{ url('/export-dashboard') }}" class="btn btn-warning"> Export Dashboard</a>
            </div>
            <div>
         <div class="lds-facebook " ng-if="loading"><div></div><div></div><div></div></div>
      </div>
      
      <div class="card-body">
         <div class="main-content-body mt-2">
            <div class="row row-sm">
               <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a  ng-click="showDailyFullDetails(1)" class="text-info">
                              <div class="project-content">
                                 <h6>Completed</h6>
                                 <ul>
                                    <li>
                                       <b> @{{complets.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullDetails(2)" class="text-danger">
                              <div class="project-content">
                                 <h6>Disqualify</h6>
                                 <ul>
                                    <li>
                                       <b>@{{disqualifies.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullDetails(3)" class="text-warning">
                              <div class="project-content">
                                 <h6>Quota Full</h6>
                                 <ul>
                                    <li>
                                       <b>@{{quotaFulls.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullDetails(4)" class="text-secondary">
                              <div class="project-content">
                                 <h6>Security Term</h6>
                                 <ul>
                                    <li>
                                       <b>@{{securityTerm.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullDetails(0)" class="text-success">
                              <div class="project-content">
                                 <h6>Drop</h6>
                                 <ul>
                                    <li>
                                       <b>@{{drops.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card">
      <div class="card-body">
         <div class="main-content-body mt-2">
            <div class="row row-sm">
               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullProjectDetails(1)" class="text-primary">
                              <div class="project-content">
                                 <h6>Bidding</h6>
                                 <ul>
                                    <li>
                                       <b>@{{biddings.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullProjectDetails(2)" class="text-warning">
                              <div class="project-content">
                                 <h6>Testing</h6>
                                 <ul>
                                    <li>
                                       <b>@{{testings.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullProjectDetails(3)" class="text-info">
                              <div class="project-content">
                                 <h6>Running</h6>
                                 <ul>
                                    <li>
                                       <b>@{{runnings.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullProjectDetails(4)" class="text-dark">
                              <div class="project-content">
                                 <h6>On Holds</h6>
                                 <ul>
                                    <li>
                                       <b>@{{holds.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullProjectDetails(6)" class="text-secondary">
                              <div class="project-content">
                                 <h6>Awaiting - IDs</h6>
                                 <ul>
                                    <li>
                                       <b>@{{awaitings.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullProjectDetails(7)" class="text-danger">
                              <div class="project-content">
                                 <h6>Closed</h6>
                                 <ul>
                                    <li>
                                       <b>@{{closed.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                  <div class="card overflow-hidden project-card">
                     <div class="card-body">
                        <div class="d-flex">
                           <a href="#" ng-click="showDailyFullProjectDetails(5)" class="text-success">
                              <div class="project-content">
                                 <h6>Completed</h6>
                                 <ul>
                                    <li>
                                       <b>@{{completed.length}}</b>
                                    </li>
                                 </ul>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="card">
      <div class="card-header">
         <h3 class="text-muted">Monthly Statistics</h3>
      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-3 text-primary">
               <h6>Completed (@{{completPercentage | number : 2}})<hr>@{{completsMonthly.length}}/@{{monthlyStastics.length}}</h6>
            </div>
            <div class="col-md-3 text-info">
               <h6>Disqualified (@{{disqualifyPercentage | number : 2}})<hr>@{{disqualifiesMonthly.length}}/@{{monthlyStastics.length}}</h6>
            </div>
            <div class="col-md-3 text-warning">
               <h6>Quotafull (@{{quotaFullPercentage | number : 2}})<hr>@{{quotaFullsMonthly.length}}/@{{monthlyStastics.length}}</h6>
            </div>
            <div class="col-md-3 text-danger">
               <h6>Security Term (@{{securityTermPercentage | number : 2}})<hr>@{{securityTermMonthly.length}}/@{{monthlyStastics.length}}</h6>
            </div>
            
         </div>
         
      </div>
      
   </div>


   <div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">
               
            </div>
            <div class="card-body">
               
            </div>
            
         </div>
         
      </div>
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">
               
            </div>
            <div class="card-body">
               
            </div>
            
         </div>
         
      </div>
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">
               
            </div>
            <div class="card-body">
               
            </div>
            
         </div>
         
      </div>
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">
               
            </div>
            <div class="card-body">
               
            </div>
            
         </div>
         
      </div>
      
   </div>


   <div class="modal fade bd-example-modal-xl" id="daily_survey_model" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-xl">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">@{{type}}</h4>
           <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
        <div class="modal-body">
           <div class="row row-sm">
             <div class="col-md-12 text-right">
               <a class="btn btn-warning" ng-click="exportTodayStasticsExcel()" ng-disabled="export">Export <div class="spinner-border spinner-border-sm" role="status" ng-show="export"></div>
               </a>
            </div>
            <div class="col-xl-12">
               <div class="card">
                 <div class="card-header pb-0">
                 </div>
                 <div class="card-body" style="overflow: scroll; height: 500px;">
                   <div class="table-responsive">
                     <div class="sticky-table-header">
                       <table class="table table-hover table-bordered">
                         <thead>
                           <tr>
                             <th>SN</th>
                             <th>ID</th>
                             <th>Suplier ID</th>
                             <th>Suplier Name</th>
                             <th>Our po</th>
                             <th>Client</th>
                             <th>Start IP</th>
                             <th>End IP</th>
                             <th>Start Time</th>
                             <th>End Time</th>
                             <th>Start Date</th>
                             <th>End Date</th>
                             <th>Ref Id</th>
                             <th>UID</th>
                             <th>Country</th>
                          </tr>
                       </thead>
                       <tbody>
                        <tr ng-repeat="project in todayDetails track by $index">
                          <td>@{{ $index+1 }}</td>
                          <td>@{{project.pid}}</td>
                          <td>@{{project.gid}}</td>
                          <td>@{{project.vendorName ? project.vendorName : "Internal Team"}}</td>
                          <td>@{{project.project_name}}</td>
                          <td>@{{project.clientName}}</td>
                          <td>@{{project.start_ip_address}}</td>
                          <td>@{{project.end_ip_address ? project.end_ip_address : project.start_ip_address}}</td>
                          <td>@{{project.start_time}}</td>
                          <td>@{{project.end_time}}</td>
                          <td>@{{project.start_date}}</td>
                          <td>@{{project.end_date}}</td>
                          <td>@{{project.ref_id}}</td>
                          <td>@{{project.user_id}}</td>
                          <td>@{{project.country_name}}</td>
                       </tr>
                    </tbody>
                 </table>
              </div>
           </div>
        </div>
     </div>
  </div>
</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn default pull-right" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<div class="modal fade bd-example-modal-xl"  id="daily_survey_project_model" tabindex="-1" role="dialog"  aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">@{{projectType}}</h4>
            <button type="button" class="close" data-dismiss="modal">x</button>
         </div>
         <div class="modal-body">
            <div class="row row-sm ">
               <div class="col-xl-12">
                  <div class="card">
                     <div class="card-header pb-0">
                     </div>
                     <div class="card-body">
                        <div class="table-responsive ">
                           <table class="table table-hover table-bordered">
                              <thead>
                                 <tr>
                                    <th>SN</th>
                                    <th>ID</th>
                                    <th>Parent</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>PM/SM</th>
                                    <th>Start Date</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr ng-repeat="project in todayProjectDetails track by $index">
                                    <td>@{{ $index+1 }}</td>
                                    <td>@{{project.id}}</td>
                                    <td>@{{project.parent_project_id != -1 ? project.parent_project_id : 0}}</td>
                                    <td>@{{project.project_name}}</td>
                                    <td>@{{project.clientName}}</td>
                                    <td>@{{project.project_manager? project.project_manager : 'NA'}} / @{{project.salesManagers ? project.salesManagers : 'NA'}}</td>
                                    <td>@{{project.start_date}}</td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn default pull-right" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
</div>
@endsection