<template>
    <form @submit.prevent="editMode ? updateOption() : createOption()">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Question</label>
                    <div class="form-control">{{question.question}}</div>
                    <input type="hidden" name="exam_id" id="exam_id"  v-model="optionData.question_id"/>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Option</label>
                    <input type="text" class="form-control" name="option_text" id="option_text" v-model="optionData.option_text" />
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Points</label>
                    <input type="text" class="form-control" name="question" id="question" v-model="optionData.points" />
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Option Img</label>
                    <input class="form-control" type="file" name="option_img" id="option_img" />
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <input v-show="!editMode" type="submit" name="submit" class="submit btn btn-success" value="Submit" />
            <input v-show="editMode" type="submit" name="submit" class="submit btn btn-success" value="Update" />
        </div>
    </form>
</template>
<script>
export default {
     data(){
        return {
            course:{},
            document: '',
            form: new Form({}),
            lesson: {},
            optionData: new Form({
                'id': '',
                'option_text': '',
                'option_img': '',
                'question_id': '',
                'points': '',
            }),
            question:{},
            Question:{},
            subCategory: {},
            type: '', 
        }
    },
    methods:{
        createOption(){
            this.optionData.post('/api/lms/options').then(response=>{
                Fire.$emit('examRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'An Option was successfully added!',
                });
                this.$Progress.finish();
                this.optionData.reset();  
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'The Option was not added try again later!',
                });
            });
        },
        updateOption(){
            this.optionData.put('/api/lms/options/'+this.optionData.id)
            .then(response=>{
                this.$Progress.finish();
                Fire.$emit('examRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'An Option was successfully updated!',
                });
                this.optionData.reset();  
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Option was not updated, try again later!',
                });
            });
        },
    },
    mounted(){ 
        Fire.$on('optionDataFill', option =>{
            this.optionData.fill(option);
        });
        Fire.$on('optionRefresh', response =>{
            $('#optionModal').modal('hide');
            });
        Fire.$on('questionDataFill', question =>{
            this.question = question;
            this.optionData.question_id = question.id;
            });
        
        },
    props: {
        'editMode': Boolean,
        'option': Object,
        },
}
</script>