
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.markdown = require('markdown-it')({
    breaks: true,
    linkify: true,
    typographer: true,
})

window.Vue = require('vue');

import Vuetify from 'vuetify'
Vue.use(Vuetify)

import VeeValidate from 'vee-validate'
Vue.use (VeeValidate)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('comment-app', require('./pages/CommentApp'))

const app = new Vue({
    el: '#app'
});
