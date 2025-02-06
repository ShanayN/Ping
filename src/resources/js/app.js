import './bootstrap';
import Vue from "vue";
import LandingPage from "./components/LandingPage.vue";
import RegisterForm from "./components/RegisterForm.vue";
import LoginForm from "./components/LoginForm.vue";
import Dashboard from "./components/Dashboard.vue";

Vue.component('landing-page', LandingPage);
Vue.component('register-form', RegisterForm);
Vue.component('login-form', LoginForm)
Vue.component('dashboard', Dashboard)

const app = new Vue({
    el: '#app'
});
