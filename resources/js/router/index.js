import Vue from "vue";
import VueRouter from "vue-router"
import { DashboardRoutes } from "../modules/dashboard";
import { AuthRoutes } from "../modules/auth";

Vue.use(VueRouter);

const routes = [
    ...AuthRoutes,
    ...DashboardRoutes,
]

const router  = new VueRouter({
    mode: "history",
    routes
});

export default router;
