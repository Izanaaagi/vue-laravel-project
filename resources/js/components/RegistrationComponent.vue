<template>
  <div>
    <!-- Root element for center items -->
    <div class="flex flex-col h-screen bg-gray-100">
      <!-- Auth Card Container -->
      <div class="grid place-items-center mx-2 my-20 sm:my-auto">
        <!-- Auth Card -->
        <div class="w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12
            px-6 py-10 sm:px-10 sm:py-6
            bg-white rounded-lg shadow-md lg:shadow-lg">

          <!-- Card Title -->
          <h2 class="text-center font-semibold text-3xl lg:text-4xl text-gray-800">
            Registration
          </h2>

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

          <div
            @keydown.enter="register"
            class="mt-10">
            <!-- Name Input -->
            <label for="name" class="block text-xs font-semibold text-gray-600 uppercase">Name</label>
            <input id="name" type="text" v-model='name' name="name" placeholder="Name"
                   autocomplete="email"
                   class="block w-full py-3 px-1 mt-2 mb-4
                    text-gray-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200"
            />

            <!-- Email Input -->
            <label for="email" class="block text-xs font-semibold text-gray-600 uppercase">E-mail</label>
            <input id="email" type="email" v-model='email' name="email" placeholder="E-mail address"
                   autocomplete="email"
                   class="block w-full py-3 px-1 mt-2
                    text-gray-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200"
            />

            <!-- Password Input -->
            <label for="password" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Password</label>
            <input id="password" type="password" v-model="password" name="password" placeholder="Password"
                   autocomplete="current-password"
                   class="block w-full py-3 px-1 mt-2 mb-4
                    text-gray-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200"
            />
            <!-- Password Input -->
            <label for="password_confirmation"
                   class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Password confirmation</label>
            <input id="password_confirmation" type="password" v-model="password_confirmation"
                   name="password_confirmation"
                   placeholder="Password"
                   autocomplete="current-password"
                   class="block w-full py-3 px-1 mt-2 mb-4
                    text-gray-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200"
            />

            <!-- Auth Buttton -->
            <button
              @click="register"
              class="w-full py-3 mt-10 bg-gray-800 rounded-sm
                    font-medium text-white uppercase
                    focus:outline-none hover:bg-gray-700 hover:shadow-none">
              Register
            </button>

            <!-- Another Auth Routes -->
            <div class="sm:flex sm:flex-wrap mt-8 sm:mb-4 text-sm text-center">
              <router-link :to="{name: 'login'}" class="flex-2 underline">
                Have an Account?
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapMutations} from "vuex";

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    }
  },
  methods: {
    ...mapMutations(['DELETE_ERRORS']),
    register: function () {
      let name = this.name;
      let email = this.email;
      let password = this.password;
      let password_confirmation = this.password_confirmation;
      this.$store.dispatch('register', {name, email, password, password_confirmation})
        .then(() => {
          if (Object.keys(this.ERRORS).length === 0)
            this.$router.push({name: 'login'})
        })
        .catch(err => console.log(err));
    }
  },
  computed: {
    ...mapGetters(['ERRORS']),
  },
  destroyed() {
    this.DELETE_ERRORS()
  }
};
</script>

<style scoped>

</style>
