<template>
    <tr>
        <td>{{id}}</td>
        <td>
            <label
                    v-bind:style="{ color: activeColor }"
                    @dblclick="onEdit('name')" v-show="!showEditableFields.name"
            >
                {{name}}
            </label>
            <div class="input-group mb-6" v-show="showEditableFields.name">
                <input type="text" class="form-control-lg" aria-describedby="basic-addon1"
                       v-model="edited.name"
                >
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">
                        <button type="button" class="btn btn-outline-success btn-sm"
                                @click="update('name', edited.name)">✔</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" @click="onEdit('name')">✗</button>
                    </span>
                </div>
            </div>
        </td>
        <td>
            <label @dblclick="onEdit('age')" v-show="!showEditableFields.age" >
                {{age}}
            </label>
            <div class="input-group mb-6" v-show="showEditableFields.age">
                <input type="number" class="form-control-lg" aria-describedby="basic-addon2"
                       v-model="edited.age"
                >
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">
                        <button type="button" class="btn btn-outline-success btn-sm"
                                @click="update('age', edited.age)">✔</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" @click="onEdit('age')">✗</button>
                    </span>
                </div>
            </div>
        </td>
        <td>
            <label @dblclick="onEdit('city')" v-show="!showEditableFields.city" >
                {{city}}
            </label>
            <div class="input-group mb-6" v-show="showEditableFields.city">
                <select class="form-control-lg" aria-describedby="basic-addon3"
                       v-model="edited.city"
                >
                    <option>Varna</option>
                    <option>Sofia</option>
                    <option>Plovdiv</option>
                </select>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon3">
                        <button type="button" class="btn btn-outline-success btn-sm"
                                @click="update('city', edited.city)">✔</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" @click="onEdit('city')">✗</button>
                    </span>
                </div>
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-outline-danger" @click="del()">Delete</button>
        </td>
    </tr>
</template>

<script>
    export default {
        name: "ConsumerComponent",
        data() {
            return {
                showEditableFields: {
                    name: false,
                    age: false,
                    city: false
                },
                edited: {
                    name: null,
                    age: null,
                    city: null
                }

            }
        },

        methods:
            {
                onEdit(field) {
                    this.showEditableFields[field] = !this.showEditableFields[field];
                },
                update(property, data) {
                  this.$emit('update', this.id, property, data);
                  this.onEdit(property);
                },
                del() {
                    this.$emit('delete', this.id);
                },
            },
        props: ['id', 'name', 'age', 'city'],
        computed: {
            activeColor: function () {
                if (this.age < 18) {
                    return "green";
                } else if (this.age > 60) {
                    return "red";
                }
                return "black";
            }
        },
        created() {
            this.edited.name = this.name;
            this.edited.age = this.age;
            this.edited.city = this.city;
        }
    }
</script>

<style scoped>

</style>