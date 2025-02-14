<template>
        <div class="fixed left-0 top-0 h-screen w-64 bg-gradient-to-r from-indigo-500">
            <div class="p-4">
                <img class="mx-auto h-10 w-auto" src="/images/logo.png" alt="logo" />
                <h1 class="mt-4 text-2xl text-center font-bold text-gray-700">Ping</h1>
            </div>
            <!-- Navigation Links -->
        <nav class="mt-4">
            <NavLink href="/dashboard" text="Home">
                <template #icon>
                    <i class="bi bi-house"></i>
                </template>
            </NavLink>
            <a :href="`/profile/${username}`" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-violet-500">
                <i class="bi bi-person-circle"></i>
                <span class="ml-2">Profile</span>
            </a>
            <nav-link text="Explore" href="/explore">
                <template #icon>
                    <i class="bi bi-search"></i>
                </template>
            </nav-link>
<!--            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-violet-500">-->
<!--                <i class="bi bi-envelope"></i>-->
<!--                <span class="ml-2">Messages</span>-->
<!--            </a>-->

<!--            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-violet-500">-->
<!--                <i class="bi bi-bell"></i>-->
<!--                <span class="ml-2">Notifications</span>-->
<!--            </a>-->
<!--            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-violet-500">-->
<!--                <i class="bi bi-chevron-up"></i>-->
<!--                <span class="ml-2">Premium</span>-->
<!--            </a>-->
<!--            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-violet-500">-->
<!--                <i class="bi bi-three-dots"></i>-->
<!--                <span class="ml-2">More</span>-->
<!--            </a>-->

            <!-- Logout Button -->
            <div class="px-4 mt-4">
                <indigo-button
                    @click="handleLogout"
                    :class="{ 'opacity-50': loading }"
                    :disabled="loading"
                    class="w-full justify-center"
                >
                    {{ loading ? 'Logging out...' : 'Logout' }}
                </indigo-button>
            </div>
        </nav>
    </div>
</template>

<script>
import indigoButton from "./IndigoButton.vue";
import NavLink from "../partials/NavLink.vue";
    export default {
        name: 'NavLeftPanel',
        components: {indigoButton, NavLink},
        props: {
            username: String
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            // Logout User
            async handleLogout() {
                this.loading = true
                try {
                    await axios.post('/logout')
                    window.location.href = '/login'
                } catch (error) {
                    console.error('Error during logout:', error)
                } finally {
                    this.loading = false
                }
            },
        }
    }
</script>
