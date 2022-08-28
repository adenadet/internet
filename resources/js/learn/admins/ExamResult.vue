<template>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Exam Results</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-head-fixed">
                    <thead><th>Exam Name</th><th>Student </th><th>Score</th><th></th></thead>
                    <tbody>
                        <tr v-for="result in results.data" :key="result.id">
                            <td><strong>{{result.exam.name}}</strong></td>
                            <td>{{(result.user !== null) ? result.user.first_name+' '+result.user.last_name : 'Inactive User'}}</td>
                            <td>{{(result.total_points !== null) ? result.total_points : 0}}</td>
                            <td><router-link :to="'/learn/admin_area/result/'+result.id" ><button title="View Results" class="btn btn-sm btn-success" ><i class="fa fa-eye"></i></button></router-link></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <!--<pagination :data="exams" @pagination-change-page="getExam" />-->
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            results: [],
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
                    this.form.delete('/api/lms/exam_results?r='+id)
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
            axios.get('/api/lms/exam_results?r='+this.$route.params.id)
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
            this.results = response.data.results;  
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