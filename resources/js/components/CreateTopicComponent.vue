<template>
  <section class="text-gray-600 body-font relative">
    <div class="container px-5 py-24 mx-auto">
      <div class="flex flex-col text-center w-full mb-12">
        <div v-if="Object.keys(ERRORS).length > 0" class="bg-red-50 border-l-8 border-red-900 mb-2">
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
        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Create Topic</h1>
      </div>
      <div class="lg:w-1/2 md:w-2/3 mx-auto">
        <div class="flex flex-wrap -m-2">
          <div class="p-4 w-full">
            <div class="relative">
              <label for="title" class="leading-7 text-sm text-gray-600">Title</label>
              <input type="text"
                     id="title"
                     name="title"
                     v-model="title"
                     @keydown.enter="createTopic"
                     class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
          </div>

        </div>
        <div class="p-2 w-full">
          <div class="relative">
            <label for="text" class="leading-7 text-sm text-gray-600">Text</label>
            <textarea
              id="text"
              name="text"
              v-model="text"
              @keydown.enter="createTopic"
              class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
          </div>
        </div>
        <div class="p-2 w-full">
          <button
            @click="createTopic"
            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
            Create
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from "vuex";
import {router} from "../router";

export default {
  name: "CreateTopicComponent",
  data() {
    return {
      categoryId: this.$route.params.category,
      title: '',
      text: '',
    }
  },
  methods: {
    ...mapActions(['CREATE_TOPIC']),
    ...mapMutations(['DELETE_ERRORS']),
    createTopic() {
      this.CREATE_TOPIC({categoryId: this.categoryId, title: this.title, text: this.text})
        .then(() => {
          if (this.ERRORS.length === 0) {
            router.push({name: 'forumCategory', props: {category: this.categoryId}})
          }
        })
    }
  },
  computed: {
    ...mapGetters(['ERRORS'])
  },
  destroyed() {
    this.DELETE_ERRORS()
  }
}
</script>

<style scoped>

</style>
