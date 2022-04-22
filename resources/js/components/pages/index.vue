<template>
    <div>      
        <div class="container">
            <div class="row">
                <div class="col-sm-3" style="border-right:1px #DEE2E6 solid"> 
                    <div>
                        <left-component v-if="this.loadedUserData" @loginSet="loginSet" :login="this.login"/>                      
                    </div>
                    <div>
                        <right-component/>                    
                    </div>               
                </div>
                <div class="col-sm-6 p-2">                 
                    <posts-component v-if="this.loadedUserData" :login="this.login"/>            
                </div>                     
            </div>           
        </div>       
    </div>
</template>

<script>
import axios from 'axios'
import PostsComponent from "../blocks/posts"
import LeftComponent from "../blocks/left"
import RightComponent from "../blocks/right"

export default {
    data(){

        return{
            loadedUserData: false,
            login: {
                status:false,
                user:0
            }
        }
    },
    mounted(){

        this.getLoginStatus()
    },
    methods:{

        getLoginStatus(){ 

            axios.get('/api/user/check-login').then(res=>{                
                if(res.data.status){ 
                    this.login.user = res.data.user
                    this.login.status = res.data.status                                                    
                } 
                this.loadedUserData = true
            }).catch(err => {
                console.log(err.response.data);
                this.loadedUserData = true                 
            })                       
        },
        loginSet(status){

            if(status){
                this.getLoginStatus()
            }else{
                this.login.status = status;
            }                     
        }
    },

    components: {

        PostsComponent,
        LeftComponent,
        RightComponent
        
    }

}
</script>

<style>

</style>