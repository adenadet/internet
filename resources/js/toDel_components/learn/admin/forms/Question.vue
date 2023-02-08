<template>
    <form @submit.prevent="editMode ? updateQuestion() : createQuestion()">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Exam</label>
                    <div class="form-control">{{exam.name}}</div>
                    <input type="hidden" name="exam_id" id="exam_id"  v-model="questionData.exam_id"/>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Question Type</label>
                    <select class="form-control" id="question_type_id" name="question_type_id" v-model="questionData.question_type_id" :class="{'is-invalid' : questionData.errors.has('question_type_id') }">
                        <option v-for="question_type in question_types" :key="question_type.id" :value="question_type.id">{{question_type.name}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Question</label>
                <input type="text" class="form-control" name="question" id="question" v-model="questionData.question" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Question Img</label>
                <input type="file" name="question_img" id="question_img" />
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
            question_types: [],
            questionData: new Form({id:'', question_type_id: '', question:'', question_img:'', exam_id:''}),
        }
    },
    methods:{
        createQuestion(){
            this.$Progress.start();
            this.questionData.post('/api/lms/questions')
            .then(response=>{
                Swal.fire({icon: 'success', title: response.data.message,});
                Fire.$emit('examRefresh', response)
                this.$Progress.finish();
                this.questionData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});
            })
        },
        getAllInitials(){
            axios.get('/api/lms/questions')
            .then(response =>{
                this.question_types = response.data.question_types;
            })
            .catch(()=>{
                toast.fire({icon: 'error', title: 'Something went wrong',})
            });
        },
        updateQuestion(){
            this.$Progress.start();
            this.questionData.put('/api/lms/questions/'+this.questionData.id)
            .then(response=>{
                Swal.fire({icon: 'success', title: response.data.message,});
                Fire.$emit('examRefresh', response)
                this.$Progress.finish();
                this.questionData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
            });
        },   
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('ExamRefresh', exam =>{
            this.exam = exam; 
            this.questionData.exam_id = exam.id;
            console.log(this.questionData.exam_id);
        });
        Fire.$on('questionDataFill', question =>{
            this.questionData.reset();
            this.questionData.fill(question)
            this.questionData.question_type_id = question.type_id;
            this.questionData.exam_id = typeof question.exam != 'undefined' ? question.exam.id : this.exam.id;
        });
    },
    props: {
        'editMode': Boolean,
        'exam': Object,
        'exam_types': Array,
        'question': Object,
    },
}
</script>