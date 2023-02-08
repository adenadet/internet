<template>
<form @submit.prevent="editMode ? editNotice() : createNotice()"  enctype="multipart/form-data">
    <alert-error :form="noticeData"></alert-error> 
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Topic</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="noticeData.topic" required>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" id="document" name="document" v-on:change="onFileChange"/> 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" v-model="noticeData.start_date" required/> 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" v-model="noticeData.end_date" required/> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" id="description" name="description" rows="5" v-model="noticeData.content"></textarea>
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
            noticeData: new Form({
                id:'', 
                topic: '', 
                end_date:'', 
                start_date: '', 
                content: '',
                editMode: '',
            }),
        }
    },
    methods:{
        onFileChange(e){
            //console.log(e.target.files[0]);
            this.filename = "Selected File: " + e.target.files[0].name;
            this.file = e.target.files[0];
            console.log(e.target.files[0].name);
        },
        createNotice(e){
            this.$Progress.start();
            //e.preventDefault();
            const json = JSON.stringify({ 
                topic: this.noticeData.topic, 
                start_date: this.noticeData.start_date, 
                end_date: this.noticeData.end_date, 
                content: this.noticeData.content,    
            });
            let currentObj = this;
            const config = {
                headers: {
                'content-type': 'multipart/form-data',
                //'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]'),
                }
            };
            // form data
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('data', json );

            console.log(formData);
            console.log(json);
            console.log(this.file);
            
            axios.post('/api/notices', formData, config)
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
        editNotice(){
            this.$Progress.start();
            const json = JSON.stringify({
                id: this.noticeData.id, 
                topic: this.noticeData.topic, 
                start_date: this.noticeData.start_date, 
                end_date: this.noticeData.end_date, 
                content: this.noticeData.content,    
            });
            
            let currentObj = this;
            
            const config = {
                headers: {'content-type': 'multipart/form-data',}
            };
            // form data
            let formData = new FormData();
            formData.append('id', this.noticeData.id);    
            formData.append('topic', this.noticeData.topic); 
            formData.append('start_date', this.noticeData.start_date); 
            formData.append('end_date', this.noticeData.end_date); 
            formData.append('content', this.noticeData.content); 
            formData.append('file', this.file);
            formData.append('data', json );
            
            console.log(formData);
            console.log(json);
            console.log(this.file);

            axios.post('/api/notices/modify', formData, config)
            .then(function (response) {
                currentObj.success = response.data.success;
                Fire.$emit('reloadPolicy', response);
                var message = editMode ? 'Notice was successfully updated!' : 'Notice was successfully added!';
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
                id: this.noticeData.id, 
                category_id: this.noticeData.category_id, 
                description: this.noticeData.description,
                name: this.noticeData.name, 
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
                axios.put('/api/policies/'+this.noticeData.id, formData, config)
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
        Fire.$on('noticeDataFill', notice =>{
            this.noticeData.reset();
            
            //this.noticeData.fill(notice)
            this.noticeData.id = notice.id 
            this.noticeData.topic = notice.topic
            this.noticeData.end_date = notice.end_date
            this.noticeData.start_date = notice.start_date
            this.noticeData.content = notice.content

            console.log(notice);
        });
    },
    props: {
        'departments': Array,
        'editMode': Boolean,
        'policy': Object,
    },
}
</script>