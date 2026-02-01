@extends('admin.layout')
@section('content')
<div class="container-flued mt-1 p-1" ng-controller="SettingsController" ng-init="init(); getProjectFilterData();">
	<div class="">
		<div class="card card-custom">
			<div class="card-header">
				<div class="card-title">
					<div class="row">
						<div class="col-md-8">
							<h3 class="card-label"> Settings</h3>
						</div>
						<div class="col-md-4">
							<div class="card-toolbar text-right">
								
							</div>
						</div>
					</div>
					<hr>
				</div>
			</div>
		</div>
	</div>
	<div class="alert alert-info" ng-if="loading">Loading....</div>
	<div class="row row-sm ">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div style="margin-top:10px">
						<div class="table ">
							<table class="table table-hover table-bordered">
								<tr>
									<th>Large Logo</th>
									<th>
										<button type="button" ng-show="!formData.large_image" class="button btn btn-warning btn-sm upload-btn" ngf-select="uploadFile($file,'large_image',formData)" ladda="large_image_uploading" data-style="expand-right" >Upload Large Logo</button>

										<a ng-href="@{{formData.large_image}}" ng-show="formData.large_image" class="btn btn-warning btn-sm" target="_blank"> View</a>
										<a ng-show="formData.large_image" type="button" class="btn btn-danger btn-sm" ng-click="removeFile('large_image')"> X</a>
									</th>
								</tr>

								<tr>
									<th>Samll Logo</th>
									<th>
										<button type="button" ng-show="!formData.small_image" class="button btn btn-warning btn-sm upload-btn" ngf-select="uploadFile($file,'small_image',formData)" ladda="small_image_uploading" data-style="expand-right" >Upload Small Logo</button>

										<a ng-href="@{{formData.small_image}}" ng-show="formData.small_image" class="btn btn-warning btn-sm" target="_blank"> View</a>
										<a ng-show="formData.small_image" type="button" class="btn btn-danger btn-sm" ng-click="removeFile('small_image')"> X</a>
									</th>
								</tr>

								<tr>
									<th>Favico Icon</th>
									<th>
										<button type="button" ng-show="!formData.fevico_image" class="button btn btn-warning btn-sm upload-btn" ngf-select="uploadFile($file,'fevico_image',formData)" ladda="fevico_image_uploading" data-style="expand-right" >Upload Favico Icon</button>

										<a ng-href="@{{formData.fevico_image}}" ng-show="formData.fevico_image" class="btn btn-warning btn-sm" target="_blank"> View</a>
										<a ng-show="formData.fevico_image" type="button" class="btn btn-danger btn-sm" ng-click="removeFile('fevico_image')"> X</a>
									</th>
								</tr>

								<tr>
									<th>Login Image</th>
									<th>
										<button type="button" ng-show="!formData.login_image" class="button btn btn-warning btn-sm upload-btn" ngf-select="uploadFile($file,'login_image',formData)" ladda="login_image_uploading" data-style="expand-right" >Upload Login Image</button>

										<a ng-href="@{{formData.login_image}}" ng-show="formData.login_image" class="btn btn-warning btn-sm" target="_blank"> View</a>
										<a ng-show="formData.login_image" type="button" class="btn btn-danger btn-sm" ng-click="removeFile('login_image')"> X</a>
									</th>
								</tr>

								<tr>
									<th>Survey Start Image</th>
									<th>
										<button type="button" ng-show="!formData.survey_start_image" class="button btn btn-warning btn-sm upload-btn" ngf-select="uploadFile($file,'survey_start_image',formData)" ladda="survey_start_image_uploading" data-style="expand-right" >Upload Survey Start Image</button>

										<a ng-href="@{{formData.survey_start_image}}" ng-show="formData.survey_start_image" class="btn btn-warning btn-sm" target="_blank"> View</a>
										<a ng-show="formData.survey_start_image" type="button" class="btn btn-danger btn-sm" ng-click="removeFile('survey_start_image')"> X</a>
									</th>
								</tr>

								<tr>
									<th>Survey End Image </th>
									<th>
										<button type="button" ng-show="!formData.survey_end_image" class="button btn btn-warning btn-sm upload-btn" ngf-select="uploadFile($file,'survey_end_image',formData)" ladda="survey_end_image_uploading" data-style="expand-right" >Upload Survey End Image</button>

										<a ng-href="@{{formData.survey_end_image}}" ng-show="formData.survey_end_image" class="btn btn-warning btn-sm" target="_blank"> View</a>
										<a ng-show="formData.survey_end_image" type="button" class="btn btn-danger btn-sm" ng-click="removeFile('survey_end_image')"> X</a>
									</th>
								</tr>

								<tr>
									<th>Loader Image </th>
									<th>
										<button type="button" ng-show="!formData.loader_image" class="button btn btn-warning btn-sm upload-btn" ngf-select="uploadFile($file,'loader_image',formData)" ladda="loader_image_uploading" data-style="expand-right" >Upload Survey End Image</button>

										<a ng-href="@{{formData.loader_image}}" ng-show="formData.loader_image" class="btn btn-warning btn-sm" target="_blank"> View</a>
										<a ng-show="formData.loader_image" type="button" class="btn btn-danger btn-sm" ng-click="removeFile('loader_image')"> X</a>
									</th>
								</tr>

								<tr>
									<th>Show Copy Button</th>
									<th><input type="checkbox" ng-checked="formData.showCopy == 1" ng-model="formData.showCopy"></th>
								</tr>

								<tr>
									<th>CPI Limit For Torfaq Fetch Data</th>
									<th class="form-group">
										<input type="text" ng-model="formData.cpi" class="form-control">
									</th>
								</tr>

								<tr>
									<th>Show Client API</th>
									<th><input type="checkbox" ng-checked="formData.show_client_api == 1" ng-model="formData.show_client_api"></th>
								</tr>

								<tr>
									<th>Show Settings</th>
									<th><input type="checkbox" ng-checked="formData.show_setting == 1" ng-model="formData.show_setting"></th>
								</tr>
							</table>
        					<button ng-disabled="processing" type="button" ng-click="onSubmit()" class="btn btn-warning">Submit 
        						<div class="spinner-border spinner-border-sm" role="status" ng-show="processing">
        						</div>
        					</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection