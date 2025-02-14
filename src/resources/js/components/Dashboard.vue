<template>
    <div>
        <div class="min-h-screen bg-gray-100">
        <!-- Left Sidebar -->
        <nav-left-panel :username="user.username"></nav-left-panel>

        <!-- Main Content -->
        <div class="ml-64 mr-80">
            <!-- Tweet creation-->
            <div class="p-4 border-b border-gray-200 bg-white">
                <div class="flex">
                    <div class="ml-4 flex-1">
                        <textarea
                            v-model="newTweet"
                            class="w-full border border-gray-300 rounded-lg p-2 resize-none"
                            placeholder="What's happening?"
                            rows="3"
                        ></textarea>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ 280 - newTweet.length }} characters remaining</span>
                            <button
                                @click="createTweet"
                                :disabled="!newTweet.trim() || tweetLoading"
                                :class="{ 'opacity-50': tweetLoading }"
                            >
                                {{ tweetLoading ? 'Posting...' : 'Ping' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tweet Feed -->
            <tweet-feed></tweet-feed>
            </div>
        </div>

        <!-- Right Sidebar -->
        <right-panel></right-panel>
    </div>
</template>

<script>
import IndigoButton from "./ui/IndigoButton.vue";
import NavLeftPanel from "./ui/NavLeftPanel.vue";
import RightPanel from "./ui/RightPanel.vue";
import TweetFeed from "./TweetFeed.vue";

export default {
    name: 'Dashboard',
    components: {TweetFeed, RightPanel, NavLeftPanel, IndigoButton},
    data() {
        return {
            loading: false,
            tweetLoading: false,
            user: {
                full_name: '',
                email: '',
                username: '',
                avatar: null
            },
            newTweet: '',
            tweets: [],
        }
    },
    created() {
        this.fetchUserData()
    },
    methods: {
        // Fetch User
        async fetchUserData() {
            try {
                const response = await axios.get('/user');
                this.user = response.data;  // Populate user data
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },

         // Create Tweet
        async createTweet() {
            if (!this.newTweet.trim()) return

            this.tweetLoading = true
            try {
                const response = await axios.post('/tweets', {
                    content: this.newTweet,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                this.tweets.unshift(response.data)
                this.newTweet = ''
            } catch (error) {
                console.error('Error creating tweet:', error)
            } finally {
                this.tweetLoading = false
            }
        },
    }
}
</script>
