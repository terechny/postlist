<template>
    <teleport to="#modal">
        <div id="madal-back">
            <div id="modal-window">
                <div> 
                    <button @click="this.$emit('status', false)" class="btn btn-sm btn-outline-secondary" style="float:right;">close</button> 
                </div>
                <div id="modal-content" class="p-2">
                    <slot></slot>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script>
export default {
    emits: ["status"],
    data(){
        return {
            modalShow:false
        }
    },
    props:{

    },
    methods:{
    }
}
</script>

<style>
   #madal-back{
        background-color: rgba(115,117,118, 0.2);
        position: absolute;
        width:100%;
        height: 100vh;
        z-index:1000;
   }
   #modal-window{
       width:36%;
       margin-left:32%;
       margin-top:5vh;
       background-color: white;
       min-height: 50vh;
       border-radius:8px;
       padding:8px;
   }

</style>