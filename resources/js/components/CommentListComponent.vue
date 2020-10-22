<template>
  <section>
    <section fluid v-for="(comment, index) in comments" v-bind:key="index">
      <b-row class="mt-3">
        <b-col>
          <b-card>
            <b-media>
              <template #aside>
                <b-img
                  :src="'https://picsum.photos/100?random=' + index"
                  blank-color="#ccc"
                  width="64"
                  alt="placeholder"
                ></b-img>
              </template>
              <h5 class="mt-0">{{ comment.comment }}</h5>

              <p class="mb-3 small text-muted">
                {{ comment.name }} @ {{ comment.created_at }}
              </p>

              <reply-component :id="comment.id"></reply-component>

              <section
                v-for="(levelOneReply, index) in comment.comment_replies"
                v-bind:key="index"
              >
                <hr />
                <b-media class="mt-3 mb-3">
                  <template #aside>
                    <b-img
                      :src="
                        'https://picsum.photos/100?random=' + levelOneReply.id
                      "
                      blank-color="#ccc"
                      width="64"
                      alt="placeholder"
                    ></b-img>
                  </template>

                  <h5 class="mt-0">{{ levelOneReply.comment }}</h5>
                  <p class="mb-2 small text-muted">
                    {{ levelOneReply.name }} @ {{ levelOneReply.created_at }}
                  </p>

                  <reply-component :id="levelOneReply.id"></reply-component>

                  <section
                    v-for="(LevelTwoReply,
                    index) in levelOneReply.comment_replies"
                    v-bind:key="index"
                  >
                    <hr />
                    <b-media class="mt-3">
                      <template #aside>
                        <b-img
                          :src="
                            'https://picsum.photos/100?random=' +
                            LevelTwoReply.id
                          "
                          blank-color="#ccc"
                          width="64"
                          alt="placeholder"
                        ></b-img>
                      </template>

                      <h5 class="mt-0">{{ LevelTwoReply.comment }}</h5>
                      <p class="small text-muted">
                        {{ LevelTwoReply.name }} @
                        {{ LevelTwoReply.created_at }}
                      </p>
                      <reply-component :id="LevelTwoReply.id"></reply-component>

                      <section
                        v-for="(LevelThreeReply,
                        index) in LevelTwoReply.comment_replies"
                        v-bind:key="index"
                      >
                        <hr />
                        <b-media class="mt-3">
                          <template #aside>
                            <b-img
                              :src="
                                'https://picsum.photos/100?random=' +
                                LevelThreeReply.id
                              "
                              blank-color="#ccc"
                              width="64"
                              alt="placeholder"
                            ></b-img>
                          </template>

                          <h5 class="mt-0">{{ LevelThreeReply.comment }}</h5>
                          <p class="small text-muted">
                            {{ LevelThreeReply.name }} @
                            {{ LevelThreeReply.created_at }}
                          </p>
                        </b-media>
                      </section>
                    </b-media>
                  </section>
                </b-media>
              </section>
            </b-media>
          </b-card>
        </b-col>
      </b-row>
    </section>
  </section>
</template>
<script>
export default {
  data() {
    return {
      loading: false,
      comments: [],
    };
  },
  methods: {
    getComments() {
      this.loading = true;
      axios
        .get("/api/comments")
        .then((response) => {
          this.loading = false;
          this.comments = [];
          this.comments = response.data;
        })
        .catch((error) => {
          this.comments = [];
          this.loading = false;
          if (error.response.status === 422) {
          } else {
          }
        });
    },
  },
  created() {
    this.$eventHub.$on("comment-added", this.getComments);
  },
  beforeDestroy() {
    this.$eventHub.$off("comment-added");
  },
  mounted() {
    this.getComments();
  },
};
</script>