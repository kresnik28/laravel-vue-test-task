require('./bootstrap');
import Vue from 'vue'

import VuePapaParse from 'vue-papa-parse'
Vue.use(VuePapaParse)

Vue.component('ProductForm', require('./components/product/Form').default)
Vue.component('ProductFormUpload', require('./components/product/form/FileUpload').default)
Vue.component('ProductFormCreateAttribute', require('./components/product/form/CreateAttribute').default)


var app = new Vue({
    el: '#app',
})
