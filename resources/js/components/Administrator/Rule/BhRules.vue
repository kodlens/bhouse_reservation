<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-11">
                    <div class="panel">
                        <div class="section">

                            <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">RULES</div>

                            <b-field label="Page">
                                <b-select v-model="perPage" @input="setPerPage">
                                    <option value="5">5 per page</option>
                                    <option value="10">10 per page</option>
                                    <option value="15">15 per page</option>
                                    <option value="20">20 per page</option>
                                </b-select>
                            </b-field>

                            <b-field label="Search">
                                <b-input type="text"
                                         v-model="search.rule" placeholder="Rule..."
                                         @keyup.native.enter="loadAsyncData"/>
                                <p class="control">
                                    <b-button type="is-primary" icon-right="account-filter" @click="loadAsyncData"/>
                                </p>
                            </b-field>

                            <b-table
                                :data="data"
                                :loading="loading"
                                paginated
                                backend-pagination
                                :total="total"
                                :per-page="perPage"
                                @page-change="onPageChange"
                                aria-next-label="Next page"
                                aria-previous-label="Previous page"
                                aria-page-label="Page"
                                aria-current-label="Current page"
                                backend-sorting
                                :default-sort-direction="defaultSortDirection"
                                @sort="onSort">

                                <b-table-column field="boarding_house_rule_id" label="ID" v-slot="props">
                                    {{ props.row.rule_id }}
                                </b-table-column>

                                <b-table-column field="rule" label="BH Name" sortable v-slot="props">
                                    {{ props.row.rule }}
                                </b-table-column>


                                <b-table-column label="Options" v-slot="props">
                                    <div class="is-flex">
                                        <!-- <b-tooltip label="View permit" v-if="props.row.is_approve === 0">
                                            <b-button class="button is-small is-link mr-1" tag="a" icon-right="desktop-mac" @click="viewPermit(props.row.bhouse_id)"></b-button>
                                        </b-tooltip>-->

                                        <b-tooltip label="Edit">
                                            <b-button class="button is-small is-warning mr-1" icon-right="pencil" @click="getData(props.row.rule_id)"></b-button>
                                        </b-tooltip>

                                        <b-tooltip label="Delete" class="is-danger">
                                            <b-button class="button is-small is-danger mr-1"  icon-right="trash-can-outline" @click="confirmDelete(props.row.rule_id)"></b-button>
                                        </b-tooltip>

                                    </div>
                                </b-table-column>
                            </b-table>

                            <div class="buttons">
                                <b-button label="NEW" type="is-primary" @click="openModal"></b-button>
                            </div>

                        </div><!--section -->

                    </div><!--panel -->
                </div><!--close column-->
            </div>


        </div><!--section div-->


        <!--modal display business permit-->
        <b-modal v-model="modalRule" has-modal-card
             trap-focus
             :width="640"
             aria-role="dialog"
             aria-label="Modal"
             aria-modal>

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Rule Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalRule = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Rule">
                                        <b-input type="text" placeholder="Rule..." v-model="fields.rule"></b-input>
                                    </b-field>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button
                            :class="btnClass"
                            icon-left="thumb-up-outline">
                            SAVE
                        </button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->


    </div>
</template>

<script>
export default {

    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'rule_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',


            search: {
                rule: '',
            },

            fields: {},

            modalRule:  false,

            errors: {},
            rule_id: 0,

            btnClass: {
                'button': true,
                'is-loading':false,
                'is-primary': true
            },

        }
    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `rule=${this.search.rule}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-bh-rules?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },


        openModal(){
            this.clearFields();
            this.modalRule = true;
        },


        deactivateBhouse: function(dataId){
            axios.post('/bh-request-deactivate/' + dataId).then(res=>{
                if(res.data.status === 'deactivated'){
                    this.$buefy.dialog.alert({
                        title: 'DEACTIVATED!',
                        message: 'Boarding house deactivated successfully',
                        type: 'is-success',
                        onConfirm: ()=>{
                            this.loadAsyncData();
                        }
                    });
                }
            });
        },


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/bh-rules/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.modalRule = true;


            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/bh-rules/'+data_id).then(res=>{
                this.fields = res.data;
            });
        },

        clearFields(){
            this.fields = {};
        },


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/bh-rules/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.modalRule = false;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/bh-rules', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.modalRule = false;
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }
        }

    },

    mounted() {
        this.loadAsyncData();
    }

}
</script>

<style scoped>

</style>
