<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex justify-content-between"><h3 class="">Profile</h3></div>
                        <div class="text-center user-info"><img :src="'/img/profile/'+(user.image != null ? user.image : 'default.png')" width="300" height="auto" alt="avatar"><p class=""></p></div>
                        <div class="user-info-list">
                            <div class="">
                                <ul class="contacts-block list-unstyled">
                                    <li class="contacts-block__item">
                                        <i class="fa fa-user mr-1" width="24" height="24"></i>{{user.first_name}} {{user.middle_name}} {{user.last_name}}
                                    </li>
                                    <li class="contacts-block__item">
                                        <i class="fa fa-calendar mr-1" width="24" height="24"></i>{{user.dob != null ? user.dob : null }}
                                    </li>
                                    <li class="contacts-block__item">
                                        <i class="fa fa-map-marker mr-1" width="24" height="24"></i> 
                                        {{user.street}} {{user.street2 ? ', '+user.street2: ''}}<br />
                                        {{user.city}}, {{user.area_id ? user.area.name : ''}}, {{user.state_id ? user.state.name: ''}}.  
                                    </li>
                                    <li class="contacts-block__item">
                                        <a :href="'mailto:'+user.email"><i class="fa fa-envelope mr-1" width="24" height="24"></i> {{user.email}}</a>
                                    </li>
                                    <li class="contacts-block__item">
                                        <i class="fa fa-phone mr-1" width="24" height="24"></i> {{user.phone}} {{user.alt_phone ? ', '+user.alt_phone: ''}} 
                                    </li>
                                </ul>
                            </div>                                    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#bio-data" data-toggle="tab">Bio Data</a></li>
                            <li class="nav-item"><a class="nav-link" href="#next-of-kin" data-toggle="tab">Next of Kin</a></li>
                            <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="bio-data">
                                <PatientProfileFormDetails :areas="areas" :states="states" :user="user" />
                            </div>
                            <div class="tab-pane" id="next-of-kin">
                                <ProfileFormNOK :nok="nok" />
                            </div>
                            <div class="tab-pane" id="password">
                                <ProfileFormPassword />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                          
    
    </div>
</template>

<script>
export default {
    data(){
        return  {
            areas:[],  
            branches:[],  
            nok:{},
            states:[],  
            user:{}, 
        }
    },
    mounted() {},
    created() {
        this.getInitials();
        Fire.$on('Reload', response =>{
            console.log("Working");
            this.user = response.data.user[0];
            this.areas = response.data.areas;
            this.branches = response.data.branches;
            this.states = response.data.states;
            this.nok = response.data.nok[0];

            Fire.$emit('BioDataFill', this.user);
            Fire.$emit('NextOfKinFill', this.nok);
        });
    },
    methods:{
        getInitials(){
            axios.get('/api/ums/profile').then(response =>{
                this.user = response.data.user[0];
                this.areas = response.data.areas;
                this.branches = response.data.branches;
                this.states = response.data.states;
                this.nok = response.data.nok[0];
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Profile loaded successfully',
                });
                Fire.$emit('BioDataFill', this.user);
                Fire.$emit('NextOfKinFill', this.nok);
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Profile not loaded successfully',
                })
            });
        },
        getProfilePic(){
            let  photo = (this.form.image.length >= 150) ? this.form.image : "./"+this.form.image;
            return photo;
        },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.form.image = reader.result
                    }
                reader.readAsDataURL(file)
            }
            else{
                swal.fire({
                    type: 'error',
                    title: 'File is too large'
                })
            }
        }
    }
}
</script>