<?php
$this->title = 'Admin Page';
?>

<div id="vue-app">
    <input v-model="token" placeholder="Admin token" />
    <table>
        <tr v-for="review in reviews" :key="review.id">
            <td>{{ review.author_name }}</td>
            <td>{{ review.text }}</td>
            <td>
                <button @click="moderate(review.id, 'approved')">Approve</button>
                <button @click="moderate(review.id, 'rejected')">Reject</button>
            </td>
        </tr>
    </table>
</div>

<script>
    new Vue({
        el: '#admin',
        data: {
            token: '',
            reviews: []
        },
        created() {
            fetch('/api/review?status=pending')
                .then(res => res.json())
                .then(data => this.reviews = data);
        },
        methods: {
            moderate(id, status) {
                fetch(`/api/review/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${this.token}`
                    },
                    body: JSON.stringify({ status })
                }).then(res => {
                    if (res.ok) {
                        this.reviews = this.reviews.filter(r => r.id !== id);
                    } else {
                        alert('Failed to moderate. Check token.');
                    }
                });
            }
        }
    });
</script>
