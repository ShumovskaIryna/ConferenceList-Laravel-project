<script setup>

function goBack()
{
    window.history.back();
}
</script>

<template>
    <span class="go-back">
        <button 
            class="absolute ml-4 mt-1 btn btn-outline-primary"
            type="button"    
            @click="goBack">
            &laquo; Go Back
        </button>
    </span>
</template>
