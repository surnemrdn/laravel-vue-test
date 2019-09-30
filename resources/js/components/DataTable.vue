<template>
    <div>
        <h3>
            <br>
            Properties List , Showing {{searchParams.current_page}} of {{last_page}}
            <div class="pull-right">
                <button class="btn btn-default" v-if="searchParams.current_page > 1" v-on:click="movePre">
                    &laquo; Previous
                </button>
                &nbsp;
                <button class="btn btn-default" v-if="searchParams.current_page != last_page"  v-on:click="moveNext">
                    Next &raquo;
                </button>

            </div>
        </h3>
        <div class="scrollme">

        <table class='table table-striped'>
            <thead>
            <tr>
                <th v-for="column in columns" :key="column.title" @click="doSort(column.name)"
                    :class="searchParams.sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                    style="width: 20%; cursor:pointer;">
                    {{column.label}}
                </th>

            </tr>
            <tr>
                <th>
                    <input class="form-control" type="text" v-model="searchParams.id" placeholder="Search..."
                           @input="fetchRecords(1)" >
                </th>
                <th>
                    <input class="form-control" type="text" v-model="searchParams.title" placeholder="Search..."
                           @input="fetchRecords(1)" >
                </th>
                <th>
                    <input class="form-control" type="text" v-model="searchParams.description" placeholder="Search..."
                           @input="fetchRecords(1)" >
                </th>
                <th>
                    <input class="form-control" type="text" v-model="searchParams.bedroom" placeholder="Search..."
                           @input="fetchRecords(1)" >
                </th>
                <th>
                    <input class="form-control" type="text" v-model="searchParams.bathroom" placeholder="Search..."
                           @input="fetchRecords(1)" >
                </th>
                <th>
                    <select v-model="searchParams.property_type" @change="fetchRecords(1)" class="form-control">
                        <option v-for="(name, value) in propertyTypes" :value="value">{{name}}</option>
                    </select>
                </th>
                <th>
                    <select v-model="searchParams.status" @change="fetchRecords(1)" class="form-control">
                        <option v-for="(name, value) in statuses" :value="value">{{name}}</option>
                    </select>
                </th>
                <th>
                    <select v-model="searchParams.for_sale" @change="fetchRecords(1)" class="form-control">
                        <option v-for="(name, value) in saleRent" :value="value">{{name}}</option>
                    </select>
                </th>
                <th>
                    <select v-model="searchParams.for_rent" @change="fetchRecords(1)" class="form-control">
                        <option v-for="(name, value) in saleRent" :value="value">{{name}}</option>
                    </select>
                </th>
                <th>
                    <input class="form-control" type="text" v-model="searchParams.projectName" placeholder="Search..."
                           @input="fetchRecords(1)" >
                </th>
                <th>
                    <select v-model="searchParams.country" @change="fetchRecords(1)" class="form-control">
                        <option v-for="(name, value) in countries" :value="value">{{name}}</option>
                    </select>
                </th>
            </th>
            </tr>
            </thead>
            <tr v-for="model in list">
                <td>{{ model.id }}</td>
                <td>{{ model.title }}</td>
                <td>{{ model.description }}</td>
                <td>{{ model.bedroom }}</td>
                <td>{{ model.bathroom }}</td>
                <td>{{ model.property_type.name }}</td>
                <td>{{ model.status.name }}</td>
                <td>{{ model.for_sale ? 'Yes' : 'No' }}</td>
                <td>{{ model.for_rent ? 'Yes' : 'No' }}</td>
                <td>{{ model.project.name }}</td>
                <td>{{ model.region.country.name }}</td>

            </tr>
        </table>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component ready.');
            this.fetchRecords();
            axios.get('property-types').then((response) => {
                this.propertyTypes = response.data;
            })
            axios.get('statuses').then((response) => {
                this.statuses = response.data;
            })
            axios.get('sale-rent').then((response) => {
                this.saleRent = response.data;
            })
            axios.get('countries').then((response) => {
                this.countries = response.data;
            })
        },
        data() {
            let sortOrders = {};

            let columns = [
                {label: 'Id', name: 'id' },
                {label: 'Title', name: 'title' },
                {label: 'Description', name: 'description' },
                {label: 'Bedroom', name: 'bedroom'},
                {label: 'Bathroom', name: 'bathroom'},
                {label: 'Property Type', name: 'property_type_id'},
                {label: 'Status', name: 'status'},
                {label: 'For Sale', name: 'for_sale'},
                {label: 'For Rent', name: 'for_rent'},
                {label: 'Project Name', name: 'project_id'},
                {label: 'Country', name: 'country_id'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                list: [],
                propertyTypes: [],
                statuses: [],
                saleRent: [],
                countries: [],
                per_page: 0,
                last_page: 0,
                columns: columns,
                field: 'id',
                sortOrders: sortOrders,
                searchParams: {
                    id: null,
                    title: null,
                    description: null,
                    bedroom: null,
                    bathroom: null,
                    property_type:null,
                    status :null,
                    for_sale :null,
                    for_rent :null,
                    projectName :null,
                    country :null,

                    sortKey: 'id',
                    sort: 'asc',
                    current_page: 1,
                }
            }
        },
        methods: {
            doSort: function(fieldName) {
                this.sortOrders[fieldName] = this.sortOrders[fieldName] * -1;
                this.searchParams.sortKey = fieldName;
                this.searchParams.current_page = 1;
                if (this.field != fieldName) {
                    this.searchParams.sort = "asc";
                } else {
                    this.searchParams.sort = this.searchParams.sort == "asc" ? "desc" : "asc";
                }
                this.field = fieldName;
                this.fetchRecords();
            },
            fetchRecords: function(newSearch = false) {
                if(newSearch){
                    this.searchParams.current_page = 1;
                }
                axios.get('property/all',
                    {
                        params: this.searchParams
                    }
                ).then((response) => {
                    this.list = response.data.data;
                    this.last_page = response.data.links.pagination.last_page;
                }, (response) => {
                    console.log(JSON.stringify(response));
                });
            },
            moveNext: function(event) {
                this.searchParams.current_page++;
                this.fetchRecords();
            },
            movePre: function(event) {
                this.searchParams.current_page--;
                this.fetchRecords();
            }

        }
    }
</script>
<style scoped>

    .control {
        float: right;
    }
    .table {
        width: 100%;
    }
    .sorting {
        background-image: url('/images/sort_both.png');
        background-repeat: no-repeat;
        background-position: center right;
    }
    .sorting_asc {
        background-image: url('/images/sort_asc.png');
        background-repeat: no-repeat;
        background-position: center right;
    }
    .sorting_desc {
        background-image: url('/images/sort_desc.png');
        background-repeat: no-repeat;
        background-position: center right;

    }

    h1 {
        text-align: center;
        font-size: 30px;
    }
    i {
        color: #3273dc !important;
    }
    .scrollme {
        overflow-y: auto;
    }
    .pull-right{
        float: right;
    }
</style>
