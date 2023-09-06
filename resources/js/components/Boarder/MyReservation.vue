<template>
    <div>
        <div class="section">
            <div class="panel">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">MY RESERVATIONS</div>

                        <div class="columns">
                            <div class="column">
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
                                                v-model="search.lname" placeholder="Search Lastname"
                                                @keyup.native.enter="loadAsyncData"/>
                                    <p class="control">
                                        <b-button type="is-primary" icon-right="account-filter" @click="loadAsyncData"/>
                                    </p>
                                </b-field>
                            </div>
                        </div>

                        <div class="buttons mt-3 is-right">
                            <b-button @click="openModal" icon-right="account-arrow-up-outline" class="is-success">NEW</b-button>
                        </div>

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

                            <b-table-column field="user_id" label="ID" v-slot="props">
                                {{ props.row.reservation_id }}
                            </b-table-column>

                            <b-table-column field="boarding_house" label="BHouse" v-slot="props">
                                {{ props.row.rental.boarding_house.bhouse_name }}
                            </b-table-column>

                            <b-table-column field="price" label="Price" sortable v-slot="props">
                                {{ props.row.price }}
                            </b-table-column>

                            <b-table-column field="book_datetime" label="Book Date" v-slot="props">
                                {{ props.row.book_datetime | formatDateTime }}
                            </b-table-column>

                            <b-table-column field="status" label="Status" v-slot="props">
                                <span v-if="props.row.status === 0">PENDING</span>
                                <span v-if="props.row.status === 1">APPROVED</span>
                                <span v-if="props.row.status === 2">CANCELLED</span>
                            </b-table-column>

                            <b-table-column field="aprroved_datetime" label="Approved Date" v-slot="props">
                                <span v-if="props.row.approved_datetime">
                                    {{ props.row.approved_datetime | formatDateTime }}
                                </span>
                            </b-table-column>


                            <b-table-column label="Action" v-slot="props">
                                <b-dropdown aria-role="list">
                                    <template #trigger="{ active }">
                                        <b-button
                                            label="..."
                                            type="is-primary"
                                            class="is-small"
                                            :icon-right="active ? 'menu-up' : 'menu-down'" />
                                    </template>

                                    <b-dropdown-item aria-role="listitem" 
                                        @click="getData(props.row.reservation_id)">Pay GCASH</b-dropdown-item>
                                    <b-dropdown-item aria-role="listitem" 
                                        @click="confirmCancel(props.row.reservation_id)"
                                        v-if="props.row.status === 0">Cancel</b-dropdown-item>
                                </b-dropdown>

                            </b-table-column>
                        </b-table>
                    </div><!--close column-->
                </div>

            </div>
        </div><!--section div-->


        <!--modal reset password-->
        <b-modal v-model="isModalResetPassword" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="submitResetPassword">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">RESET PASSWORD</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalResetPassword = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">

                            <b-field label="Password" label-position="on-border"
                                     :type="this.errors.password ? 'is-danger':''"
                                     :message="this.errors.password ? this.errors.password[0] : ''">
                                <b-input type="password" password-reveal v-model="fields.password" placeholder="Password">
                                </b-input>
                            </b-field>
                            <b-field label="Re-type Password" label-position="on-border"
                                     :type="this.errors.password_confirmation ? 'is-danger':''"
                                     :message="this.errors.password_confirmation ? this.errors.password_confirmation[0] : ''">
                                <b-input type="password" password-reveal v-model="fields.password_confirmation"
                                         placeholder="Re-type Password">
                                </b-input>
                            </b-field>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="isModalResetPassword=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">RESET PASSWORD</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal reset password-->


    </div>
</template>

<script>

export default{
    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'user_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                lname: '',
            },

            isModalCreate: false,
            isModalResetPassword : false,

            fields: {
                username: '',
                lname: '', fname: '', mname: '',
                password: '', password_confirmation : '',
                sex : '', role: '',  email : '', contact_no : '',
                province: '', city: '', barangay: '', street: ''
            },
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            provinces: [],
            cities: [],
            barangays: [],
        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `key=${this.search.lname}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-my-reservations?${params}`)
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
            this.isModalCreate=true;
            this.global_id = 0;
            this.fields = {};
            this.errors = {};
        },

        loadProvince: function(){
            axios.get('/load-provinces').then(res=>{
                this.provinces = res.data;
            })
        },

        loadCity: function(){
            axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                this.cities = res.data;
            })
        },

        loadBarangay: function(){
            axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                this.barangays = res.data;
            })
        },


        submit: function(){

            if(this.global_id > 0){
                //update
                axios.put('/users/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.isModalCreate = false;
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
                axios.post('/users', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
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
        },

        //alert box ask for deletion
        confirmCancel(id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-info',
                message: 'Are you sure you want to cancel reservation?',
                cancelText: 'Close',
                confirmText: 'Yes',
                onConfirm: () => this.cancelSubmit(id)
            });
        },
        //execute delete after confirming
        cancelSubmit(id) {
            axios.post('/cancel-my-reservations/' + id).then(res => {
                if(res.data.status === 'cancelled'){
                    this.loadAsyncData();
                }

            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        clearFields(){
            this.fields = {};
        },


        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;


            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/users/'+data_id).then(res=>{
                this.fields = res.data;
                let tempData = res.data;
                //load city first
                axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                    //load barangay
                    this.cities = res.data;
                    axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                        this.barangays = res.data;
                        this.fields = tempData;
                    });
                });
            });
        },

        openModalResetPassword(dataId){
            this.fields = {};
            this.isModalResetPassword = true;
            this.global_id = dataId;
        },
        
        submitResetPassword: function(){
            axios.post('/user-reset-password/' +this.global_id, this.fields).then(res=>{
                if(res.data.status === 'reseted'){
                    this.$buefy.dialog.alert({
                        title: 'RESET SUCCESSFULLY!',
                        message: 'Password reset successfully',
                        type: 'is-success',
                        onConfirm: ()=>{
                            this.fields = {};
                            this.global_id = 0;
                            this.loadAsyncData();
                            this.isModalResetPassword = false;
                        }
                    });
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            })
        },


        checkMobileNo(evt){
            var phoneno = /^(09|\+639)\d{9}$/;
            if(evt.match(phoneno)){
                this.errors.contact_no = false;
            }else{
                this.errors.contact_no = true;
                this.errors.contact_no = ['Invalid mobile number format. Valid format sample is (+639161234123)'];

            }
        },


        confirmDeactivate(dataId) {
            this.$buefy.dialog.confirm({
                title: 'Deactivate!',
                type: 'is-danger',
                message: 'Are you sure you want deactivate this data?',
                cancelText: 'Cancel',
                confirmText: 'Disable',
                onConfirm: () => this.deactivate(dataId)
            });
        },
        //execute delete after confirming
        deactivate(dataId) {
            axios.post('/user-deactivate/' + dataId).then(res => {

                if(res.data.status === 'deactivated'){
                    this.$buefy.toast.open({
                        message: 'Account deactivated',
                        type: 'is-success'
                    })
                }
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        activate: function(dataId){
            axios.post('/user-activate/' + dataId).then(res => {

                if(res.data.status === 'activated'){
                    this.$buefy.toast.open({
                        message: 'Account activated',
                        type: 'is-success'
                    })
                }
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        }



    },

    mounted() {
        this.loadAsyncData();
        this.loadProvince();
    }
}
</script>


<style scoped>
    .panel{
        padding: 25px;
    }

</style>
