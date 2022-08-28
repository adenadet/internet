<template>
<div class="col-12 table-responsive">
    <div class="modal fade" id="pdfModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">See {{type}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="((lesson.video !== null) || (lesson.pdf !== null) || (lesson.doc !== null))">
                        <VuePdfReader :url="'/'+pdf" v-if="(lesson.file_type == 'pdf') || (type == 'pdf')"/>
                        <div class="col-md-10 offset-md-1" style="text-align:center" v-else-if="type == 'video'">
                            <youtube :video-id="document" ref="youtube" @playing="playing"></youtube>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="lessonModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Module</h4>
                    <h4 class="modal-title" v-show="!editMode">New Module</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <LmsFormLesson :editMode="editMode" :lesson="lesson"/>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-light">
        <div class="card-header">
            <h3 class="card-title">Course Modules</h3>
            <div class="card-tools"><button type="button" class="btn btn-sm btn-success" @click="addLesson()"><i class="fas fa-plus"></i>Add Module</button></div>
        </div>
        <div class="card-body">
<table class="table table-striped table-hover" v-show="(lessons.length != null)&&(typeof lesson != 'undefined')">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Content</th>
            <th>Resources</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="lesson in lessons" :key="lesson.id">
            <td>{{lesson.serial_number}}</td>
            <td>{{lesson.name}}</td>
            <td :title="lesson.content">{{lesson.content | readMore(25, '...')}}</td>
            <td>
                <button v-show="lesson.video !== null"  type="button" class="btn btn-sm btn-outline-success" @click="viewResource(lesson.video, 'video')">
                    <i class="fa fa-video" style="color:green;"></i>
                </button>
                <button type="button" v-show="lesson.file != null" class="btn btn-sm btn-outline-primary" @click="viewResource(lesson.file, 'pdf')"><i class="fa fa-file-pdf" style="color:red;"></i></button>
            </td>
            <td>
                <div class="btn-group">
                    <router-link :to="'/learn/tutor_area/lesson/'+lesson.id"><button class="btn btn-sm btn-success" ><i class="fa fa-eye"></i></button></router-link>
                    <button class="btn btn-sm btn-danger" v-on:click="deleteLesson(lesson.id)"><i class="fa fa-trash"></i></button>
                </div>
            </td>
        </tr>
    </tbody>
</table>
        </div>
    </div>
</div>
</template>
<script>
import pdf from 'vue-pdf';
import VueDocPreview from 'vue-doc-preview';

export default {
    components:{
        pdf, 
        VueDocPreview
    },
    computed: {
        player() {return this.$refs.youtube.player;}
    },
    data(){
        return {
            course:{},
            document: '',
            editMode: true,
            form: new Form({}),
            lesson: {},
            subCategory: {},
            type: '', 
            pdf: '',
        }
    },
    methods:{
        addLesson(){
            this.lesson = {};
            this.editMode = false;
            Fire.$emit('LessonDataFill', this.lesson);
                $('#lessonModal').modal('show');
            },
        deleteLesson(id){
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
                    //Send Delete request
                    if(result.value){
                        this.form.delete('/api/lms/lessons/'+id)
                        .then(response=>{
                            Swal.fire('Deleted!', 'Lesson has been deleted.', 'success');
                            Fire.$emit('CatRefresh', response);
                            Fire.$emit('courseRefresh', response.data.course);   
                        })
                        .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                        });
                    }
                });  
        },
        deleteCourseUser(id){
            Swal.fire({
                title: 'Are you sure?', text: "You won't be able to revert this!",
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!'
                })
            .then((result) => {
                if(result.value){
                    this.form.delete('/api/lms/sub_categories/'+id)
                    .then(response =>{
                        Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                        Fire.$emit('CatRefresh', response);
                        Fire.$emit('CourseUpdate', response.data.course);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                        });
                    }
                });  
            },
        editLesson(lesson){
            this.lesson = lesson;
            this.editMode = true;
            Fire.$emit('LessonDataFill', this.lesson);
            $('#lessonModal').modal('show');
            },
        playVideo() {
            //console.log(this.lesson.video)
            this.player.playVideo()
            },
        playing() {
            // console.log('\o/ we are watching!!!')
            },
        viewResource(pdf, type){
            this.type = type;
            console.log(pdf);
            this.pdf = pdf;
            /*
            if(this.type == 'video'){this.document = pdf;}
            else{this.document = pdf;} */
            $('#pdfModal').modal('show');
            },
        },
    mounted() { 
        Fire.$on('courseRefresh', course =>{
            $('#lessonModal').modal('hide');
            });
        Fire.$on('CourseUpdate', course => {
            $('#lessonModal').modal('hide');
        });
        Fire.$on('refresh', response =>{
            $('#lessonModal').modal('show');
            });
        
    },
    props: {
        'lessons': Object,
    },
}
</script>