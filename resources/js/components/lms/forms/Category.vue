<template>
    <div>
        <form @submit.prevent="editMode ? updateCategory() : createCategory() "> 
        <alert-error :form="CategoryData"></alert-error> 
            <div class="row">
                <!-- Get Address -->
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name *" v-model="CategoryData.name" :class="{'is-invalid' : CategoryData.errors.has('name') }" required />
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="status" name="status" placeholder="Enter Street Desc" v-model="CategoryData.status" :class="{'is-invalid' : CategoryData.errors.has('status') }" required>
                            <option value="">---Select Category---</option>
                            <option value="1">Active</option>
                            <option value="0">Pending</option>
                            <option value="2">Deactivated</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="5" class="form-control" id="description" name="description" placeholder="Enter Description " v-model="CategoryData.description" :class="{'is-invalid' : CategoryData.errors.has('description') }"></textarea>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input v-show="!editMode" type="submit" name="submit" class="submit btn btn-success" value="Submit" />
                    <input v-show="editMode" type="submit" name="submit" class="submit btn btn-success" value="Update" />
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data(){
            return {
                CategoryData: new Form({
                    id:'',
                    name: '', 
                    status:'', 
                    description:'', 
                }),
            }
        },
    methods:{
        createCategory(){
            this.CategoryData.post('/api/lms/categories').then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: 'Category was successfully added!',
                });
                this.$Progress.finish();
                this.CategoryData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Category was not added try again later!',
                });
            });
        },
        updateCategory(){
            this.CategoryData.put('/api/lms/categories/'+this.CategoryData.id)
            .then(response=>{
                //this.Category.reset();
                Fire.$emit('CatRefresh', response)
                Swal.fire({
                    icon: 'success',
                    title: 'Category was successfully updated!',
                });
                this.$Progress.finish();
                this.CategoryData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Category was not updated try again later!',
                })
            });
        },
    },
    mounted() {
        Fire.$on('editCategory', category =>{
            this.CategoryData.fill(category);
            console.log(this.editMode)
        });    
    },
    props: {
        'category': Object,
        'editMode': Boolean,
    },
}
</script>