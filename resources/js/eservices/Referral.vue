<template>
<section class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="invoice p-3 m-5">
                <div class="row">
                    <div class="col-12 mb-2">
                        <center><img src="/img/background/SNH_logo.png" height="60" width="auto" /></center>
                    </div>
                    <div class="col-12 bg-dark p-1" style="background-color: #1434A4 !important;">
                        <center><h3>PATIENT REFERRAL FORM</h3></center>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-8 invoice-col">
                        <h3>Date:  <strong><u>{{ referral.updated_at | excelDate }}</u></strong></h3>
                        <h3>REF: <strong><u>{{ appointment.patient | FullName }}</u></strong></h3>
                        <h3>SNH No: <strong><u>{{ appointment.unique_id }}</u></strong></h3>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <h3>Date of Birth: <strong><u>{{appointment.patient.dob}}</u></strong></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Medical History</h3>
                            </div>
                            <div class="card-body">
                                <div v-html="referral.details" style="min-height:400px;"></div>

                                <p style="font-size:30px;" class="mt-3"><strong>Yours Sincerely,<br />For: St. Nicholas Hospital</strong></p>
                                <p><img :src="referral.creator.id == 56 ? '/img/consents/rusman.png' : (referral.creator.id == 57 ? '/img/consents/rabudah.png' :(referral.creator.id == 55 ? '/img/consents/bsalami.png' :(referral.creator.id == 331 ? '/img/consents/mnwachukwu.png' :'/img/consents/bsalami.png')))" class="img-fluid" /></p>
                                <p style="font-size:30px;" class="mt-3"><strong>Dr. {{ referral.creator | FullName }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-5 invoice-col">
                        <i class="fa fa-phone mr-1"></i><small> +234 1271 8691-3, +234 802 290 8484, +234 803 525 1295</small>
                    </div>
                    <div class="col-md-3 invoice-col">
                        <i class="fa fa-envelope mr-1"></i> <small>info@saintnicholashospital.com</small>
                    </div>
                    <div class="col-md-4 invoice-col">
                        <i class="fa fa-globe mr-1"></i> <small>www.saintnicholashospital.com</small>
                    </div>
                </div>
                <hr />
                <div class="row invoice-info">
                    <div class="col-sm-3 invoice-col">
                        <address>
                            <strong>Lagos Island</strong><br>
                            57, Campbell Street,<br>
                            Lagos Island, Lagos<br>
                        </address>
                    </div>
                    <div class="col-sm-3 invoice-col">
                        <address>
                            <strong>Victoria Island</strong><br>
                            7B, Etim Inyang Crescent,<br>
                            Victoria Island, Lagos
                        </address>
                    </div>
                    <div class="col-sm-3 invoice-col">
                        <address>
                            <strong>Lekki Free Trade Zone</strong><br>
                            Lekki, Ibeju Lekki<br>
                            Lagos<br>
                        </address>
                    </div>
                    <div class="col-sm-3 invoice-col">
                        <address>
                            <strong>Maryland</strong><br>
                            18, Faramobi Ajike Crescent,<br>
                            Off Ikorodu Rd., Anthony, Lagos
                        </address>
                    </div>
                </div>
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
            referral: {}
        };
    },
    mounted() {
        this.getInitials();
    },
    methods: {
        getInitials() {
            axios.get("/api/emr/referrals/" + this.$route.params.id)
            .then(response => {
                this.refreshAppointment(response);
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
            this.referral = response.data.referral;
        },
    },
}
</script>