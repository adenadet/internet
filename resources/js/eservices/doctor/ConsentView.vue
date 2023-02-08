<template>
<section>
<div class="card row p-3">
    <h3>Annex F: Consent Form</h3>
    <p>UNITED KINGDOM PRE-ENTRY TUBERCULOSIS SCREENING PROGRAMME</p>
    <table>
        <tr><td>Name:</td><td> {{patient.last_name+', '+patient.first_name+' '+patient.middle_name}}</td></tr>
        <tr><td>Date of Birth:</td><td>{{patient.dob}}</td></tr>
        <tr><td>Clinic Location</td><td></td></tr>
    </table>
    <div>
        <strong>Applicant's Declaration</strong><br />
        <ul>I understand that:
            <li>I am required to undergo testing for pulmonary tuberculosis (TB), involving an X-ray and possibly sputum tests, prior to applying for entry clearance to go to the UK.</li>
            <li>If my chest X-ray is abnormal, I will receive individual counselling and an explanation of the further testing procedures.</li>
            <li>If my chest X-ray is abnormal, and changes aresuggestive of tuberculosis, regardless of whether these changes are old or new, or if there are other clinical reasons to suspect TB, I will have to provide 3 sputum samples which will be tested for TB with smear and culture. I understand that the results of sputum cultures may take up to ten weeks</li>
            <li>If sputum samples are necessary, I will be required to return for sputum collection on 3 consecutive mornings starting with 7 days of my chest X-ray. If I fail to return within 7 days, I will forfeit the opportunity to obtain a TB certificate.</li>
            <li>If the smear or culture shows the presence of TB bacteria, I will be referred for TB treatment. Treatment shall bbe at my own expense; I will inform the TB treatment facility that I have close family contacts, who may need evaluation for TB</li>
            <li>I have the right to refuse to undergo the TB assessment procedure and TB treatment, but accept such a refusal may adversely impact on my UK visa application.</li>
            <li>I understand that the physican has the final decision about whether I receive a Certificate.</li>
        </ul>
    </div>
    <div>
        <strong>Female applicants</strong><br />
        <ul>All female applicants will be asked about their menstrual period to identify applicants who possibly may be pregnant:
            <li>If I could be pregnant, I will be offered several alternatives: 1) a chest X-ray with protective shield; 2) I can postpone the CXR (and TB clearnace) until after delivery or 3) I can opt to provide 3 sputum samples for laboratory examination.</li>
            <li>I acknowledge that a CXR can carry a risk for the unborn child, but that this tisk is quite small in the second and third trimester. I am therefore advised to consult the panel physician and may wish to consult mygynaecologist to understand the risks before I take a chest X-ray. If I decide to submit to an X-ray, this shall be at my own risk.</li>
        </ul>
    </div>
    <div>
        <ul>I hereby:
            <li>consent to undergo TB testing;</li>
            <li>authorise you and your designated laboratory to store all relevant personal information collected during the assessment process, including health records and chest X-ray;</li>
            <li>authorise you and your designated clinics to share my personal details and assessment results with the UK immigration authorities, the UK Department of Health, Public Health England and the UK National Health Service.</li>
            <li>I authorise you to share my assessment results with the health authorities of my country of residence where this is required by my country's laws. I release and hold harmless the UK Government and you from any liability for loss, injury suffered or other harm during, or as a result of, the TB assessment procedures.</li>
        </ul>
    </div>
    <div class="col-md-12" style="border: 1px solid #232323;">
        <div class="row">
            <p>I have read this consent form, or had translated for me. I was invited to ask questions to clarify what was not clear to me. I understand the content of this declaration.</p>
            <div class="col-md-9">
                Applicant's Signature <br />
                <img v-if="consent.signaturePad != null" :src="'/img/consents/'+consent.signaturePad" class="img-fluid"/>
            </div>
            <div class="col-md-3">Date <br /> {{consent.created_at |excelDate}}</div>
            <div class="clear"></div>
            <p class="col-md-12">Please print your name: {{patient.last_name+', '+patient.first_name+' '+patient.middle_name}}</p>
        </div>
    </div>
    <div class="col-md-12" style="border: 1px solid #232323;">
        <p>For children, or adults without the mental capacity to give consent, I confirm that I a the parent or legal guardian of the applicant and confirm that I give my consent.<br />For adults, who are not able to physically sign the form, I confirm that I am an independent witness and the applicant has given their consent orally or by other non-verbal means.</p>
        <div class="row">
            <div class="col-md-9">Signature<br />
                <img v-if="consent.signaturePad_1 != null" :src="'/img/consents/'+consent.signaturePad_1" class="img-fluid"/>
            </div>
            <div class="col-md-3">Date <br /> {{consent.created_at |excelDate}}</div>
            <div class="clear"></div>
            
            <p class="col-md-12">Please print your name: {{consent.guardian != null ? consent.guardian : ''}}</p>
            <p class="col-md-12">Relationship to applicant: {{consent.guardian_relationship != null ? consent.guardian_relationship : ''}}</p>
        </div>
    </div>
    <div class="col-md-12" style="border: 1px solid #232323;">
        <p>Statement of interpreter (if required); I have translatwed the content of this document for the applicant to the best of my ability and in a way in which I believe s/he can understand.</p>
        <div class="row">
            <div class="col-md-9">Signed:<br /> <img v-if="consent.signaturePad_2 != null" :src="'/img/consents/'+consent.signaturePad_2" class="img-fluid"/></div>
            <div class="col-md-3">Date <br /> {{consent.created_at | excelDate}}</div>
            <div class="clear"></div>
            <p class="col-md-12">Please print your name: {{consent.interpreter != null ? consent.interpreter : ''}}</p>
        </div>
    </div>
    <div class="col-md-12" style="border: 1px solid #232323;">
        <p>For female applicants who might be pregnant; I confirm that I have had the risks of having a chest X-ray in pregnancy explained to me and I wish to carry on with the chest X-ray.</p>
        <div class="row">
            <div class="col-md-9">
                Signed:<br /> <img v-if="consent.signaturePad_3 != null" :src="'/img/consents/'+consent.signaturePad_3" class="img-fluid"/>
            </div>
            <div class="col-md-3">Date <br /> {{consent.created_at | excelDate}}</div>
            <p class="col-md-12">Please print your name: {{consent.pregnancy != null ? patient.last_name+', '+patient.first_name+' '+patient.middle_name: ''}}</p>
        </div>
    </div>
    <div class="col-md-12" style="border: 1px solid #232323;">
        <p>Statement of Physician (if required); I have explained the consent of this document to the applicant and confirm that the applicant has declined to go ahead with the assessment.</p>
        <div class="row">
            <div class="col-md-9">
                Signed:<br /> <img v-if="consent.signaturePad_4 != null" :src="'/img/consents/'+consent.signaturePad_4" class="img-fluid"/>
            </div>
            <div class="col-md-3">Date <br /> {{consent.created_at | excelDate}}</div>
            <div class="clear"></div>
            <p class="col-md-12">Please print your name: {{consent.doctor != null ? consent.doctor.last_name+', '+consent.doctor.first_name+' '+consent.doctor.middle_name : ''}}</p>
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
        consent: Object,
    }
};
</script>
<style>
.signature {
    border: double 3px transparent;
    border-radius: 5px;
    background-image: linear-gradient(white, white), radial-gradient(circle at top left, #4bc5e8, #9f6274);
    background-origin: border-box;
    background-clip: content-box, border-box;
    height: 300px;
}

.container {
    width: "100%";
    padding: 8px 16px;
}

.buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    margin-top: 8px;
}
</style>
