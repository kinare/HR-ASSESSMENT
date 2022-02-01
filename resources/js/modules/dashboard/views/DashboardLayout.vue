<template>
    <v-app>
        <v-app-bar color="white" app>
            <v-toolbar-title>HR Policy Assessments</v-toolbar-title>

            <v-spacer />

            <v-btn class="mx-2" small @click="$store.dispatch('Auth/reset')" >Reset</v-btn>
            <v-btn class="mx-2" small color="primary" @click="$store.dispatch('Auth/logout')" >logout</v-btn>
        </v-app-bar>

        <v-main class="mt-10">
            <!-- Content-->
            <router-view />
        </v-main>

        <loader />
    </v-app>
</template>

<script>

import { AuthService } from "../../auth";

export default {
    name: "DashboardLayout",
    data: () => ({

    }),

    computed: {

        user() {
            return AuthService.user
        },
    },

}
</script>

<style scoped>

</style>
