<!DOCTYPE html>
<html lang="en" sigplusextliteextension-installed="true" sigwebext-installed="true">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>St. Nicholas Hospital | @yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script type="text/javascript">
        var imgWidth;
        var imgHeight;
        function StartSign()
        {   
            var isInstalled = document.documentElement.getAttribute('SigPlusExtLiteExtension-installed');  
            if (!isInstalled) {
                alert("SigPlusExtLite extension is either not installed or disabled. Please install or enable extension.");
                return;
            }	
            var canvasObj = document.getElementById('cnv');
            canvasObj.getContext('2d').clearRect(0, 0, canvasObj.width, canvasObj.height);
            document.FORM1.sigStringData.value = "SigString: ";
            document.FORM1.sigRawData.value = "Base64 String: ";
            document.FORM1.sigRawData.value = "Base64 String: ";
            imgWidth = canvasObj.width;
            imgHeight = canvasObj.height;
            var message = { "firstName": "", "lastName": "", "eMail": "", "location": "", "imageFormat": 1, "imageX": imgWidth, "imageY": imgHeight, "imageTransparency": false, "imageScaling": false, "maxUpScalePercent": 0.0, "rawDataFormat": "ENC", "minSigPoints": 25 };
                
            top.document.addEventListener('SignResponse', SignResponse, false);
            var messageData = JSON.stringify(message);
            var element = document.createElement("MyExtensionDataElement");
            element.setAttribute("messageAttribute", messageData);
            document.documentElement.appendChild(element);
            var evt = document.createEvent("Events");
            evt.initEvent("SignStartEvent", true, false);				
            element.dispatchEvent(evt);		
        }
        function SignResponse(event)
        {	
            var str = event.target.getAttribute("msgAttribute");
            var obj = JSON.parse(str);
            SetValues(obj, imgWidth, imgHeight);
        }
        function SetValues(objResponse, imageWidth, imageHeight)
        {
            var obj = null;
            if(typeof(objResponse) === 'string'){
                obj = JSON.parse(objResponse);
            } else{
                obj = JSON.parse(JSON.stringify(objResponse));
            }		
            
            var ctx = document.getElementById('cnv').getContext('2d');

                if (obj.errorMsg != null && obj.errorMsg!="" && obj.errorMsg!="undefined")
                {
                    alert(obj.errorMsg);
                }
                else
                {
                    if (obj.isSigned)
                    {
                        document.FORM1.sigRawData.value += obj.imageData;
                        document.FORM1.sigStringData.value += obj.sigString;
                        document.FORM1.signaturePad.value += "data:image/png;base64," + obj.imageData;
                        var img = new Image();
                        img.onload = function () 
                        {
                            ctx.drawImage(img, 0, 0, imageWidth, imageHeight);
                        }
                        img.src = "data:image/png;base64," + obj.imageData;
                    }
                }
        }
        function ClearFormData()
        {
            document.FORM1.sigStringData.value = "SigString: ";
            document.FORM1.sigRawData.value = "Base64 String: ";
            document.getElementById('SignBtn').disabled = false;
        }

    </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="corner">
    @include('partials.lte.navbar')
    @include('partials.lte.aside')
    <div class="content-wrapper">
        @include('partials.lte.breadcrumb')
