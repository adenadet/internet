<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="editMode ? updateBranch() : createBranch() ">
                    <alert-error :form="branchData"></alert-error> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="branchData.name" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Consultant In Charge</label>
                                <select class="form-control" id="cinc_id" name="cinc_id" v-model="branchData.cinc_id" required>
                                    <option value="">--Select Head of Branch--</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.unique_id+' | '+user.first_name+' '+user.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Head of Nurses</label>
                                <select class="form-control" id="hon_id" name="hon_id" v-model="branchData.hon_id" required>
                                    <option value="">--Select Head of Branch--</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.unique_id+' | '+user.first_name+' '+user.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Practice Manager</label>
                                <select class="form-control" id="pm_id" name="pm_id" v-model="branchData.pm_id" required>
                                    <option value="">--Select Head of Branch--</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.unique_id+' | '+user.first_name+' '+user.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" id="description" name="description" rows=5 placeholder="A full description of the Course" v-model="branchData.description"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
                </form>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return  {
            branchData: new Form({
                id: '',
                cinc_id: '',
                hon_id: '',
                name: '', 
                pm_id: '',
                description: '',
            }),
        }
    },
    mounted() {
        Fire.$on('BranchDataFill', branch =>{
            console.log('Working');
            this.branchData.id = branch.id;
            this.branchData.name = branch.name;
            this.branchData.pm_id = branch.pm_id;
            this.branchData.cinc_id = branch.cinc_id;
            this.branchData.hon_id = branch.hon_id;
            this.branchData.description = branch.description;
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.BioData.fill(data)));
        });
    },
    methods:{
        createBranch(){
            this.$Progress.start();
            this.branchData.post('/api/ums/branches')
            .then(response =>{
                Fire.$emit('BranchRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Branch'+ this.BranchData.name+' has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
            this.$Progress.finish();
            this.branchData.clear();
        },
        updateBranch(){
            this.$Progress.start();
            this.branchData.put('/api/ums/branches/'+ this.branchData.id)
            .then(response =>{
                Fire.$emit('BranchRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Branch '+this.branchData.name+' has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.$Progress.finish();
                this.branchData.clear();
            })
            .catch(()=>{
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
    props:{branch: Object, editMode: Boolean, users: Array,}
}
</script>
