<template>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Consultation Detail</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                    <EServiceDocFormConsent v-if="appointment.consent == null" :patient="patient" :consent="appointment.consent" :consultation="consultation" :editMode="editMode" :appointment="appointment"/>
                    <EServiceDocFormScreening v-else-if="appointment.consultation == null" :consultation="consultation" :editMode="editMode" :appointment="appointment" />
                    <EServiceDocView v-else :consultation="appointment.consultation" :appointment="appointment" :editMode="!editMode" :patient="patient" :findings="findings"/>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
import ConsentForm from './forms/Consent.vue'; 
export default {
    data() {
        return {
            editMode: false,
            findings: [],
            appointment: {},
            consultation: {},
            consultations: {},
            patient: {},
        };
    },
    mounted() {
        this.getInitials();
        Fire.$on("refreshAppointment", response => {
            this.refreshAppointment(response);
        });
        Fire.$on("refreshPayment", response => {
            this.refreshAppointment(response);
            $("#paymentModal").modal("hide");
        });
    },
    methods: {
        addAppointment() {
            this.$Progress.start();
            this.editMode = false;
            this.appointment = {};
            Fire.$emit("AppointmentDataFill", {});
            $("#appointmentModal").modal("show");
            this.$Progress.finish();
        },
        getInitials() {
            axios.get("/api/emr/appointments/" + this.$route.params.id)
                .then(response => {
                Fire.$emit("refreshAppointment", response);
            })
                .catch(() => {
                this.$Progress.fail();
                toast.fire({
                    icon: "error",
                    title: "Your appointments did not loaded successfully",
                });
            });
        },
        refreshAppointment(response) {
            this.appointment = response.data.appointment;
            this.consultation = response.data.appointment;
            this.patient = this.consultation.patient;
            this.findings = response.data.findings;
        },
    },
    components: { ConsentForm }
}
</script>