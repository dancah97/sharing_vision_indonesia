import Vue from 'vue';
import VueRouter from 'vue-router';
import AllPosts from './components/AllPosts.vue';
import EditPost from './components/EditPost.vue';
import AddNew from './components/AddNew.vue';
import PostPreview from './components/PostPreview.vue';

Vue.use(VueRouter);

const routes = [
  { path: '/', component: AllPosts },
  { path: '/add', component: AddNew },
  { path: '/edit/:id', component: EditPost },
  { path: '/preview', component: PostPreview }
];

export default new VueRouter({ routes });