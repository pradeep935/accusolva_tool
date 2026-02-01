<div class="modal fade bd-example-modal-xl"  id="add_qalification" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@{{ (suplierData.id) ? "Update Qualification" : "Add Qualification"}}</h4>
        <button type="button" class="close" data-dismiss="modal">x</button>
      </div>
      <form>
        <div class="modal-body">
          <div class="row">

            <div class="col-md-10 form-group">
              <label>Qestion </label>
              <textarea class="form-control" ng-model="qualificationData.question_name"></textarea>
            </div>

            <div class="col-md-2 form-group">
              <label>Select Type </label>
              <select class="form-control" ng-model="qualificationData.type">
                <option ng-value="1">Single Select</option>
                <option ng-value="2">Multi Select</option>
                <option ng-value="3">Open End</option>
                <option ng-value="4">Dummy</option>
              </select>
            </div>

          </div>

          <div class="row">
            <div class="col-md-12">
            <table class="table key-buttons text-md-nowrap  table-hover table-bordered " >
                <thead>
                  <tr >
                    <th>SN</th>
                    <th>Option</th>
                    <th>Answer</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="option in options track by $index">
                    <td>@{{ $index+1 }}</td>
                    <td class="form-group">
                      <input type="text" class="form-control" ng-model="option.option_name">
                    </td>
                    <td class="form-group">
                      <input type="checkbox"  ng-click="changeStatus(option.answer)" class="form-control" ng-model="option.answer">
                    </td>
                    <td>
                      <button  ng-click=removeOptoin($index) class="btn btn-danger">X</button>
                    </td>
                  </tr>
                  <tr>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-4">
              <button ng-click="addMoreOptoin()" class="btn btn-warning"> Add More +</button>
             </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" ng-click="saveQualification()" ng-disabled="ladda">@{{ (suplierData.id) ? "Update" : "Add"}}</button> 
          <button type="button" class="btn default pull-right" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl" id="question_model" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Client Wise Question</h4>
        <button type="button" class="close" data-dismiss="modal">x</button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 text-right">
              <button class="btn btn-primary" ng-disabled="question_processing"  ng-click="fetchApiQuestion()"> Fetch Question <div class="spinner-border spinner-border-sm" role="status" ng-show="question_processing"></div></button>
            </div>
            <div class="col-md-12 mt-3" style="overflow-y: scroll;height: 400px;">
            <table class="table key-buttons text-md-nowrap  table-hover table-bordered " >
                <thead>
                  <tr>
                    <th>SN <input type="checkbox"></th>
                    <th>name</th>
                    <th>Question Key</th>
                    <th>Question Type</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="question in questions track by $index">
                    <td>@{{ $index+1 }}</td>
                    <td>@{{ question.question_name }}</td>
                    <td>@{{ question.questionKey }}</td>
                    <td>@{{ question.questionType }}</td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-4">
              <button class="btn btn-warning" ng-click="manageOption()" ng-disabled="option_processing">Manage Option <div class="spinner-border spinner-border-sm" role="status" ng-show="option_processing"></div></button>

              <button class="btn btn-info" ng-click="manageOptionAnswer()" ng-disabled="option_answer_processing">Manage Quota <div class="spinner-border spinner-border-sm" role="status" ng-show="option_answer_processing"></div></button>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
