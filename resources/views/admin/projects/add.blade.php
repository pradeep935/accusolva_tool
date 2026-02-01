@extends('admin.layout')
@section('content')
<style type="text/css">
  .header {
  overflow: hidden;
  background: linear-gradient(45deg, rgba(245, 66, 102, 0.8), rgba(56, 88, 249, 0.8));
  padding: 20px 10px;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
  }
  .header a {
  float: left;
  color: white;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  line-height: 25px;
  border-radius: 19px;
  }
  .header a.logo {
  font-size: 25px;
  font-weight: bold; 
  }
  .header a:hover {
  background-color: #ddd;
  color: black;
  }
  .header a.active {
  background-color: dodgerblue;
  color: black;
  }
  .header-right {
  float: right;
  }
  .font-stastics {
  font-size: 20px;
  }
  .error-msg {
    color: red !important;
  }
</style>
<div ng-controller="projectCtrl" ng-init="formInit({{$project_id}})" class="container-flued mt-1 p-1">

  <form ng-submit="saveProject(addForm.$valid)" name="addForm" novalidate="novalidate">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="card ">
          <div class="card-body">
            <div class="row" ng-if="{{$project_id}}">
              <div class="header col-md-6">
                <div class="header-left">
                  @if($project) <a href="#">{{$project->project_name}} ({{$project->country_name}})</a>  @endif
                </div>
              </div>
              <div class="header col-md-6 text-right">
                <div class="header-right">
                  <a href="{{url('/projects/download/'.$project_id)}}">Download</a>
                  <a href="{{url('/projects')}}">Projects</a>
                  <a href="{{url('/qualifications/'.$project_id)}}">Qualification</a>
                  <a href="{{url('/supliers/'.$project_id)}}">Suppliers</a>
                  <a href="{{url('/re-concile/'.$project_id)}}">Reconcile</a>
                </div>
              </div>
            </div>
            <div class="row" ng-if="{{$project_id}}">
              <div class="col-md-3">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Security Checklist</h5>
                    <div ng-repeat="checkList in securityChecklist">
                      <input style="margin-right: 20px; " type="checkbox" ng-click="addChecklist(checkList.value)" ng-value="@{{checkList.value}}" ng-checked=" all_checklist_ids.indexOf(checkList.value) > -1 " >
                      <span class="text-warning">@{{checkList.label}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">Hits</h6>
                      <h2 class="mb-2 ">@{{stastics.hits}}</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">Redirects</h6>
                      <h2 class="mb-2 ">@{{stastics.redirect}}</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">Completed</h6>
                      <h2 class="mb-2 ">@{{stastics.complete}}</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">Disqualified</h6>
                      <h2 class="mb-2 ">@{{stastics.disqualify}}</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">Quota Full</h6>
                      <h2 class="mb-2 ">@{{stastics.quotaFull}}</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">Security</h6>
                      <h2 class="mb-2 ">@{{stastics.securityTerm}}</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">EPC</h6>
                      <h2 class="mb-2 ">@{{stastics.epc}}</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">IR</h6>
                      <h2 class="mb-2 ">@{{stastics.ir}}</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">Average LOI</h6>
                      <h2 class="mb-2 ">@{{stastics.loi}}</h2>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="plan-card text-center">
                      <h6 class="text-drak text-uppercase mt-2">Abandons</h6>
                      <h2 class="mb-2 ">@{{stastics.abendond}}</h2>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <hr/>
            <div class="main-content-label mg-b-5">
              <div class="row">
                <div class="col-md-6">
                  <label> @{{formData.id ? 'Edit' : 'Add'}} Project</label>
                </div>
                <div class="col-md-6 text-right" style="">
                  <a href="{{url('/projects')}}" class="btn btn-secondary btn-rounded btn-sm" type="submit">Back</a>
                </div>
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <div class="main-content-label mg-b-5">
                    </div>

                      <div class="row row-sm">

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Self parent <span class="text-danger">*</span></p>
                          
                          <input type="text" class="form-control" placeholder="Search project..."
                          ng-model="searchProject" ng-focus="showDropdown = true" ng-blur="hideDropdown()" />

                          <ul class="list-group" ng-show="showDropdown && filteredProjects().length" style="height: 100px; overflow: scroll;">
                            <li class="list-group-item"
                              ng-repeat="project in filteredProjects()"
                              ng-click="selectProject(project)">
                              @{{ project.project_name }}
                            </li>
                            <li class="list-group-item" ng-if="filteredProjects().length === 0">
                              No results found
                            </li>
                          </ul>

                          <input type="hidden" ng-model="formData.parent_project_id" />
                        </div>


                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Project Name <span class="text-danger">*</span></p>
                          <input class="form-control" ng-model="formData.project_name" type="text" required>
                        </div>

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Study Type <span class="text-danger">*</span></p>
                          <select class="form-control" ng-model="formData.study_type" required>
                            <option value="">Select</option>
                            <option ng-repeat="study in studyTypes" ng-value="@{{study.value}}">@{{study.label}}</option>
                          </select>
                        </div>

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Countries <span class="text-danger">*</span></p>
                          <select class="form-control" ng-model="formData.country_id" required>
                            <option value="">Select</option>
                            <option ng-repeat="country in countries" ng-value="@{{country.id}}">@{{country.name}}</option>
                          </select>
                        </div>

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Languages <span class="text-danger">*</span></p>
                          <select class="form-control" ng-model="formData.language_id" required>
                            <option value="">Select</option>
                            <option ng-repeat="language in languages" ng-value="@{{language.id}}">@{{language.language_name}}</option>
                          </select>
                        </div>

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Currency <span class="text-danger">*</span></p>
                          <select class="form-control" ng-model="formData.currency_id" required>
                            <option value="">Select</option>
                            <option ng-repeat="currenc in currency" ng-value="@{{currenc.id}}">@{{currenc.currency_name}}</option>
                          </select>
                        </div>

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Client's Budget (CPI) <span class="text-danger">*</span></p>
                          <input class="form-control" ng-model="formData.cpc" placeholder="Input box" type="number" required>
                        </div>

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Survey Link <span class="text-danger">*</span></p>
                          <textarea class="form-control" ng-model="formData.survey_link" placeholder="Survey Link" rows="3" required></textarea>
                        </div>

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Survey Test Link </p>
                          <textarea class="form-control" ng-model="formData.survey_test_link" placeholder="Survey Test Link" rows="3" ></textarea>
                        </div>

                      </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <!--div-->
                <div class="card">
                  <div class="card-body">
                    <div class="main-content-label mg-b-5">
                      Expected Metrices & Data
                    </div>
                    <div class="row row-sm">
                      <div class="col-lg-4 form-group">
                        <p class="mg-b-10">Req. Completes <span class="text-danger">*</span></p>
                        <input type="number"  class="form-control" ng-model="formData.req_complete" placeholder="Req. Completes " type="text" required>
                      </div>

                      <div class="col-lg-4 form-group">
                        <p class="mg-b-10">IR <span class="text-danger">*</span></p>
                        <input type="number"  class="form-control" ng-model="formData.ir" placeholder="Input box" type="text" required>
                      </div>

                      <div class="col-lg-4 form-group">
                        <p class="mg-b-10">LOI <span class="text-danger">*</span></p>
                        <input type="number" class="form-control" ng-model="formData.loi" placeholder="loi" required>
                      </div>

                      <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                        <p class="mg-b-10"> Supported Devices <span class="text-danger">*</span></p>
                        <label class="form-check form-check-inline" ng-repeat="device in devices">
                        <input type="checkbox" ng-click="addDevice(device.value)" ng-value="@{{device.value}}" ng-checked=" all_devices_ids.indexOf(device.value) > -1 "  required> 
                        <span class="form-check-label p-1">
                          @{{device.icon}}
                        </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="main-content-label mg-b-5">
                        People
                      </div>
                      <div class="row row-sm">

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Clients <span class="text-danger">*</span></p>
                          <select class="form-control" ng-model="formData.client_id"  required>
                            <option value="">Select</option>
                            <option ng-repeat="client in clients" ng-value="@{{client.id}}">@{{client.clientName}}</option>
                          </select>
                        </div>

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Project Manager <span class="text-danger">*</span></p>
                          <select class="form-control" ng-model="formData.project_manager_id"  required>
                            <option value="">Select</option>
                            <option ng-repeat="projectManager in projectManagers" ng-value="@{{projectManager.id}}">@{{projectManager.user_name}}</option>
                          </select>

                        </div> 

                        <div class="col-lg-4 form-group">
                          <p class="mg-b-10">Sales Manager <span class="text-danger">*</span></p>
                          <select class="form-control" ng-model="formData.sales_manager_id"  required>
                            <option value="">Select</option>
                            <option ng-repeat="salesManager in salesManagers" ng-value="@{{salesManager.id}}">@{{salesManager.user_name}}</option>
                          </select>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <div class="main-content-label mg-b-5">
                      Memorandum
                    </div>
                    <div class="row row-sm">
                      <div class="col-lg-4 form-group">
                        <p class="mg-b-10">Notes </p>
                        <textarea class="form-control" ng-model="formData.notes" rows="3" ></textarea>
                      </div>
                      <div class="col-lg-4 form-group">
                        <p class="mg-b-10">Project Brief </p>
                        <textarea class="form-control" ng-model="formData.project_brief" placeholder="Notes" rows="3" ></textarea>
                      </div>
                      <div class="col-lg-4 form-group">
                        <p class="mg-b-10">Current Status <span class="text-danger">*</span></p>
                        <select class="form-control" ng-model="formData.status" required>
                          <option value="">Select</option>
                          <option ng-repeat="status in statusOptions" ng-value="@{{status.value}}">@{{status.label}}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form-group col-lg-12">
              <button class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection