<template>
  <div class="py-12">
    <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="flex flex-row justify-around">
          <div class="flex flex-col text-center"><span class="text-2xl">My friends</span>
            <div v-if="haveFriends">
              <div v-for="friend in $store.state.friends.acceptedFriends">
                <router-link class="hover:underline hover:text-blue-700"
                             :to="{name: 'user', params:{id: friend.id, user: friend}}">
                  {{ friend.name }}
                </router-link>
                <button @click="removeFriend(friend.id)"
                        class="border bg-red-600 hover:bg-red-700 rounded-md py-1 px-3 outline-none">
                  Remove
                </button>
              </div>
            </div>
            <div v-else class="py-2">You haven't friends</div>
          </div>
          <div class="flex flex-col text-center"><span class="text-2xl">Requests</span>
            <div v-if="haveRequests">
              <div v-for="request in $store.state.friends.requests">
                <router-link class="hover:underline hover:text-blue-700"
                             :to="{name: 'user', params:{id: request.id, user: request}}">{{
                    request.name
                  }}
                </router-link>
                <button @click="acceptFriend(request.id)"
                        class="border bg-green-600 hover:bg-green-700 rounded-md py-1 px-3">
                  Accept
                </button>
              </div>
            </div>
            <div v-else class="py-2">You haven't requests</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import {mapActions} from "vuex";

export default {
  name: "FriendsListComponent",
  data() {
    return {}
  },
  methods: {
    ...mapActions(['FRIENDS_LIST']),
    acceptFriend(id) {
      this.$store.dispatch('FRIEND_ACCEPT', {id: id})
    },
    removeFriend(id) {
      this.$store.dispatch('FRIEND_REMOVE', {id: id})
    }
  },
  computed: {
    haveFriends() {
      return this.$store.state.friends.acceptedFriends.length > 0
    },
    haveRequests() {
      return this.$store.state.friends.requests.length > 0
    }
  }
  ,
  mounted() {
    this.FRIENDS_LIST();
  }
}
</script>

<style scoped>
</style>
