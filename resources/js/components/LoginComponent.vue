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
            Login
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

          <div class="mt-10"
               @keypress.enter="login">
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

            <!-- Auth Buttton -->
            <button
              @click="login()"
              class="w-full py-3 mt-10 bg-gray-800 rounded-sm
                    font-medium text-white uppercase
                    focus:outline-none hover:bg-gray-700 hover:shadow-none">
              Login
            </button>

            <!-- Another Auth Routes -->
            <div
              class="flex justify-around items-center flex-row sm:flex sm:flex-wrap mt-8 sm:mb-4 text-sm text-center">
              <router-link :to="{name: 'register'}" class="flex-2 underline">
                Create an Account
              </router-link>
              <button
                @click="oAuthLogin('google')"
                class="focus:outline-none flex items-center justify-center text-white rounded-lg shadow-md hover:bg-gray-100">
                <div class="px-4 py-3">
                  <svg class="h-6 w-6" viewBox="0 0 40 40">
                    <path
                      d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.045 27.2142 24.3525 30 20 30C14.4775 30 10 25.5225 10 20C10 14.4775 14.4775 9.99999 20 9.99999C22.5492 9.99999 24.8683 10.9617 26.6342 12.5325L31.3483 7.81833C28.3717 5.04416 24.39 3.33333 20 3.33333C10.7958 3.33333 3.33335 10.7958 3.33335 20C3.33335 29.2042 10.7958 36.6667 20 36.6667C29.2042 36.6667 36.6667 29.2042 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z"
                      fill="#FFC107"/>
                    <path
                      d="M5.25497 12.2425L10.7308 16.2583C12.2125 12.59 15.8008 9.99999 20 9.99999C22.5491 9.99999 24.8683 10.9617 26.6341 12.5325L31.3483 7.81833C28.3716 5.04416 24.39 3.33333 20 3.33333C13.5983 3.33333 8.04663 6.94749 5.25497 12.2425Z"
                      fill="#FF3D00"/>
                    <path
                      d="M20 36.6667C24.305 36.6667 28.2167 35.0192 31.1742 32.34L26.0159 27.975C24.3425 29.2425 22.2625 30 20 30C15.665 30 11.9842 27.2359 10.5975 23.3784L5.16254 27.5659C7.92087 32.9634 13.5225 36.6667 20 36.6667Z"
                      fill="#4CAF50"/>
                    <path
                      d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.7592 25.1975 27.56 26.805 26.0133 27.9758C26.0142 27.975 26.015 27.975 26.0158 27.9742L31.1742 32.3392C30.8092 32.6708 36.6667 28.3333 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z"
                      fill="#1976D2"/>
                  </svg>
                </div>
                <span class="px-4 py-3 w-5/6 text-center text-gray-600 font-bold">Sign in with Google</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from "vuex";

export default {
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    ...mapMutations(['DELETE_ERRORS', 'SET_ERRORS', 'DELETE_ERRORS']),
    login() {
      let email = this.email
      let password = this.password
      this.$store.dispatch('login', {email, password})
        .then(() => {
            if (Object.keys(this.ERRORS).length === 0) {
              this.$router.push({name: 'forum'})
            }
          }
        )
        .catch(err => console.log(err))
    },
    oAuthLogin(provider) {
      const newWindow = openWindow('', 'message')
      axios.get(`api/login/${provider}`)
        .then(response => {
          newWindow.location.href = response.data.url;
          this.DELETE_ERRORS();
        })
        .catch(error => {
          this.SET_ERRORS(error.response.errors)
        });
    },
    onMessage(e) {
      if (e.origin !== window.origin || !e.data.access_token) {
        return
      }
      let token = `${e.data.token_type} ${e.data.access_token}`
      localStorage.setItem('token', token)
      axios.defaults.headers.common['Authorization'] = token

      this.$store.commit('AUTH_SUCCESS', {token})

      this.$router.replace({name: 'forum'})
    }
  },
  computed: {
    ...mapGetters(['ERRORS'])
  },
  mounted() {
    window.addEventListener('message', this.onMessage, false)
  },
  destroyed() {
    window.removeEventListener('message', this.onMessage)
    this.DELETE_ERRORS()
  },
};

function openWindow(url, title, options = {}) {
  if (typeof url === 'object') {
    options = url
    url = ''
  }

  options = {url, title, width: 600, height: 720, ...options}

  const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
  const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
  const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
  const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height

  options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
  options.top = ((height / 2) - (options.height / 2)) + dualScreenTop

  const optionsStr = Object.keys(options).reduce((acc, key) => {
    acc.push(`${key} =${options[key]}`)
    return acc
  }, []).join(',')

  const newWindow = window.open(url, title, optionsStr)

  if (window.focus) {
    newWindow.focus()
  }

  return newWindow
}
</script>
