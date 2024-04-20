<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sub Menus</h3>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active">
                <router-link to="/eservices/doctor/consultations" class="nav-link"><i class="fa fa-calendar-day"></i> Consultations</router-link>
            </li>
            @if(Auth::user()->hasRole('Medical Consultant') || Auth::user()->hasRole('Super Admin'))
            <li class="nav-item">
                <router-link to="/eservices/doctor/pending" class="nav-link"><i class="fa fa-hourglass"></i> Pending Issuance</router-link>
            </li>
            
            <li class="nav-item">
                <router-link to="/eservices/doctor/reviews" class="nav-link"><i class="fa fa-file"></i> Review Results</router-link>
            </li>
            @endif
        </ul>
    </div>
</div>