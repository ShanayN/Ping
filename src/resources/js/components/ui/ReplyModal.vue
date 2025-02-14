<template>
    <div v-if="isOpen" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
            <!-- Close Button (Top-Right) -->
            <button class="close-button" @click="closeModal">&times;</button>

            <!-- Display Existing Comments -->
            <!-- Display Comments -->
            <div class="comments-section">
                <div v-if="loading">Loading comments...</div>
                <div v-else-if="comments.length">
                    <div v-for="comment in comments" :key="comment.id" class="comment">
                        <strong>@{{ comment.user.username }}</strong>
                        <span class="ml-2 text-sm text-gray-500">· {{ formatDate(comment.user.created_at) }}</span>
                        <p>{{ comment.body }}</p>
                    </div>
                    <!--                        <button class="delete-button" @click="deleteComment(comment.id)">🗑</button>-->
                </div>
                <p v-else class="no-comments">No comments yet. Be the first to reply!</p>
            </div>

            <!-- Larger Textarea for Reply -->
            <textarea v-model="commentText" placeholder="Write your reply..."></textarea>

            <!-- Buttons Aligned at the Bottom -->
            <div class="modal-footer">
                <button class="comment-button" @click="submitComment" :disabled="commenting">
                    {{ commenting ? "Commenting..." : "Comment" }}
                </button>
                <button class="cancel-button" @click="closeModal">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['isOpen', 'tweet', 'comments'],
    data() {
        return {
            commentText: "",
            loading: false,
            commenting: false,
        };
    },
    watch: {
        isOpen(newVal) {
            if (newVal) this.fetchComments();
        }
    },
    methods: {
        async fetchComments() {
            this.loading = true;
            try {
                const response = await axios.get(`/tweets/${this.tweet.id}/comments`);
                this.comments = response.data;
            } catch (error) {
                console.error("Error fetching comments:", error);
            }
            this.loading = false;
        },
        async submitComment() {
            if (!this.commentText.trim()) return;
            this.commenting = true;
            try {
                const response = await axios.post(`/tweets/${this.tweet.id}/comments`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: this.commentText,
                });
                this.comments.push(response.data);
                this.commentText = "";
            } catch (error) {
                console.error("Error posting comment:", error);
            }
            this.commenting = false;
        },
        // async deleteComment(commentId) {
        //     if (!confirm("Delete this comment?")) return;
        //     try {
        //         await axios.delete(`/comments/${commentId}`);
        //         this.comments = this.comments.filter(comment => comment.id !== commentId);
        //     } catch (error) {
        //         console.error("Error deleting comment:", error);
        //     }
        // },
        closeModal() {
            this.$emit("close");
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString()
        },
    }
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.1); /* Slightly transparent overlay */
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 24px;
    border-radius: 12px;
    width: 600px;
    max-width: 80vw;
    max-height: 80vh;
    overflow-y: auto;
    text-align: left;
    border: none;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    position: relative;
    display: flex;
    flex-direction: column;
}

/* Close Button (Top-Right) */
.close-button {
    position: absolute;
    top: 12px;
    right: 12px;
    background: transparent;
    border: none;
    font-size: 20px;
    cursor: pointer;
}

/* Comments Section */
.comments-section {
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid #ddd;
}

.comment {
    background: #f1f1f1;
    padding: 8px;
    border-radius: 6px;
    margin-bottom: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.no-comments {
    color: #888;
    font-style: italic;
}

/* Larger Textarea */
textarea {
    width: 100%;
    height: 120px;
    padding: 10px;
    border: 1px solid #6d28d9;
    border-radius: 6px;
    resize: vertical;
    font-size: 16px;
}

/* Buttons at the Bottom */
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 16px;
}

.comment-button {
    background: #6d28d9;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.cancel-button {
    background: #ccc;
    color: black;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
}

.comment-button:hover {
    background: #5b21b6;
}

.cancel-button:hover {
    background: #bbb;
}

</style>


<!--//.delete-button {-->
<!--//    background: red;-->
<!--//    color: white;-->
<!--//    border: none;-->
<!--//    padding: 4px 8px;-->
<!--//    border-radius: 4px;-->
<!--//    cursor: pointer;-->
<!--//}-->
<!--//-->
<!--//.delete-button:hover {-->
<!--//    background: darkred;-->
<!--//}-->
