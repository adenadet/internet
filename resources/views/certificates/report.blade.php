<div class="col-12 p-2" width="100%" style="border: 2px solid #222;">
    <div class="row">
        <label class="col-4" style="font-weight:normal !important; "><small>Sputum Test:</small></label>
        <div class="col-4">
            <div class="d-flex">
                <i class="mr-1 {{is_null($appointment->laboratory) ?  'fa fa-check' : 'far fa-square' }}"></i>
                <label style="font-weight:normal !important; color: #222; "><small>Not Done</small></label>
            </div>
        </div>
        <div class="col-4">
            <div class="d-flex">
                <i class="mr-1 {{is_null($appointment->laboratory) ? 'far fa-square' : 'fa fa-check'}}"></i>
                <label style="font-weight:normal !important; color: #222;" ><small>Negative</small></label>
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-3" style="font-weight:normal !important; color: #222;"><small>Chest X-Ray:</small></label>
        <div class="col-3">
            <div class="d-flex">
                <i class="mr-1 {{is_null($appointment->report) ? 'fa fa-check' :'far fa-square'}}"></i>
                <label style="font-weight:normal !important; color: #222;"><small>Not Done</small></label>
            </div>
        </div>
        <div class="col-3">
            <div class="d-flex">
                <i class="mr-1 {{!is_null($appointment->report) && ($appointment->report->summary == 'normal') ? 'fa fa-check':'far fa-square'}}"></i>
                <label style="font-weight:normal !important; color: #222;"><small>Normal</small></label>
            </div>
        </div>
        <div class="col-3">
            <div class="d-flex">
                <i class="mr-1 {{!is_null($appointment->report) && (($appointment->report->summary == 'not suggestive') ||($appointment->report->summary == 'suggestive')) ? 'fa fa-check':'far fa-square'}}"></i>
                <label style="font-weight:normal !important; color: #222;"><small>Abnormal</small></label>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex">
                <i class="mr-1 {{($appointment->consultation->decision == 8 ) || (!is_null($appointment->laboratory)  && ($appointment->laboratory->summary == 'normal')) || (!is_null($appointment->report) && (($appointment->report->summary == 'not suggestive') ||($appointment->report->summary == 'normal'))) ? 'fa fa-check':'far fa-square'}}"></i>
                <label style="font-weight:normal !important; color: #222;"><small>No evidence of active pulmonary TB </small></label>
            </div>
        </div>
    </div>
</div>