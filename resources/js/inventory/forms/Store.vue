<template>
<section>
    <form>
        <alert-error :form="StoreData"></alert-error> 
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" name="name" v-model="StoreData.name" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Branch</label>
                    <select class="form-control" id="branch_id" name="branch_id" v-model="StoreData.branch_id">
                        <option value="">--Select Branch--</option>
                        <option v-for="branch in branches" :value="branch.id">{{ branch.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Department</label>
                    <select class="form-control" id="department_id" name="department_id" v-model="StoreData.department_id">
                        <option value="">--Select Department--</option>
                        <option v-for="department in departments" :value="department.id">{{ department.name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="status" name="status" v-model="StoreData.status">
                        <option value="">--Select Status--</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="StoreData.id" />
        <button @click.prevent="editMode ? updateStore() : createStore()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            branches: [],
            departments: [],
            StoreData: new Form({
                name: '', 
                branch_id: '',
                department_id: '', 
                status: '', 
                id: '',
            }),
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('StoreDataFill', store =>{
            this.StoreData.fill(store);
        });
    },
    methods:{
        createStore(){
            this.$Progress.start();
            this.StoreData.post('/api/inventory/stores')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('storeReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Store has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });  
        },
        getInitials(){
            axios.get('/api/inventory/stores/initials')
            .then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Users loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Users not loaded successfully',
                })
            });
        },
        refreshPage(response){
            this.branches = response.data.branches;
            this.departments = response.data.departments;
        },
        updateStore(){
            this.$Progress.start();
            this.StoreData.put('/api/inventory/stores/'+this.StoreData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('storeReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Store has been updated',
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
        },
    },
    props:{
        editMode: Boolean,
    }
}
</script>