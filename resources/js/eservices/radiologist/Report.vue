<template>
<div class="row clearfix">
    <div class="modal fade" id="reportModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Report</h4>
                    <h4 class="modal-title" v-show="!editMode">New Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <EServiceRadFormReport :editMode="editMode" :report="report" :findings="findings" :patient="report.patient" :appointment="appointment" :service="report.service"/>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Report Detail</h3>
            <div class="card-tools">
                <button v-if="report.report == null" class="btn btn-sm btn-primary" @click="addReport"><i class="fa fa-edit"></i> Write Report</button>
                <button v-else="report.report != null" class="btn btn-sm btn-warning" @click="editReport"><i class="fa fa-edit"></i> Update Report</button>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1" v-if="report != null && report.service != null">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Estimated Cost</span>
                                <span class="info-box-number text-center text-muted mb-0">{{report.service.price}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light bg-primary">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Status</span>
                                <span class="info-box-number text-center text-muted mb-0">{{report.status == 0 ? 'Unpaid' : (report == 9 ? 'Cancelled' : 'Paid')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Estimated duration</span>
                                <span class="info-box-number text-center text-muted mb-0">{{report.service.duration != null ? report.service.duration+' mins': 'Not Defined'}} </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4>Recent Activity</h4>
                        <div class="post" v-if="report.radiologist != null && report.radiologist_id != null">
                            <h6><b>Radiologist</b></h6>
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="report.radiologist != null ? '/img/profile/'+report.radiologist.image : '/img/profile/default.png'" :title="report.radiologist.first_name+' '+report.radiologist.last_name">
                                <span class="username"><a href="#">{{report.radiologist != null ? report.radiologist.first_name+' '+report.radiologist.last_name : 'Radiologist Undefined'}}</a>
                                </span>
                                <span class="description">Posted: {{report.radiologist_at | excelDate}}</span>
                            </div>
                            <p>{{report.report.summary}}</p>
                            <p>{{report.radiologist_remark}}</p>
                        </div>

                        <div class="post clearfix" v-if="report.medical_officer != null && report.doctor_id != null">
                            <h6><b>Medical Officer</b></h6>
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="report.medical_officer != null && report.medical_officer.image != null ? '/img/profile/'+report.medical_officer.image : '/img/profile/default.png'" alt="user image">
                                <span class="username"><a href="#">{{report.medical_officer != null ? report.medical_officer.first_name+' '+report.medical_officer.last_name : 'Radiologist Undefined'}}</a>
                                </span>
                                <span class="description">Posted: {{report.medical_officer_at | excelDate}}</span>
                            </div>
                            <p>{{report.medical_officer_remark}}</p>
                        </div>

                        <div class="post clearfix" v-if="report.front_office_id != null">
                            <h6><b>Front Officer</b></h6>
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="report.front_officer != null ? '/img/profile/'+report.front_officer.image : '/img/profile/default.png'" :title="report.front_officer != null ? report.front_officer.first_name+' '+report.front_officer.last_name : 'Undefined Officer'">
                                <span class="username"><a href="#">{{report.front_officer != null ? report.front_officer.first_name+' '+report.front_officer.last_name : 'Undefined Officer'}}</a>
                                </span>
                                <span class="description">Posted: {{report.arrived_at | excelDate}}</span>
                            </div>
                            <p v-html="report.front_office_remark"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1" v-else>
                <img class="img-fluid" src="/img/loading/1.gif"/>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2" v-if="report.patient != null">
                <h4 class="text-primary"><i class="fas fa-user"></i> {{report.patient.first_name+' '+report.patient.middle_name+' '+report.patient.last_name}}</h4>
                <div class="text-muted">
                    <p class="text-sm">Sex | Age: <b class="d-block">{{report.patient.sex}} | {{report.patient.dob | age}} years</b></p>
                    <p class="text-sm">Registered at: <b class="d-block">{{report.patient.created_at | excelDate}}</b></p>
                    <p class="text-sm">Nationality: <b class="d-block">{{report.patient.nationality != null && report.patient.nationality_id != null ? report.patient.nationality.name : 'None Given'}}</b></p>
                    <p class="text-sm">Passport: <b class="d-block">{{report.patient.passport_no != null ? report.patient.passport_no :'Request Passport' }}</b>
                    </p>
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
        return {
            editMode: false,
            report: {}, 
            appointment: {},
            findings: [],    
        }
    },
    methods:{
        addReport(){
            this.editMode = false;
            Fire.$emit('reportDataFill', this.report);
            $('#reportModal').modal('show');
            this.$Progress.finish();
        },
        editReport(){
            this.$Progress.start();
            this.editMode = true;
            Fire.$emit('reportDataFill', this.report);
            $('#reportModal').modal('show');
            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/emr/radiologists/'+this.$route.params.id)
            .then(response =>{
                this.reportReload(response);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Report was loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Report was not loaded successfully',})
            });
        },
        reportReload(response){
            this.findings = response.data.findings;
            this.report = response.data.report;
        },
    },
    mounted() {
        this.getAllInitials();    
        Fire.$on('reportReload', response=>{
            this.reportReload(response);
            $('#reportModal').modal('hide');
        });    
    }
}
</script>