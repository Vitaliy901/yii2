<!-- views/site/index.php -->
<div id="app">
    <h2>Send Review</h2>
    <form @submit.prevent="submitReview">
        <input v-model="name" placeholder="Author name" required><br>
        <textarea v-model="text" placeholder="Review content" required></textarea><br>
        <button type="submit">Send</button>
        <p v-if="message">{{ message }}</p>
    </form>

    <hr>

    <h2>Review</h2>
    <div v-for="review in reviews" :key="review.id">
        <strong>{{ review.author_name }}</strong><br>
        {{ review.text }}<hr>
    </div>

    <!-- Admin panel -->
    <div>
        <h3>Moderation</h3>
        <input v-model="token" placeholder="Admin token" />
        <button @click="loadPending">Upload</button>
        <div v-for="r in pending" :key="r.id">
            <b>{{ r.author_name }}</b>: {{ r.text }}
            <button @click="moderate(r.id, 'approved')">Approved</button>
            <button @click="moderate(r.id, 'rejected')">Deny</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            name: '',
            text: '',
            message: '',
            reviews: [],
            pending: [],
            token: ''
        },
        mounted() {
            this.loadApproved();
        },
        methods: {
            async submitReview() {
                const res = await fetch('/api/review', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({author_name: this.name, text: this.text})
                });
                this.message = 'Thanks, review was sent for moderation.';
                this.name = '';
                this.text = '';
            },
            async loadApproved() {
                const res = await fetch('/api/review?status=approved');
                this.reviews = await res.json();
            },
            async loadPending() {
                const res = await fetch('/api/review?status=pending', {
                    headers: { Authorization: 'Bearer ' + this.token }
                });
                this.pending = await res.json();
            },
            async moderate(id, status) {
                await fetch('/api/review/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: 'Bearer ' + this.token
                    },
                    body: JSON.stringify({status})
                });
                this.loadPending();
                this.loadApproved();
            }
        }
    });
</script>
