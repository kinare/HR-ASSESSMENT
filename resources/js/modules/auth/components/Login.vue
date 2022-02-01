<template>
    <v-container class="fill-height">
        <v-row>
            <v-col cols="12" md="4" offset-md="4" class="flex-column justify-center align-center">
                <v-card class="pa-5">
                    <v-card-title class="text-center">
                        Login
                    </v-card-title>
                       <v-card-text>
                           <v-alert v-if="$store.getters['Auth/error'] && $store.getters['Auth/isLogin']" text outlined color="warning" icon="mdi-alert">
                               {{ $store.getters['Auth/error']}}
                           </v-alert>

                           <v-form ref="loginForm" v-model="isValid">

                               <!--User name-->
                               <v-text-field @keyup.enter="login" ref="email" label="Email address" :rules="rules.email" v-model=formData.email placeholder="Enter email address" />

                               <!-- Password -->
                               <v-text-field @keyup.enter="login" ref="password" type="password" :rules="rules.password" label="Password" v-model=formData.password placeholder="Enter Password" />

                               <v-btn @keyup.enter="login"  @click='login' color="primary" tile block large>
                                   Login
                               </v-btn>
                           </v-form>
                       </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "Login",
    data: function (){
        return {
            isValid: false,
            formData:{
                email:'',
                password:'',
            },
            rules: {
                email: [
                    value => {
                        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        return pattern.test(value) || 'Invalid e-mail.'
                    }
                ],
                password: [value => !!value || 'Required.'],
            },
            viewPassword: false,
            loading: false
        }
    },
    mounted() {
        Event.$on('loading', value =>{
            this.loading = value
        })
    },
    methods:{
        login: function(){
            this.$refs.loginForm.validate();
            if (this.isValid) {
                this.$store.dispatch("Auth/login", this.formData);
            }
        }
    },
}
</script>

<style scoped>

</style>
