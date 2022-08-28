<template>
<section class="content">
    <div class="container-fluid">            
        <div class="row">
            <section class="col-lg-8 connectedSortable">
                <div class="row">
                    <div class="col-md-6"><DashboardChat :message_rooms="message_rooms" :contacts="contacts" /></div>
                    <div class="col-md-6"><DashboardNewStaff :staffs="new_staffs" /></div>
                    <div class="col-md-5"><DashboardNotice :notices="notices" /></div>
                    <div class="col-md-7"><DashboardTicket :tickets="tickets" /></div>
                </div>
            </section>
            <section class="col-lg-4 connectedSortable">
                <DashboardBirthday :birthdays="birthdays"/> 
                <DashboardStaffMonth :items="staff_months"/>
            </section>
        </div>
    </div>
</section>
</template>
<script>
import moment from 'moment'
export default {
    data(){
        return {
            birthdays: [],
            contacts: [],
            editMode: false,
            messages: [],
            message_rooms: [],
            month: '',
            new_staffs: [],
            notices: {},
            staff_months: [],
            tickets: {},   
            settings: {
                suppressScrollY: false,
                suppressScrollX: false,
                wheelPropagation: false
            },
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/dashboard')
            .then(response =>{
                this.birthdays      = response.data.birthdays;
                this.contacts       = response.data.contacts;
                this.chats          = response.data.chats;
                this.messages       = response.data.messages;
                this.message_rooms  = response.data.chats;
                this.notices        = response.data.notices;
                this.new_staffs     = response.data.new_staffs;
                this.tickets        = response.data.tickets;
                this.staff_months   = response.data.staff_months;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Dashboard not loaded successfully',});
            });
        },
        scrollHanle(evt) {
            console.log(evt)
        },
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>
<style >
.scroll-area {
  position: relative;
  margin: auto;
  width: 600px;
  height: 400px;
}
</style>