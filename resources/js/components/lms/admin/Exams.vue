<template>
    <div class="row">
        <div class="modal fade" id="examModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="editMode">Edit Exam</h4>
                        <h4 class="modal-title" v-show="!editMode">New Exam</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <LmsFormExam :exam="exam" :courses="courses" :editMode="editMode"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Exams</h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-success" @click="addExam">Add New</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-head-fixed">
                        <thead><th width="65%">Name</th><th width="35%"></th></thead>
                        <tbody>
                            <tr v-for="exam in exams.data" :key="exam.id">
                                <td width="60%"><strong>{{exam.name}}</strong></td>
                                <td width="40%">
                                    <button title="View Sub Categories" class="btn btn-sm btn-success" @click="examLoad(exam)"><i class="fa fa-eye"></i></button>
                                    <button title="Edit Exam" class="btn btn-sm btn-primary" @click="editExam(exam)"><i class="fa fa-edit"></i></button>
                                    <button title="Delete Exam" class="btn btn-sm btn-danger" @click="deleteExam(exam.id)"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <pagination :data="exams" @pagination-change-page="getExam" />
                </div>
            </div>
        </div>
        
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <LmsDetailQuestions :exam="exam" />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            courses: [],
            Exam:{},
            exam: {},
            exams:{},
            exam_types: [],
            question_types:[],
            editMode: false,
            form: new Form({}),
        }
    },
    methods:{
        addExam(exam){
            this.editMode = false;
            Fire.$emit('ExamDataFill', exam);    
            $('#examModal').modal('show');
        },
        examLoad(exam){
            this.exam = exam;
            Fire.$emit('examLoad', exam);
        },
        deleteExam(id){
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
                    this.form.delete('/api/lms/exams/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Exam has been deleted.', 'success');
                        Fire.$emit('refresh', response);
                        this.refresh(response);   
                        })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                        });
                    }
                });  
            },
        editExam(exam){
            this.Exam = exam;
            this.editMode = true;
            Fire.$emit('ExamDataFill', exam);
            //Fire.$emit('editexam', exam);    
            $('#examModal').modal('show');
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/exams')
            .then(response =>{
                this.refresh(response);
                this.courses = response.data.courses;
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Exams loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Exams not loaded successfully',
                })
            });
        },
        getExam(page=1){
            axios.get('/api/lms/exams?page='+page)
            .then(response=>{
                this.exams = response.data.exams;
                this.Exam = response.data.exams.data[0];
                this.exam_types = response.data.exam_types;
            });
        },
        refresh(response){
            //console.log("Working");
            //this.courses = responses.data.courses;
            this.exams = response.data.exams;
            this.Exam = response.data.exams.data[0];
            this.exam_types = response.data.exam_types;   
        }
    },
    
    mounted() { 
        this.getAllInitials();
        Fire.$on('refresh', response =>{ console.log("Testing"); this.refresh(response); $('#examModal').modal('hide');});
    }
}
</script>
