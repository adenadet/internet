<template>
    
</template>
<script>
export default {
    data(){
        return  {
            areas:[],  
            branches:[],  
            departments:[], 
            editMode: true, 
            nok:{},
            states:[],  
            user:{}, 
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    created() {
        this.getInitials();
        Fire.$on('Reload', response =>{
            console.log("Working");
            this.user = response.data.user[0];
            this.areas = response.data.areas;
            this.branches = response.data.branches;
            this.departments = response.data.departments;
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
                this.departments = response.data.departments;
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
                });
            }
        }
    }
}
</script>k
