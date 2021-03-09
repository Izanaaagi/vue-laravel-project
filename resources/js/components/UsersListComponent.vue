<template>
  <div class="py-12">
    <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

        <!--        @foreach($users as $user)-->
        <!--        <div class="m-3.5 flex mb-2.5 flex-row">-->
        <!--          <div>-->
        <!--            @if($user->isProfilePhoto())-->
        <!--            <a href="{{(route('getUser', ['id' => $user['id']]))}}">-->
        <!--              <img width="200px" class="rounded-full"-->
        <!--                   src="{{$user->getProfilePhotoUrlAttribute()}}"-->
        <!--                   alt="">-->
        <!--            </a>-->
        <!--            @else-->
        <!--            <a href="{{(route('getUser', ['id' => $user['id']]))}}">-->
        <!--              <img-->
        <!--                width="200px" class="rounded-full"-->
        <!--                src="/storage/profile-photos/default-avatar.jpg"-->
        <!--                alt="">-->
        <!--            </a>-->
        <!--            @endif-->
        <!--          </div>-->
        <!--          <div class="ml-5 flex flex-col">-->
        <div
          v-for="user in $store.getters.USERS_LIST"
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
      </div>
    </div>
    <!--        @endforeach-->
    <!--      </div>-->
    <!--    </div>-->
  </div>
</template>

<script>


import {mapActions} from "vuex";

export default {
  name: "UsersListComponent",
  methods: {
    ...mapActions(['USERS_LIST'])
  },
  mounted() {
    this.USERS_LIST()
  }
}
</script>

<style scoped>

</style>
