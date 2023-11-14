<template>
<section>
    <form>
        <alert-error :form="ItemData"></alert-error> 
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" name="name" v-model="ItemData.name" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" id="item_type_id" name="item_type_id" v-model="ItemData.item_type_id">
                        <option value=''>--Select Item Type--</option>
                        <option v-for="item_type in types" :value="item_type.id">{{ item_type.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" id="category_id" name="category_id" v-model="ItemData.category_id">
                        <option value=''>--Select Category--</option>
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" v-model="ItemData.quantity" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Minimum Reorder Level</label>
                    <input type="number" class="form-control" id="minimum_level" name="minimum_level" v-model="ItemData.minimum_level" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Current Cost Price</label>
                    <input type="text" class="form-control" id="current_cost_price" name="current_cost_price" v-model="ItemData.current_cost_price" />
                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="ItemData.id" />
        <button @click.prevent="editMode ? updateItem() : createItem()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            categories: [],
            types: [],
            ItemData: new Form({
                name: '', 
                item_type_id: '',
                category_id: '', 
                quantity: '', 
                minimum_level: '', 
                current_cost_price: '', 
                id: '',
            }),
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('ItemDataFill', item =>{
            console.log(typeof(item));
            if (item != null && typeof(item) != undefined && item.id != null && item.id != undefined && typeof(item.id) != "undefined" && item.id != ''){this.ItemData.fill(item);}
            else{this.ItemData.reset();}
        });
    },
    methods:{
        createItem(){
            this.$Progress.start();
            this.ItemData.post('/api/inventory/items')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('itemReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Item has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });  
        },
        getInitials(){
            axios.get('/api/inventory/items/initials')
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
            this.categories =  response.data.categories;
            this.types = response.data.types;
        },
        updateItem(){
            this.$Progress.start();
            this.ItemData.put('/api/inventory/items/'+this.ItemData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('itemReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Item has been updated',
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