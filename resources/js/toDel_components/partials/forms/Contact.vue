<template>
    <div>
        <form action="#" @submit.prevent="edit ? updateContact(contact.id) : createContact()">
            <div class="form-group">
                <label>Name</label>
                <input v-model="contact.name" type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input v-model="contact.email" type="text" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input v-model="contact.phone" type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea v-model="contact.message" rows=5 name="message" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button v-show="!edit" type="submit" class="btn btn-default">Submit</button>
                <button v-show="edit" type="submit" class="btn btn-primary">Update Contact</button>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                accounts:{},
                editMode:false,
                edit:false,
                list:[],
                contact:{id:'', name:'', email:'', phone:'', message: ''},
                form: new Form({
                    id:'',
                    saving_id:'',
                    bank_id: '',
                    payment_date:'',
                    amount:'',
                    description:'',                    
                }),
                savings:{},
            }
        },
        methods:{
            createContact(){
                this.form.post('/api/contact').then(response=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Your message was successfully sent!',
                    });
                    this.form.reset();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Your message was not sent try again later!',
                    });
                });
            },
            editContribution(contribution){
                this.editMode = true;
                console.log(contribution);
                this.form.fill(contribution);
            },
            getAllInitials(){
                axios.get('/api/coop/contributions/initials').then(response =>{
                    this.accounts = response.data.accounts;
                    this.savings = response.data.savings;
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Contribution Form loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Contribution Form not loaded successfully',
                    })
                });
            },
            updateContact(){
                this.form.put('/api/contact/'+this.contact.id)
                .then(response=>{
                    this.form.reset();
                    Fire.$emit('Refresh')
                    Swal.fire({
                        icon: 'success',
                        title: 'Contribution was successfully updated!',
                    });
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Contribution was not updated try again later!',
                    })
                });
            },
            updateItems(invoice_items){
                this.form.invoice_items = invoice_items.items;
                this.form.delivery = invoice_items.delivery;
                this.form.vat = invoice_items.vat;
                this.form.sub_total = invoice_items.sub_total;
                this.form.totals = parseFloat(invoice_items.sub_total) + parseFloat(invoice_items.delivery) + parseFloat(invoice_items.vat);
            },
            
        },
        mounted() {
            
            Fire.$on('editContribution', contribution =>{
                this.editContribution(contribution);
            }); 
        },
        props:{'contribution': Object},
    }
</script>