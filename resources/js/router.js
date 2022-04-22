import { createRouter, createWebHistory } from 'vue-router'


import HomeComponent from './components/pages/index.vue'

const routes = [
    {
      path: "/",
      name: "home",
      component: HomeComponent,
    },
    {
      path: "/user/:id",
      name: "user",
      component: HomeComponent,
    },
    {
      path: "/new",
      name: "new",
      component: HomeComponent,
    },
    {
      path: "/popular",
      name: "popular",
      component: HomeComponent,
    }
  ];


const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;