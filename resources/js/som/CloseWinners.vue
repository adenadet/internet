<template>
    <div class="overlay-wrapper">
        <div v-if="loading" class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Nominations for {{ month_date | ExcelMonthYear }}</h3>
                        <div class="card-tools">
                            <button class="btn btn-sm btn-primary" @click="openNominations(new_month)"><i class="fa fa-calendar-check"></i> Open Nomination for {{ new_month | ExcelMonthYear }}</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" style="max-height: 500px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Branch</th>
                                    <th>Staff</th>
                                    <th>Nominated By</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(nomination,index) in nominations" :key="nomination.id">
                                    <td>{{ index | addOne}}</td>
                                    <td>{{ nomination.branch != null ? nomination.branch.name: 'HQ?' }}</td>
                                    <td>{{ nomination.nominee | FullName }}</td>
                                    <td>{{ nomination.nominator | FullName }}</td>
                                    <td>{{ nomination.description }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <span v-if="staff_month != null && staff_month.nomination_end != null">Nominations have been closed, </span>
                        <button v-else class="btn btn-sm btn-primary" @click="closeNominations()"><i class="fa fa-calendar-times mr-1"></i>Close Nominations</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { assertNullLiteralTypeAnnotation } from '@babel/types';
import moment from 'moment'
export default {
    data(){
        return {
            nominations: [],
            loading: true,
            editMode: false,
            new_month: '',
            month: '', 
            month_date: '',
            nominateData: new Form({}),
            staff_month: {},
        }
    },
    methods:{
        closeNominations(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close nominations!'
            })
            .then((result) => {
                if(result.value){
                    this.$Progress.start();
                    this.nominateData.put('/api/som/nominations/close/'+this.month_date)
                    .then(response=>{
                        this.reloadPage(response);        
                        this.$Progress.finish();
                        Swal.fire({icon: 'success', title: 'All nominations has for '+this.month+' been closed!',});
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                        Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
                    })
                }
            });
        },
        getAllInitials(){
            this.loading = true;
            var currentDate = moment({});
            this.new_month = currentDate.format('YYYY-MM');
            var futureMonth = moment(currentDate).add(-1, 'M');
            var futureMonthEnd = moment(futureMonth).endOf('month');
            this.month = futureMonthEnd.format('YYYY-MM-DD');
            this.month_date = futureMonth.format('YYYY-MM');
            axios.get('/api/som/nominations/'+futureMonthEnd.format('YYYY-MM'))
            .then(response =>{
                this.reloadPage(response);
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Nominations did not loaded successfully',})
            });
        },
        openNominations(date){
            this.loading = true; this.$Progress.start();
            axios.get('/api/som/nominations/open/'+date)
            .then(response =>{
                Swal.fire({icon: 'success', title: response.data.message, showConfirmButton: false, timer: 1500});
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Nominations did not loaded successfully',})
            });
            //alert(date);
        },
        reloadPage(response){
            this.nominations = response.data.nominations;
            this.staff_month = response.data.staff_month;
            this.loading = false;
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('loadMonth', month=>{
            var futureMonth = moment(month).format('YYYY-MM');
            console.log(futureMonth);
            let query = this.$parent.search;
            axios.get('/api/som/nominations/'+futureMonth)
            .then((response ) => {this.reloadPage(response);})
            .catch(()=>{});
        });
    },
}
</script>