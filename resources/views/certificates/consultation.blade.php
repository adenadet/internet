<div class="col-12 p-2 mt-1" style="border: 2px solid #222;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex">
                <i class="mr-1 {{$appointment->consultation->all_previous_tb == 1 ? 'fa fa-check' : 'far fa-square'}}"></i>
                <label style="font-weight:normal !important; color: #222;"> Family contact with tuberculosis</label>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex">
                <i class="mr-1 {{$appointment->consultation->women_pregnant == 1 ? 'fa fa-check' : 'far fa-square'}}""></i>
                <label style="font-weight:normal !important; color: #222;"> Pregnant</label>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex">
                <i class="mr-1 
                <?php 
                    $now = $appointment->consultation->created_at;
                    $dob = $appointment->patient->dob;
                    $dif = date_diff(date_create($dob), date_create($now));
                    if (intval($dif->format('%y')) >= 11){
                        echo "far fa-square";
                    } 
                    else{
                        echo "fa fa-check";
                    }
                ?>"></i>
                <label style="font-weight:normal !important; color: #222;"> Under 11 years of age undergone health assessment</label>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex">
                <i class="mr-1 fa fa-check"></i>
                <label style="font-weight:normal !important; color: #222; "> Chest X-ray & interaction with applicant</label>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex">
                <i class="mr-1 {{$appointment->issue_action == 'certificate' ? 'far fa-square' : 'fa fa-check'}}"></i>
                <label style="font-weight:normal !important; color: #222;"> Referral letter given to applicant</label>
            </div>
        </div>
    </div>
</div>