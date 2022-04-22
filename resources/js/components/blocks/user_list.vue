<template>
    <div v-for="(user, index) in users" :key="index">
        <p>  
            <router-link :to="'/user/' + user.id" style="text-decoration:none;">{{ user.name }} {{ user.second_name }}</router-link>
        </p>
    </div>
</template>

<script>
export default {
   props:{
       users: Object
   }
 
}
</script>

<style>

</style>