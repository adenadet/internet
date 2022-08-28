<template>
<div class="col-12 table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Student</th>
                <th>Assigned</th>
                <th>Expires</th>
                <th>Status</th>
                <th>Trials</th>
                <th>Start Date</th>
                <th>Completed</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="student in assignees" :key="student.id">
                <td>{{student.user.first_name}} {{student.user.last_name}}<br /><small><b>[{{student.user.unique_id}}]</b></small></td>
                <td>{{student.assigned_date | shortDate}}</td>
                <td>{{student.expiry_date | shortDate}}</td>
                <td>{{student.status}}</td>
                <td>{{student.trials}}</td>
                <td v-show="(student.user_start_time !== null)"> {{ student.user_start_time | shortDate}}</td>
                <td v-show="(student.user_start_time === null)"> Not Yet Started</td>
                <td v-show="(student.user_finish_time !== null)"> {{ student.user_finish_time | shortDate}}</td>
                <td v-show="(student.user_finish_time === null)"> Not Yet Finished</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary" v-on:click="editCourseUser(student)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" v-on:click="deleteCourseUser(student.id)"><i class="fa fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
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
        addCourseTutor(){
            this.subCategory = {};
            this.editMode = true;
            Fire.$emit('editSubCategory', subCategory);
            $('#subCategoryModal').modal('show');
            },
        deleteCourseUser(id){
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
        editCourseUser(sub_category){
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
        'assignees': Array,
    },
}
</script>