<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#consent" data-toggle="tab">Consent Form</a></li>
                    <li class="nav-item"><a class="nav-link" href="#consultation" data-toggle="tab">Consultation</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="consent">
                            <EServiceDocConsentView :consent="appointment.consent" :appointment="appointment" :patient="appointment.patient" :consultation="appointment"/>
                        </div>
                        <div class="tab-pane" id="consultation">
                            <EServiceDocConsultationView  :consultation="consultation" :appointment="appointment" :patient="appointment.patient"/>
                        </div>
                        <div class="tab-pane" id="password">
                            <PMFormPassword />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                           
</div>
</template>

<script>
export default {
    data(){
        return  {
            
        }
    },
    mounted() {
        //console.log('Component mounted.')
    },
    created() {
        //this.getInitials();
        Fire.$on('reloadAppointment', response =>{this.refreshAppointment(response);});
    },
    methods:{
        getInitials(){
            axios.get('/api/emr/consultations/'+this.$route.params.id).then(response =>{
                this.$Progress.finish();
                this.reloadConsultation(response);
                toast.fire({
                    icon: 'success',
                    title: 'Consultation loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Consultation not loaded successfully',
                })
            });
        },
        getProfilePic(){
            let  photo = (this.form.image.length >= 150) ? this.form.image : "./"+this.form.image;
            return photo;
        },
    },
    props:{
        consent: Object,
        consultation: Object,
        patient: Object,
        appointment: Object,
        editMode: Boolean,
    }
}
</script>