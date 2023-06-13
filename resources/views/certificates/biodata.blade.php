<div class="row">
    <label class="col-7 text-small" style="font-weight:normal !important;"><small>Given name(s) (as shown in passport):</small></label>
    <div class="col-5"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{$appointment->patient->first_name}} {{$appointment->patient->middle_name}}</div></div>
</div>
<div class="row">
    <label class="col-7 text-small" style="font-weight:normal !important; "><small>Family name (as shown in passport):</small></label>
    <div class="col-5"><div div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{$appointment->patient->last_name}}</div></div>
</div>
<div class="row">
    <div class="col-6">
        <div class="row">
            <label class="col-3 text-small" style="font-weight:normal !important; "><small>Gender:</small></label>
            <div class="col-4">
                <div class="d-flex">
                    <i class="mr-1 {{$appointment->patient->sex == 'Male' ? 'fa fa-check' : 'far fa-square'}}"></i>
                    <label style="font-weight:normal !important; color: #222;">
                    <small>Male</small></label>
                </div>
            </div>
            <div class="col-5">
                <div class="d-flex">
                    <i class="mr-1 {{$appointment->patient->sex == 'Female' ? 'fa fa-check' : 'far fa-square mr-1'}}"></i>
                    <label style="font-weight:normal !important; color: #222;"><small>Female</small></label>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="col-4" style="font-weight:normal !important; "><small>Nationality:</small></label>
            <div class="col-8"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{$appointment->patient->nationality->name}}</div></div>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <label class="col-6" style="font-weight:normal !important;"><small>Date of Birth:</small></label>
            <div class="col-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{$appointment->patient->dob}}</div></div>
        </div>
        <div class="row">
            <label class="col-6" style="font-weight:normal !important; "><small>Passport No:</small></label>
            <div class="col-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{$appointment->patient->passport_no}}</div></div>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-10" style="font-weight:normal !important; "><small>Number of accompanying children under 11 years of age:</small></label>
    <div class="col-2"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{$appointment->patient->accompanying_kids}}</div></div>
</div>
<div class="row">
    <label class="col-5" style="font-weight:normal !important; "><small>Full residential address:</small></label>
    <div class="col-7"><div width="100%" min-height="200px" style="border: 1px solid #222; color: #222;" class="pl-2"><?php echo $appointment->patient->nigerian_address; ?></div></div>
</div>
<div class="row">
    <label class="col-5" style="font-weight:normal !important; "><small>Address in the UK:</small></label>
    <div class="col-7"><div width="100%" min-height="200px" style="border: 1px solid #222; color: #222;" class="pl-2"><?php echo $appointment->patient->uk_address; ?></div></div>
</div>