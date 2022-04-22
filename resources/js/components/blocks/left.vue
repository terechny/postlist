<template>
    <div>
        <user-component v-if="login.status" @loginSet="loginSet" :login="this.login"/>
        <authorization-component @loginSet="loginSet" v-else/>
    </div>  
</template>

<script>

import UserComponent from "../blocks/user"
import AuthorizationComponent from "../blocks/authorization"

export default {

    props: {
        login: Object
    },
    methods: {
        loginSet(status){
            this.$emit('loginSet', status)
        }
    },
    components: {
        UserComponent,
        AuthorizationComponent
    }

}
</script>

<style>

</style>