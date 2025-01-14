import VueRouter from "vue-router";
import Login from "./components/LoginComponent";
import RegistrationComponent from "./components/RegistrationComponent";
import MainLayout from "./layouts/MainLayout";
import ForumComponent from "./components/ForumComponent";
import UserProfileComponent from "./components/UserProfileComponent";
import FriendsListComponent from "./components/FriendsListComponent";
import UsersListComponent from "./components/UsersListComponent";
import Vue from "vue";
import {store} from "./store";
import CategoryComponent from "./components/CategoryComponent";
import TopicComponent from "./components/TopicComponent";
import CreateTopicComponent from "./components/CreateTopicComponent";
import ChatComponent from "./components/ChatComponent";
import ChatsComponent from "./components/ChatsComponent";
import PageNotFound from "./components/PageNotFound";

Vue.use(VueRouter);

export let router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/auth/:provide/callback',
      component: {
        template: '<div class="auth-component"></div>'
      }
    },
    {
      path: '/',
      name: 'login',
      component: Login,
      meta: {
        isAuthorized: true
      }
    },
    {
      path: '/register',
      name: 'register',
      component: RegistrationComponent,
      meta: {
        isAuthorized: true
      }
    },
    {
      path: '/',
      name: 'mainLayout',
      component: MainLayout,
      meta: {
        requiresAuth: true
      },
      children: [
        {
          path: '/forum',
          name: 'forum',
          component: ForumComponent,
          children: []
        },
        {
          path: '/forum/:category',
          name: 'forumCategory',
          component: CategoryComponent,
        },
        {
          path: '/forum/:category/topics/createTopic',
          name: 'createForumTopic',
          component: CreateTopicComponent,
        },
        {
          path: '/forum/:category/topics/:topic',
          name: 'forumTopic',
          component: TopicComponent,
        },
        {
          path: '/user/:id?',
          name: 'user',
          component: UserProfileComponent,
          props: true
        },
        {
          path: '/friends',
          name: 'friends',
          component: FriendsListComponent,
        },
        {
          path: '/usersList',
          name: 'usersList',
          component: UsersListComponent,
        },
        {
          path: '/chat',
          name: 'chatsList',
          component: ChatsComponent,
        },
        {
          path: '/chat/:userId',
          name: 'chatRoom',
          component: ChatComponent,
        },
      ]
    },
    {
      path: '*',
      name: 'pageNotFound',
      component: PageNotFound
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // этот путь требует авторизации, проверяем залогинен ли
    // пользователь, и если нет, перенаправляем на страницу логина
    if (!localStorage.getItem('token')) {
      next({name: 'login'})
    } else {
      next()
    }
  } else {
    next() // всегда так или иначе нужно вызвать next()!
  }
})

router.beforeResolve((to, from, next) => {
  if (to.matched.some(record => record.meta.isAuthorized)) {
    if (localStorage.getItem('token')) {
      next('/forum')
    } else {
      next()
    }
  } else {
    next()
  }
})
