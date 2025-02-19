<template>
    <div>
      <v-text-field v-model="post.title" label="Title" />
      <v-textarea v-model="post.content" label="Content" />
      <v-text-field v-model="post.category" label="Category" />
      <v-btn @click="savePost('Publish')">Publish</v-btn>
      <v-btn @click="savePost('Draft')">Draft</v-btn>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from 'axios';

const apiUrl = 'http://127.0.0.1:8000/api';

export default {
  name: 'EditPosts',
  data() {
    return { post: {}, errorMessage: '' };
  },
  methods: {
    fetchPost() {
      axios.get(`${apiUrl}/article/${this.$route.params.id}`).then(res => {
        console.log('ese',res);
        this.post = res.data[0];
      }).catch(error => {
        this.errorMessage = "Error fetching posts. Please try again.";
        console.error("Error fetching posts:", error);
      });
    },
    savePost(status) {
      axios.put(`${apiUrl}/article/${this.post.id}`, { ...this.post, status }).then(() => {
        this.$router.push('/');
      }).catch(error => {
        this.errorMessage = "Error fetching posts. Please try again.";
        console.error("Error fetching posts:", error);
      });
    }
  },
  created() {
    this.fetchPost();
  }
}
</script>