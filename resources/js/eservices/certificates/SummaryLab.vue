<template>
<section>
    <div class="col-12 p-3" style="border: 2px solid #222;">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label" style="font-weight:normal !important; "><small>Sputum Test:</small></label>
            <div class="col-sm-3">
                <div class="form-check">
                    <i class="mr-1" :class="appointment.laboratory == null ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222; "><small>Not Done</small></label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check">
                    <i class="mr-1" :class="(appointment.laboratory != null && appointment.laboratory.summary != null) ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;" ><small>Negative</small></label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            
            <label for="inputEmail3" class="col-sm-3" style="font-weight:normal !important; color: #222;"><small>Chest X-Ray:</small></label>
            <div class="col-sm-3">
                <div class="form-check">
                    <i class="mr-1" :class="appointment.report == null ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"><small>Not Done</small></label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check">
                    <i class="mr-1" :class="appointment.report != null && appointment.report.summary == 'normal' ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"><small>Normal</small></label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check">
                    <i class="mr-1" :class="appointment.report != null && appointment.report.summary != 'normal' ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"><small>Abnormal</small></label>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-check">
                    <i class="mr-1" :class="appointment.report != null && (appointment.report.summary == 'normal' || (appointment.report != 'null' && appointment.report.summary == 'not suggestive')) ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"><small>No evidence of active pulmonary TB </small></label>
                </div>
            </div><!---->
        </div>
    </div>
    <div class="col-12 p-3 mt-3" style="border: 2px solid #222;">
        <div class="form-group row">
            <div class="col-sm-12">
                <div class="form-check">
                    <i class="mr-1" :class="(appointment.consultation.all_household_tb == 1) || (appointment.consultation.all_recent_contact == 1) ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"> Family contact with tuberculosis</label>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-check">
                    <i class="mr-1" :class="(appointment.consultation != null) && (appointment.consultation.women_pregnant == 1) ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"> Pregnant</label>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-check">
                    <i class="mr-1" :class="(age(appointment.patient.dob) <= 11) ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"> Under 11 years of age undergone health assessment</label>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-check">
                    <i class="mr-1" :class="(appointment.report != null) || (appointment.laboratory != null) ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222; "> Chest X-ray & interaction with applicant</label>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-check">
                    <i class="mr-1" :class="appointment.issue_action != 'certificate' ? 'fa fa-check': 'far fa-square'"></i>
                    <label class="form-check-label" style="font-weight:normal !important; color: #222;"> Referral letter given to applicant</label>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
        };
    },
    methods: {
        age(date){
            var dob = new Date(date);
            var month_diff = Date.now() - dob.getTime();  
            var age_dt = new Date(month_diff);   
            var year = age_dt.getUTCFullYear();  
            var age = Math.abs(year - 1970);  
            
            return age;
        },
    },
    props: {appointment: Object}
}
</script>