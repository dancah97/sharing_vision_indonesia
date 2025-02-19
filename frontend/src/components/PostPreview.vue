<template>
    <div>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      <v-btn @click="$router.push('/')" color="primary">ALL POST</v-btn>
      <v-container>
        <v-card v-for="post in posts" :key="post.id">
          <v-card-title>{{ post.title }}</v-card-title>
          <v-card-text>{{ post.content }}</v-card-text>
        </v-card>
      </v-container>
      <v-pagination v-model="page" :length="totalPages" @input="fetchPosts" />
    </div>
</template>

<script>
import axios from 'axios';

const apiUrl = 'http://127.0.0.1:8000/api';

export default {
  name: 'PostPreview',
  data() {
    return { posts: [], page: 1, totalPages: 1, errorMessage: '', limit : 10, offset : 0 };
  },
  methods: {
    fetchPosts() {
      this.offset = (this.page - 1) * this.limit;
      axios.get(`${apiUrl}/article/${this.limit}/${this.offset}?status=publish&page=${this.page}`).then(res => {
        this.posts = res.data.data;
        this.totalPages = res.data.last_page;
      }).catch(error => {
        this.errorMessage = "Error fetching posts. Please try again.";
        console.error("Error fetching posts:", error);
      });
    }
  },
  created() {
    this.fetchPosts();
  }
}
</script>