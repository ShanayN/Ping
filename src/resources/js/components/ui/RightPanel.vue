<template>
    <div class="fixed right-0 top-0 h-screen w-80 bg-gradient-to-r from-indigo-50 to-indigo-500 overflow-y-auto p-4">
        <!-- Search Bar -->
        <div class="mb-4">
            <div class="relative">
                <input
                    type="text"
                    placeholder="Search Twitter"
                    class="w-full bg-gray-100 rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
<!--                v-model="searchQuery"-->
<!--                goes into input-->
                <!-- Search icon -->
                <div class="absolute left-3 top-2.5">
                    <i class="bi bi-search text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Premium Block -->
        <div class="bg-gray-50 rounded-xl p-4 mb-4">
            <h2 class="text-xl font-bold mb-2">Subscribe to Premium</h2>
            <p class="text-gray-600 mb-3">Subscribe to unlock new features and get a blue checkmark!</p>
            <indigo-button class="w-full justify-center">
                Subscribe Now
            </indigo-button>
        </div>

        <!-- What's Happening Block -->
        <div class="bg-gray-50 rounded-xl p-4 mb-4">
            <h2 class="text-xl font-bold mb-3">What's happening</h2>
            <div class="space-y-4">
                <div v-for="trend in trends" :key="trend.id" class="cursor-pointer hover:bg-gray-100 -mx-4 px-4 py-2">
                    <div class="text-sm text-gray-500">{{ trend.category }}</div>
                    <div class="font-bold">{{ trend.title }}</div>
                    <div class="text-sm text-gray-500">{{ trend.tweets_count }} Tweets</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 hover:text-blue-600 text-sm mt-3 block">Show more</a>
        </div>

        <!-- Who to Follow Block -->
        <div class="bg-gray-50 rounded-xl p-4">
            <h2 class="text-xl font-bold mb-3">Who to follow</h2>
            <div class="space-y-4">
                <div v-for="suggestion in suggestions" :key="suggestion.id" class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img :src="suggestion.avatar || 'https://via.placeholder.com/40'" class="h-10 w-10 rounded-full">
                        <div class="ml-3">
                            <div class="font-bold">{{ suggestion.name }}</div>
                            <div class="text-sm text-gray-500">@{{ suggestion.username }}</div>
                        </div>
                    </div>
                    <indigo-button class="text-sm">
                        Follow
                    </indigo-button>
                </div>
            </div>
            <a href="#" class="text-blue-500 hover:text-blue-600 text-sm mt-3 block">Show more</a>
        </div>
    </div>
</template>

<script>
    import IndigoButton from "./IndigoButton.vue";

    export default {
        name: 'RightPanel',
        components: {IndigoButton},
        searchQuery: '',
        data() {
            return  {
                trends: [
                    { id: 1, category: 'Trending in Technology', title: '#VueJS', tweets_count: '12.5K' },
                    { id: 2, category: 'Trending in Web Dev', title: '#Laravel', tweets_count: '8.2K' },
                    { id: 3, category: 'Technology · Trending', title: 'Full Stack', tweets_count: '5.1K' }
                ],
                suggestions: [
                    { id: 1, name: 'John Doe', username: 'johndoe', avatar: null },
                    { id: 2, name: 'Jane Smith', username: 'janesmith', avatar: null },
                    { id: 3, name: 'Bob Wilson', username: 'bobwilson', avatar: null }
                ],
            }
        }
    }
</script>
