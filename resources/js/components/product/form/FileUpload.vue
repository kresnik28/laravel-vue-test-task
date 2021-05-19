<template>
    <form>
        <input type="file" accept=".csv" name="products_file" @change="setFile" ref="productsFileInput">
        <div v-if="productsFile" style="margin-top: 10px;">
            <table class="bordered-table">
                <tr>
                    <td v-for="col in mappableColumns">{{ col }}</td>
                </tr>
                <tr>
                    <td v-for="col in mappableColumns">
                        <select v-model="productsMapping[col]">
                            <option :value="null">__</option>
                            <option v-for="colName in columnNames" :value="colName">{{ colName }}</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" @click="addNewAttribute()">Add new</button>
                    </td>
                </tr>
            </table>
            <button type="button" @click="saveProducts">Accept</button>
        </div>
    </form>
</template>

<script>
import 'papaparse'

export default {
    name: "ProductFormUpload",

    props: {
        requiredCols: {
            type: Array
        },
    },

    data() {
        return {
            mappableColumns: [],
            productsFile: null,
            columnNames: [],
            productsMapping: {},
        }
    },

    created() {
        this.getMappableColumns()

        this.$root.$on('attribute-saved', () => {
            this.getMappableColumns()
        })
    },

    methods: {
        saveProducts() {
            let formData = new FormData
            formData.append('mapping_data', JSON.stringify(this.productsMapping))
            formData.append('products_file', this.productsFile)

            axios({
                method: 'post',
                url: 'api/product',
                data: formData,
                header: {
                    'Accept': 'application/json',
                    'Content-Type': 'multipart/form-data',
                },
            }).then((data) => {
                if (data.data.success) {
                    this.$refs.productsFileInput.value = null
                    this.productsFile = null
                    alert('Successfully saved')
                } else {
                    alert('Something went wrong:' + data.message)
                }
            }).catch(e => console.log(e))
        },
        getMappableColumns() {
            axios.get('api/product/mappable-columns').then((result) => {
                this.mappableColumns = result.data;
            })
        },

        setFile(event) {
            this.productsFile = event.target.files[0];
            this.generateMap()
        },

        addNewAttribute() {
            console.log("RNNITRE")
            this.$emit('set-tab', 'ProductFormCreateAttribute')
        },

        async generateMap() {
            this.columnNames = await this.getHeaders();

            if (this.columnNames.length < this.requiredCols.length) {
                alert("Columns count in file is less then required database columns")
                this.$refs.productsFileInput.reset()
                this.productsFile = null;
                return
            }

            this.mappableColumns.forEach((col) => {
                this.productsMapping[col] = null
            })

            this.columnNames.forEach((col) => {
                if (!this.productsMapping.hasOwnProperty(col)) {
                    return
                }
                this.productsMapping[col] = col
            })

            this.columnNames.forEach((col) => {
                if (this.productsMapping.hasOwnProperty(col)) {
                    return
                }
                const name = this.getFirstEmptyElement(this.productsMapping)
                if (!name) {
                    return
                }
                this.productsMapping[name] = col
            })
        },

        getFirstEmptyElement(obj) {
            for (let name in obj) {
                if (obj.hasOwnProperty(name)) {
                    if (obj[name] === null) {
                        return name
                    }
                }
            }
            return null
        },

        async getHeaders() {

            return new Promise(resolve => {
                this.$papa.parse(this.productsFile, {
                    config: {
                        // base config to use for each file
                    },
                    error: function (err, file, inputElem, reason) {
                        console.log('error parsing file: ', err)
                    },
                    complete: function (results, file) {
                        resolve(results.data[0])
                    }
                });
            })
        }
    }
}
</script>

<style scoped>
.bordered-table tr td {
    border: 1px solid #1a202c;
}
</style>
