<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Test Result for {{user != null ? user.first_name+' '+user.last_name: 'Loading'}}
                    <div class="card-tools">
                        <!--@if (exam.pass_mark <= $result->total_points)
                        Passed
                        @else
                        Failed <a href="/student_area/exam/{{exam.id}}"><button type="button" class="btn btn-sm btn-primary" title="Repeat">Retry</button></a>
                        @endif -->
                    </div>
                </div>
                <div class="card-body">
                    <!--@if(session('status'))
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success" role="alert"></div>
                        </div>
                    </div>
                    @endif -->
                    <div class="row invoice-info">
                        <div class="col-sm-6 invoice-col">
                        Exam:<address><strong><h2>{{exam.name}}</h2></strong></address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            <address>
                                <strong>Pass Mark:</strong>
                                <h3>{{exam.pass_mark}} of {{exam.question}}</h3>
                            </address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            <address>
                                <strong>Result Mark:</strong>
                                <h3>{{result.total_points}} of {{exam.question}}</h3>
                            </address>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr><th style="width: 10%;">#</th><th style="width: 40%;">Question</th><th style="width: 40%;">Answer</th><th style="width: 10%;">Score</th></tr>
                        </thead>
                        <tbody>
                            <tr v-for="(question,index) in questions" :key="question.id">
                                <td>{{index | addOne}}.</td>
                                <td>{{question.question.question}}</td>
                                <td>
                                <ul type="none">
                                    <li v-for="option in question.question.options" :key="option.id">
                                        {{option.option_text}}
                                        <i class="fa fa-check" v-show="question.option_id ==  option.id"></i>
                                        <hr />    
                                    </li>
                                </ul>
                                </td>
                                <td><span :class="(question.points > 0) ? 'badge bg-success' : 'badge bg-danger'">{{question.points}}</span></td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
                <div class="card-footer">
                    <!-- @if(exam.pass_mark <= $result->total_points)
                    <p>Congratulations, you may <a href="/learn/student_area/exams">See other Exams</a> or <a href="/learn/student_area/courses">Return to Courses</a>.</p>
                    @else
                    <p>You failed this stage, you would need to repeat it, <a href="/learn/student_area/exam/{{exam.id}}">click here</a> to retake exam
                    @endif -->
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            exam: {},
            questions: {},
            result: {},
            user: {},
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/exam_results/'+this.$route.params.id)
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
        getUser(page=1){
            axios.get('/api/ums/users?page='+page)
            .then(response=>{
                this.users = response.data.users;   
            });
        },
        refresh(response){
            this.exam = response.data.result.exam;
            this.result = response.data.result;
            this.questions = response.data.result.answers;
            this.user = response.data.result.user;
        },
        setUserRole(user){
            this.$Progress.start();
            this.user = user;
            Fire.$emit('userRoleUpdate', user);
            $('#roleModal').modal('show');
            this.$Progress.finish();
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/users/search?q='+query)
            .then((response ) => {this.users = response.data.users;})
            .catch(()=>{});
        });
        Fire.$on('userRoleReload', response =>{});
        Fire.$on('Reload', response =>{
            $('#userModal').modal('hide'); 
            $('#roleModal').modal('hide');
            this.users = response.data.users;
        });
    },
}
</script>