<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <img class="mx-auto h-10 w-auto" src="/images/logo.png" alt="logo" />
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                   Login
                </h2>
            </div>
            <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
                <input type="hidden" :value="csrfToken" name="_token">
                <div class="rounded-md shadow-sm -space-y-px">
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
                </div>

                <div v-if="error" class="text-red-500 text-sm text-center">
                    {{ error }}
                </div>

                <div>
                    <indigo-button
                        type="submit"
                        :disabled="loading"
                    >
                        <span v-if="loading">Logging In...</span>
                        <span v-else>Log In</span>
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
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import IndigoButton from "./ui/IndigoButton.vue";

export default {
    name: 'Login',
    components: {IndigoButton},
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            error: null,
            loading: false,
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.post('/login', this.form, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.data.user) {
                    window.location.href = '/dashboard';
                }
            } catch(error) {
                this.error = error.response?.data?.message || 'Login failed';
                console.error('Login error:', error.response?.data);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

