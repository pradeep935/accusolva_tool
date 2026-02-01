@extends('admin.layout')
@section('content')
<div class="container-flued mt-1 p-1" ng-controller="projectCtrl" ng-init="init(); getProjectFilterData();">
	<div class="">
		<div class="card card-custom">
			<div class="card-header">
				<div class="card-title">
					<div class="row">
						<div class="col-md-8">
							<h3 class="card-label"> Add Project</h3>
						</div>
						<div class="col-md-4">
							<div class="card-toolbar text-right">
								@if(in_array(2, $accessRights))
									<a href="{{url('/projects/add')}}" class="btn btn-secondary">Add </a>
								@endif
							</div>
						</div>
					</div>
					<hr>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-2 form-group" >
						<label>ID </label>
						<input type="text" class="form-control" ng-model="filter.id"  >
					</div>



					<div class="col-md-4 form-group" >
                        <label>Self parent</label>
                        <input auto-complete-company placeholder="Search By parent" class="form-control" id="projectName" >
                        <input type="hidden"  ng-model="filter.parent_project_id">
                    </div>




                    <!-- @if(false) -->
					<!-- <div class="col-md-2 form-group">
						<label>Self parent</label>
						<select class="form-control" ng-model="filter.parent_project_id">
							<option value="-1">Self Project</option>
							<option ng-repeat="project in projects" ng-value="@{{project.id}}">@{{project.project_name}}</option>
						</select>
					</div>
					 -->
					<!-- @endif -->

					<div class="col-md-2 form-group">
						<label>Project Name </label>
						<input class="form-control" ng-model="filter.project_name" type="text" >
					</div>

					<div class="col-md-2 form-group">
						<label>Status</label>
						<select class="form-control" ng-model="filter.status">
							<option value="">Select</option>
							<option ng-repeat="status in statusOptions" ng-value="@{{status.value}}">@{{status.label}}</option>
						</select>
					</div>
					<div class="col-lg-2 form-group">
						<label>Country</label>
						<select class="form-control" ng-model="filter.country_id">
							<option value="">Select</option>
							<option ng-repeat="country in countries" ng-value="@{{country.id}}">@{{country.name}}</option>
						</select>
					</div>
					<div class="col-md-2 form-group">
						<label>Client</label>
						<select class="form-control" ng-model="filter.client_id">
							<option value="">Select</option>
							<option ng-repeat="client in clients" ng-value="@{{client.id}}">@{{client.clientName}}</option>
						</select>
					</div>
					<div class="col-md-2 form-group">
						<label>Manager</label>
						<select class="form-control" ng-model="filter.project_manager_id">
							<option value="">Select</option>
							<option ng-repeat="projectManager in projectManagers" ng-value="@{{projectManager.id}}">@{{projectManager.user_name}}</option>
						</select>
					</div>
					<div class="col-md-2 form-group">
						<label>Sales Manager</label>
						<select class="form-control" ng-model="filter.sales_manager_id"  >
							<option value="">Select</option>
							<option ng-repeat="salesManager in salesManagers" ng-value="@{{salesManager.id}}">@{{salesManager.user_name}}</option>
						</select>
					</div>
					<div class="col-md-4">
						<button class="btn  btn-primary" ng-click="searchInit()" style="margin-top: 25px;">Search <i class="fa fa-search" aria-hidden="true"></i></button>
						<button class="btn  btn-info" ng-click="refresh()" style="margin-top: 25px;">Refresh <i class="fa fa-refresh" ></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="alert alert-info" ng-if="loading">Loading....</div>
	<div class="row row-sm ">
		<div class="col-xl-12">
			<div class="card mg-b-20">
				
				<div class="">
					<div class="table-responsive " ng-if="dataset.length > 0 && !loading">
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
									<th>Hits</th>
									<th>Quota Full</th>
									<th>Complete</th>
									<th>Disqalify</th>
									<th>Security Term</th>
									<th>Drop</th>
									<th>IR</th>
									<th>Loi</th>
									<th>Status</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="project in dataset track by $index" ng-style="{ 'background-color': project.copy_for_client == 1 ? 'lightblue' : '' }">
									<td>@{{ (filter.page_no - 1)*filter.max_per_page+$index+1 }}</td>
									<td>@{{project.id}}</td>
									<td>@{{project.parent_project_id != -1 ? project.parent_project_id : 0}}</td>
									<td>
										@{{project.project_name}}<hr>
										@{{project.country_name}}
									</td>
									<td>@{{project.clientName}}</td>
									<td>@{{project.project_manager? project.project_manager : 'NA'}} / @{{project.salesManagers ? project.salesManagers : 'NA'}}</td>
									<td>@{{project.start_date_created}}</td>

									<td>@{{project.hits}}</td>

									<td>
										<a class="btn btn-light  btn-sm" href="{{ url('projects/view-project-survey-details') }}/@{{project.id}}/3">@{{project.quota_full}}</a>
									</td>

									<td>
										<a class="btn btn-light  btn-sm" href="{{ url('projects/view-project-survey-details') }}/@{{project.id}}/1">
										@{{project.complete}}</a>
									</td>

									<td>
										<a class="btn btn-light  btn-sm" href="{{ url('projects/view-project-survey-details') }}/@{{project.id}}/2">
										@{{project.disqualify}}</a>
									</td>

									<td>
										<a class="btn btn-light  btn-sm" href="{{ url('projects/view-project-survey-details') }}/@{{project.id}}/4">
										@{{project.securityTerm}}</a>
									</td>

									<td>@{{project.abendond}} %</td>
									<td>@{{project.ir}} %</td>
									<td>@{{project.loi}}</td>
									<td>
										@if(in_array(5, $accessRights))
											<a class="btn btn-warning bg-gradient-warning btn-sm text-white"  ng-click=changeStatus(project,$index)>@{{project.status}}</a>
										@else
											@{{project.status}}
										@endif
									</td>
									<td>
										<span class="ml-auto">
										<a class="btn btn-success  btn-sm" href="{{ url('projects/view-project-survey-details') }}/@{{project.id}}/0">View</a>

										@if(in_array(3, $accessRights))
											<a class="btn btn-primary bg-gradient-primary btn-sm" href="{{ url('projects/add') }}/@{{project.id}}">Edit</a>
										@endif
										
										<!-- <a class="btn btn-warning  btn-sm" ng-click=copyPoject(project.id) ng-if="project.showCopy">Copy</a> -->

										@if(in_array(4, $accessRights))
											<a class="btn btn-danger bg-gradient-danger btn-sm" ng-click=removePoject(project.id) >Delete</a>
										@endif
										</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div  ng-if="dataset.length == 0 && !loading" class="alert alert-warning">
						No Data found
						
					</div>

					<div class="card-header pb-0" ng-if="dataset.length > 0 && !loading">
						<div table-paginate></div>
					</div>

				</div>
			</div>
		</div>
	</div>
	@include('admin.projects.model')
</div>
@endsection