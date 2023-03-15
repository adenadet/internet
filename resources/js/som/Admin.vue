<template>
<section class="row">
    <div class="modal fade" id="monthModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Month Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <SOMFormMonth :editMode="editMode" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 card card-primary">
        <div class="card-header"><h3 class="card-title">Staff of the Month Administrator</h3>
            <div class="card-tools">
                <button class="btn btn-xs btn-default" @click="addMonth()"><i class="fa fa-calendar-check"></i> Add new Month</button>
            </div>
        </div>
        <div class="card-body">
            <section class="row">
                <div class="col-2">
                    <section>
                        List of Months 
                        <button class="btn btn-block btn-default" @click="showMonth(month.month)" v-for="month in months.data" :key="month.id">{{month.month | ExcelMonthYear}}</button>
                    </section>
                </div>
                <div class="col-10">
                    <section class="row">
                        <div class="col-12 col-md-12 col-sm-6">
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                                        <li class="nav-item"><a class="nav-link" id="details-tab" data-toggle="pill" href="#details" role="tab" aria-controls="detail" aria-selected="true">Details</a></li>
                                        <li class="nav-item"><a class="nav-link active" id="nomination-tab" data-toggle="pill" href="#nomination" role="tab" aria-controls="nomination" aria-selected="true">Nominations</a></li>
                                        <li class="nav-item"><a class="nav-link" id="voting-tab" data-toggle="pill" href="#voting" role="tab" aria-controls="voting" aria-selected="false">Voting</a></li>
                                        <li class="nav-item"><a class="nav-link" id="winners-tab" data-toggle="pill" href="#winners" role="tab" aria-controls="winners" aria-selected="true">Winners</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-five-tabContent">
                                        <div class="tab-pane fade show active" id="nomination" role="tabpanel" aria-labelledby="nomination-tab"><SOMCloseNominations /></div>
                                        <div class="tab-pane fade" id="voting" role="tabpanel" aria-labelledby="voting-tab"><SOMCloseVoting /></div>
                                        <div class="tab-pane fade show" id="details" role="tabpanel" aria-labelledby="details-tab"><SOMDetail /></div>
                                        <div class="tab-pane fade show" id="winners" role="tabpanel" aria-labelledby="winners-tab"><SOMCloseWinners /></div>
                                    </div>
                                </div>
                            </div> 
                        </div>  
                    </section>
                </div>
            </section>
        </div>   
    </div>
</section>
</template>
<script>
//import moment from 'moment'
export default {
    data(){
        return {
            dept_users: [],
            editMode: false,
            month: '',
            months: {},
            nominateData: new Form({
                id: '',
                user_id: 0,
                month: '',
                description: '',
            }),
            staff_months: {},   
        }
    },
    methods:{
        addMonth(){
            this.editMode = false;
            this.month = {};
            Fire.$emit('MonthDataFill', this.month);
            $('#monthModal').modal('show');
        
        },
        closeModal(){
            $('#monthModal').modal('hide');
        },
        editMonth(month){
            this.editMode = true;
            Fire.$emit('MonthDataFill', month);
            $('#monthModal').modal('show');
        },
        getAllInitials(){
            axios.get('/api/som/months')
            .then(response =>{
                this.reloadPage(response);
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Dashboard not loaded successfully',
                })
            });
        },
        reloadPage(response){
            this.months = response.data.staff_months;
            this.showMonth = response.data.staff_month.month;
        },
        showMonth(month){
            Fire.$emit('loadMonth', month);
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('monthReload', response=>{
            this.closeModal();
            this.reloadPage(response);
        });
        Fire.$on('fireEditMonth', month =>{
            this.editMonth(month);
        });
    }
}
</script>