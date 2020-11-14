import Vue from "vue";
import VueRouter from "vue-router";
import Dashboard from "@/views/Dashboard";
import Stats from "@/views/Stats";
import Analytics from "@/views/Analytics";
import Logs from "@/views/Logs";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard
  },
  {
    path: "/stats",
    name: "Stats",
    component: Stats
  },
  {
    path: "/analytics",
    name: "Analytics",
    component: Analytics
  },
  {
    path: "/logs",
    name: "Logs",
    component: Logs
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
