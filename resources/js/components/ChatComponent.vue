<template>
  <div class="pb-10 px-20">
    <square v-if="loading"></square>
    <div v-else class="flex-1 p:2 sm:p-6 justify-between flex flex-col">
      <div class="flex sm:items-center justify-between py-3 border-b-2 border-gray-200">
        <div class="flex items-center space-x-4">
          <router-link :to="{name: 'user', params: {id: CURRENT_USER_PROFILE.id} }">
            <img
              :src="CURRENT_USER_PROFILE.avatar_path"
              alt="" class="w-10 sm:w-16 h-10 sm:h-16 rounded-full">
          </router-link>
          <div class="flex flex-col leading-tight">
            <div class="text-2xl mt-1 flex items-center">
              <span class="text-gray-700 mr-3">{{ CURRENT_USER_PROFILE.name }}</span>
            </div>
            <span class="text-lg text-gray-600">{{ CURRENT_USER_PROFILE.email }}</span>
          </div>
        </div>
      </div>
      <div
        id="messages"
        class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
        <div v-if="CHAT_ROOM" class="chat-message overflow-y-auto " style="height: 350px">
          <div v-for="message in CHAT_MESSAGES"
               :class="['flex',  {'justify-end' : USER.id == message.from.id }]">
            <div class="flex flex-col space-y-2 item text-xs max-w-xs mx-2 order-2 items-end">
              <div><span
                class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">
                {{ message.message }}</span>
              </div>
            </div>
            <img
              v-if="USER.id !== message.from.id"
              :src="CURRENT_USER_PROFILE.avatar_path"
              alt="My profile" class="w-8 h-8 rounded-full order-1">
          </div>
        </div>
        <div v-else
             class="chat-message flex justify-center overflow-y-auto" style="height: 350px">
          No messages Yet
        </div>
      </div>
      <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
        <div class="relative flex">
          <input type="text"
                 v-model="inputMessage"
                 placeholder="Write Something"
                 @keyup.enter="sendMessage(inputMessage)"
                 class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-4 bg-gray-200 rounded-full py-3">
          <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
            <button type="button"
                    @click="sendMessage(inputMessage)"
                    class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                   class="h-6 w-6 transform rotate-90">
                <path
                  d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  data() {
    return {
      userId: this.$route.params.userId,
      inputMessage: '',
      loading: true,
    }
  },
  name: "ChatComponent",

  created() {
    this.USER_BY_ID({id: this.userId})
    this.GET_CHAT_MESSAGES({id: this.userId})
      .then(() => {
        if (this.CHAT_ROOM) {
          Echo.join(`chat.${this.CHAT_ROOM}`)
            .here(users => {
            })
            .joining(user => {
            })
            .leaving(user => {
            })
            .listen('MessageEvent', resp => {
                this.$store.commit('SEND_CHAT_MESSAGE', resp.message)
              }
            )
          this.scrollToBottom()
        }
        this.loading = false
      })
  },

  updated() {
    this.scrollToBottom()
  },

  destroyed() {
    Echo.leave(`chat.${this.CHAT_ROOM}`)
  },

  methods: {
    ...mapActions(['USER_BY_ID', 'SEND_CHAT_MESSAGE', 'GET_CHAT_MESSAGES']),
    sendMessage(message) {
      if (message !== '') {
        this.SEND_CHAT_MESSAGE({message, to: this.CURRENT_USER_PROFILE.id})
        this.inputMessage = '';
      }
    },
    scrollToBottom() {
      if (this.$el.querySelector('.chat-message')) {
        let messagesContainer = this.$el.querySelector('.chat-message')
        messagesContainer.scrollTop = messagesContainer.scrollHeight
      }
    }
  },

  computed: {
    ...mapGetters(['USER', 'CURRENT_USER_PROFILE', 'CHAT_MESSAGES', 'CHAT_ROOM'])
  },

  watch: {
    CHAT_ROOM(newValue, oldValue) {
      if (newValue !== oldValue && oldValue == null) {
        Echo.join(`chat.${this.CHAT_ROOM}`)
          .here(users => {
          })
          .joining(user => {
          })
          .leaving(user => {
          })
          .listen('MessageEvent', resp => {
              this.$store.commit('SEND_CHAT_MESSAGE', resp.message)
            }
          )
        this.scrollToBottom()
      }
    }
  }
}
</script>

<style scoped>
</style>
