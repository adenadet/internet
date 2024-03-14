<template>
    <section class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <img class="img-fluid" src="img/background/SNH_logo.png" />
                            <h4 class="text-justify"> PATIENT REFERRAl FORM</h4>
                        </div>
                    </div>
             
                    <div class="row invoice-info">
                        <div class="col-sm-7 invoice-col">
                            <address>
                                REF: <u><b>{{ appointment.patient | fullName }}</b></u><br>
                                SNH No: <u><b>{{ appointment.unique_id }}</b></u><br>
                                Date of Birth: <u><b>{{ appointment.patient.dob | excelDate }}</b></u><br>
                            </address>
                        </div>
                        <div class="col-sm-5 invoice-col">
                            <address>
                                Date:  <u><b>{{ referral.updated_at | excelDate }}</b></u><br>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Medical History</h3>
                            <div class="" style="font-size: 20;"  v-html="referral.content"></div>
                            <div class="" style="font-size: 20;">
                                <strong>Yours Sincerely,<br />
                                For: St. Nicholas Hospital, </strong><br />

                                <img :src="referral.created_by == 56 ? '/img/consents/rusman.png' : (referral.created_by == 57 ? '/img/consents/rabudah.png' :(referral.created_by == 55 ? '/img/consents/bsalami.png' :(referral.created_by == 331 ? '/img/consents/mnwachukwu.png' :'/img/consents/bsalami.png')))" class="img-fluid text-fluid" />
                                <strong>Dr. {{referral.creator | fullName}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default{
    props:{
        appointment: Object,
        referral: Object,
    }
}
</script>
