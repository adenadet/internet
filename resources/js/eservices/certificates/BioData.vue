<template>
<section>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-5 col-form-label text-small" style="font-weight:normal !important;"><small>Given name(s) (as shown in passport):</small></label>
        <div class="col-sm-6"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{ appointment.patient | Names}}</div></div>
    </div>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-5 col-form-label text-small" style="font-weight:normal !important; "><small>Family name (as shown in passport):</small></label>
        <div class="col-sm-6"><div div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" v-html="appointment.patient.last_name"></div></div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label text-small" style="font-weight:normal !important; "><small>Gender:</small></label>
                <div class="col-sm-4">
                    <div class="form-check">
                        <i class="" :class="appointment.patient.sex == 'Male' ? 'fa fa-check' : 'far fa-square'"></i>
                        <label class="form-check-label" style="font-weight:normal !important; color: #222;">
                        <small>Male</small></label>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-check">
                        <i class="" :class="appointment.patient.sex == 'Female' ? 'fa fa-check' : 'far fa-square'"></i>
                        <label class="form-check-label" style="font-weight:normal !important; color: #222;"><small>Female</small></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="font-weight:normal !important; "><small>Nationality:</small></label>
                <div class="col-sm-8"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;"  v-html="appointment.patient.nationality.name"></div></div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4" style="font-weight:normal !important;"><small>Date of Birth:</small></label>
                <div class="col-sm-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;"  v-html="appointment.patient.dob"></div></div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4" style="font-weight:normal !important; "><small>Passport No:</small></label>
                <div class="col-sm-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;" v-html="appointment.patient.passport_no"></div></div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-8 col-form-label" style="font-weight:normal !important; "><small>Number of accompanying children under 11 years of age:</small></label>
        <div class="col-sm-3"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" v-html="appointment.patient.accompanying_kids != null ? appointment.patient.accompanying_kids : 0"></div></div>
    </div>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>Full residential address:</small></label>
        <div class="col-sm-6" v-html="appointment.patient.nigerian_address" width="100%" min-height="200px" style="border: 1px solid #222; color: #222;"></div>
    </div>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>Address in the UK:</small></label>
        <div class="col-sm-6" v-html="appointment.patient.uk_address" width="100%" min-height="200px" style="border: 1px solid #222; color: #222;"></div>
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
        };
    },
    props: {appointment: Object}
}
</script>