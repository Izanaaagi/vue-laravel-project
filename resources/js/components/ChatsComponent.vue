<template>
  <div class="py-12">
    <square v-if="loading"></square>
    <div v-else class="max-w-10xl mx-auto sm:px-6 lg:px-8">
      <div v-if="CHATS_LIST.length > 0" class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex flex-col p-5">
        <router-link
          class="flex items-start px-4 py-6 hover:bg-gray-100"
          :to="{name: 'chatRoom', params:{userId: chat.user.id}}"
          v-for="chat in CHATS_LIST"
          :key="chat.chatRoom">
          <img class="w-12 h-12 rounded-full object-cover mr-4 shadow"
               :src="chat.user.avatar_path"
               alt="avatar">
          <div class="w-full">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-semibold text-gray-900 -mt-1">{{ chat.user.name }}</h2>
              <small class="text-sm text-gray-700">{{ chat.created_at }}</small>
            </div>
            <p class="mt-3 text-gray-700 text-sm">
              {{ chat.last_message }}
            </p>
          </div>
        </router-link>
      </div>
      <div v-else
           class="mt-20 text-2xl container bg-white px-5 py-6 mx-auto flex justify-center align-middle">
        Oops... You haven't сhats yet :(
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "ChatsComponent.vue",
  data() {
    return {
      loading: true
    }
  },
  mounted() {
    this.GET_CHATS()
      .then(() => {
        this.loading = false
      });
  },
  methods: {
    ...mapActions(['GET_CHATS']),
  },
  computed: {
    ...mapGetters(['CHATS_LIST']),
  }
}
</script>

<style scoped>

</style>
