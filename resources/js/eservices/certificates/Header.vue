<template>
<section>
    <div class="row">
        <div class="col-3 p-5">
            <img :src="'/img/applicants/'+appointment.patient.image" class="img-fluid" />
        </div>
        <div class="col-9">
            <div class="row">
                <div class="col-8"><h5 class="mt-3">UK Pre-Departure Tuberculosis Detection Programme</h5></div>
                <div class="col-2"><img src="/img/background/logo/uk-visa.png" class="img-fluid" /></div>
                <div class="col-2"><img src="/img/background/logo/snh-square.png" class="img-fluid" /></div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label" style="color: #222;font-weight:normal !important; ">Certificate No:</label>
                        <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" v-html="appointment.unique_id != null ? appointment.unique_id: 'N/A'"></div></div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">SP ID No:</label>
                        <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;"  v-html="appointment.sp_id != null ? appointment.sp_id : 'N/A'"></div></div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">City/Town:</label>
                        <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" >LAGOS ISLAND</div></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">Issue Date:</label>
                        <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;"  id="inputEmail3">{{appointment.issue_at | excelDate}}</div></div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important; ">Expiry Date:</label>
                        <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" >{{appointment.issue_at | excel6Months}}</div></div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-weight:normal !important;">Country:</label>
                        <div class="col-sm-8"><div width="100%"  class="pl-2 rounded" style="border: 1px solid #222; color: #222;" >NIGERIA</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
        };
    },
    props: {appointment: Object}
}
</script>