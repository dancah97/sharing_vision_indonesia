<template>
    <div>
        <v-btn @click="$router.push('/add')" color="primary">Add New Post</v-btn>
        <v-btn @click="$router.push('/preview')" color="primary">Preview</v-btn>
        <v-tabs v-model="activeTab">
            <v-tab v-for="tab in tabs" :key="tab" @click="fetchPosts(tab)">{{ tab }}</v-tab>
        </v-tabs>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        <v-data-table :headers="headers" :items="posts">
            <template slot="item.action" slot-scope="{ item }">
                <v-icon @click="editPost(item.id)">edit</v-icon>
                <br>
                <v-icon @click="moveToTrash(item)">delete</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import axios from 'axios';

const apiUrl = 'http://127.0.0.1:8000/api';

export default {
  name: 'AllPosts',
  data() {
    return {
      activeTab: 'Publish',
      tabs: ['Publish', 'Draft', 'Thrash'],
      headers: [
        { text: 'Title', value: 'title' },
        { text: 'Category', value: 'category' },
        { text: 'Action', value: 'action', sortable: false }
      ],
      posts: [],
      limit : 10,
      offset : 0,
      errorMessage: ''
    };
  },
  methods: {
    fetchPosts(status) {
      axios.get(`${apiUrl}/article/all/${this.offset}?status=${status.toLowerCase()}`).then(res => {
        this.posts = res.data;
      }).catch(error => {
        this.errorMessage = "Error fetching posts. Please try again.";
        console.error("Error fetching posts:", error);
      });
    },
    editPost(id) {
      this.$router.push(`/edit/${id}`);
    },
    moveToTrash(item) {
        axios.put(`${apiUrl}/article/${item.id}`, { status: 'Thrash', title: item.title, content: item.content, category: item.category }).then(() => {
            this.fetchPosts('Publish');
      }).catch(error => {
        this.errorMessage = "Error fetching posts. Please try again.";
        console.error("Error fetching posts:", error);
      });
    }
  },
  created() {
    this.fetchPosts(this.activeTab);
  }
}
</script>