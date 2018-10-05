<template>
<div>
<v-toolbar fixed app dark color="primary">
  <v-toolbar-title class="white--text">
    <a href="/" style="color:inherit;text-decoration:none">
      {{ name }}
    </a>
  </v-toolbar-title>
  <v-spacer></v-spacer>
    <v-btn flat @click="store.getComment(null)">
      Post a New Comment
    </v-btn>
</v-toolbar>

<v-content>
  <new-comment-form></new-comment-form>
  <v-container fill-height>
    <v-layout justify-center>
      <v-flex xs12 md10 lg8 xl6>
        <comment v-for="comment in comments"
          :key="comment.id"
          :comment="comment"
        ></comment>
      </v-flex>
    </v-layout>
  </v-container>
</v-content>
</div>
</template>

<script>
import Comment from '~/components/Comment'
import NewCommentForm from '~/components/NewCommentForm'
import CommentStore from '~/store/CommentStore'

export default {

  name: 'CommentApp',

  components: {
    comment: Comment,
    'new-comment-form': NewCommentForm,
  },

  props: {
    name: {
      type: String,
      default: 'Application',
    }
  },

  data: () => ({
    store: CommentStore,
  }),

  created() {
    this.loadComments()
  },

  computed: {
    comments() { return this.store.comments }
  },

  methods: {
    loadComments() {
      axios.get('/api/comments')
        .then(response => {
          this.store.comments = response.data.data
        })
    },
  },

}
</script>
