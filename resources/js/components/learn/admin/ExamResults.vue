<template>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Exams</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-head-fixed">
                    <thead><th>Name</th><th>Course</th><th>Lesson</th><th>Trials</th><th></th></thead>
                    <tbody>
                        <tr v-for="exam in exams.data" :key="exam.id">
                            <td><strong>{{exam.name}}</strong></td>
                            <td>{{(exam.course !== null) ? exam.course.name : 'Not Course Assigned'}}</td>
                            <td>{{(exam.lesson !== null) ? exam.lesson.name : 'Not Lesson Assigned'}}</td>
                            <td>{{exam.results.length}}</td>
                            <td><router-link :to="'/learn/admin_area/exam_results/'+exam.id" ><button title="View Results" class="btn btn-sm btn-success" ><i class="fa fa-eye"></i></button></router-link></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <pagination :data="exams" @pagination-change-page="getExam" />
            </div>
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
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Exams loaded successfully',
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
            .then(response=>{this.refresh(response);});
        },
        refresh(response){
            this.exams = response.data.results;  
        }
    },
    
    mounted(){ 
        this.getAllInitials();
        Fire.$on('refresh', response =>{ 
            console.log("Testing"); 
            this.refresh(response); 
            $('#examModal').modal('hide');
        });
    }
}
</script>