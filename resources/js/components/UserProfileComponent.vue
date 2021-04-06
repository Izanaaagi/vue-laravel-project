<template>
  <div class="py-12">
    <square v-if="loading"></square>
    <div v-else class="max-w-10xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex flex-row">
        <div>
          <img :src="$store.state.avatar"
               width="150px"
               alt=""
               class="rounded-full">
        </div>
        <div class="flex flex-col ml-5">
          <b>Name:</b> {{ CURRENT_USER_PROFILE.name }}
          <b>Email:</b> {{ CURRENT_USER_PROFILE.email }}
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
              :to="{name: 'chat', params:{userId: this.$route.params.id}}"
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
          <!--    @if(auth()->user()->id != $user->id)-->

          <!--    @if(auth()->user()->haveFriendOrRequest($user->id))-->
          <!--    <form action="{{route('deleteFriend', ['id' => $user->id])}}" method="POST">-->
          <!--      @csrf-->
          <!--      @method('DELETE')-->
          <!--      <button type="submit"-->
          <!--              class="border bg-red-500 hover:bg-red-700 rounded-md md:py-1 md:text-lg md:px-5">-->
          <!--        Delete Friend-->
          <!--      </button>-->
          <!--    </form>-->
          <!--    @else-->
          <!--    <form action="{{route('sendRequest', ['id' => $user->id])}}" method="POST">-->
          <!--      @csrf-->
          <!--      @method("POST")-->
          <!--      <button type="submit"-->
          <!--              class="border bg-green-600 hover:bg-green-700 rounded-md md:py-1 md:text-lg md:px-5">-->
          <!--        Add to friends-->
          <!--      </button>-->
          <!--      @endif-->
          <!--    </form>-->
          <!--    @endif-->

          <!--    @if(auth()->user()->getRoleNames()[0] == 'admin')-->
          <!--    <div class="mt-10">-->
          <!--      <h1 class="text-red-700 text-2xl">ADMIN PANEL</h1>-->
          <!--      <form action="{{route('editUserName', ['user' => $user])}}" method="POST">-->
          <!--        @csrf-->
          <!--        @method("PATCH")-->
          <!--        <input type="text" name="name" value="{{$user->name}}">-->
          <!--        <button type="submit"-->
          <!--                class="border bg-yellow-200 hover:bg-yellow-400 rounded-md md:py-1 md:text-lg md:px-5">-->
          <!--          Edit Name-->
          <!--        </button>-->
          <!--      </form>-->
          <!--    </div>-->
          <!--    @endif-->
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "UserProfileComponent",
  data() {
    return {
      file: '',
      loading: true
    }
  },
  methods: {
    ...mapActions([
      'USER_BY_ID',
      'FRIEND_REQUEST',
      'FRIEND_REMOVE',
      'FRIENDS_LIST',
      'GET_AVATAR',
      'UPLOAD_AVATAR']),
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    submitAvatar() {
      let formData = new FormData();
      formData.append('image', this.file)
      this.UPLOAD_AVATAR({formData})
    }
  },
  computed: {
    ...mapGetters(['CURRENT_USER_PROFILE']),
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
        this.USER_BY_ID({id: this.$route.params.id})
        this.FRIENDS_LIST()
        this.GET_AVATAR({id: this.$route.params.id})
          .then(() => {
            this.loading = false
          })
      },
    },
  },
}
</script>

<style scoped>

</style>
