<template>
<div class="col-lg-3 col-md-4 col-sm-6 d-flex align-items-stretch">
    <div class="card bg-light">
        <div class="card-header text-muted border-bottom-0">&nbsp;</div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>{{user.first_name}} {{user.middle_name}} {{user.last_name}}</b></h2>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Department: {{typeof user.departent != 'undefined' ? user.department.name: ''}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{user.phone}}</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img :src="(user.image) ? '/img/profile/'+user.image : '/img/profile/default.png'" alt="" class="img-circle img-fluid">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
            <a href="#" class="btn btn-sm bg-teal">
                <i class="fas fa-comments"></i>
            </a>
            </div>
        </div>
    </div>
</div>
</template>