<template>
  <div v-cloak>
    <header class="text-gray-600 body-font">
      <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
          <img :src="$store.getters.USER.avatar_path" width="50px" class="rounded-full" alt="">
          <span class="ml-3 text-xl">{{ $store.getters.USER.name }}</span>
        </a>
        <nav
          class="md:mr-auto md:ml-4 md:py-1 md:pl-4 md:border-l md:border-gray-400	flex flex-wrap items-center text-base justify-center">
          <router-link :to="{name: 'user', params: {id: $store.getters.USER.id}}"
                       class="mr-5 hover:text-gray-900">
            Profile
          </router-link>
          <router-link :to="{name: 'usersList'}"
                       class="mr-5 hover:text-gray-900">
            Users List
          </router-link>
          <router-link :to="{name: 'friends'}" class="mr-5 hover:text-gray-900">Friends</router-link>
          <router-link :to="{name: 'forum'}" class="mr-5 hover:text-gray-900">Forum</router-link>
          <router-link :to="{name: 'chat'}" class="mr-5 hover:text-gray-900">Chat</router-link>
        </nav>
        <button
          v-show="isLoggedIn"
          @click="logout"
          class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
          Logout
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               class="w-4 h-4 ml-1" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
        </button>
      </div>
    </header>

    <router-view></router-view>
  </div>
</template>

<script>

import {mapActions, mapGetters} from "vuex"

export default {
  computed: {
    ...mapGetters(['isLoggedIn'])
  },
  methods: {
    ...mapActions(['USER']),
    logout: function () {
      return this.$store.dispatch('logout')
        .then(() => {
          this.$router.push('/')
        })
    },
  },
  mounted() {
    this.USER()
  }
}
</script>

<style>
[cloack] {
  display: none;
}

.router-link-active {
  text-decoration: underline;
  color: black;
}
</style>
