<template>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">General Policies</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search" v-model="search">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" @click="getAllInitials"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 d-flex align-items-stretch" v-for="policy in policies.data" :key="policy.id">
                            <div class="card bg-light">
                                <div class="card-header text-muted border-bottom-0">&nbsp;</div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>{{policy.name}}</b></h2>
                                        </div>
                                        <div class="col-5 text-center">
                                            <h1><i class="fa fa-file-pdf"></i></h1>
                                        </div>
                                        <div class="col-12">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-tag"></i></span> Category: {{policy.category_id != null && typeof policy.category != 'undefined' ? policy.category.name: ''}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <router-link :to="'/policies/view/'+policy.id"><button class="btn btn-sm btn-primary" title="Read"><i class="fa fa-eye"></i></button></router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <pagination :data="policies" @pagination-change-page="getAllInitials">
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
            policy:{},
            policies:{},
            search: '',
        }
    },
    methods:{
        getAllInitials(page=1){
            this.$Progress.start();
            axios.get('/api/policies/all/general?page='+page+'&query='+this.search)
            .then(response =>{
                this.policies = response.data.policies;
                this.$Progress.finish();
                //toast.fire({icon: 'success', title: 'Policies loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Policies were not loaded successfully',
                })
            });
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/policies/search?q='+query)
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