<section class="content">
    <div class="row">
        <div class="col-md-3">
            @include('partials.eservices.doctor')
        </div>
        <div class="col-md-9" id="consentForm">
            <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
            Saved! <a href="/eservices/doctor/consultation/{{$appointment->id}}" class="btn btn-primary btn-sm">Continue to Consultation</a> 
            </div>
           <form name="FORM1" id="SubmitForm" method="post" action="/api/emr/consents/signature">
                <div class="card row p-3">
                    <h3>Annex F: Consent Form</h3>
                    <p>UNITED KINGDOM PRE-ENTRY TUBERCULOSIS SCREENING PROGRAMME</p>
                    <table>
                        <tr><td>Name:</td><td> {{$appointment->patient->last_name.', '.$appointment->patient->first_name.' '.$appointment->patient->middle_name}}</td></tr>
                        <tr><td>Date of Birth:</td><td>{{$appointment->patient->dob}}</td></tr>
                        <tr><td>Clinic Location</td><td></td></tr>
                    </table>
                    <div>
                        <strong>Applicant's Declaration</strong><br />
                        <ul>I understand that:
                            <li>I am required to undergo testing for pulmonary tuberculosis (TB), involving an X-ray and possibly sputum tests, prior to applying for entry clearance to go to the UK.</li>
                            <li>If my chest X-ray is abnormal, I will receive individual counselling and an explanation of the further testing procedures.</li>
                            <li>If my chest X-ray is abnormal, and changes are suggestive of tuberculosis, regardless of whether these changes are old or new, or if there are other clinical reasons to suspect TB, I will have to provide 3 sputum samples which will be tested for TB with smear and culture. I understand that the results of sputum cultures may take up to ten weeks</li>
                            <li>If sputum samples are necessary, I will be required to return for sputum collection on 3 consecutive mornings starting with 7 days of my chest X-ray. If I fail to return within 7 days, I will forfeit the opportunity to obtain a TB certificate.</li>
                            <li>If the smear or culture shows the presence of TB bacteria, I will be referred for TB treatment. Treatment shall bbe at my own expense; I will inform the TB treatment facility that I have close family contacts, who may need evaluation for TB</li>
                            <li>I have the right to refuse to undergo the TB assessment procedure and TB treatment, but accept such a refusal may adversely impact on my UK visa application.</li>
                            <li>I understand that the physician has the final decision about whether I receive a Certificate.</li>
                        </ul>
                    </div>
                    <div>
                        <strong>Female applicants</strong><br />
                        <ul>All female applicants will be asked about their menstrual period to identify applicants who possibly may be pregnant:
                            <li>If I could be pregnant, I will be offered several alternatives: 1) a chest X-ray with protective shield; 2) I can postpone the CXR (and TB clearnace) until after delivery or 3) I can opt to provide 3 sputum samples for laboratory examination.</li>
                            <li>I acknowledge that a CXR can carry a risk for the unborn child, but that this risk is quite small in the second and third trimester. I am therefore advised to consult the panel physician and may wish to consult mygynaecologist to understand the risks before I take a chest X-ray. If I decide to submit to an X-ray, this shall be at my own risk.</li>
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
                    <div class="col-md-12 p-3" style="border: 1px solid #232323;">
                        <div class="row">
                            <p>I have read this consent form, or had translated for me. I was invited to ask questions to clarify what was not clear to me. I understand the content of this declaration.</p>
                            <div class="col-md-9">
                                Applicant's Signature<br />
                            </div>
                            <div class="col-md-3">Date </div>
                            <div class="clear"></div>
                            <canvas id="cnv" name="cnv" width="500" height="100" class="border"></canvas>
                            <div class="col-md-12 btn-group buttons">
                                <input class="btn btn-primary" id="SignBtn" name="SignBtn" type="button" value="Use Signature pad" onclick="StartSign()">
                            </div>
                            <p class="col-md-12">Please print your name:  {{$appointment->patient->last_name.', '.$appointment->patient->first_name.' '.$appointment->patient->middle_name}}</p>
                        </div>
                        <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
                        <input type="hidden" name="service_id" value="{{$appointment->service->id}}">
                        <input type="hidden" name="bioSigData">
                        <input type="hidden" name="signaturePad">
                    <input type="hidden" name="sigImgData">
                    <br>
                    <br>
                    <textarea name="sigStringData" rows="2" cols="50" class="invisible">SigString: </textarea>
                    <textarea name="sigRawData" rows="2" cols="50" class="invisible">Base64 String: </textarea>
                    </div>
                    <div class="col-md-12" style="border: 1px solid #232323;">
                        <p>For children, or adults without the mental capacity to give consent, I confirm that I am the parent or legal guardian of the applicant and confirm that I give my consent.<br />For adults, who are not able to physically sign the form, I confirm that I am an independent witness and the applicant has given their consent orally or by other non-verbal means.</p>
                        <div class="row">
                            <div class="col-md-9">Signature</div>
                            <div class="col-md-3">Date</div>
                            <div class="clear"></div>
                            
                            <p class="col-md-12 form-group">
                                <label>Please print your name:</label> 
                                <input type="text" class="form-control" name="guardian" id="guardian" v-model="consentForm.guardian" />
                            </p>
                            <p class="col-md-12">
                                <label>Relationship to applicant:</label> 
                                <input type="text" class="form-control" name="guardian_relationship" id="guardian_relationship" v-model="consentForm.guardian_relationship" />
                             </p>
                        </div>
                    </div>
                    <div class="col-md-12" style="border: 1px solid #232323;">
                        <p>Statement of interpreter (if required); I have translated the content of this document for the applicant to the best of my ability and in a way in which I believe s/he can understand.</p>
                        <div class="row">
                            <div class="col-md-9">Signed:<br /></div>
                            <div class="col-md-3">Date <br /></div>
                            <p class="col-md-12 form-group">
                                <label>Please print your name:</label> 
                                <input type="text" class="form-control" name="interpreter" id="interpreter" v-model="consentForm.interpreter" />
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12" style="border: 1px solid #232323;">
                        <p>For female applicants who might be pregnant; I confirm that I have had the risks of having a chest X-ray in pregnancy explained to me and I wish to carry on with the chest X-ray.</p>
                        <div class="row">
                            <div class="col-md-9">
                                Signed:<br />
                            </div>
                            <div class="col-md-3">Date <br /></div>
                        </div>
                    </div>
                    <div class="col-md-12" style="border: 1px solid #232323;">
                        <p>Statement of Physician (if required); I have explained the consent of this document to the applicant and confirm that the applicant has declined to go ahead with the assessment.</p>
                        <div class="row">
                            <div class="col-md-9">
                                Signed:<br />
                            </div>
                            <div class="col-md-3">Date <br /></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <button type="submit" class="btn btn-success form-control">Save</button>
                </div>
            </form>
        </div>
    </div>
</section>
</div>
    <aside class="control-sidebar control-sidebar-dark">
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <footer class="main-footer no-print">
        <div class="float-right d-none d-sm-inline">St. Nicholas Hospital</div>
        <strong>Copyright &copy; 2014-2021 <a href="https://squarem.com.ng">Squarem</a>.</strong> All rights reserved.
    </footer>
</div>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
