<template>
    <div class="divide-y divide-gray-200">
        <div v-for="tweet in tweets" :key="tweet.id" class="p-4 hover:bg-gray-50">
            <div class="flex">
                 <div class="flex-shrink-0">
                     <img
                        :src="tweet.user.avatar"
                        alt="Author avatar"
                        class="w-12 h-12 rounded-full"
                    />
                </div>
                <div class="ml-4">
                    <div class="flex items-center">
                        <span class="font-medium">
                            <a :href="`/profile/${tweet.user.username}`" class="hover:text-violet-500">
                                {{ tweet.user.full_name }}
                            </a>
                        </span>

                        <span class="ml-2 text-sm text-gray-500">@{{ tweet.user.username }}</span>
                        <span class="ml-2 text-sm text-gray-500">· {{ formatDate(tweet.created_at) }}</span>
                    </div>
                    <p class="mt-1">{{ tweet.content }}</p>
                    <div class="mt-2 flex space-x-4">
                        <span class="font-bold">{{ tweet.likes_count }}</span>
                        <button @click="toggleLike(tweet)" :class="tweet.liked_by_user ? 'text-violet-700' : 'text-black'">
                            {{ tweet.liked_by_user ? 'Like' : 'Like' }}
                        </button>

                        <div>
                            <span class="font-bold mr-2">{{ tweet.comments_count }}</span>
                            <button @click="commentOnTweet(tweet)">Comment</button>

                            <ReplyModal
                                v-if="isModalOpen"
                                :isOpen="isModalOpen"
                                :tweet="selectedTweet"
                                :comments="comments"
                                @close="isModalOpen = false"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import IndigoButton from "./ui/IndigoButton.vue";
import ReplyModal from "./ui/ReplyModal.vue";

export default {
    name: 'TweetFeed',
    components: {IndigoButton, ReplyModal},
    data() {
        return {
            user: {
                full_name: '',
                email: '',
                username: '',
                avatar: null
            },
           tweets: [],
            comments: [],
            isModalOpen: false,
            selectedTweet: null
        };
    },
    mounted() {
        this.fetchTweets()
    },
    methods: {
        // Fetch tweets when mounted
        async fetchTweets() {
            try {
                const response = await axios.get('/tweets');
                this.tweets = response.data.data;
            } catch (error) {
                console.error('Error fetching tweets:', error)
            }
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString()
        },

        async toggleLike(tweet) {
            try {
               const response = await axios.post(`/tweets/${tweet.id}/like`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
               });
                tweet.liked_by_user = response.data.liked_by_user;
                tweet.likes_count = response.data.likes_count;
            } catch (error) {
                console.error("Error liking tweet:", error);
            }
        },

        commentOnTweet(tweet) {
            this.selectedTweet = { ...tweet };
            this.isModalOpen = true;
            this.fetchComments(tweet.id);
        },

        async fetchComments(tweetId) {
            try {
                const response = await axios.get(`/tweets/${tweetId}/comments`);
                this.comments = response.data;
            } catch (error) {
                console.error("Error fetching comments:", error);
                this.comments = [];
            }
        }
    }
}
</script>
