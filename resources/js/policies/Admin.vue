<template>
<div class="col-12">
    <div class="modal fade" id="policyModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ editMode ? 'Edit Policy: '+ policy.name : 'Create New Policy'}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <PoliciesForm :departments="departments" :editMode="editMode" :policy="policy"/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="assignModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Policies to Department</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <PoliciesFormAssign :departments="departments"/>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of All Policies</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search" v-model="search">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" @click="getAllInitials()"><i class="fas fa-search"></i></button>
                        <button type="button" class="btn btn-sm btn-success" @click="createPolicy">Add New</button>
                    </div>  
                </div>
            </div>
            <div class="card-tools"></div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table m-b-0 col-md-12">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>File</th>
                        <th>Category</th>
                        <th>Created By</th>
                        <th>No of Departments</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="policy in policies.data" :key="policy.id">
                        <td><h6 class="mb-0">{{policy.name}}</h6></td>
                        <td v-if="policy.file === null"><i class="fa fa-times"></i></td>
                        <td v-else><i class="fa fa-check"></i></td>
                        <td>{{typeof policy.category != 'undefined' && policy.category != null ? policy.category.name: 'Category'}}</td>
                        <td>{{typeof policy.creator != 'undefined' && policy.creator != null ? policy.creator.first_name+' '+policy.creator.last_name: 0 }}</td>
                        <td>{{typeof policy.depts != 'undefined' && policy.depts != null ? policy.depts.length: 0 }}</td>
                        <td>
                            <div class="btn btn-group">
                                <a class="btn btn-primary" title="Read Policy" :href="'/policies/view/'+policy.id"><i class="fa fa-eye"></i></a>
                                <button class="btn btn-success" title="Edit Policy" @click="editPolicy(policy)"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-warning" title="Assign Policy" @click="assignPolicy(policy)"><i class="fa fa-inbox"></i></button>
                                <button class="btn btn-danger"  title="Delete Policy" @click="deletePolicy(policy.id)"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <pagination :data="policies" @pagination-change-page="getAllInitials">
                <span slot="prev-nav">&lt; Previous </span>
                <span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>
    </div>    
</div>
</template>
<script>
export default {
    data(){
        return {
            categories: {},
            departments: [],
            editMode: false,
            form: new Form({}),
            policy: {},
            policies: {},
            search: '',
        }
    },
    methods:{
        assignPolicy(policy){
            if (policy.category_id == 0){
                Swal.fire({
                    title: 'This is a General Policy, it can not be assigned to a Department',
                    icon: 'error',
                })
            }
            else{
                this.policy = policy;
                Fire.$emit('policyLoad', policy);
                $('#assignModal').modal('show');
            }
        },
        createPolicy(){
            this.editMode = false;
            this.policy = {};
            Fire.$emit('policyDataFill', this.policy);
            $('#policyModal').modal('show');
        },
        deletePolicy(id){
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
                    this.form.delete('/api/policies/'+id)
                    .then(response=>{
                    Swal.fire('Deleted!', 'Policies has been deleted.', 'success');
                    Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!',});});
                }
            }); 
        },
        editPolicy(policy){
            this.editMode = true;
            this.policy = policy;
            Fire.$emit('policyDataFill', policy);
            $('#policyModal').modal('show');
        },
        getAllInitials(page=1){
            alert(page)
            this.$Progress.start();
            axios.get('/api/policies?page='+page+'&search='+this.search).then(response =>{
                this.reset(response);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Policies loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Policies not loaded successfully',});
            });
        },
        reset(response){
            this.categories = response.data.categories;
            this.departments = response.data.departments;
            this.policies = response.data.policies;

            $('#assignModal').modal('hide');
            $('#policyModal').modal('hide');
        }
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('reloadPolicy', response =>{this.reset(response); console.log("Updated")});
    }   
}
</script>