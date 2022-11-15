<template>
    <section class="content p-10">
        <div class="container-fluid" v-if="((appointment == null) && ((appointment.report == null) || (appointment.status == 8)) && (appointment.patient == null))">
            <div class="card">
                <div class="card-header">Incomplete Appointment</div>
                <div class="card-body"><p>This appointment is still been processed.</p></div>
            </div>
        </div>
        <div class="container-fluid" v-else-if="((appointment != null) &&(appointment.report != null) &&(appointment.patient != null))">
            <div class="invoice p-5 mb-3">
                <div class="row">
                    <div class="col-3 p-5">
                        <img :src="'/img/applicants/'+appointment.patient.image" class="img-fluid" />
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-9"><h5 class="mt-3">UK Pre-Departure Tuberculosis Detection Programme</h5></div>
                            <div class="col-2"><img src="/img/background/logo/uk-visa.png" class="img-fluid" /></div>
                            <div class="col-1"><img src="/img/background/logo/snh-square.png" class="img-fluid" /></div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label" style="color: #222;font-weight:normal !important; ">Certificate No:</label>
                                    <div class="col-sm-8"><div class="form-control form-control-sm" id="inputEmail3" v-html="appointment.unique_id"></div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">SP ID No:</label>
                                    <div class="col-sm-8"><div class="form-control form-control-sm" v-html="appointment.sp_id"></div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">City/Town:</label>
                                    <div class="col-sm-8"><div class="form-control form-control-sm">LAGOS ISLAND</div></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">Issue Date:</label>
                                    <div class="col-sm-8"><div class="form-control form-control-sm" id="inputEmail3">{{appointment.issue_at | excelDate}}</div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">Expiry Date:</label>
                                    <div class="col-sm-8"><div class="form-control form-control-sm">{{appointment.issue_at | excel6Months}}</div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important;">Country:</label>
                                    <div class="col-sm-8"><div class="form-control form-control-sm">NIGERIA</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label text-small" style="font-weight:normal !important;"><small>Given name(s) (as shown in passport):</small></label>
                            <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3" v-html="appointment.patient.first_name+' '+appointment.patient.last_name"></div></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label text-small" style="font-weight:normal !important; "><small>Family name (as shown in passport):</small></label>
                            <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3" v-html="appointment.patient.last_name"></div></div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label text-small" style="font-weight:normal !important; "><small>Gender:</small></label>
                                    <div class="col-sm-4"><div class="form-check"><input class="form-check-input" type="checkbox" disabled :checked="appointment.patient.sex == 'Male'"><label class="form-check-label" style="font-weight:normal !important; "><small>Male</small></label></div></div>
                                    <div class="col-sm-4"><div class="form-check"><input class="form-check-input" type="checkbox" disabled :checked="appointment.patient.sex == 'Female'"><label class="form-check-label" style="font-weight:normal !important; "><small>Female</small></label></div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label" style="font-weight:normal !important; "><small>Nationality:</small></label>
                                    <div class="col-sm-8"><div class="form-control form-control-sm" id="inputEmail3" v-html="appointment.patient.nationality.name"></div></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4" style="font-weight:normal !important;"><small>Date of Birth:</small></label>
                                    <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3" v-html="appointment.patient.dob"></div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4" style="font-weight:normal !important; "><small>Passport No:</small></label>
                                    <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3" v-html="appointment.patient.passport_no"></div></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-8 col-form-label" style="font-weight:normal !important; "><small>Number of accompanying children under 11 years of age:</small></label>
                            <div class="col-sm-3"><div class="form-control form-control-sm" id="inputEmail3" v-html="appointment.patient.accompanying_kids"></div></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; ">Full residential address:</label>
                            <div class="col-sm-6" v-html="appointment.patient.nigerian_address" width="100%" min-height="200px" style="border: 1px solid #222; color: #222;"></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; ">Address in the UK:</label>
                            <div class="col-sm-6" v-html="appointment.patient.uk_address" width="100%" min-height="200px" style="border: 1px solid #222; color: #222;"></div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="col-12 p-3" style="border: 2px solid #222;">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label" style="font-weight:normal !important; "><small>Sputum Test:</small></label>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.laboratory != 'null'">
                                        <label class="form-check-label" style="font-weight:normal !important; color: #222; "><small>Not Done</small></label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.laboratory == 'null'">
                                        <label class="form-check-label" style="font-weight:normal !important; "><small>Negative</small></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3" style="font-weight:normal !important;"><small>Chest X-Ray:</small></label>
                                <div class="col-sm-3">
                                    <div class="form-check"><input class="form-check-input" type="checkbox" disabled :checked="appointment.report == 'null'"><label class="form-check-label" style="font-weight:normal !important; "><small>Not Done</small></label></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.report != 'null' && appointment.report.summary == 'normal'">
                                        <label class="form-check-label" style="font-weight:normal !important;"><small>Normal</small></label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.report != 'null' && appointment.report.summary != 'normal'">
                                        <label class="form-check-label" style="font-weight:normal !important; "><small>Abnormal</small></label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.report != 'null' && appointment.report.summary == 'not suggestive'">
                                        <label class="form-check-label" style="font-weight:normal !important; "><small>No evidence of active pulmonary TB </small></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-3 mt-3" style="border: 2px solid #222;">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.report == 'null'">
                                        <label class="form-check-label" style="font-weight:normal !important; "> Family contact with tuberculosis</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled
                                            :checked="appointment.report == 'null'">
                                        <label class="form-check-label" style="font-weight:normal !important; "> Pregnant</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.report == 'null'">
                                        <label class="form-check-label" style="font-weight:normal !important;" :checked="appointment.consultation.status == 8"> Under 11 years of age undergone health assessment</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.report != 'null'">
                                        <label class="form-check-label" style="font-weight:normal !important; "> Chest X-ray & interaction with applicant</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled :checked="appointment.issue_action != 'certificate'">
                                        <label class="form-check-label" style="font-weight:normal !important; "> Referral letter given to applicant</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 p-3 mb-3" style="border: 2px solid #222;">
                        <p style="font-weight:normal !important; text-align: justify;"><b>IMPORTANT:</b> You must carry this certificate with you, in your hand luggage, when you
                            travel to the UK and present it to the Immigration Officer on arrival. Failure to do so will
                            result in a delay to your journey as you <b><u>may be</u></b> required to undergo the tests
                            again. Upon arrival in the UK you should register with a General Practitioner (GP) and
                            supply s copy of this certificate for their records. If your chest X-ray shows abnormality
                            requiring follow-up, we will also give a copy of the chest X-ray and X-ray interpretation
                            and this should also be supplied.</p>
                    </div>
                    <div class="col-6 mt-1">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>SP Health Professional Name:</small></label>
                            <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3" v-html="'Dr. '+appointment.medical_officer.first_name+' '+appointment.medical_officer.last_name"></div></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>SP Health Professional Sign:</small></label>
                            <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3"><img :src="appointment.medical_officer.id == 56 ? '/img/consents/rusman.png' : '/img/consents/101-1667818422.png'" class="img-fluid" /></div></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>SP Health Professional Date:</small></label>
                            <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3">{{appointment.issued_at |excelDate}}</div></div>
                        </div>
                    </div>
                    <div class="col-6 mt-1">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label"  style="font-weight:normal !important; ">Applicant's Signature:</label>
                            <div class="col-sm-6"><div class="form-control form-control-sm"><img :src="'/img/consents/'+appointment.consent.signaturePad" class="img-fluid"/></div></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; ">Date:</label>
                            <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3">{{appointment.consent.created_at | excelDate}}</div></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; ">Visa Category:</label>
                            <div class="col-sm-6"><div class="form-control form-control-sm" id="inputEmail3" v-html="appointment.patient.visa_type"></div></div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <p class="text-primary" style="font-weight:normal !important;">The information contained within this document provides information in connection with your application for a United Kingdom visa <b><u>ONLY</u></b> and does not constitute a diagnosis or assurance of health for any other purpose. The issue of the certificate does not mean that your application for a visa will be successful.</p>
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
            appointment: {},
        };
    },
    methods: {
        getInitials() {
            axios.get('/api/emr/appointments/' + this.$route.params.id)
                .then(response => {
                    Fire.$emit('refreshAppointment', response);
                })
                .catch(() => {
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'The certificate did not loaded successfully',
                    })
                });
        },
        refreshAppointment(response) {
            this.appointment = response.data.appointment;
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on("refreshAppointment", response => {
            this.refreshAppointment(response);
        });
    },
    props: {

    },
};
</script>