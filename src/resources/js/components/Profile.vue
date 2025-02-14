<template>
        <div>
            <div class="min-h-screen bg-gray-100">
                <!-- Left Sidebar -->
                <nav-left-panel></nav-left-panel>

                <!-- Main Content -->
                <div class="ml-64 mr-80">
                    <div class="profile-container max-w-2xl mx-auto">
                        <!-- Cover Image -->
                        <div class="relative h-48 bg-gray-200">
                            <img
                                :src="fullUser.coverImage"
                                alt="Cover image"
                                class="w-full h-full object-cover"
                            />

                            <!-- Profile Picture -->
                            <div class="absolute -bottom-16 left-4">
                                <img
                                    :src="fullUser.avatar"
                                    alt="Profile picture"
                                    class="w-32 h-32 rounded-full border-4 border-white"
                                />
                            </div>

                            <!-- Profile Actions -->
                            <div class="flex justify-end p-4">
                                <button
                                    v-if="isCurrentUser"
                                    class="px-4 py-2 border border-gray-300 rounded-full font-bold hover:bg-gray-50"
                                >
                                    Edit Profile
                                </button>
                                <button
                                    v-else
                                    :class="[
                                          'px-4 py-2 rounded-full font-bold',
                                          isFollowing
                                            ? 'border border-gray-300 hover:bg-gray-50'
                                            : 'bg-black text-white hover:bg-gray-800'
                                        ]"
                                    @click="toggleFollow"
                                >
                                    {{ isFollowing ? 'Unfollow' : 'Follow' }}
                                </button>
                            </div>
                        </div>

                            <!-- Profile Info -->
                            <div class="px-4 mt-24">
                                <h1 class="text-xl font-bold">{{ fullUser.full_name }}</h1>
                                <p class="text-gray-500">@{{ fullUser.username }}</p>

                                <p class="mt-4">{{ fullUser.bio }}</p>

                                <div class="flex gap-4 mt-4 text-gray-500">

                                        <span class="flex items-center">
                                              <i class="fas fa-calendar mr-1"></i>
                                              Joined {{ formatDate(fullUser.created_at) }}
                                        </span>
                                </div>

                                <div class="flex gap-4 mt-4">
                                        <span class="font-bold">{{ fullUser.following_count}}</span>
                                        <span class="text-gray-500">Following</span>

                                        <span class="font-bold">{{ fullUser.followers_count }}</span>
                                        <span class="text-gray-500">Followers</span>
                                </div>
                            </div>

                        <!-- Tweets Section -->
                        <div v-if="tweets.length" class="tweets mt-8 px-4">
                            <h2 class="text-xl font-bold">Tweets</h2>
                            <div
                                v-for="tweet in tweets"
                                :key="tweet.id"
                                class="p-4 border-b hover:bg-gray-50"
                            >
                                <div class="flex gap-3">
                                <img
                                    :src="tweet.user.avatar"
                                    alt="Author avatar"
                                    class="w-12 h-12 rounded-full"
                                />
                                <div class="flex-1">
                                    <div class="flex items-center gap-1">
                                        <span class="font-bold">{{ tweet.user.full_name }}</span>
                                        <span class="text-gray-500">@{{ tweet.user.username }}</span>
                                        <span class="text-gray-500">·</span>
                                        <span class="text-gray-500">{{ formatDate(tweet.created_at) }}</span>
                                    </div>
                                    <p class="mt-1">{{ tweet.content }}</p>

                                    <!-- Tweet Actions -->
                                    <div class="flex justify-between mt-3 text-gray-500">
                                        <button class="hover:text-blue-500" @click="replyToTweet(tweet)">
                                            <i class="far fa-comment"></i>
                                            <span>{{ tweet.replies }}</span>
                                        </button>

                                        <button class="hover:text-red-500" @click="likeTweet(tweet)">
                                            <i :class="[tweet.isLiked ? 'fas' : 'far', 'fa-heart']"></i>
                                            <span>{{ tweet.likes }}</span>
                                        </button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <!-- No Tweets Found -->
                        <div v-else class="mt-8 text-gray-500 px-4">
                            <p>This user hasn't tweeted yet.</p>
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <right-panel></right-panel>
                </div>
            </div>
        </div>
</template>

<script>
import NavLeftPanel from "./ui/NavLeftPanel.vue";
import RightPanel from "./ui/RightPanel.vue";

export default {
    name: 'Profile',
    components: {RightPanel, NavLeftPanel},
    props: {
        user: {
            type: Object,
            required: true
        },
        isCurrentUser: {
            type: Boolean,
            required: true
        },
        isFollowing: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            tweets: []
        }
    },
    computed: {
        fullUser() {
            // Return the entire user object as a computed property
            return this.user || {};
        }
    },
    mounted() {
        this.fetchTweets();
    },
    methods: {
        formatDate(date) {
            return new Date(date).toLocaleDateString()
        },

        async fetchTweets() {
           try {
               const response = await axios.get(`/profile/${this.user.username}/tweets`);
               this.tweets = response.data.map(tweet => ({
                   ...tweet,
               }));
           } catch (error) {
               console.error('Error fetching tweets:', error);
               this.errorMessage = 'Failed to load tweets. Please try again later.';
           }
        },

        async toggleFollow() {
            try {
                if (this.isFollowing) {
                    await axios.post(`/unfollow/${this.user.username}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                } else {
                    await axios.post(`/follow/${this.user.username}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                }
                this.isFollowing = !this.isFollowing;
            } catch (error) {
                console.error('Error toggling follow:', error);
                this.errorMessage = 'Failed to update follow status. Please try again later.';
            }
        }
    }
}
</script>
