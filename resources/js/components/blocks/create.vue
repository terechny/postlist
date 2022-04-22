<template>
    <div class="row mt-2"> 
        <div class="col-sm-10">
            <textarea class="form-control" v-model="post.text"> </textarea> 
        </div>
        <div class="col-sm-2" style="padding:0;">
            <button type="button" class="btn btn-sm btn-primary" @click="sendPost"> Add Post </button>
        </div>
    </div> 
</template>

<script>
import axios from 'axios'
export default {

    data(){

        return {
            post: {   
                text: null            
            }
        }
    },
    methods: {
        sendPost(){  

            axios.post('/api/posts', this.post ).then(res=>{ 

                this.post.text = '';

                this.$emit('addPost',  [res.data.post])
            })
        }
    }
}
</script>

<style>

</style>