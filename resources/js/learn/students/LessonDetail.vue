<template>
    <div class="card-body pt-0">
        <h3>{{lesson.name}}</h3>
        <h6>{{lesson.course !== null && typeof (lesson.course) !== 'undefined' ? lesson.course.name : ''}}</h6>
        <div class="row" style="text-align:center" v-if="((lesson.video !== null) && (typeof lesson !== 'undefined') &&(typeof lesson.video !== 'undefined'))"><youtube class="col-md-12" :video-id="lesson.video" ref="youtube" /></div>
        <div class="row" style="max-height: 500px; overflow: scroll;" v-if="lesson.file !== null">
            <vue-pdf-embed :source="lesson.file != null ? 'https://intranet.saintnicholashospital.com'+lesson.file : 'http://localhost:8000/upload/lessons/1666686506.pdf'" width="900"/>
        </div>
        <div class="col-md-12">{{lesson.content}}</div>
    </div>
</template>
<script>
import VuePdfEmbed from 'vue-pdf-embed/dist/vue2-pdf-embed'
export default {
    components: {
        VuePdfEmbed
    },
    data(){
        return {
            document: '',
            editMode: true,
            file: '',
            form: new Form({}),
            playerOptions: {
                height: '400', muted: false, language: 'en', playbackRates: [0.7, 1.0, 1.5, 2.0],
                sources: [{type: "video/mp4", src: "/"}],
            },
            scale: 100,
        }
    },
    methods:{
        async playVideo() {
            await this.player.playVideo()
        },
        playing(){
            console.log(1);
        },
        rerun(lesson){
            this.lesson = lesson;
            this.file = this.lesson.file;
            console.log(this.lesson.file);
            if ((this.lesson !== 'undefined')&&(this.lesson.video !== null)&&(typeof this.lesson.video !== 'undefined')) {
                this.playerOptions.sources = [{
                    type: "video/mp4", src: this.lesson.video,
                }];
                toast.fire({icon: 'success', title: 'Lesson loaded successfully',});
            }
        }
    },
    mounted() { 
        Fire.$on('LessonRefresh', lesson =>{
            //this.rerun(lesson);
        });
    },
    props:{
        'lesson' : Object
    }
}
</script>
