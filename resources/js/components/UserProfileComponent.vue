<template>
  <div class="py-12">
    <square v-if="loading"></square>
    <div v-else class="max-w-10xl mx-auto sm:px-6 lg:px-8">
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
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex flex-row">

        <div>
          <img :src="$store.state.avatar"
               width="150px"
               alt=""
               class="rounded-full">
        </div>
        <div class="flex flex-col ml-5">
          <div class="flex flex-col">
            <b>Name:</b>
            <input
              :class="[
               'border',
               'border-gray-400',
               'outline-none',
               {'border-red-600': Object.keys(this.ERRORS).length !== 0}]"
              v-if="adminMode"
              v-model="CURRENT_USER_PROFILE.name"
              @keypress.enter="editName"
              ref="name"
              type="text">
            <span v-else>{{ CURRENT_USER_PROFILE.name }}</span>
          </div>
          <b>Email:</b> {{ CURRENT_USER_PROFILE.email }}
          <b>Role:</b>
          <span v-for="role in CURRENT_USER_PROFILE.roles"> {{ role }}</span>
          <b>Date of Registration: </b> {{ CURRENT_USER_PROFILE.created_at }}
          <div v-show="!isAuthUser"
               class="flex flex-row">
            <div v-if="isFriend">
              <button @click="FRIEND_REMOVE({id: CURRENT_USER_PROFILE.id})"
                      class="border bg-red-600 hover:bg-red-700 rounded-md py-2 px-3">
                Remove from Friends
              </button>

            </div>
            <div v-else>
              <button @click="FRIEND_REQUEST({id: CURRENT_USER_PROFILE.id})"
                      class="border bg-green-600 hover:bg-green-700 rounded-md py-2 px-3">
                Add to Friends
              </button>
            </div>
            <router-link
              :to="{name: 'chatRoom', params:{userId: this.$route.params.id}}"
              class="border bg-blue-600 hover:bg-blue-700 rounded-md py-2 px-3">
              Chat
            </router-link>

          </div>
          <div
            v-show="isAuthUser"
            class="flex flex-col mt-8"
          >
            <input
              type="file"
              id="file"
              ref="file"
              v-on:change="handleFileUpload()"/>
            <button
              class="border bg-green-600 hover:bg-green-700 rounded-md py-2 px-3"
              v-on:click="submitAvatar">
              Save new avatar
            </button>
          </div>
          <div v-if="USER.roles == 'admin'" class="mt-10">
            <h1 class="text-red-700 text-2xl">ADMIN PANEL</h1>
            <button
              @click="showNameInput"
              class="border bg-yellow-200 hover:bg-yellow-400 rounded-md md:py-1 md:text-lg md:px-5">
              Edit Name
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import {mapActions, mapGetters, mapMutations} from "vuex";

export default {
  name: "UserProfileComponent",
  data() {
    return {
      file: '',
      loading: true,
      adminMode: false,
    }
  },
  methods: {
    ...mapActions([
      'USER_BY_ID',
      'FRIEND_REQUEST',
      'FRIEND_REMOVE',
      'FRIENDS_LIST',
      'GET_AVATAR',
      'UPLOAD_AVATAR',
      'CHANGE_USERNAME',
    ]),
    ...mapMutations(['DELETE_ERRORS',]),
    handleFileUpload() {
      this.file = this.$refs.file.files[0]
    },
    submitAvatar() {
      let formData = new FormData()
      formData.append('image', this.file)
      this.UPLOAD_AVATAR({formData}).then(() => {
        if (this.CURRENT_USER_PROFILE.id === this.USER.id) {
          this.USER.avatar_path = this.$store.state.avatar
        }
      })
    },
    showNameInput() {
      this.adminMode = true
      Vue.nextTick(() => {
        this.$refs.name.focus()
      })
    },
    editName() {
      this.CHANGE_USERNAME({user: this.CURRENT_USER_PROFILE})
        .then(() => {
          if (Object.keys(this.ERRORS).length === 0)
            if (this.CURRENT_USER_PROFILE.id === this.USER.id) {
              let USER = this.USER;
              this.USER.name = this.CURRENT_USER_PROFILE.name
            }
          this.adminMode = false
        })
      if (this.adminMode) {
        this.$refs.name.focus()
      }
    }
  },
  computed: {
    ...mapGetters(['CURRENT_USER_PROFILE', 'ERRORS', 'USER']),
    isFriend() {
      return !!this.$store.state.friends.acceptedFriends.find(friend => friend.id === this.CURRENT_USER_PROFILE.id)
    },
    isAuthUser() {
      return this.CURRENT_USER_PROFILE.id === this.$store.getters.USER.id
    }
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler() {
        this.DELETE_ERRORS()
        this.adminMode = false

        this.USER_BY_ID({id: this.$route.params.id})
        this.FRIENDS_LIST()
        this.GET_AVATAR({id: this.$route.params.id})
          .then(() => {
            this.loading = false
          })
      },
    },
  },
  destroyed() {
    this.DELETE_ERRORS()
  },
}
</script>

<style scoped>

</style>
