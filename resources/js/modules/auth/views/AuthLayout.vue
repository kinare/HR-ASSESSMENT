<template>
    <v-app>
        <v-main class="primary lighten-5">
            <!-- Content-->
            <router-view />
        </v-main>
        <v-overlay opacity="0.5" :value="loading">
            <v-progress-circular indeterminate size="100">
                Loading...
            </v-progress-circular>
        </v-overlay>
    </v-app>
</template>

<script>
import {AuthService} from "../index";

export default {
name: "AuthLayout",
    data: function (){
        return{
            loading: false
        }
    },
    beforeRouteEnter(to, from, next){
        next(v => {
            if (AuthService.check())
                v.$router.push({ name: "Assessments"})
        })
    },
    mounted() {
        Event.$on('loading', value =>{
            this.loading = value
        })
    }
}
</script>

<style scoped>

</style>
