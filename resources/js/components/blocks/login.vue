<template>
    <div class="row bg-light p-2 border-bottom">
        <h5>Login</h5>
        <div v-if="this.errors.status">
            <div class="alert alert-danger" role="alert"  v-for="(message, index) in this.errors.text" :key="index" >
                {{ message }}
            </div>
        </div>
         <div><br>
            <form>
                <p> <input type="email" v-model="loginform.email" placeholder="Email" class="form-control"> </p>
                <p> <input type="password" v-model="loginform.password" placeholder="Password" class="form-control"> </p>
                <p> <button type="button" @click="loginUser" class="btn btn-sm btn-primary"> Login </button> </p>
            </form>
            <button type="button" class="btn btn-sm btn-light" @click="this.$emit('loginShow', false)">Registration</button>
         </div>      
    </div>
</template>

<script>
import axios from 'axios'
export default {

    data(){

        return {
            loginform: {
                email:null,
                password:null
            },
            errors: {
                status:false,
                text: []
            } 
        }
    },

    methods: {

        loginUser(){

            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', this.loginform )
                .then(res=>{                   
                    this.$emit('loginSet', true)
                    this.errors.status = false
                })
                .catch(err=>{
                    this.errors.status = true
                    this.errors.text = err.response.data.errors.email   
                })
            });
        },
    }
}
</script>

<style>

</style>