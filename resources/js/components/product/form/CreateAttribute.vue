<template>
    <form @submit.prevent="saveAttribute">
        <h3>Create Attribute</h3>
        <label>Name</label>
        <input type="text" v-model="attribute.name" required>
        <button>Save</button>
    </form>
</template>

<script>
export default {
    name: "ProductFormCreateAttribute",
    data() {
        return {
            attribute: {
                name: ''
            }
        }
    },

    methods: {
        saveAttribute() {
            axios.post('api/attribute', this.attribute).then((data) => {
                this.$emit('set-tab', 'ProductFormUpload')
                this.attribute.name = ''
                this.$root.$emit('attribute-saved')
            }).catch(e => console.log(e))
        }
    }
}
</script>

<style scoped>

</style>
