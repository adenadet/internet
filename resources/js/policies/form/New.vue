<template>
<form @submit.prevent="createPolicy"  enctype="multipart/form-data">
    <alert-error :form="policyData"></alert-error> 
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Policy Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="policyData.name" required>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Category</label>
                <select class="form-control" id="category_id" name="category_id" placeholder="Youtube Video Link" v-model="policyData.category_id">
                    <option value="">---Select Policy Type---</option>
                    <option value="0">General Type</option>
                    <option v-for="department in departments" :key="department.id" :value="department.id">{{department.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Upload File</label>
                <input type="file" class="form-control" id="document" name="document" v-on:change="onFileChange"/> 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Existing File</label>
                <div class="form-control">{{policyData.file != null ? policyData.file: "No File Added Yet"}}</div> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" v-model="policyData.description"></textarea>
            </div>
        </div>
        <input type="hidden" name="editMode" id="editMode" :value="editMode" />
        <div class="col-md-4 col-sm-12">
            <input type="submit" name="submit" class="submit btn btn-success" :value="editMode ? 'Update' : 'Create'" />
        </div>
    </div>
</form>
</template>
<script>
export default {
    data(){
        return {   
            file: '',
            filename: '',
            policyData: new Form({
                id:'', 
                category_id: '', 
                name:'', 
                file: '', 
                description: '',
                editMode: '',
            }),
        }
    },
    methods:{
        onFileChange(e){
            //console.log(e.target.files[0]);
            this.filename = "Selected File: " + e.target.files[0].name;
            this.file = e.target.files[0];
        },
        createPolicy(e){
            //e.preventDefault();
            const json = JSON.stringify({
                id: this.policyData.id, 
                name: this.policyData.name, 
                category_id: this.policyData.category_id, 
                description: this.policyData.description,
                
            });
            let currentObj = this;
            const config = {
                headers: {
                'content-type': 'multipart/form-data',
                //'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            };
            // form data
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('data', json );

            console.log(formData);
            
            axios.post('/api/policies', formData, config)
            .then(function (response) {
                currentObj.success = response.data.success;
                currentObj.filename = "";
                Fire.$emit('reloadPolicy', response);
                var message = editMode ? 'Policy was successfully updated!' : 'Policy was successfully added!';
                Swal.fire({
                    icon: 'success',
                    title: message,
                });
            })
            .catch(function (error) {currentObj.output = error;});
        },
        uploadFile(e){
            this.file = e.target.files[0];
        },
        uploadFiles(e) {
            e.preventDefault();
            
            const json = JSON.stringify({
                id: this.policyData.id, 
                category_id: this.policyData.category_id, 
                description: this.policyData.description,
                name: this.policyData.name, 
                editMode: this.editMode,
            });
            //console.log(json);

            let currentObj = this;
            
            const config = {headers: { 'content-type': 'multipart/form-data'}}

            let formData = new FormData();
            if (!(this.editMode)){formData.append('file', this.file);}
            formData.append('data', json);

            console.log(formData.data);
            if (editMode){
                axios.put('/api/policies/'+this.policyData.id, formData, config)
                .then(function (response) {
                    Fire.$emit('CourseRefresh', response.data.course);
                    Swal.fire({icon: 'success', title: response.data.success,});   
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            }
            else{
                axios.post('/api/policies', formData, config)
                .then(function (response) {
                    //Fire.$emit('refresh', response);
                    Fire.$emit('CourseRefresh', response.data.course);
                    Swal.fire({icon: 'success', title: response.data.success,});   
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            }
            
        },
    },
    mounted() {
        Fire.$on('policyDataFill', policy =>{
            this.policyData.reset();
            this.policyData.fill(policy)
        });
    },
    props: {
        'departments': Array,
        'editMode': Boolean,
        'policy': Object,
    },
}
</script>