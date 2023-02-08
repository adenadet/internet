<template>
    <form role="form" @submit.prevent="assignDepartment">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Policy</label>
                    <input type="text" class="form-control" v-model="assignData.policy_name" disabled />
                    <input type="hidden" name="policy_id" id="policy_id" v-model="assignData.policy_id" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"><label>Departments</label></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3" v-for="department in departments" :key="department.id">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="departments[]" id="departments[]" v-model="assignData.departments" :value="department.id" :checked="assignData.departments.includes(department.id)">
                    <label class="form-check-label">{{department.name}}</label>
                </div>
            </div>
        </div> 
        <div class="row">
            <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
        </div>
    </form>
</template>
<script>
export default {
    data(){
        return  {
            assignData: new Form({'policy_id': '', 'policy_name': '', 'departments': [],}),
        }
    },
    mounted(){      
    },
    created(){
        Fire.$on('policyLoad', policy =>{this.reloadData(policy);});
    },
    methods:{
        assignDepartment(){
            this.$Progress.start();
            this.assignData.post('/api/policies/assign')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Policy "'+ response.data.policy.name+'" has been updated',
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
        reloadData(policy){
            this.assignData.policy_id   = policy.id;
            this.assignData.policy_name = policy.name;
            this.assignData.departments = [];
            for (let i = 0; i < policy.depts.length; i++) {this.assignData.departments.push(policy.depts[i].department.id);}    
        },
    },
    props:{
        'departments': Array,
    },
}
</script>
