<template>
    <div>
        <form @submit.prevent="editMode ? updateSubCategory() : createSubCategory() "> 
        <alert-error :form="SubCategoryData"></alert-error> 
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name *" v-model="SubCategoryData.name" :class="{'is-invalid' : SubCategoryData.errors.has('name') }" required />
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category_id" name="category_id" placeholder="Enter Street Desc" v-model="SubCategoryData.category_id" :class="{'is-invalid' : SubCategoryData.errors.has('category_id') }" required>
                            <option value="">---Select SubCategory---</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="status" name="status" placeholder="Enter Street Desc" v-model="SubCategoryData.status" :class="{'is-invalid' : SubCategoryData.errors.has('status') }" required>
                            <option value="">---Select SubCategory---</option>
                            <option value="1">Active</option>
                            <option value="0">Pending</option>
                            <option value="2">Deactivated</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="5" class="form-control" id="description" name="description" placeholder="Enter Description " v-model="SubCategoryData.description" :class="{'is-invalid' : SubCategoryData.errors.has('description') }"></textarea>
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
                SubCategoryData: new Form({
                    id:'',
                    name: '',
                    category_id:'', 
                    status:'', 
                    description:'', 
                }),
            }
        },
    methods:{
        createSubCategory(){
            this.SubCategoryData.post('/api/lms/sub_categories').then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: 'Sub Category was successfully added!',
                });
                this.$Progress.finish();
                this.SubCategoryData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Sub Category was not added try again later!',
                });
            });
        },
        updateSubCategory(){
            this.SubCategoryData.put('/api/lms/sub_categories/'+this.SubCategoryData.id)
            .then(response=>{
                //this.SubCategory.reset();
                Fire.$emit('SubCatRefresh', response)
                Swal.fire({
                    icon: 'success',
                    title: 'Sub Category was successfully updated!',
                });
                this.$Progress.finish();
                this.SubCategoryData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Sub Category was not updated try again later!',
                })
            });
        },
    },
    mounted() {
        Fire.$on('editSubCategory', sub_category =>{
            this.SubCategoryData.fill(sub_category);
        });    
    },
    props: {
        'SubCategory': Object,
        'editMode': Boolean,
        'categories': Array,
    },
}
</script>