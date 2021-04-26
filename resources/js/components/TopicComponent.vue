<template>
  <div>
    <square v-if="loading"/>
    <div v-else>
      <div class="p-8 dark:bg-gray-900 flex items-center ">
        <div class="px-5 py-4 bg-white dark:bg-gray-800 shadow rounded-lg w-full">
          <div class="flex mb-4">
            <router-link :to="{name: 'user', params:{id: CURRENT_TOPIC.user.id}}">
              <img width="200px" class="w-12 h-12 rounded-full"
                   :src="CURRENT_TOPIC.user.avatar_path"
                   alt="">
            </router-link>
            <div class="ml-2 mt-0.5">
                    <span
                      class="block font-medium text-base leading-snug text-black dark:text-gray-100">{{
                        CURRENT_TOPIC.user.name
                      }}</span>
              <span
                class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">{{
                  CURRENT_TOPIC.created_at
                }}</span>
            </div>
          </div>
          <h2 class="font-bold text-lg h-2 mb-8">{{ CURRENT_TOPIC.title }}</h2>
          <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">{{ CURRENT_TOPIC.text }}</p>
          <div class="flex justify-between items-center mt-5">
            <div class="flex ">
              <button @click="LIKE_TOPIC({categoryId, topicId})">
                <svg viewBox="0 0 20 20"
                     :class="['hover:text-green-600', 'mr-1', 'w-5', {'text-green-600': CURRENT_TOPIC.isLiked }, 'text-gray-500']">
                  <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                  >
                    <g class="fill-current">
                      <path
                        d="M11.0010436,0 C9.89589787,0 9.00000024,0.886706352 9.0000002,1.99810135 L9,8 L1.9973917,8 C0.894262725,8 0,8.88772964 0,10 L0,12 L2.29663334,18.1243554 C2.68509206,19.1602453 3.90195042,20 5.00853025,20 L12.9914698,20 C14.1007504,20 15,19.1125667 15,18.000385 L15,10 L12,3 L12,0 L11.0010436,0 L11.0010436,0 Z M17,10 L20,10 L20,20 L17,20 L17,10 L17,10 Z"
                        id="Fill-97"></path>
                    </g>
                  </g>
                </svg>
              </button>
              <span class=" ml-1 text-gray-500 dark:text-gray-400 font-light">{{ CURRENT_TOPIC.likes }}</span>
              <button
                @click="DISLIKE_TOPIC({categoryId, topicId})"
                class="ml-5">
                <svg viewBox="0 0 20 20"
                     :class="['hover:text-red-600', 'mr-1', 'w-5', {'text-red-600': CURRENT_TOPIC.isDisliked}, 'text-gray-500']">
                  <g id="Page-1" stroke="none" stroke-width="1" fill="none">
                    <g class="fill-current">
                      <path
                        d="M11.0010436,20 C9.89589787,20 9.00000024,19.1132936 9.0000002,18.0018986 L9,12 L1.9973917,12 C0.894262725,12 0,11.1122704 0,10 L0,8 L2.29663334,1.87564456 C2.68509206,0.839754676 3.90195042,8.52651283e-14 5.00853025,8.52651283e-14 L12.9914698,8.52651283e-14 C14.1007504,8.52651283e-14 15,0.88743329 15,1.99961498 L15,10 L12,17 L12,20 L11.0010436,20 L11.0010436,20 Z M17,10 L20,10 L20,0 L17,0 L17,10 L17,10 Z"
                        id="Fill-97"></path>
                    </g>
                  </g>
                </svg>
              </button>
              <span
                class="ml-1 text-gray-500 dark:text-gray-400  font-light"><span
                class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{ CURRENT_TOPIC.dislikes }}</span></span>
            </div>
            <div class="flex flex-row ml-1 text-gray-500 dark:text-gray-400 font-light">
              <div>{{ TOPIC_COMMENTS.length }} comments</div>
            </div>
          </div>
        </div>
      </div>

      <div class="px-8 pb-8 dark:bg-gray-900 flex items-center ">

        <section class="rounded-b-lg w-full  mt-4 ">

          <div v-if="Object.keys(ERRORS).length > 0"
               class="bg-red-50 border-l-8 border-red-900 mb-2">
            <div class="flex items-center">
              <div class="p-2">
                <div class="flex items-center">
                  <div class="ml-2">
                  </div>
                  <p class="px-6 py-4 text-red-900 font-semibold text-lg">Please fix the
                    following
                    errors.</p>
                </div>
                <div class="px-16 mb-4">
                  <li v-for="error in ERRORS" class="text-md font-bold text-red-500 text-sm">
                    {{ error[0] }}
                  </li>
                </div>
              </div>
            </div>
          </div>

          <div id="task-comments" class="pt-4">
            <div
              class="bg-white rounded-lg p-3  flex flex-col justify-center items-center md:items-start shadow-lg mb-4"
              v-for="comment in TOPIC_COMMENTS">
              <div class="flex flex-row justify-center mr-2 w-full">
                <img width="48" height="48"
                     class="rounded-full w-10 h-10 mr-4 shadow-lg mb-4"
                     :src="comment.user.avatar_path">
                <div class="flex flex-row justify-between w-full">
                  <h3 class="text-purple-600 font-semibold text-lg text-center md:text-left ">
                    {{ comment.user.name }}</h3>
                  <span
                    class="text-gray-500">{{ comment.created_at }}</span>
                </div>
              </div>


              <p style="width: 90%"
                 class="text-gray-600 text-lg text-center md:text-left ">{{ comment.text }}</p>

              <div v-show="USER.id === comment.user_id" class="w-full flex flex-row justify-end">
                <button @click="DELETE_TOPIC_COMMENT({categoryId, topicId, commentId: comment.id })"
                        class="outline-none font-bold px-2 bg-red-600 text-sm hover:bg-red-700 text-white shadow-md rounded-lg ">
                  Delete
                </button>
              </div>
            </div>

            <textarea
              @keypress.enter="sendComment"
              class="resize-none w-full shadow-inner p-4 border-0 mb-4 rounded-lg focus:shadow-outline text-2xl"
              placeholder="Ask questions here." cols="5" rows="4" id="comment_content"
              ref="commentInput"
              name="text"
              v-model="commentText"/>
            <button @click="sendComment"
                    class="font-bold py-2 px-4 w-full bg-indigo-600 text-lg hover:bg-indigo-700 text-white shadow-md rounded-lg ">
              Comment
            </button>
          </div>
        </section>

      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from "vuex";

