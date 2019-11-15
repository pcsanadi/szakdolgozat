/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

$(function () {
    $('.datepicker').datepicker({
        firstDay: 1,
        dateFormat: "yy-mm-dd",
        altFormat: "(yy-mm-dd)",
        showButtonPanel: true,
        currentText: "Ma",
        closeText: "Bezárás",
        regional: "hu"
    });
    $('.cbShowDeleted').click(function() {
        var d=document.getElementsByName('deleted_row');
        for(var i=0;i<d.length;++i)
        {
            if(this.checked)
                d[i].classList.remove('d-none');
            else
                d[i].classList.add('d-none');
        }
        var sd=document.getElementsByName('showDeleted');
        for(var i=0;i<sd.length;++i)
        {
            sd[i].value=(this.checked?'true':'false');
        }
    });
});
