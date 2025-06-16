<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// Form state
const author_name = ref('')
const content = ref('')
const status = ref('pending')

// List of reviews
const reviews = ref([])

// Load reviews on mount
async function loadReviews() {
  try {
    const response = await axios.get('http://localhost:8080/review')
    reviews.value = response.data
  } catch (e) {
    console.error('Failed to load reviews:', e)
  }
}

onMounted(loadReviews)

// Submit review
async function submitReview() {
  try {
    await axios.post('http://localhost:8080/review', {
      author_name: author_name.value,
      content: content.value,
      status: status.value,
    })
    // Clear form
    author_name.value = ''
    content.value = ''
    status.value = 'pending'
    // Reload reviews
    await loadReviews()
  } catch (e) {
    console.error('Failed to submit review:', e)
  }
}
</script>

<template>
  <div>
    <h1>Reviews</h1>
    <ul>
      <li v-for="r in reviews" :key="r.id">
        <strong>{{ r.author_name }}</strong>: {{ r.content }} (Status: {{ r.status }})
      </li>
    </ul>

    <h2>Submit a Review</h2>
    <form @submit.prevent="submitReview">
      <div>
        <label for="author_name">Author Name:</label>
        <input id="author_name" v-model="author_name" required maxlength="255" />
      </div>
      <div>
        <label for="content">Content:</label>
        <textarea id="content" v-model="content" required></textarea>
      </div>
      <div>
        <label for="status">Status:</label>
        <select id="status" v-model="status" required>
          <option value="pending">Pending</option>
          <option value="approved">Approved</option>
          <option value="rejected">Rejected</option>
        </select>
      </div>
      <button type="submit">Submit Review</button>
    </form>
  </div>
</template>

<style scoped>
form > div {
  margin-bottom: 1em;
}
label {
  display: block;
  font-weight: bold;
}
input, textarea, select {
  width: 100%;
  padding: 0.5em;
  font-size: 1em;
}
button {
  padding: 0.7em 1.5em;
  background-color: #2a9d8f;
  color: white;
  border: none;
  cursor: pointer;
}
button:hover {
  background-color: #21867a;
}
</style>
