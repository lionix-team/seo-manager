<template>
    <td>
        <span v-for="param in params" class="badge badge-primary">{{ param }}</span>
    </td>
</template>

<script>
    export default {
        name: "Params",
        props: {
            params: {
                type: Array
            }
        }
    }
</script>

<style scoped>
    .badge{
        margin-right: 3px;
    }
</style>
