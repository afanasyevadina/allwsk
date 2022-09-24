import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import EventView from '../views/EventView.vue'
import SessionView from "../views/SessionView.vue";
import EventRegisterView from "../views/EventRegisterView.vue";

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/organizers/:organizerSlug/events/:eventSlug',
    name: 'event',
    props: true,
    component: EventView
  },
  {
    path: '/organizers/:organizerSlug/events/:eventSlug/sessions/:sessionId',
    name: 'session',
    props: true,
    component: SessionView
  },
  {
    path: '/organizers/:organizerSlug/events/:eventSlug/registration',
    name: 'event-registration',
    props: true,
    component: EventRegisterView
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
