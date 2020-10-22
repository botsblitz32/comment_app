<template>
  <section>
    <b-row>
      <b-col>
        <b-card title="This is a nice post">
          <b-card-text>
            The purpose of life is to live it, to taste experience to the
            utmost, to reach out eagerly and without fear for newer and richer
            experience.
          </b-card-text>
          <template #footer>
            <small class="text-muted">Last updated 3 mins ago</small>
          </template>
        </b-card>
      </b-col>
    </b-row>
    <br />
    <b-row>
      <b-col>
        <b-form ref="formComment" @submit.prevent @submit="onSubmit(1)">
          <b-overlay :show="loading" rounded="sm">
            <b-form-group id="input-group-1" label="Name" label-for="input-1">
              <b-form-input
                id="input-1"
                type="text"
                required
                v-model="fields.name"
                placeholder="Enter name"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              id="input-group-1"
              label="Comment"
              label-for="input-1"
            >
              <b-form-textarea
                v-model="fields.comment"
                id="textarea-no-resize"
                placeholder="Enter Comment"
                rows="3"
                no-resize
                required
              ></b-form-textarea>
            </b-form-group>
          </b-overlay>
          <b-button
            :disabled="loading"
            align-h="end"
            type="submit"
            variant="primary"
            >Comment</b-button
          >
        </b-form>
      </b-col>
    </b-row>
  </section>
</template>
<script>
export default {
  data() {
    return {
      fields: { comment: "", name: "" },
      loading: false,
      errors: {},
    };
  },
  watch: {
    "fields.name": function (val) {
      localStorage.setItem("name", this.fields.name);
      this.$eventHub.$emit("name-updated", this.fields.name);
    },
  },
  methods: {
    onSubmit(level) {
      this.loading = true;
      axios
        .post("/api/comment", this.fields)
        .then((response) => {
          this.loading = false;
          this.$bvToast.toast(`Comment added`, {
            toaster: "b-toaster-top-center",
            title: "Success",
            variant: "success",
          });
          this.fields.comment = "";
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
  mounted() {
    localStorage.setItem("name", this.fields.name);
  },
};
</script>