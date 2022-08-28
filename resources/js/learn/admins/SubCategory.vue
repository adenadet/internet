<template>
<div>
    <div class="modal fade" id="subCategoryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Sub Category: {{subCategory.name}}</h4>
                    <h4 class="modal-title" v-show="!editMode">New Sub Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <LmsFormSubCategory :categories="categories" :editMode="editMode" :sub_category="subCategory" />
                </div>
            </div>
        </div>
    </div>
    <div class="card-header">
        <h3 class="card-title">All Sub Categories in {{category_name}}</h3>
        <div class="card-tools"><button type="button" class="btn btn-sm btn-success" @click="addSubCategory">Add New</button></div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>                  
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th style="width: 40px">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sub_category in sub_categories" :key="sub_category.id" :value="sub_category.id">
                    <td width="30%"><strong>{{sub_category.name}}</strong></td>
                    <td width="30%">{{sub_category.description}}</td>
                    <td width="20%" v-show="sub_category.status == 0">Pending</td>
                    <td width="20%" v-show="sub_category.status == 1">Active</td>
                    <td width="20%" v-show="sub_category.status == 2">Suspended</td>
                    <td width="20%">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-primary" v-on:click="editSubCategory(sub_category)"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" v-on:click="deleteSubCategory(sub_category.id)"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            form: new Form({}),
            subCategory: {},
            editMode: true,
        }
    },
    methods:{
        addSubCategory(){
            this.subCategory = {};
            this.editMode = false;
            Fire.$emit('editSubCategory', this.subCategory);
            $('#subCategoryModal').modal('show');
        },
        deleteSubCategory(id){
            Swal.fire({
                title: 'Are you sure?', text: "You won't be able to revert this!",
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if(result.value){
                    this.form.delete('/api/lms/sub_categories/'+id)
                    .then(response =>{
                        Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                        Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                        });
                    }
                });  
            },
        editSubCategory(sub_category){
            this.subCategory = sub_category;
            this.editMode = true;
            Fire.$emit('editSubCategory', sub_category);
            $('#subCategoryModal').modal('show');
            },
        },
    mounted() { 
        Fire.$on('SubCatRefresh', response =>{
            $('#subCategoryModal').modal('hide');
            });
    },
    props: {
        'category_name': String,
        'sub_categories': Array,
        'categories': Array,
    },
}
</script>