<div class="row m-0">
    <div class="col-6">
        <div class="row">
            <label class="col-6" style="font-weight:normal !important; "><small>SP Health Professional Name:</small></label>
            <div class="col-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;">Dr. {{$appointment->issuing_officer->first_name}} {{$appointment->issuing_officer->last_name}}</div></div>
        </div>
        <div class="row">
            <label class="col-6" style="font-weight:normal !important; "><small>SP Health Professional Sign:</small></label>
            <div class="col-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;"><img src="https://intranet.saintnicholashospital.com/img/consents/{{$appointment->issuer == 56 ? 'rusman.png' :($appointment->issuer == 57 ? 'rabudah.png' : ($appointment->issuer == 55 ? 'bsalami.png' : ($appointment->issuer.id == 331 ? 'mnwachukwu.png' : 'bsalami.png')))}}" height="30px" width="auto" /></div></div>
        </div>
        <div class="row">
            <label class="col-6" style="font-weight:normal !important; "><small>SP Health Professional Date:</small></label>
            <div class="col-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{date('d M, Y', strtotime($appointment->issue_at))}}</div></div>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <label class="col-5"  style="font-weight:normal !important; "><small>Applicant's Signature:</small></label>
            <div class="col-6"><div class="pl-2 rounded" width="100%" style="border: 1px solid #222; color: #222;"><img src="https://intranet.saintnicholashospital.com/img/consents/{{$appointment->consent->signaturePad}}" height="30px" width="auto"/></div></div>
        </div>
        <div class="row">
            <label class="col-5" style="font-weight:normal !important; "><small>Date:</small></label>
            <div class="col-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{date('d M, Y', strtotime($appointment->consent->created_at))}}</div></div>
        </div>
        <div class="row">
            <label class="col-5" style="font-weight:normal !important; "><small>Visa Category:</small></label>
            <div class="col-6"><div width="100%" class="pl-2 rounded" style="border: 1px solid #222; color: #222;">{{$appointment->patient->visa_type}}</div></div>
        </div>
    </div>
    <div class="col-12 m-0">
        <p class="text-primary" style="font-size:small; font-weight:normal !important;">The information contained within this document provides information in connection with your application for a United Kingdom visa <b><u>ONLY</u></b> and does not constitute a diagnosis or assurance of health for any other purpose. The issue of the certificate does not mean that your application for a visa will be successful.<br/>
        <span class="text-muted text-small">Kindly scan the QR Code to confirm the validity of this certificate.</span></p>
    </div>
</div>