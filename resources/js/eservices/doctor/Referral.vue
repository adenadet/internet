<template>
<section class="card">
    <div class="card-body">
        <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Patient</label>
                        <div class="form-control">{{appointment.patient | FullName}}</div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Service</label>
                        <div class="form-control" v-html="appointment.service != null ? appointment.service.name : 'No service selected'"></div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Details*</label>
                        <div style="width: 100%; border: 1px solid #666; min-height:200px; padding:3px 5px;" v-html="appointment.referral.details"></div>
                    </div>
                </div>
            </div>
    </div>
    <div class="card-footer">
        <p>Referring Doctor: <b>{{appointment.referral.creator | FullName}}</b></p>
        <p>Referral Date: {{appointment.referral.updated_at | excelDate}}</p>
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
        };
    },
    methods:{
    },
    mounted(){
    },
    props:{
        appointment: Object,
    }
};
</script>