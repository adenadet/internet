<template>
<section class="mt-3">
    <div class="row">
        <div class="col-sm-10 p-3 mb-3" style="border: 2px solid #222;">
            <p style="font-weight:normal !important; text-align: justify;"><b>IMPORTANT:</b> You must carry this certificate with you, in your hand luggage, when you
                travel to the UK and present it to the Immigration Officer on arrival. Failure to do so will
                result in a delay to your journey as you <b><u>may be</u></b> required to undergo the tests
                again. Upon arrival in the UK you should register with a General Practitioner (GP) and
                supply s copy of this certificate for their records. If your chest X-ray shows abnormality
                requiring follow-up, we will also give a copy of the chest X-ray and X-ray interpretation
                and this should also be supplied.
            </p>
        </div>
        <div class="col-sm-1 text-center p-5">
            <qr-code :text="'https://intranet.saintnicholashospital.com/certificates/'+appointment.id" size=75 color="#000" bg-color="#fff" error-level="L"></qr-code>
        </div>
        <div class="col-6 mt-1">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>SP Health Professional Name:</small></label>
                <div class="col-sm-6"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" id="inputEmail3" v-html="'Dr. '+appointment.issuing_officer.first_name+' '+appointment.issuing_officer.last_name"></div></div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>SP Health Professional Sign:</small></label>
                <div class="col-sm-6"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" id="inputEmail3"><img :src="appointment.issuing_officer.id == 56 ? '/img/consents/rusman.png' : (appointment.issuing_officer.id == 57 ? '/img/consents/rabudah.png' :(appointment.issuing_officer.id == 55 ? '/img/consents/bsalami.png' :(appointment.issuing_officer.id == 331 ? '/img/consents/mnwachukwu.png' :'/img/consents/bsalami.png')))" class="img-fluid" /></div></div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>SP Health Professional Date:</small></label>
                <div class="col-sm-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;" id="inputEmail3">{{appointment.issue_at |excelDate}}</div></div>
            </div>
        </div>
        <div class="col-6 mt-1">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 col-form-label"  style="font-weight:normal !important; "><small>Applicant's Signature:</small></label>
                <div class="col-sm-6"><div class="pl-2 rounded" width="100%" style="border: 1px solid #222; color: #222;"><img :src="'/img/consents/'+appointment.consent.signaturePad" class="img-fluid"/></div></div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>Date:</small></label>
                <div class="col-sm-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;" id="inputEmail3">{{appointment.consent.created_at | excelDate}}</div></div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 col-form-label" style="font-weight:normal !important; "><small>Visa Category:</small></label>
                <div class="col-sm-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;" id="inputEmail3" v-html="appointment.patient.visa_type"></div></div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <p class="text-primary" style="font-weight:normal !important;">The information contained within this document provides information in connection with your application for a United Kingdom visa <b><u>ONLY</u></b> and does not constitute a diagnosis or assurance of health for any other purpose. The issue of the certificate does not mean that your application for a visa will be successful.</p>
            <span>Kindly scan the QR Code to confirm the validity of this certificate.</span> 
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
    props: {appointment: Object}
}
</script>