<template>
    <div>
        <keep-alive>
            <component @set-tab="setTab" :is="activeTab" :required-cols="requiredCols"></component>
        </keep-alive>
    </div>
</template>

<script>
import './form/FileUpload'

export default {
    name: "ProductForm",

    props: {
        requiredCols: {
            type: Array
        },
    },

    data() {
        return {
            activeTab: 'ProductFormUpload'
        }
    },
    methods: {
        setTab(tab) {
            console.log("SET TAB", tab)
            this.activeTab = tab
        }
    }
}
</script>

<style scoped>
.bordered-table tr td {
    border: 1px solid #1a202c;
}
</style>
