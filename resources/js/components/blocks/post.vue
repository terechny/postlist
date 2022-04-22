<template>
        <div class="p-2 mb-2 border-bottom">
            <div class="mb-1">
                <router-link :to="'/user/' + post.user_id" style="text-decoration:none;">{{ post.name }} {{ post.second_name }}</router-link>
            </div> 
            <div>{{ post.text }}</div>
            <div class="text-secondary mt-1"> <small> {{ post.created_at }} </small> </div>
        </div>
</template>

<script>
export default {
    props: {

        post: Object
    }
}
</script>

<style>

</style>