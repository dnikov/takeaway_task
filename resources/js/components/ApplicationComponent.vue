<template>
    <div id="app" class="container">
        <div class="row">
            <div class="col-sm-4">
                <input v-model="search" class="form-control" placeholder="Type to search...">
            </div>
            <div class="col-sm-8">
                <div class="form-group row float-right">
                    <label for="sort" class="col-sm-4 col-form-label">Sort</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="sort" v-model="sort" v-on:change="sortTable">
                            <option value="" disabled selected>Sort option</option>
                            <optgroup label="ID"></optgroup>
                            <option value="id-asc">ID Asc</option>
                            <option value="id-desc">ID Desc</option>
                            <optgroup label="Name"></optgroup>
                            <option value="name-asc">Name Asc</option>
                            <option value="name-desc">Name Desc</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Age</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            <consumer-component
                    v-for="consumer in filteredConsumers"
                    v-bind="consumer"
                    v-bind:key="consumer.id"
                    @update="update"
                    @delete="del"
            ></consumer-component>
            <tr>
                <td></td>
                <td>
                    <input class="form-control" placeholder="Name"
                           id="name"
                           v-model="newConsumer.name"
                           type="text"
                           name="name"
                    >
                </td>
                <td>
                    <input class="form-control" placeholder="Age"
                           id="age"
                           v-model="newConsumer.age"
                           type="number"
                           name="age"
                           min="14"
                           max="99">
                </td>
                <td>
                    <!--This must be served by backend as well. But it is not part of the task now-->
                    <select class="form-control"
                            id="city"
                            v-model="newConsumer.city"
                            name="city"
                    >
                        <option value="Varna">Varna</option>
                        <option value="Plovdiv">Plovdiv</option>
                        <option value="Sofia">Sofia</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-outline-primary " @click="create()">Add User</button>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-if="errors.length">
            <b>Please correct the following error(s):</b>
        <ul>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
        </p>
    </div>
</template>

<script>
    function Consumer({id, name, age, city}) {
        this.id = id;
        this.name = name;
        this.age = age;
        this.city = city;
    }

    import ConsumerComponent from './ConsumerComponent.vue';

    export default {
        data() {
            return {
                search: '',
                sort: 'id-asc',
                consumers: [],
                errors: [],
                loading: false,
                newConsumer: new Consumer({})

            }
        },
        methods: {
            read() {
                //Load cunsumers on startup
                window.axios.get('/api/consumers').then(({data}) => {
                    data.forEach(consumer => {
                        this.consumers.push(new Consumer(consumer));
                    });
                });
            },
            checkForm: function () {
                // Simple validation. More validation will be triggered from backend.
                this.errors = [];
                if (this.newConsumer.name && this.newConsumer.age && this.newConsumer.city && this.newConsumer.city !== "") {
                    return true;
                }

                if (!this.newConsumer.name) {
                    this.errors.push('Name is required.');
                }
                if (!this.newConsumer.age) {
                    this.errors.push('Age is required.');
                }
                if (!this.newConsumer.city || this.newConsumer.city === '') {
                    this.errors.push('Please, choose city.');
                }

            },
            create() {
                // POST request to backend. Creating new consumer.
                if (!this.checkForm()) {
                    return false;
                }
                this.toggleLoading();
                axios.post('/api/consumers', this.newConsumer)
                    .then(({data}) => {
                        this.consumers.push(new Consumer(data));
                        this.resetData();
                        this.toggleLoading();
                    })
                    .catch(object => {
                        if (object.response) {
                            var app = this;
                            $.each(object.response.data.errors, function (key, value) {
                                value.forEach(message => {
                                    app.errors.push(message);
                                })
                            })
                            this.toggleLoading();
                        }
                    });
            },
            update(id, attribute, value) {
                // PUT request to backend. Updating consumer.
                this.toggleLoading();
                this.errors = [];
                window.axios.put(`/api/consumers/${id}`, {[attribute]: value}).then(({data}) => {
                    this.consumers.find(consumer => consumer.id === data.id)[attribute] = data[attribute];
                    this.toggleLoading();
                })
                    .catch(object => {
                        if (object.response) {
                            var app = this;
                            $.each(object.response.data.errors, function (key, value) {
                                value.forEach(message => {
                                    app.errors.push(message);
                                })
                            })
                        }
                        this.toggleLoading();
                    });
            },
            del(id) {
                // DELETE request to backend. Deleting consumer
                this.toggleLoading();
                window.axios.delete(`/api/consumers/${id}`).then(() => {
                    let index = this.consumers.findIndex(consumer => consumer.id === id);
                    this.consumers.splice(index, 1);
                    this.toggleLoading();
                });
            },
            sortTable() {
                // Sort table by simple key provided.
                let propertyDirection = this.sort.split('-');

                function compare(a, b) {
                    if (a[propertyDirection[0]] < b[propertyDirection[0]])
                        return propertyDirection[1] === 'asc' ? -1 : 1;
                    if (a[propertyDirection[0]] > b[propertyDirection[0]])
                        return propertyDirection[1] === 'asc' ? 1 : -1;
                    return 0;
                }

                this.consumers.sort(compare);
            },
            resetData() {
                //Reset table in initial condition.
                this.search = '';
                this.sort = 'id-asc';
                this.sortTable();
                this.newConsumer = new Consumer({});
            },
            toggleLoading() {
                // for now we will just put some overlay, easy-peasy.
                this.loading = !this.loading;
            }

        },
        created() {
            this.read();
        },
        components: {
            ConsumerComponent
        },
        computed: {
            filteredConsumers() {
                return this.consumers.filter(consumer => {
                    return consumer.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        consumer.age.toString().includes(this.search.toLowerCase()) ||
                        consumer.city.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
        watch: {
            loading(val) {
                // Just to toggle "ON" class on the overlay.
                document.getElementById('loading').className = val ? "on" : "";
            }
        }

    }
</script>

<style scoped>

</style>