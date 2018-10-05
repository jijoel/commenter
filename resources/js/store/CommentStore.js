export default {

    // The primary nested list
    // of comments in the system
    comments: [],

    // Associative index of comments so we can
    // instantly look them up
    map: {},

    // The currently active comment
    // (used by new comments)
    active: null,

    // Should we show the new comment form?
    visible: false,

    /**
     * Show a form to get a new comment from
     * the user
     */
    getComment(comment) {
      this.active = comment
      this.visible = true
    },

    /**
     * Add a new comment to the UI once it has been
     * created by the back-end
     */
    addComment(comment) {

        // The first time we're asked to add a comment,
        // build a map of objects so we can instantly
        // add new comments as they come up
        if (Object.keys(this.map).length === 0)
            this.buildMap(this.comments)

        this.map[comment.id] = comment

        // Add a top-level comment
        if (comment.parent_id === 0) {
            return this.comments.push(comment)
        }

        // Add a deeper comment
        this.map[comment.parent_id].children.push(comment)
    },

    buildMap(list) {
        for (var i = 0; i < list.length; i++) {
            this.map[list[i].id] = list[i]
            this.buildMap(list[i].children)
        }
    }
}
