<template>
    <section class="content p-10">
        <div class="container-fluid" v-if="(appointment == null) || (appointment.issuing_officer == null)">
            <div class="card">
                <div class="card-header">Incomplete Appointment</div>
                <div class="card-body"><p>This certificate is still been processed.</p></div>
            </div>
        </div>
        <!-- For those that did Xray scan-->
        <div class="container-fluid" v-else-if="((appointment != null) && (appointment.report != null) && (appointment.patient != null))">
            <div class="invoice p-5 mb-3">    
            <EServiceCertificateHeader :appointment="appointment" />
                <div class="row">
                    <div class="col-7">
                        <EServiceCertificateBioData :appointment="appointment" />
                    </div>
                    <div class="col-5">
                        <EServiceCertificateSummary :appointment="appointment" />
                    </div>
                    <EServiceCertificateFooter :appointment="appointment" />
                </div>
            </div>
        </div>
        <!--For those that did sputum-->
        <div class="container-fluid" v-else-if="((appointment != null) && (appointment.laboratory != null) && (appointment.patient != null))">
            <div class="invoice p-5 mb-3">    
            <EServiceCertificateHeader :appointment="appointment" />
                <div class="row">
                    <div class="col-7">
                        <EServiceCertificateBioData :appointment="appointment" />
                    </div>
                    <div class="col-5">
                        <EServiceCertificateSummaryLab :appointment="appointment" />
                    </div>
                    <EServiceCertificateFooter :appointment="appointment" />
                </div>
            </div>
        </div>
        <!-- For those kids under 11 years-->
        <div class="container-fluid" v-else-if="((appointment != null) && (appointment.consultation.decision == 8) && (appointment.patient != null))">
            <div class="invoice p-5 mb-3">    
            <EServiceCertificateHeader :appointment="appointment" />
                <div class="row">
                    <div class="col-7">
                        <EServiceCertificateBioData :appointment="appointment" />
                    </div>
                    <div class="col-5">
                        <EServiceCertificateSummaryKid :appointment="appointment" />
                    </div>
                    <EServiceCertificateFooter :appointment="appointment" />
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
        age(date){
            var dob = new Date(date);
            var month_diff = Date.now() - dob.getTime();  
            var age_dt = new Date(month_diff);   
            var year = age_dt.getUTCFullYear();  
            var age = Math.abs(year - 1970);  
            
            return age;
        },
        getInitials() {
            axios.get('/api/certificates/' + this.$route.params.id)
                .then(response => {
                    Fire.$emit('refreshAppointment', response);
                })
                .catch(() => {
                    this.$Progress.fail();
                    toast.fire({icon: 'error', title: 'The certificate did not loaded successfully',})
                });
        },
        refreshAppointment(response) {this.appointment = response.data.appointment;}
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