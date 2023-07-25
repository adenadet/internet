<template>
<section class="content-header">
    <div class="container-fluid">
        <section class="card card-primary">
            <div class="card-header">Report Query</div>
            <div class="card-body">
                <div class="col-md-12">
                    <form @submit.prevent="searchAppointment()">
                        <alert-error :form="reportData"></alert-error> 
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Report Type</label>
                                    <select class="form-control" id="report_type" name="report_type" v-model="reportData.report_type" required>
                                        <option value="">--Select Type of Detailed Report--</option>
                                        <option value="all">All Appointments</option>
                                        <option value="pending">Pending Appointments</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Start Date:</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" v-model="reportData.start_date" required/>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>End Date:</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" v-model="reportData.end_date" required/>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search</button>
                    </form>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header"><h3 class="card-title">Report</h3></div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead v-if="report_type == 'all' || report_type == ''">
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>X-ray</th>
                                    <th>Sputum</th>
                                    <th>Kids under 11</th>
                                    <th>Postponed</th>
                                    <th>Missed</th>
                                </tr>
                            </thead>
                            <thead v-else-if="report_type == 'pending'">
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Total No</th>
                                    <th>Total Amount</th>
                                    <th>Kids No</th>
                                    <th>Kids Amount</th>
                                    <th>Adult No</th>
                                    <th>Adult Amount</th>
                                    <th>Strange No</th>
                                    <th>Strange Amount</th>
                                </tr>
                            </thead>
                            <tbody v-if="reports == null">
                                <tr><td colspan="8" class="text-center">No report yet. Fill the form please</td></tr>
                            </tbody>
                            <tbody v-else-if="report_type == 'all' && reports != null">
                                <tr v-for="(report, index) in reports" :key="index">
                                    <td>{{index | addOne}}</td>
                                    <td>{{report.date | excelDate}}</td>
                                    <td>{{report.total}}</td>
                                    <td>{{report.x_ray}}</td>
                                    <td>{{report.sputum}}</td>
                                    <td>{{report.kid_under_11}}</td>
                                    <td>{{report.postponed}}</td>
                                    <td>{{report.missed}}</td>
                                </tr>
                            </tbody>
                            <tbody v-else-if="report_type == 'pending' && reports != null">
                                <tr v-for="(report, index) in reports" :key="index">
                                    <td>{{index | addOne}}</td>
                                    <td>{{report.end_date}}</td>
                                    <td>{{report.total_no}}</td>
                                    <td>{{report.total_amount | currency}}</td>
                                    <td>{{report.no_kids}}</td>
                                    <td>{{report.total_kids | currency}}</td>
                                    <td>{{report.no_adult}}</td>
                                    <td>{{report.total_adult | currency}}</td>
                                    <td>{{report.no_strange}}</td>
                                    <td>{{report.total_strange | currency}}</td>
                                </tr>
                            </tbody>
                        </table>
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
            appointments:[],
            reportData: new Form({
                report_type: "",
                start_date: "",
                end_date: "",
            }),
            reports: [],
            report_type: "",
        }
    },
    mounted() {
        //this.getInitials();
        Fire.$on('refreshReport', response => {
            this.refreshReport(response);
        });
    },
    methods: {
        
        searchAppointment(){
            this.$Progress.start();
            this.reportData.post('/api/emr/admin/summary_report')
            .then(response => {
                this.appointments = response.data.appointments;
                this.reports = response.data.reports;
                this.report_type = response.data.report_type;
                this.$Progress.finish();
            })
            .close(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                    });
                this.$Progress.fail();
            });
        }
    },

}
</script>