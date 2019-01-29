
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 |
 | First, we will load all of the "core" dependencies for Spark which are
 | libraries such as Vue and jQuery. This also loads the Spark helpers
 | for things such as HTTP calls, forms, and form validation errors.
 |
 | Next, we'll create the root Vue application for Spark. This will start
 | the entire application and attach it to the DOM. Of course, you may
 | customize this script as you desire and load your own components.
 |
 */

require('spark-bootstrap');
require('./components/bootstrap');


import {Config} from './config/app';

import Vue from 'vue';

import VueResource from 'vue-resource';
Vue.use(VueResource);



import Toasted from 'vue-toasted';
Vue.use(Toasted, {
    theme: 'primary',
    position: 'top-center',
    duration: 3000
})

import moment from 'moment';
window.moment = moment;


//window.axios.defaults.baseURL = Config.baseUrl;

var app = new Vue({
    mixins: [require('spark')],

});

jQuery(document).ready(function ($) {
    $('.hamburger-button').click(function(){
        if($('#spark-navbar-collapse').hasClass('in')){
            $('#top-responsive-menu').removeClass('open');
        }else{
            $('#top-responsive-menu').addClass('open');
        }
        
    });
});
