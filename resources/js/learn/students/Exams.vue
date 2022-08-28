<template>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Assigned Exams</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                </div>
            </div>
        </div>
        
        <div class="card-body table-responsive p-0" style="height: 300px;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
            <tr>
                <th>Exam Name</th>
                <th>Course | Lesson</th>
                <th>Assigned Date</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="exam in exams.data" :key="exam.id">
                <td>{{exam.exam != null ? exam.exam.name : 'Quiz'}}</td>
                <td>{{exam.course !==  null ? exam.course.name : ''}} 
                    {{exam.lesson !==  null ? (exam.course != null ? ' | '+exam.lesson.name : exam.lesson.name) : ''}}
                </td>
                <td>{{exam.start_date | ExcelDate}}</td>
                <td>{{exam.expiry_date | ExcelDate}}</td>
                <td><span class="tag tag-success">Done</span></td>
                <td v-show="exam.status == 0">
                    <a :href="'/learn/student_area/exam/'+(exam.exam != null ? exam.exam.id: 0)"><button class="btn btn-sm btn-primary"><i class="fa fa-clock"></i></button></a>
                    <button title="Repeat Exam" class="btn btn-sm btn-success"><i class="far fa-circle"></i></button>
                </td>
                <td v-show="exam.status == 1">
                    <a :href="'/learn/student_area/exam/'+ (exam.exam != null ? exam.exam.id: 0)"><button class="btn btn-sm btn-primary"><i class="fa fa-clock"></i></button></a>
                    <button title="Repeat Exam" class="btn btn-sm btn-success"><i class="far fa-circle"></i></button>
                </td>
                <td v-show="exam.status == 2">
                    <a :href="'/learn/student_area/exam/'+(exam.exam != null ? exam.exam.id: 0)"><button class="btn btn-sm btn-primary"><i class="fa fa-clock"></i></button></a>
                    <button title="Repeat Exam" class="btn btn-sm btn-success"><i class="far fa-circle"></i></button>
                </td>
                <td v-show="exam.status == 3">
                    <a :href="'/learn/student_area/exam/'+(exam.exam != null ? exam.exam.id: 0)"><button class="btn btn-sm btn-primary"><i class="fa fa-clock"></i></button></a>
                    <button title="Repeat Exam" class="btn btn-sm btn-success"><i class="far fa-circle"></i></button>
                </td>
            </tr>
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
                certificate_types:[],
                course:{},
                courses:{},
                categories:[],
                editMode: false,
                Exam:{},
                exams: {},
                exam_types: [],
                form: new Form({}),
                sub_categories:[],
                users:[],   
            }
        },
        methods:{
            addExam(){
                this.$Progress.start();
                
                this.$Progress.finish();
            },
            deleteExam(id){

            },
            editExam(exam){
                this.$Progress.start();
                this.editMode = true;
                this.exam = exam;
                Fire.$emit('examDataFill', exam);
                $('#examModal').modal('show');
                this.$Progress.finish();
            },
            getAllInitials(){
                this.$Progress.start();
                axios.get('/api/lms/std_exams').then(response =>{
                    //this.refresh(response);
                    this.exams = response.data.exams;
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Exams were loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Exams were not loaded successfully',
                    })
                });
            },
            getExams(page=1){
                axios.get('/api/lms/exams?page='+page)
                .then(response=>{
                    this.exams = response.data.exams;   
                });
            },
            refresh(response){
                this.exams = response.data.exams;
            },
            seeExam(exam){
                this.$Progress.start();
                this.exam = exam;
                Fire.$emit('examRefresh', exam)
                this.$Progress.finish();
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>