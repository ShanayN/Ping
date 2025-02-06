<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <img class="mx-auto h-10 w-auto" src="/images/logo.png" alt="logo" />
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Create your account
                </h2>
            </div>
            <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
                <input type="hidden" :value="csrfToken" name="_token">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="name" class="sr-only">Full Name</label>
                        <input
                            id="name"
                            v-model="form.full_name"
                            type="text"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="Full name"
                        >
                    </div>
                    <div>
                        <label for="name" class="sr-only">Username</label>
                        <input
                            id="username"
                            v-model="form.username"
                            type="text"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="Username"
                        >
                    </div>
                    <div>
                        <label for="date_of_birth" class="sr-only">Date of Birth</label>
                        <input
                            id="date_of_birth"
                            v-model="form.date_of_birth"
                            type="date"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="Email address"
                        >
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="Password"
                        >
                    </div>
                    <div>
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm password"
                        >
                    </div>
                </div>

                <div v-if="error" class="text-red-500 text-sm text-center">
                    {{ error }}
                </div>

                <div>
                    <indigo-button
                        type="submit"
                        :disabled="loading"
                    >
                        <span v-if="loading">Creating account...</span>
                        <span v-else>Create account</span>
                    </indigo-button>
                </div>
            </form>

            <div>
                <indigo-button>
                    <a href="/">
                        Cancel
                    </a>
                </indigo-button>
            </div>

            <div class="text-center">
                <a href="/login" class="text-sm text-blue-600 hover:text-blue-500">
                    Already have an account? Sign in
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import IndigoButton from "./ui/IndigoButton.vue";

export default {
    name: 'Register',
    components: {IndigoButton},
    data() {
        return {
            form: {
                full_name: '',
                username: '',
                date_of_birth: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            error: null,
            loading: false,
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    methods: {
        async handleRegister() {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.post('/register', this.form, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.data.user) {
                    window.location.href = '/login';
                }
            } catch(error) {
                this.error = error.response?.data?.message || 'Registration failed';
                console.error('Registration error:', error.response?.data);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

