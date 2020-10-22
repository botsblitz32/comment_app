<template>
  <section>
    <b-button
      v-b-toggle="'collapse-level-1-' + id"
      variant="outline-secondary"
      size="sm"
      ><b-icon-chat-left-dots-fill></b-icon-chat-left-dots-fill
      >&nbsp;Reply</b-button
    >
    <b-collapse accordion="collapse" v-bind:id="'collapse-level-1-' + id">
      <b-form :ref="'form-' + id" @submit.prevent @submit="onReply(id)">
        <b-form-textarea
          class="mt-2"
          id="textarea-no-resize"
          placeholder="Enter reply"
          rows="3"
          no-resize
          required
        ></b-form-textarea>

        <b-button
          class="mt-2"
          :disabled="loading"
          v-b-toggle="'collapse-level-1-' + id"
          align-h="end"
          size="sm"
          variant="outline-danger"
          >Cancel</b-button
        >
        <b-button
          class="mt-2"
          :disabled="loading"
          align-h="end"
          type="submit"
          size="sm"
          variant="outline-primary"
          >Reply</b-button
        >
      </b-form>
    </b-collapse>
  </section>
</template>
<script>
export default {
  data() {
    return {
      errors: {},
      loading: false,
      name: "",
    };
  },
  methods: {
    onReply(parent_id) {
      let params = {
        comment_parent_id: parent_id,
        comment: this.$refs["form-" + parent_id][0].value,
        name: localStorage.getItem("name"),
      };
      axios
        .post("/api/comment", params)
        .then((response) => {
          this.loading = false;
          this.$bvToast.toast(`Comment added`, {
            toaster: "b-toaster-top-center",
            title: "Success",
            variant: "success",
          });
          this.$refs["form-" + parent_id][0].value = "";
          this.$eventHub.$emit("comment-added");
        })
        .catch((error) => {
          this.loading = false;
          let errorMessage = "";
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            for (var key of Object.keys(this.errors)) {
              console.log(key + " -> " + this.errors[key]);
              errorMessage = errorMessage + this.errors[key] + "\n";
            }
          } else {
            errorMessage = error.response.data.message;
          }
          this.$bvToast.toast(errorMessage, {
            toaster: "b-toaster-top-center",
            title: "Danger",
            variant: "danger",
          });
        });
    },
  },
  props: ["id"],
};
</script>