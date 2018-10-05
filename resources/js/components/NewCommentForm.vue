<template>
<v-dialog
  v-model="visible"
  max-width="500px"
  transition="dialog-transition"
  @keydown.esc="visible = false"
  persistent
>
  <slot></slot>

  <v-card>
    <v-card-title primary-title
      class="title primary white--text pa-2"
    >
      Please enter your comment below
    </v-card-title>
    <v-card-text>

      <v-text-field
        name="name"
        label="Your Name"
        id="name"
        v-model="form.name"
        v-validate="'required'"
        :error-messages="errorMessages('name')"
      ></v-text-field>

      <v-textarea
        box
        name="comment"
        label="Your Comment"
        v-model="form.comment"
        v-validate="'required'"
        :error-messages="errorMessages('comment')"
        hint="What do you have to say?"
      >
      </v-textarea>

    </v-card-text>
    <v-card-actions>

      <v-btn color="primary"
        @click="submit"
        :loading="form.busy"
        :active="!form.busy"
      >
        Submit
      </v-btn>

      <v-btn color="secondary"
        @click="visible=false"
      >
        Cancel
      </v-btn>

    </v-card-actions>
  </v-card>

</v-dialog>
</template>

<script>
import CommentStore from '~/store/CommentStore'
import { Form } from 'vform'

export default {

  name: 'NewCommentForm',

  data: () => ({
    store: CommentStore,
    form: new Form({
      parent_id: null,
      name: null,
      comment: null,
    })
  }),

  computed: {
    parent() {
      return this.store.active
    },
    parentId() {
      return this.store.active && this.store.active.id
    },
    visible: {
      get() { return this.store.visible },
      set(v) {
        this.form.reset()
        this.$validator.reset()
        this.store.visible = v
      },
    }
  },

  methods: {
    // This will concatenate error messages
    // from vform (Laravel) and vee-validate
    errorMessages(field) {
      return this.errors.collect(field).concat(
        this.form.errors.only(field)
      )
    },

    submit() {
      // Set the requested parent id from
      // the object that opened me
      this.form.parent_id = this.parentId

      this.form.post('/api/comments')
        .then(response => {
          this.store.addComment(response.data.data)
          this.visible = false
        })
    },
  },

}
</script>