export default {
  name: "TopicComponent",
  data() {
    return {
      categoryId: this.$route.params.category,
      topicId: this.$route.params.topic,
      commentText: '',
      loading: true
    }
  },
  methods: {
    ...mapActions([
      'GET_TOPIC_BY_ID',
      'LIKE_TOPIC',
      'DISLIKE_TOPIC',
      'GET_TOPIC_COMMENTS',
      'DELETE_TOPIC_COMMENT',
      'COMMENT_TOPIC']),
    ...mapMutations(['DELETE_ERRORS']),
    sendComment() {
      this.COMMENT_TOPIC({categoryId: this.categoryId, topicId: this.topicId, text: this.commentText})
      this.commentText = ''
    }
  },
  computed: {
    ...mapGetters([
      'CURRENT_TOPIC',
      'TOPIC_COMMENTS',
      'USER',
      'ERRORS']),
  },
  mounted() {
    this.GET_TOPIC_BY_ID({categoryId: this.categoryId, topicId: this.topicId})
      .then(() => {
        this.GET_TOPIC_COMMENTS({categoryId: this.categoryId, topicId: this.topicId})
          .then(() => {
            this.loading = false
          })
      })
  },
  destroyed() {
    this.DELETE_ERRORS()
  }
}
</script>

<style scoped>
button,
button:focus,
button:active {
  outline: none;
}
</style>
