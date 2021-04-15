<template>
  <div class="py-12">
    <square v-if="loading"></square>
    <div v-else class="max-w-10xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div
          v-for="user in USERS_LIST.data"
          class="m-3.5 flex mb-3 flex-row">
          <div>
            <router-link
              :to="{name: 'user', params: {id: user.id}}">
              <img
                :src="user.avatar_path"
                alt=""
                width="150px"
                class="rounded-full">
            </router-link>
          </div>
          <div class="flex flex-col justify-center ml-5">
            <b>Name:</b>
            <router-link
              :to="{name: 'user', params: {id: user.id}}"
              class="hover:underline hover:text-blue-700"> {{
                user.name
              }}
            </router-link>
            <b>Email:</b> {{ user.email }}
          </div>
        </div>
        <tailable-pagination
          :data="USERS_LIST"
          :show-numbers="true"
          :hide-when-empty="true"
          @page-changed="payload => GET_USERS_LIST({page: payload}) ">
        </tailable-pagination>
      </div>
    </div>
  </div>
</template>

<script>


import {mapActions, mapGetters} from "vuex";

export default {
  name: "UsersListComponent",
  data() {
    return {
      loading: true
    }
  },
  methods: {
    ...mapActions(['GET_USERS_LIST']),
  },
  mounted() {
    this.GET_USERS_LIST({page: 1}).then(() => {
      this.loading = false
    })
  },
  computed: {
    ...mapGetters(['USERS_LIST'])
  }
}
</script>

<style scoped>

</style>
