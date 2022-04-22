<template>
    <div class="row bg-light p-2 border-bottom">
         <h5>Registration</h5>
         <div><br>
            <form class="">

                <div class="invalid-feedback mb-1" id="name-error-text">//</div>
                <p> <input type="text"  v-model="regform.name" placeholder="Name" id="name-input" class="form-control"> </p>

                <div class="invalid-feedback mb-1" id="secondname-error-text"></div>
                <p> <input type="text"  v-model="regform.secondname" placeholder="Secondname" id="secondname-input" class="form-control"> </p>  

                <div class="invalid-feedback mb-1" id="email-error-text"></div>             
                <p> <input type="email"  v-model="regform.email" placeholder="Email" id="email-input" class="form-control"> </p>

                <div class="invalid-feedback mb-1" id="password-error-text"></div>
                <p> <input type="password" v-model="regform.password" placeholder="Password" id="password-input" class="form-control"> </p>

                <p> <input type="password" v-model="regform.password_confirmation" placeholder="Confirm password" class="form-control"> </p>
                <p> <button type="button" @click="registerUser" class="btn btn-sm btn-primary"> Registration </button> </p>
            </form>
            <button type="button" class="btn btn-sm btn-light" @click="this.$emit('loginShow', true)">Login</button>
         </div>                                          
    </div>
</template>

<script>
import axios from 'axios'
import $ from 'jquery'

export default {

    data(){
        return {
            regform: {
                name: null,
                email: null,
                password: null, 
                password_confirmation: null
            }
        }
    },

    methods: {
        registerUser(){

            $('.form-control').removeClass("is-invalid")
            $('.invalid-feedback').css('display', 'none').text('')

            axios.post('/register', this.regform )
            .then(res=>{

                this.$emit('loginSet', true)
            })  
            .catch(err=>{

                var errors = err.response.data.errors

                for(var name in errors){

                    errors[aa].forEach(element => {
                        
                        $("#" + name + "-input").addClass("is-invalid")
                        $("#" + name + "-error-text").css('display', 'block').text(element)
                    });
                }
            })
        }
    }
}
</script>

<style>

</style>