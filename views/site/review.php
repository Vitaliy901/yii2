<?php
$this->title = 'Leave a Review';
?>

<div id="vue-app">
    <form @submit.prevent="submitReview">
        <input v-model="name" placeholder="Your name" required>
        <textarea v-model="text" placeholder="Your review" required></textarea>
        <button type="submit">Submit</button>
        <p v-if="message">{{ message }}</p>
    </form>
</div>

<script>
    new Vue({
        el: '#app',
        data: {
            name: '',
            text: '',
            message: ''
        },
        methods: {
            async submitReview() {
                const res = await fetch('/api/review', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        author_name: this.name,
                        text: this.text
                    })
                });
                if (res.ok) {
                    this.message = 'Thank you! Review sent for moderation.';
                    this.name = '';
                    this.text = '';
                }
            }
        }
    });
</script>
