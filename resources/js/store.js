import Vuex from "vuex";
import Vue from "vue";

Vue.use(Vuex);

export let store = new Vuex.Store({
  state: {
    avatar: null,
    status: '',
    token: localStorage.getItem('token') || '',
    authUser: {},
    currentUserProfile: {},
    usersList: [],
    friends: {
      acceptedFriends: [],
      requests: []
    },

    categories: [],
    categoryTopics: [],
    currentTopic: {},
    topicComments: []
  },
  actions: {
    register({commit}, user) {
      return new Promise((resolve, reject) => {
        commit('AUTH_REQUEST')
        axios.post('/api/register', user)
          .then(resp => {
            commit('AUTH_SUCCESS', user)
            resolve(resp)
          })
          .catch(err => {
            commit('AUTH_ERROR', err)
            reject(err)
          })
      })
    },
    login({commit}, user) {
      return new Promise((resolve, reject) => {
        commit('AUTH_REQUEST')
        axios.post('/api/login', user)
          .then(resp => {
            const token = resp.data.access_token ? `${resp.data.token_type} ${resp.data.access_token}` : undefined
            const user = resp.data.user
            localStorage.setItem('token', token)
            axios.defaults.headers.common['Authorization'] = token
            commit('AUTH_SUCCESS', {token, user})
            resolve(resp)
          })
          .catch(err => {
            commit('AUTH_ERROR')
            localStorage.removeItem('token')
            reject(err)
          })
      })
    },
    logout({commit}) {
      return new Promise((resolve, reject) => {
        axios.post('/api/logout')
          .then(resp => {
            commit('LOGOUT')
            localStorage.removeItem('token')
            delete axios.defaults.headers.common['Authorization']
            resolve()
          })
          .catch(err => {
            reject(err)
          })

      })
    },

    USER({commit},) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/users`)
          .then(resp => {
            let user = resp.data
            commit('SET_AUTH_USER', user)
            resolve(resp)
          })
          .catch(err => {
            reject(err)
          })
      })
    },

    USER_BY_ID({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/users/${payload.id}`)
          .then(resp => {
            let user = resp.data
            commit('SET_CURRENT_USER_PROFILE', user)
            resolve(resp)
          })
          .catch(err => {
            reject(err)
          })
      })
    },

    USERS_LIST({commit}) {
      return new Promise((resolve, reject) => {
        axios.get('/api/usersList')
          .then(resp => {
            let users = resp.data.users
            commit('SET_USERS_LIST', users)
            resolve(resp)
          })
          .catch(err => {
            reject(err)
          })
      })
    },

    FRIENDS_LIST({commit}) {
      return new Promise((resolve, reject) => {
        axios.get('/api/friends')
          .then(resp => {
            let friends = resp.data.friends
            let requests = resp.data.requests
            commit('SET_FRIENDS_LIST', {friends, requests})
            resolve(resp)
          })
          .catch(err => {
            reject(err)
          })
      })
    },

    FRIEND_ACCEPT({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.patch(`/api/friends/add/${payload.id}`)
          .then(resp => {
            let friends = resp.data.friends
            let requests = resp.data.requests
            commit('SET_FRIENDS_LIST', {friends, requests})
            resolve(resp)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    FRIEND_REQUEST({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.post(`/api/friends/sendRequest/${payload.id}`)
          .then(resp => {
            let friends = resp.data.friends
            let requests = resp.data.requests
            commit('SET_FRIENDS_LIST', {friends, requests})
            resolve(resp)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    FRIEND_REMOVE({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.delete(`/api/friends/delete/${payload.id}`)
          .then(resp => {
            let friends = resp.data.friends
            let requests = resp.data.requests
            commit('SET_FRIENDS_LIST', {friends, requests})
            resolve(resp)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    UPLOAD_AVATAR({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.post('/api/avatar',
          payload.formData,
          {headers: {'Content-type': 'multipart/form-data'}})
          .then(resp => {
            commit('SET_AVATAR', resp.data.path)
            resolve(resp)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    GET_AVATAR({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/avatar/${payload.id}`)
          .then(resp => {
            commit('SET_AVATAR', resp.data.path)
          })
          .catch(err => {
            reject(err)
          })

      })
    },
    GET_FORUM_CATEGORIES({commit}) {
      return new Promise((resolve, reject) => {
        axios.get('/api/forum')
          .then(resp => {
            let categories = resp.data.categories
            commit('SET_FORUM_CATEGORIES', categories)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    GET_CATEGORY_TOPICS({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/forum/${payload.categoryId}`)
          .then(resp => {
            let topics = resp.data.topics
            commit('SET_CATEGORY_TOPICS', topics)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    GET_TOPIC_BY_ID({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/forum/${payload.categoryId}/topics/${payload.topicId}`)
          .then(resp => {
            let topic = resp.data.topic
            commit('SET_CURRENT_TOPIC', topic)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    LIKE_TOPIC({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.post(`/api/forum/${payload.categoryId}/topics/${payload.topicId}/likes`, {'action': 'like'})
          .then(resp => {
            let {likes, dislikes} = resp.data
            commit('SET_TOPIC_LIKES', {likes, dislikes})
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    DISLIKE_TOPIC({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.post(`/api/forum/${payload.categoryId}/topics/${payload.topicId}/likes`, {'action': 'dislike'})
          .then(resp => {
            let {likes, dislikes} = resp.data
            commit('SET_TOPIC_DISLIKES', {likes, dislikes})
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    GET_TOPIC_COMMENTS({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/forum/${payload.categoryId}/topics/${payload.topicId}/comments`)
          .then(resp => {
            let comments = resp.data.comments
            commit('SET_COMMENTS', comments)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    DELETE_TOPIC_COMMENT({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.delete(`/api/forum/${payload.categoryId}/topics/${payload.topicId}/comments/${payload.commentId}`)
          .then(resp => {
            let comments = resp.data.comments
            commit('SET_COMMENTS', comments)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    COMMENT_TOPIC({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.post(`/api/forum/${payload.categoryId}/topics/${payload.topicId}/comments`, {text: payload.text})
          .then(resp => {
            let comments = resp.data.comments
            commit('SET_COMMENTS', comments)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    DELETE_TOPIC({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.delete(`/api/forum/${payload.categoryId}/topics/${payload.topicId}`)
          .then(resp => {
            let topics = resp.data.topics
            commit('SET_CATEGORY_TOPICS', topics)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    CREATE_TOPIC({commit}, payload) {
      return new Promise((resolve, reject) => {
        axios.post(`/api/forum/${payload.categoryId}/topics`, {title: payload.title, text: payload.text})
          .then(resp => {
            let topics = resp.data.topics
            commit('SET_CATEGORY_TOPICS', topics)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
  },
  mutations: {
    AUTH_REQUEST(state) {
      state.status = 'loading'
    },
    AUTH_SUCCESS(state, data) {
      state.status = 'success'
      state.token = data.token
      state.user = data.user
    },
    AUTH_ERROR(state) {
      state.status = 'error'
    },
    LOGOUT(state) {
      state.status = ''
      state.token = ''
    },
    SET_AUTH_USER(state, user) {
      state.authUser = user
    },
    SET_CURRENT_USER_PROFILE(state, user) {
      state.currentUserProfile = user
    },
    SET_USERS_LIST(state, list) {
      state.usersList = list
    },
    SET_FRIENDS_LIST(state, list) {
      state.friends.acceptedFriends = list.friends
      state.friends.requests = list.requests
    },
    SET_AVATAR(state, avatar) {
      state.avatar = avatar
    },
    SET_FORUM_CATEGORIES(state, categories) {
      state.categories = categories
    },
    SET_CATEGORY_TOPICS(state, topics) {
      state.categoryTopics = topics
    },
    SET_CURRENT_TOPIC(state, topic) {
      state.currentTopic = topic
    },
    SET_TOPIC_LIKES(state, statusObject) {
      state.currentTopic.likes = statusObject.likes
      state.currentTopic.dislikes = statusObject.dislikes
      state.currentTopic.isLiked = true;
      state.currentTopic.isDisliked = false
    },
    SET_TOPIC_DISLIKES(state, statusObject) {
      state.currentTopic.likes = statusObject.likes
      state.currentTopic.dislikes = statusObject.dislikes
      state.currentTopic.isLiked = false
      state.currentTopic.isDisliked = true
    },
    SET_COMMENTS(state, comments) {
      state.topicComments = comments;
    }
  },
  getters: {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    USER: state => state.authUser,
    USERS_LIST: state => state.usersList,
    CURRENT_USER_PROFILE: state => state.currentUserProfile,
    FORUM_CATEGORIES: state => state.categories,
    CATEGORY_TOPICS: state => state.categoryTopics,
    CURRENT_TOPIC: state => state.currentTopic,
    TOPIC_COMMENTS: state => state.topicComments,
  }
})
