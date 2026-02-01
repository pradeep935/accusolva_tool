
<div class="modal fade bd-example-modal-xl"  id="setting_modal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Change Settings</h4>
            <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
        <div class="modal-body">
            <form ng-submit="saveAPISettings(addForm.$valid)" name="addForm" novalidate="novalidate">

                <div class="row">

                    <div class="col-md-12 form-group">
                        <label>Client</label>
                        <select class="form-control" ng-model="settingData.client_id" required>
                            <option ng-repeat="client in clients" value="@{{client.id}}">@{{client.client_name}}</option>
                        </select>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Api</label>
                        <textarea class="form-control" ng-model="settingData.api_name" required></textarea>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" style="margin-top:25px;" class="btn btn-primary">Submit</button> 
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default pull-right" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>  

<div class="modal fade bd-example-modal-xl" id="country_modal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Client Wise Country</h4>
        <button type="button" class="close" data-dismiss="modal">x</button>
      </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn-primary" ng-disabled="country_processing"  ng-click="getCountries()"> Fetch Country <div class="spinner-border spinner-border-sm" role="status" ng-show="country_processing"></div></button>
            </div>
            <div class="col-md-12 mt-3">
            <table class="table key-buttons text-md-nowrap  table-hover table-bordered " >
                <thead>
                  <tr >
                    <th>SN</th>
                    <th>name</th>
                    <th>Code</th>
                    <th>Country ID</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="country in countries track by $index">
                    <td>@{{ $index+1 }}</td>
                    <td>@{{ country.name }}</td>
                    <td>@{{ country.nameCode }}</td>
                    <td>@{{ country.countryID }}</td>
                  </tr>
                  <tr>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

