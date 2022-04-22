<template>
  <div class="row p-2 mt-2 border-bottom">
       <div class="p-2">
          <p class="nav-btn" v-for="(link, index) in links" :key="index" >
               <router-link class="nav-link active" :to="link.href">{{ link.title }}</router-link>       
          </p>
       </div>
  </div>
</template>

<script>
export default {
     data(){
          return{

               links:[
                    {
                    title: "Home",
                    href: "/"
                    },
                    {
                    title: "New",
                    href: "/new"
                    }
               ]
          }
     },
     methods: {

          loadPosts(type){
              console.log(type)
          }
     }
}
</script>

<style>
   .nav-btn{
        cursor:pointer;
        font-weight:bold;
   }
</style>