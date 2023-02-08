<template>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reports</h3>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Patient</th>
                                <th>Status</th>
                                <th>Report Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="report in reports.data" :key="report.id">
                                <td>{{report.date | excelDate}}</td>
                                <td>{{report.service.name}}</td>
                                <td>{{report.patient !== null ? report.patient.last_name+', '+report.patient.first_name+' '+report.patient.middle_name : ''}}</td>
                                <td>{{report.status}}</td>
                                <td>{{report.radiologist_at != null ? report.radiologist_at : 'Not yet reported'}}</td>
                                <td>
                                    <div class="btn-group">
                                        <router-link :to="'/eservices/radiologist/report/'+report.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link>
                                    </div>          
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <pagination :data="reports" @pagination-change-page="getReports">
                    <span slot="prev-nav">&lt; Previous </span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            reports: {},
        }
    },
    methods:{
        addReport(){
            this.$Progress.start();
            this.editMode = false;
            this.report = {};
            Fire.$emit('ReportDataFill', {});
            $('#reportModal').modal('show');
            this.$Progress.finish();
        },
        deleteReport(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                })
            .then((result) => {
                //Send Delete request
                if(result.value){
                    this.form.delete('/api/lms/reports/'+id)
                    .then(response=>{
                    Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                    Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        editReport(report){
            this.$Progress.start();
            this.editMode = true;
            this.report = report;
            Fire.$emit('ReportDataFill', report);
            $('#reportModal').modal('show');
            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/emr/radiologists').then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Reports were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Reports were not loaded successfully',
                })
            });
        },
        getReports(page=1){
            axios.get('/api/emr/radiologists?page='+page)
            .then(response=>{
                this.reports = response.data.reports;   
            });
        },
        refresh(response){
            this.reports = response.data.reports;
        },
        seeReport(report){
            this.$Progress.start();
            this.report = report;
            //Fire.$emit('ReportRefresh', report)
            Fire.$emit('AssignUsers', report.assignees);
            Fire.$emit('ReportRefresh', this.report);
            this.$Progress.finish();
        },
    },
    mounted() {
        this.getAllInitials();
    },
}
</script>