<template>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Tickets</h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                <a href="/tickets" class="nav-link active">Add New</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table m-b-0">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Created By</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="ticket in tickets.data" :key="ticket.id">
                        <td>{{ticket.subject}}</td>
                        <td>{{ticket.user_id !== null ? ticket.creator.first_name+' '+ticket.creator.last_name : ''}}</td>
                        <td>{{ticket.category.name}}</td>
                        <td :title="ticket.content">{{ticket.content | readMore(25, '...')}}</td>
                        <td>{{ticket.status.name}}</td>
                        <td>{{ticket.priority.name}}</td>
                        <td>
                            <div class="btn-group">
                                <a :href="'/ticketing/'+ticket.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                            </div>          
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>   
    </div>
    <div class="card-footer text-center"><a href="/ticketing">See More</a></div>
</div>
</template>
<script>
export default {
    data(){
        return {}
    },
    props:{'tickets': Object}
}
</script>
<style scoped>

</style>