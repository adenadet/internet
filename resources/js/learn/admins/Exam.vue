<template>
<div class="col-12">
    <div class="modal fade" id="questionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Question</h4>
                    <h4 class="modal-title" v-show="!editMode">New Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <LmsFormQuestion :editMode="editMode" :exam="exam" :exam_types="exam_types"/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="optionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit option</h4>
                    <h4 class="modal-title" v-show="!editMode">New Option</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <LmsFormOption :editMode="editMode" :option="option" :question="question"/>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Exam</h3>
            <div class="card-tools"><button class="btn btn-success btn-sm"  @click="addQuestion()">Add New Question</button></div>
        </div>
        <div class="card-body">
            <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                    <b>Exam Name:</b> {{exam.name ? exam.name: 'Unassigned'}}<br>
                    <b>Course:</b> {{exam.course ? exam.course.name: 'Unassigned'}}<br>
                    <b>Lesson:</b> {{exam.lesson ? exam.lesson.name: 'Unassigned'}}<br>
                    <b>Description:</b> {{exam.description ? exam.description: 'Unassigned'}}<br>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="35%">Question</th>
                        <th width="45%">Options</th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody v-if="((typeof exam.questions !== 'undefined') && (exam.questions.length > 0))">
                    <tr  v-for="question in exam.questions" :key="question.id">
                        <td>{{question.question}}
                            <img v-show="question.question_img !== null" :src="question.question_img" width="80%" height="auto" />
                            <br />
                            <span><button class="btn btn-sm btn-primary" v-on:click="editQuestion(question)"><i class="fa fa-edit"></i></button></span> 
                        </td>
                        <td>
                            <div class="row" v-for="option in question.options" :key="option.id">
                                <div class="col-md-7">{{ option.option_text}}</div>
                                <div class="col-md-2">{{ option.points}}</div>
                                <div class="col-md-3">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary" v-on:click="editOption(question, option)"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger" v-on:click="deleteOption(option.id)"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-success" title="Add New Option" v-on:click="addOption(question)"><i class="fa fa-plus"></i></button>
                                <button class="btn btn-sm btn-danger" v-on:click="deleteQuestion(question.id)"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr><td colspan=5>No Question has been added to this exam</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            exam: {},
            exam_types: [],
            option: {},
            question: {},
            question_types:[],
            relay: {},
            editMode: false,
            form: new Form({}),
        }
    },
    methods:{
        addQuestion(){
            this.editMode = false;
            Fire.$emit('questionDataFill', {});
            $('#questionModal').modal('show');
        },
        addOption(question){
            this.question = question;
            this.option = {};
            this.relay = {question: this.question, option: this.option,};
            console.log(this.relay);
            this.editMode = false;
            Fire.$emit('optionDataFill', this.relay);
            $('#optionModal').modal('show');
        },
        deleteOption(id){
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
                if(result.value){
                    this.form.delete('/api/lms/options/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Option has been deleted.', 'success');
                        Fire.$emit('refresh', response);
                        this.refresh(response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        deleteQuestion(id){
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
                if(result.value){
                    this.form.delete('/api/lms/questions/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Questions has been deleted.', 'success');
                        Fire.$emit('refresh', response);
                        this.refresh(response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        editQuestion(question){
            this.editMode = true;
            Fire.$emit('questionDataFill', question);
            $('#questionModal').modal('show');
        },
        editOption(question, option){
            this.editMode = true;this.question = question;this.option = option;
            Fire.$emit('optionDataFill', option);
            Fire.$emit('questionDataFill', question);
            $('#optionModal').modal('show');
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/exams/'+this.$route.params.id)
            .then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Exam loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Exam not loaded successfully',})
            });
        },
        refresh(response){ 
            this.exam = response.data.exam;
            this.exam_types = response.data.exam_types;
        }
    },
    mounted() { 
        this.getAllInitials();
        Fire.$on('refresh', response =>{ this.refresh(response); $('#examModal').modal('hide');});
        Fire.$on('examRefresh', response => {this.refresh(response); $('#examModal').modal('hide');});
    }
}
</script>
