<template>
  <div class="">
    <square v-if="loading"></square>
    <div v-else class="">
      <div
        class="border-t border-gray-100 text-gray-600 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="w-full text-center mx-auto">
          <div class="flex justify-end">
            <div class="">
              <router-link
                :to="{name: 'createForumTopic'}"
                class="block no-underline border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline"
              >
                Create Post
              </router-link>
            </div>
          </div>
          <div
            v-if="CATEGORY_TOPICS.total > 0"
            class="container bg-white px-5 py-6 mx-auto">

            <div class="flex flex-row divide-y-2 divide-gray-100"
                 v-for="topic in CATEGORY_TOPICS.data">
              <router-link class="w-full"
                           :to="{name: 'forumTopic', params:{category: topic.category_id, topic: topic.id}}">
                <div class=" py-8 cursor-pointer flex flex-row md:flex-nowrap hover:bg-gray-100">
                  <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col ">
                    <span class="font-semibold title-font text-gray-700">{{ topic.user_name }}</span>
                    <span
                      class="mt-1 text-gray-500 text-sm">{{ topic.created_at }}</span>
                  </div>
                  <div class="md:flex-grow flex-col">
                    <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{ topic.title }}</h2>
                    <p class="leading-relaxed">{{ topic.text }}</p>
                    <span class="text-indigo-500 inline-flex items-center mt-4">
                  Learn More
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 12h14"></path>
                      <path d="M12 5l7 7-7 7"></path>
                    </svg>
                </span>
                  </div>
                </div>
              </router-link>
              <button v-if="USER.id == topic.user_id"
                      @click="DELETE_TOPIC({categoryId: topic.category_id, topicId: topic.id})"
                      class="outline-none font-bold px-2 bg-red-600 text-sm hover:bg-red-700 text-white shadow-md rounded-lg">
                Delete
              </button>
            </div>
            <tailable-pagination
              :data="CATEGORY_TOPICS"
              :show-numbers="true"
              :hide-when-empty="true"
              @page-changed="payload => GET_CATEGORY_TOPICS({categoryId, page: payload}) ">
            </tailable-pagination>
          </div>
          <div v-else
               class="mt-20 text-2xl container bg-white px-5 py-6 mx-auto flex justify-center align-middle">
            Oops... There are no topics yet :(
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "CategoryComponent",
  data() {
    return {
      categoryId: this.$route.params.category,
      loading: true
    }
  },
  methods: {
    ...mapActions(['GET_CATEGORY_TOPICS', 'DELETE_TOPIC']),
  },
  computed: {
    ...mapGetters(['CATEGORY_TOPICS', 'USER']),
  },
  mounted() {
    console.log(this.categoryId)
    this.GET_CATEGORY_TOPICS({categoryId: this.categoryId})
      .then(() => {
        this.loading = false
      })
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
