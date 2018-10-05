<template>
<v-card class="mt-4">
  <v-card-title primary-title
    class="primary white--text pa-2"
  >
    <span class="title">
      {{ comment.name }}
    </span>
    <v-spacer></v-spacer>
    <span>
      {{ postedDate }} ago
    </span>
  </v-card-title>
  <v-card-text v-html="getMarkdownComment">
  </v-card-text>

  <v-card-actions>
    <span class="ml-2"
      @click.prevent="store.getComment(comment)"
    >
      <a href="#">Respond to this comment</a>
    </span>
    <v-spacer></v-spacer>
    <v-btn icon v-if="comment.children.length"
      @click="show_children = !show_children"
    >
      <v-icon>{{ show_children ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}</v-icon>
    </v-btn>
  </v-card-actions>

  <v-card-text v-if="show_children">
    <comment v-for="child in comment.children"
      :key="child.id"
      :comment="child"
    ></comment>
  </v-card-text>
</v-card>
</template>

<script>
import { distanceInWordsToNow, parse } from 'date-fns'
import CommentStore from '~/store/CommentStore'

export default {

  name: 'Comment',

  props: {
    comment: {
      type: Object,
      required: true,
    }
  },

  data: () => ({
    show_children: true,
    store: CommentStore,
  }),

  computed: {
    getMarkdownComment() {
      return markdown.render(this.comment.comment)
    },
    postedDate() {
      return distanceInWordsToNow(
        parse(this.comment.created_at)
      )
    },
  },
}
</script>
