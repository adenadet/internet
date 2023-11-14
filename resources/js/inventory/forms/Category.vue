<template>
<section>
    <form>
        <alert-error :form="CategoryData"></alert-error> 
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" name="name" v-model="CategoryData.name" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Parent</label>
                    <select class="form-control" id="name" name="name" v-model="CategoryData.parent_category_id">
                        <option value="">--Select Parent Category--</option>
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" id="name" name="name" v-model="CategoryData.type_id">
                        <option value="">--Select Type--</option>
                        <option v-for="item_type in item_types" :value="item_type.id">{{ item_type.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <wysiwyg rows="5" id="description" name="description" v-model="CategoryData.description"></wysiwyg>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="CategoryData.id" />
        <button @click.prevent="editMode ? updateCategory() : createCategory()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            categories: [],
            item_types: [],
            CategoryData: new Form({
                name: '', 
                parent_category_id: '',
                type_id: '',
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
        getInitials(){
            this.$Progress.start();
            axios.get('/api/inventory/categories')
            .then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Users loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Users not loaded successfully',
                })
            });
        },
        refreshPage(response){
            this.categories = response.data.categories;
            this.item_types = response.data.item_types;
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