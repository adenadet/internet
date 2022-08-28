<template>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3 class="card-title">My Departmental Policies</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 d-flex align-items-stretch" v-for="policy in policies.data" :key="policy.id">
                            <div class="card bg-light" v-show="policy.policy != null">
                                <div class="card-header text-muted border-bottom-0">&nbsp;</div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>{{policy.policy != null ? policy.policy.name: 'Deleted Policy'}}</b></h2>
                                        </div>
                                        <div class="col-5 text-center">
                                            <h1><i class="fa fa-file-pdf"></i></h1>
                                        </div>
                                        <div class="col-12">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-tag"></i></span> Category: {{policy.policy != null && policy.policy.category_id != null && typeof policy.policy.category != 'undefined' ? policy.policy.category.name: ''}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <router-link :to="policy.policy != null ? '/policies/view/'+policy.policy.id : '/policies/'"><button class="btn btn-sm btn-primary" title="Read"><i class="fa fa-eye"></i></button></router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <pagination :data="policies" @pagination-change-page="getPolicy">
                            <span slot="prev-nav">&lt; Previous </span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
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
            areas:[],
            branches:[],
            departments:[],
            editMode: false,
            savings:{},
            states:[],
            policy:{},
            policies:{},
            form: new Form({}),
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/policies/all/departmental').then(response =>{
                this.policies = response.data.policies;
                
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Policies loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Policies were not loaded successfully',
                })
            });
        },
        getPolicy(page=1){
            axios.get('/api/policies/all/departmental?page='+page)
            .then(response=>{
                this.Policys = response.data.Policys;   
            });
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/Policys/search?q='+query)
            .then((response ) => {
                this.Policys = response.data.Policys;
            })
            .catch(()=>{

            });
        });
        Fire.$on('Reload', response =>{
            $('#PolicyModal').modal('hide');
            this.Policys = response.data.Policys;
        });
    },
}
</script>