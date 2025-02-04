import './bootstrap';
import Vue from "vue";
import LandingPage from "./components/LandingPage.vue";
import RegisterForm from "./components/RegisterForm.vue";

Vue.component('landing-page', LandingPage);
Vue.component('register-form', RegisterForm);

const app = new Vue({
    el: '#app'
});

