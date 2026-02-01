<div class="modal fade "  id="suplier_survey_info" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Suplier Survey Information</h4>
        <button type="button" class="close" data-dismiss="modal">x</button>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-2">Survey Link</div>
        <div class="col-md-8">
          <input type="text" readonly class="form-control" ng-model="info.newUrl">
        </div>
        <div class="col-md-2 text-right">
          <button type="button" class="btn btn-warning" ng-click="exportSurveyExcel()" ng-disabled="export"> Export <div class="spinner-border spinner-border-sm" role="status" ng-show="export"></div>
          </button>
        </div>
        
        <!-- <div class="col-md-12 form-group">
          <label>Survey Test Link</label>
          <input type="text" readonly class="form-control" ng-model="info.newTestUrl">
        </div> -->
      </div>
      <hr>
      <div class="table-responsive " style="overflow: scroll; height: 450px;">
        <table id="example" class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>SN</th>
              <th>ID</th>
              <th>Suplier ID</th>
              <th>Suplier Name</th>
              <th>Our po</th>
              <th>Client</th>
              <th>Start IP</th>
              <th>End IP </th>
              <th>Start Time</th>
              <th>End Time </th>
              <th>Start Date</th>
              <th>End Date </th>
              <th>Ref Id</th>
              <th>UID</th>
              <th>Status</th>
              <th>Country</th>
              
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="project in suplierSurveyDetails track by $index">
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
              <td>@{{project.status}}</td>
              <td>@{{project.country_name}}</td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl"  id="add_suplier" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@{{ (suplierData.id) ? "Update Suppliers" : "Add Suppliers"}}</h4>
        <button type="button" class="close" data-dismiss="modal">x</button>
      </div>
      <form ng-submit="saveSuplier(addForm.$valid)" name="addForm" novalidate="novalidate">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3 form-group">
              <label>Vendor <span class="text-danger">*</span></label>
              <select class="form-control" ng-change="getVendorDetails()" ng-model="suplierData.vendor_id" convert-to-number required>
                <option value="">Select</option>
                <option ng-repeat="vendor in vendors" value="@{{vendor.id}}">@{{vendor.vendorName}}</option>
              </select>
            </div>
            <div class="col-md-3 form-group">
              <label>Cost Per Complete (Only enter Project CPI*0.6)<span class="text-danger">*</span></label>
              <input type="number" class="form-control" ng-model="suplierData.cost_per_complete" required>
            </div>
            <div class="col-md-3 form-group">
              <label>Req. Completes <span class="text-danger">*</span></label>
              <input type="number" class="form-control" ng-model="suplierData.complete_request" required>
            </div>
            <div class="col-md-3 form-group">
              <label>Max Redirects <span class="text-danger">*</span></label>
              <input type="number" class="form-control" ng-model="suplierData.max_redirect" required>
            </div>
            <div class="col-md-6 form-group">
              <label>Completion Link <span class="text-danger">*</span></label>
              <textarea class="form-control" ng-model="suplierData.completeLink" placeholder="Completion Link" rows="3" required></textarea>
            </div>
            <div class="col-md-6 form-group">
              <label>Disqualify Link <span class="text-danger">*</span></label>
              <textarea class="form-control" ng-model="suplierData.disqualifyLink" placeholder="Disqualify Link" rows="3" required></textarea>
            </div>
            <div class="col-md-6 form-group">
              <label>Qouta Full Link <span class="text-danger">*</span></label>
              <textarea class="form-control" ng-model="suplierData.qoutafullLink" placeholder="Qouta Full Link " rows="3" required></textarea>
            </div>
            <div class="col-md-6 form-group">
              <label>Security Term Link <span class="text-danger">*</span></label>
              <textarea class="form-control" ng-model="suplierData.securityTermlink" placeholder="Security Term Link" rows="3" required></textarea>
            </div>
            <div class="col-md-4 form-group">
              <label>Notes <span class="text-danger">*</span></label>
              <textarea class="form-control" ng-model="suplierData.notes" placeholder="Notes" rows="3" required></textarea>
            </div>
            <div class="col-md-4 form-group">
              <label>Status <span class="text-danger">*</span></label>
              <select class="form-control" ng-model="suplierData.status" required>
                <option value="">Select</option>
                <option ng-repeat="status in statusOptions" ng-value="@{{status.value}}">@{{status.label}}</option>
              </select>
              <div ng-if="!suplierData.status && supplierSubmitted">
                <span class="mg-b-10 text-danger">The Current Status field is required.</span>
              </div>
            </div>
            <div class="col-md-4">
              <p class="mg-b-10"> Data to ask on redirect<span class="text-danger">*</span></p>
              <label class="form-check form-check-inline" ng-repeat="dataToAsk in dataToAskOnRedirect">
              <input type="checkbox" ng-click="adddataToAskRedirect(suplierData.data_redirect_ids, dataToAsk.value)" ng-value="@{{dataToAsk.value}}" ng-checked="suplierData.data_redirect_ids.indexOf(dataToAsk.value) > -1 "  required> 
              <span class="form-check-label p-1">
              @{{dataToAsk.label}}
              </span>
              </label>
            </div>
          </div>
          <div class="row" ng-if="suplierData.id">
            <div class="col-md-12 form-group">
              <label>Survey Link</label>
              <input type="text" readonly class="form-control" ng-model="suplierData.newUrl">
            </div>
            <div class="col-md-12 form-group">
              <label>Survey Test Link</label>
              <input type="text" readonly class="form-control" ng-model="suplierData.newTestUrl">
            </div>
          </div>
          <hr>
          <div>
            <button class="btn btn-primary" ng-disabled="ladda">@{{ (suplierData.id) ? "Update" : "Add"}}</button> 
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn default pull-right" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>