<template>
    <div class="explore-page">
        <nav-left-panel></nav-left-panel>

        <!-- Search Bar -->
        <div class="search-bar">
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Search Users"
                @input="searchUsers"
            />
        </div>
        <!-- Main Content -->
        <div v-if="users && users.data && users.data.length">
            <div v-for="user in users.data" :key="user.id" class="mt-2 flex space-x-4 space-y-4">
                <img :src="user.avatar" alt="Avatar" class="w-12 h-12 rounded-full"/>

                <span>
                <a :href="`/profile/${user.username}`" class="hover:text-blue-500">
                    (@{{ user.username }})
                </a>
                </span>
                <span class="ml-2 text-sm text-gray-500">{{ user.full_name }} </span>
            </div>
        </div>
            <div v-else-if="searchQuery.length > 0 && !loading">
                <p>No users found.</p>
            </div>
            <div v-else-if="loading">
                <p>Loading...</p>
            </div>
        <right-panel></right-panel>
    </div>
</template>

<script>
import NavLeftPanel from "../ui/NavLeftPanel.vue";
import RightPanel from "../ui/RightPanel.vue";

export default {
    name: 'Explore',
    components: {NavLeftPanel, RightPanel},
    data() {
        return {
            searchQuery: "",
            users: null,
            loading: false
        };
    },
    methods: {
        // Fetch users
        async searchUsers() {
            this.loading = true;
            if (this.searchQuery.length < 1) {
                this.users = null;
                this.loading = false;
                return;
            }
            try {
                const encodedQuery = encodeURIComponent(this.searchQuery);
                const response = await axios.get(`/explore/users?query=${encodedQuery}`);
                this.users = response.data.users;
            } catch (error) {
                this.users = null;
            } finally {
                this.loading = false;
            }
        },
        clearSearch() {
            this.searchQuery = "";
            this.users = null;
        }
    }
};
</script>

<style scoped>
.explore-page {
    width: 100%;
    max-width: 800px;
    margin: auto;
}

/* Search Bar */
.search-bar {
    padding: 10px;
}
.search-bar input {
    width: 100%;
    padding: 10px;
    border-radius: 20px;
    border: none;
    background: lightgray;
    color: black;
}

/* Content */
.content {
    padding: 10px;
}
</style>

