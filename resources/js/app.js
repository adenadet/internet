require('./bootstrap');
import router from './routes';

window.Vue = require('vue');
import Vue from 'vue';

//Import PDF Reader
//import VuePdfReader from 'vue-pdf-reader';
//import 'vue-pdf-reader/dist/vue-pdf-reader.min.css';
//Vue.component(VuePdfReader);

//Import Progress Bar
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {color: 'rgb(255, 255, 19)', failedColor: 'red', height: '5px',});

//Import Horizontal Slider
import VueHorizontalList from 'vue-horizontal-list';
Vue.use(VueHorizontalList);

//Import Sweet Alert
import Swal from 'sweetalert2'
window.Swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

window.toast = toast;
//Import Moment for DateTime functions
import moment from 'moment';

//Import Video Player
//import VueVideoPlayer from 'vue-video-player';
//import 'video.js/dist/video-js.css'
//import 'vue-video-player/src/custom-theme.css'

/*Vue.use(VueVideoPlayer, /* {
    options: global default options,
    events: global videojs events} 
    );*/

//Import VueRouter for SPA Routing
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//Import Simple Pagination
Vue.component('pagination', require('laravel-vue-pagination'));

//Import Vform for forms and Errors
import {Form, HasError, AlertError} from 'vform';
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
window.Form = Form;

//import objectToFormData from './objectToFormData'
//window.objectToFormData = objectToFormData;
//const objectToFormData = window.objectToFormData

//Import Chart and ChartKick for Charts
import Chart from 'chart.js';
import Chartkick from 'vue-chartkick';
Vue.use(Chartkick.use(Chart));

//Import Emit for all components
window.Fire = new Vue();

//Import Paystack 
import paystack from 'vue-paystack';
Vue.use(paystack);

//Import QR Code
import VueQRCodeComponent from 'vue-qrcode-component';
Vue.component('qr-code', VueQRCodeComponent);

//Import WYSIWYG
import wysiwyg from "vue-wysiwyg";
import "vue-wysiwyg/dist/vueWysiwyg.css";
Vue.use(wysiwyg, {});

//Import Youtube Player
import VueYoutube from 'vue-youtube';
Vue.use(VueYoutube);

//Import Signature Pad
import VueSignature from 'vue-signature-pad';
Vue.use(VueSignature);

//Special Created Filters
Vue.filter('addOne', function(value) {
    if (isNaN(value)){ return '0';}
    let val = value + 1;
    return val;
});

Vue.filter('age', function(value){
    return moment().diff(moment(value, "DD MMM YYYY"), 'years');
});
   
Vue.filter('currency', function(value) {
    if (isNaN(value)){ return '0.00';}
    let val = (value/1).toFixed(2).replace(',', '.')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
});

Vue.filter('ExcelDate', function(text){
    return moment(text).format('MMMM Do, YYYY');
});

Vue.filter('ExcelDateShort', function(text){
    return moment(text).format('DD/MM/YYYY');
});

Vue.filter('ExcelDateMonth', function(text){
    return moment(text).format('MMM Do');
});

Vue.filter('Excel6Months', function(text){
    return moment(text).add(6, 'M').format('MMM Do, YYYY');
});

Vue.filter('ExcelMonthYear', function(text){
    return moment(text).format('MMM, YYYY');
});
    
Vue.filter('FullName', function(text){
    if (text == null){return 'Old User/Staff';}
    return text.last_name+', '+text.first_name+ (text.middle_name != null ? ' '+text.middle_name : '');
});

Vue.filter('Names', function(text){
    if (text == null){return 'Old User/Staff';}
    return text.first_name+ (text.middle_name != null ? ' '+text.middle_name : '');
});

Vue.filter('FullDate', function(text){
    return moment(text).format('LLLL');
});

Vue.filter('firstUp', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase(); 
});

Vue.filter('getAge', function(text){
    var birthYear = parseInt(moment(text).format('YYYY'));
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var age = currentYear - birthYear;
    return age+' years';
});

Vue.filter('readMore', function (text, length, suffix) {
    if (text == null){return text;}
    else if (text.length <= length){return text;}
    else{return text.substring(0, length) + suffix;}
});        

Vue.filter('shortDate', function(text){
    return moment(text).format('MMM Do, YY');    
});

Vue.filter('profilePicture', function (text){
    if (text == null){return '/img/profile/default.png';}
    else{ return '/img/profile/'+text ;}
});

//Users Components

const app = new Vue({
    el: '#corner',
    router,
    data:{ search: '',},
    methods:{searchIt: _.debounce(()=>{Fire.$emit('searchInstance');}, 1000)},

});
