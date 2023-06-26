<template>
    <div class="row clearfix">
        <div class="col-lg-12"><EServiceFormSearch search_type="radiologist"/></div>
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
                                    <th>Reported By</th>
                                    <th>Report Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="report in reports.data" :key="report.id">
                                    <td>{{report.date | excelDate}}</td>
                                    <td>{{report.service.name}}</td>
                                    <td>{{report.patient !== null ? report.patient.last_name+', '+report.patient.first_name+' '+report.patient.middle_name : ''}}</td>
                                    <td>{{report.radiologist != null ? 'Dr. '+report.radiologist.first_name+' '+report.radiologist.last_name : 'Deleted Doctor'}}</td>
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
            getAllInitials(){
                this.$Progress.start();
                axios.get('/api/emr/radiologists/reviews').then(response =>{
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
        },
        mounted() {
            this.getAllInitials();
            Fire.$on('refreshAppointment', response => {
                this.refresh(response);
                $('#reportModal').modal('hide');
            });
        },
    }
    </script>