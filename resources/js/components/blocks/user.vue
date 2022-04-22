<template>
    <div class="row border-bottom pb-2">
        <div class="row">
            <div class="col-sm-10" style="padding-top:10px;">
                <div> 
                    <h5> {{ user.firstname }} {{ user.secondname }} </h5>
                </div> 
                <div v-if="userPage" class="mt-4">
                    <button v-if="user.subscribe" @click="setSubscribe(user.user_id, false)" class="btn btn-sm btn-warning">Unsubscribe</button> 
                    <button v-else @click="setSubscribe(user.user_id, true)" class="btn btn-sm btn-primary">Subscribe</button>                     
                </div>                          
            </div>
        </div>
        <div class="container">
            <div class="row mt-3 pt-2 border-top">
                <div class="col-sm-4">
                    <div class="text-center"> Records </div>
                    <div class="text-center p-3 text-secondary"> {{ user.posts_count }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-center"> Follows </div>
                    <div class="text-center p-3 text-secondary follow-btn rounded" @click="getFollows(user.user_id, 'follows')">{{ user.follows }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-center"> Followers </div>
                    <div class="text-center p-3 text-secondary follow-btn rounded" @click="getFollows(user.user_id, 'followers')">{{ user.followers }}</div>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-link" @click="logout">Logout</button>
            </div>            
        </div>
        <modal-component v-if="this.modalOpen" @status="modalStatus"> 
            <user-list :users="this.followersList"></user-list>        
        </modal-component>
    </div> 
</template>

<script>
import axios from 'axios'
import ModalComponent from "../blocks/modal"
import UserList from "../blocks/user_list"

export default {

    data(){

        return {
            user: [],
            userPostId: 0,
            userPage: false,
            subscribe: false,
            followersList: [],
            modalOpen:false
        }
    },
    props: {
        login: Object
    },
    mounted(){
    
        this.setUserId()
        this.loadUserData()       
    },
    watch: {
        async "$route.name"(){

            this.setUserId()
            this.loadUserData()

            if(this.$route.name == 'home'){
                this.userPage = false
            }

        }
    },    
    methods: {
        loadUserData(){

            axios.get( '/api/user/info/' + this.userPostId ).then(res=>{               
                this.user = res.data
            }) 
                           
        },
        setUserId(){
            
            if(this.$route.params.id){
                       
                this.userPostId = this.$route.params.id

                if( +this.login.user !== +this.userPostId){
                    this.userPage = true
                } 
                             
            }else{
                this.userPostId = this.login.user
            }                 
        },
        setSubscribe(user_id, status){

            this.user.subscribe = status

            if( status ){

                axios.get('/api/user/subscribe/' + user_id ).then(res=>{

                    this.user.followers++
                })

            }else{

                axios.get('/api/user/unsubscribe/' + user_id ).then(res=>{

                    this.user.followers--
                })
            }          
        },
        logout(){

            if(confirm('LOGOUT')){

                this.$emit('loginSet', false)
                axios.post('/logout').then(res=>{})
            }
        },
        getFollows(user, type){

            var params = {
                user: user,
                type: type
            }

            axios.get('/api/user/follows', { params }).then(res=>{

                this.followersList = res.data.users

                this.modalStatus(true)
            })
        },
        modalStatus(status){
            this.modalOpen = status
        }
    },
    components: {
        ModalComponent,
        UserList
    }

}
</script>

<style>
   .follow-btn{
       cursor:pointer;   
   }

   .follow-btn:hover{
      background-color:#F6F8F9;
   }
</style>