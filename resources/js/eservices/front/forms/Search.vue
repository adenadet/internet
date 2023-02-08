<template>
<section class="card card-primary row clearfix">
    <div class="card-header">Appointment Search</div>
    <div class="card-body">
        <div class="col-md-12">
            <form @submit.prevent="searchAppointment()">
                <alert-error :form="searchData"></alert-error> 
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Applicant's Name</label>
                            <input class="form-control" id="patient" name="patient" v-model="searchData.patient" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>From:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" v-model="searchData.start_date" />
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>To:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" v-model="searchData.end_date" />
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search</button>
            </form>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            route: "",
            searchData: new Form({
                patient: "",
                start_date: "",
                end_date: "",
            }),
        }
    },
    mounted() {
        Fire.$on('searchDataFill', search =>{
            
        });
    },
    methods:{
        searchAppointment(){
            var route = '';
            if (this.search_type == "consultations"){ route = '/api/emr/consultations/search';}
            else if (this.search_type == "consultations"){ route = '/api/emr/appointments/search';}
            else if (this.search_type == "consultations"){ route = '/api/emr/appointments/search';}
            else{ route = '/api/emr/appointments/search';}
            this.searchData.post(route)
            .then(response => {
                this.$Progress.finish();
                Fire.$emit('refreshAppointment', response);
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
        },
    },
    props:{
        search_type: String,
    }
}
</script>