<template>
    <login-component v-if="loginblock" @loginShow="loginShow" ></login-component>
    <registration-component v-else @loginShow="loginShow"></registration-component>
</template>

<script>

import LoginComponent from "../blocks/login"
import RegistrationComponent from "../blocks/registration"

export default {

    data(){
        return {
            loginblock:true
        }
    },
    methods: {
        loginShow(status){
            this.loginblock = status
        }
    },
    components: {
        LoginComponent,
        RegistrationComponent
    }
}
</script>

<style>

</style>