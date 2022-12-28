<template>
<div class="col-md-6 col-sm-12">
    <div class="card bg-light">
        <div class="card-header text-muted border-bottom-0">&nbsp;</div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-7">
                        <h2 class="lead"><b>{{user.first_name}} {{user.middle_name}} {{user.last_name}}</b></h2>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: {{user.email}}</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dept: {{((typeof user.department != 'undefined') && (user.department !== null))? user.department.name: ''}}</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{user.phone}}</li>
                        </ul>
                    </div>
                    <div class="col-5 text-center">
                        <img :src="(user.image) ? '/img/profile/'+user.image : '/img/profile/default.png'" alt="" class="img-circle img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button class="btn btn-sm btn-success" @click="messageUser(user)" title="Message Staff"><i class="fa fa-comment"></i></button>
                </div>
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
            exam_types: [],
            form: new Form({}),
            sub_categories:[],
            users:[],   
        }
    },
    methods:{
        messageUser(user){
            
        },
    },
    mounted() {
        //this.getAllInitials();
    },
    props:{
        'user':Object,
    },

}
</script>