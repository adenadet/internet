<template>
<section>
    <form>
        <alert-error :form="ItemTypeData"></alert-error> 
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" name="name" v-model="ItemTypeData.name" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <wysiwyg rows="5" id="description" name="description" v-model="ItemTypeData.description"></wysiwyg>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="ItemTypeData.id" />
        <button @click.prevent="editMode ? updateItemType() : createItemType()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            categories: [],
            types: [],
            ItemTypeData: new Form({
                name: '', 
                description: '',
                id: '',
            }),
        }
    },
    mounted() {
        Fire.$on('ItemTypeDataFill', item =>{
            this.ItemTypeData.fill(item);
        });
    },
    methods:{
        createItemType(){
            this.$Progress.start();
            this.ItemTypeData.post('/api/inventory/item_types')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Item Type has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });  
        },
        updateItemType(){
            this.$Progress.start();
            this.ItemTypeData.put('/api/inventory/item_types/'+this.ItemTypeData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Item Type has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });              
        },
    },
    props:{
        editMode: Boolean,
    }
}
</script>