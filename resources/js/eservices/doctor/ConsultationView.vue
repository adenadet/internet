<template>
<section>
    <div class="row">
        <label class="col-sm-12">Has the applicant (or their child) had any of the following symptoms in the last 3 months *</label>
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="cough" id="cough" v-model="consultation.sym_cough" disabled>
                <label class="form-check-label">Cough</label>
            </div>
        </div> 
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="fever" id="fever" v-model="consultation.sym_fever" disabled>
                <label class="form-check-label">Fever</label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="haemoptysis" id="haemoptysis" v-model="consultation.sym_haemoptysis" disabled>
                <label class="form-check-label">Haemoptysis</label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="night_sweats" id="night_sweats" v-model="consultation.sym_night_sweats" disabled>
                <label class="form-check-label">Night Sweats</label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="weight_loss" id="weight_loss" v-model="consultation.sym_weight_loss" disabled>
                <label class="form-check-label">Weight Loss</label>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="row">
        <label class="col-sm-12">For Children only; is there any history of the following:</label>
        <div class="col-sm-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kid_respiratory" id="kid_respiratory" v-model="consultation.kid_respiratory"  disabled>
                <label class="form-check-label">Any respiratory disease, such as Cystic fibrosis</label>
            </div>
        </div> 
        <div class="col-sm-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kid_throaic_surgery" id="kid_throaic_surgery" v-model="consultation.kid_throaic_surgery"  disabled>
                <label class="form-check-label">Previously Thoraic surgery</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kid_cyanosis" id="kid_cyanosis" v-model="consultation.kid_cyanosis" disabled>
                <label class="form-check-label">Cyanosis</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kid_cyanosis" id="kid_cyanosis" v-model="consultation.kid_respiratory_insufficiency" disabled>
                <label class="form-check-label">Respiratory Insufficiency that limits activity</label>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="row">
        <label class="col-sm-12">For All Applicants</label>
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="all_previous_tb" id="all_previous_tb" disabled v-model="consultation.all_previous_tb">
                <label class="form-check-label">Is there any history of previous TB?</label>
            </div>
        </div> 
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="all_household_tb" v-model="consultation.all_household_tb" disabled>
                <label class="form-check-label">has anyone in the household been diagnosed with TB in the last 2 years?</label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="all_recent_contact" id="all_recent_contact" v-model="consultation.all_recent_contact" disabled>
                <label class="form-check-label">Is there any history of recent contact with a case of active pulmonary TB (shared the same enclosed air space or household or other enclosed environmentfor a prolonged period for days or weeks)></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label>Doctor's Decision:</label>
                <select class="form-control" id="decision" name="decision" required v-model="consultation.decision" disabled>
                    <option value="">--Select Decision--</option>
                    <option value="6">Send to Xray for CXR</option>
                    <option value="8">Send to Lab for Sputum Test</option>
                    <option value="10">Patient Postponed</option>
                    <option value="11">Patient Cancelled</option>
                </select>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="form-group">
                <label>Doctor's Remark:</label>
                <textarea row="5" class="form-control" v-html="consultation.remarks" disabled></textarea>
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
    methods:{
    },
    props:{
        consultation: Object,
        patient: Object,
    }
};
</script>