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
                    <EServiceDocFormConsent v-if="consultation.status = 4" :patient="patient" :consultation="consultation" />
                    <EServiceDocFormScreening v-if="consultation.status = 5" :patient="patient" :consultation="consultation" />
                    <div class="row">
                    <div class="col-12">
                        <h4>Recent Activity</h4>
                        <div class="post">
                            <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="/dist/img/user1-128x128.jpg" alt="user image">
                            <span class="username">
                                <a href="#">Jonathan Burke Jr.</a>
                            </span>
                            <span class="description">Shared publicly - 7:45 PM today</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore.
                            </p>

                            <p>
                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                            </p>
                        </div>

                        <div class="post clearfix">
                            <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="/dist/img/user7-128x128.jpg" alt="User Image">
                            <span class="username">
                                <a href="#">Sarah Ross</a>
                            </span>
                            <span class="description">Sent you a message - 3 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore.
                            </p>
                            <p>
                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 2</a>
                            </p>
                        </div>

                        <div class="post">
                            <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="/dist/img/user1-128x128.jpg" alt="user image">
                            <span class="username">
                                <a href="#">Jonathan Burke Jr.</a>
                            </span>
                            <span class="description">Shared publicly - 5 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore.
                            </p>

                            <p>
                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                            </p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <h3 class="text-primary"><i class="fas fa-user"></i> Applicant Detail</h3>
                    <p class="text-muted"></p><br>
                    <div class="text-muted">
                    <p class="text-sm">Applicant's Name <b class="d-block">{{patient.last_name+', '+patient.first_name+' '+patient.middle_name}}</b></p>
                    <p class="text-sm">Service <b class="d-block">{{consultation.service != null ? consultation.service.name: 'Truncated Service'}}</b></p>
                    <p class="text-sm">Date of Birth | Sex | LMP <b class="d-block">{{patient.dob}} | {{patient.sex}} |  {{patient.lmp}}</b></p>
                    <p class="text-sm">Nationality | Passport No <b class="d-block">{{patient.nationality != null ? patient.nationality.name : ''}} | {{patient.passport_number}}</b></p>
                    <p class="text-sm">Number of Accompanying Kids <b class="d-block">{{patient.accompanying_kids}}</b></p> 
                    </div>

                    <h5 class="mt-5 text-muted">Results files</h5>
                    <ul class="list-unstyled">
                    <li><a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Functional-requirements.docx</a></li>
                    <li><a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> UAT.pdf</a></li>
                    <li><a href="" class="btn-link text-secondary"><i class="far fa-fw fa-envelope"></i> Email-from-flatbal.mln</a></li>
                    <li><a href="" class="btn-link text-secondary"><i class="far fa-fw fa-image "></i> Logo.png</a></li>
                    <li><a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Contract-10_12_2014.docx</a></li>
                    </ul>
                    <div class="text-center mt-5 mb-3">
                    <a href="#" class="btn btn-sm btn-primary">Add files</a>
                    <a href="#" class="btn btn-sm btn-warning">Report contact</a>
                    </div>
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
            consultation: {},
            consultations: {},
            patient: {},
            editMode: true,
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
            //this.appointment = response.data.appointment;
            this.consultation = response.data.appointment;
            this.patient = this.consultation.patient;
        },
    },
    components: { ConsentForm }
}
</script>