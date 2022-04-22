<template>
    <div style="max-height:80vh;overflow-y:scroll;">       
        <post-component :post="post" v-for="(post, index) in posts" :key="index"></post-component> 
        <div><button class="btn btn-sm btn-outline-primary" @click="addNumPage">Load next</button></div>               
    </div>
    <create-component v-if="createBlock" @addPost="addToPosts"></create-component>
</template>

<script>
import axios from 'axios'
import PostComponent from "../blocks/post"
import CreateComponent from "../blocks/create"
export default {

    data(){

        return {
            posts: {},
            createBlock: false,
            postParams: {
                params:{

                    user: null,
                    page: 'home',
                    num_page: 0,
                    per_page: 0
                }
            }
        }
    },
    mounted(){
        
        this.setParams() 
        this.getPost()
        this.setCreateBlock()
    },
    watch: {     
        async "$route.name"(){

            this.postParams.params.page = this.$route.name
            this.postParams.params.num_page = 0

            if( this.$route.name == 'home' ){
 
                this.postParams.params.user = this.login.user

                if( this.login.status ){
                      this.createBlock = true
                }
            }else{
                this.createBlock = false
            }

            if( this.$route.name == 'user' ){

                if( this.$route.params.id ){
                    this.postParams.params.user  = this.$route.params.id            
                }
            }
 
            this.getPost(true)
        }
    },    
    methods: {
        getPost(reload=false){ 
          
            axios.get('/api/posts',  this.postParams ).then(res=>{ 

                if(reload){ this.posts = {} }
                                                      
                this.addToPosts(res.data.posts)             
            })
        },
        addToPosts(posts){

            var postsCount = Object.keys(this.posts).length

            posts.forEach(element => {

                postsCount++      
                this.posts[postsCount] = element  
            }); 
        },
        setParams(){

            this.postParams.params.page = this.$route.name
            
            if( this.$route.name == 'user' ){

                if( this.$route.params.id ){
                    this.postParams.params.user  = this.$route.params.id            
                }
            }else{

                this.postParams.params.user = this.login.user 
            }
                
        },
        setCreateBlock(){

            if( this.login.status & this.$route.name == 'home' ){

                this.createBlock = true
            }       
        },
        addNumPage(){
            
            this.postParams.params.num_page ++
            this.getPost()
        }
    }, 
    props: {
        login: Object
    },
    components:{
        PostComponent,
        CreateComponent,
    } 
}
</script>

<style>

</style>