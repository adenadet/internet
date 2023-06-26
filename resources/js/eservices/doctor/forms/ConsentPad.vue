<template>
<section class="content">
    <div class="modal fade" id="signatureModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body card">
					This is a test.
                    <!--<canvas id="cnv" name="cnv" width="500" height="100"></canvas>-->
                </div>
            </div>
        </div>
    </div>
    <table border="1" cellpadding="0" width="500">
        <tbody>
            <tr>
                <td height="100" width="500">
                    <canvas id="cnv" name="cnv" width="500" height="100"></canvas>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <canvas name="SigImg" id="SigImg" width="500" height="100"></canvas>
    <form action="" name="FORM1">
        <p>
            <input id="SignBtn" name="SignBtn" type="button" value="Sign" @click="StartSign()">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="HIDDEN" name="bioSigData">
            <input type="HIDDEN" name="sigImgData">
            <br>
            <br>
            <textarea name="sigStringData" rows="20" cols="50">SigString: </textarea>
            <textarea name="sigRawData" rows="20" cols="50">Base64 String: </textarea>
        </p>
    </form>
    <br><br>
</section>
</template>
<script>
export default {
    data() {
        return {
            consentForm: new Form({
                signaturePad: '', 
                signaturePad_1:'',
                signaturePad_2:'',
                signaturePad_3:'',
                signaturePad_4:'', 
                appointment_id:'', 
                id: '',
                appointment_id: '', 
                service_id: '',
                guardian: '',
                guardian_relationship: '',
                interpreter: '',
                pregnancy: '',
            }),
            pad: 0,
            options:{
                penColor:"rgb(0, 0, 0)",
                backgroundColor:"rgb(255,255,255)",
            },
            disabled:false,
            imgWidth: 0,
            imgHeight: 0,
        };
    },
    methods:{
        undo(id) {this.$refs.signaturePad.undoSignature();},
        change() {this.options = {penColor: "#00f",};},
        createConsentForm(){
            this.$Progress.start();
            this.save(0);
            this.save(1);
            this.save(2);
            this.save(3);
            this.save(4);
            this.consentForm.appointment_id = this.appointment.id;
            this.consentForm.service_id = this.appointment.service_id;
            alert(this.consentForm.appointment_id);
            this.consentForm.post('/api/emr/consents')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('refreshAppointment', response);
                Swal.fire({icon: 'success', title: 'The Consent Form has been saved', showConfirmButton: false, timer: 1500});
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...',  text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });  
        },
        resume() {this.options = {penColor: "#c0f",};},
        sign(id){this.$Progress.start();$('#signaturetModal').modal('show');this.$Progress.finish();},
        save(id) {
            const { isEmpty, data } = this.$refs.signaturePad.saveSignature();
            if(id == 0){this.consentForm.signaturePad = data;}
            else if(id == 1){this.consentForm.signaturePad_1 = data;}
            else if(id == 2){this.consentForm.signaturePad_2 = data;}
            else if(id == 3){this.consentForm.signaturePad_3 = data;}
            else if(id == 4){this.consentForm.signaturePad_3 = data;}

            return;
        },
        StartSign(){   
            var isInstalled = document.documentElement.getAttribute('SigPlusExtLiteExtension-installed'); 
            if (!isInstalled) {
                alert("SigPlusExtLite extension is either not installed or disabled. Please install or enable extension.");
                return;
            }	
            //$('#signatureModal').modal('show');
            var canvasObj = document.getElementById('cnv');
            canvasObj.getContext('2d').clearRect(0, 0, canvasObj.width, canvasObj.height);
            //this.consentForm.sigStringData.value = "SigString: ";
            this.consentForm.signaturePad = "";
            this.imgWidth = canvasObj.width;
            this.imgHeight = canvasObj.height;
            var message = { "firstName": "", "lastName": "", "eMail": "", "location": "", "imageFormat": 1, "imageX": this.imgWidth, "imageY": this.imgHeight, "imageTransparency": false, "imageScaling": false, "maxUpScalePercent": 0.0, "rawDataFormat": "ENC", "minSigPoints": 25 };
                
            top.document.addEventListener('SignResponse', this.SignResponse(), false);
            var messageData = JSON.stringify(message);
            var element = document.createElement("MyExtensionDataElement");
            element.setAttribute("messageAttribute", messageData);
            document.documentElement.appendChild(element);
            var evt = document.createEvent("Events");
            evt.initEvent("SignStartEvent", true, false);				
            element.dispatchEvent(evt);		
        },
        SignResponse(event)
        {	
            var str = event.target.getAttribute("msgAttribute");
            var obj = JSON.parse(str);
            SetValues(obj, this.imgWidth, this.imgHeight);
        },
        SetValues(objResponse, imageWidth, imageHeight)
        {
            var obj = null;
            if(typeof(objResponse) === 'string'){obj = JSON.parse(objResponse);} 
            else{obj = JSON.parse(JSON.stringify(objResponse));}		
            
            var ctx = document.getElementById('cnv').getContext('2d');

            if (obj.errorMsg != null && obj.errorMsg!="" && obj.errorMsg!="undefined"){alert(obj.errorMsg);}
            else{
                if (obj.isSigned){
                    document.FORM1.sigRawData.value += obj.imageData;
                    document.FORM1.sigStringData.value += obj.sigString;
                    var img = new Image();
                    img.onload = function () {ctx.drawImage(img, 0, 0, imageWidth, imageHeight);}
                    img.src = "data:image/png;base64," + obj.imageData;
                }
            }
        },
        ClearFormData()
        {
            this.consentForm.signaturePad = "";
            //document.FORM1.sigRawData.value = "Base64 String: ";
            document.getElementById('SignBtn').disabled = false;
        }

    },
    mounted() {
        this.ClearFormData();
        let topazScripts = document.createElement('script')
        topazScripts.setAttribute('src', 'https://www.sigplusweb.com/SigWebTablet.js')
        document.head.appendChild(topazScripts)

        let topazScript = document.createElement('script')
        topazScript.setAttribute('src', 'js/personal.js')
        document.head.appendChild(topazScript)
    },
    props:{
        consultation: Object,
        editMode: Boolean,
        patient: Object,
        appointment: Object,
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
