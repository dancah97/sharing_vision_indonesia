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
  name: 'AddNew',
  data() {
    return { post: { title: '', content: '', category: '' },errorMessage: '' };
  },
  methods: {
    savePost(status) {
      axios.post(`${apiUrl}/article`, { ...this.post, status }).then(() => {
        this.$router.push('/');
      }).catch(error => {
        this.errorMessage = "Error saving post. Please try again.";
        console.error("Error saving post:", error);
      });
    }
  }
}
</script>