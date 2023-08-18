<template>
    <div>
        <div class="section">

            <div class="columns" v-if="user.active == 0">
                <div class="column is-8 is-offset-2">
                    <b-notification
                            type="is-danger is-light"
                            aria-close-label="Close notification"
                            role="alert">
                            Account status is inactive.
                    </b-notification>
                </div>
            </div>


            <h1 class="title is-flex is-justify-content-center">LANDOWNER DASHBOARD</h1>

        </div>

        <div class="section" v-if="user.active == 1">
            <div class="bhouse-container">

                <div class="card" v-for="(item, index) in bhouses" :key="index">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <img :src="`/storage/bhouses/${item.bhouse_img_path}`" />
                        </figure>
                    </div>

                    <div class="card-content">
                        <div class="media">
                            <div class="media-left">
                                <figure class="image is-48x48">
                                <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                </figure>
                            </div>
                            <div class="media-content">
                                <p class="title is-4">{{ item.bhouse_name }}</p>
                                <p class="subtitle is-6">{{ item.contact_person }}</p>
                            </div>
                        </div>

                        <div class="my-2">
                            <b>Contact NO.: </b> <span>{{ item.contact_no }}</span>
                        </div>

                        <div class="buttons">
                            <a class="button is-link" :href="`/boarding-house/${item.bhouse_id}/edit`">EDIT</a>
                            <a class="button is-link" :href="`/boarding-house-rooms/${item.bhouse_id}`" icon-left="craddle-outline">MANAGE ROOMS</a>

                        </div>

                        <div class="content">
                            <div class="card-w-content">
                                <span class="card-content-title">Description: </span>
                                    {{ item.bhouse_desc }}
                            </div>
                            <div class="card-w-content">
                                <span class="card-content-title">Amenitites: </span>
                                <span v-for="(a, ix) in item.amenities" :key="`am${ix}`">
                                    {{ a.amenity.amenity }},
                                </span>
                            </div>

                                <div class="card-w-content">
                                <span class="card-content-title">Location: </span>
                                {{ item.street }}, {{ item.barangay.brgyDesc }} {{ item.city.citymunDesc }}, {{ item.province.provDesc}}
                            </div>

                        </div>
                    </div>

                </div><!--card-->
            </div><!--bhouses-->
        </div>

    </div>
</template>

<script>
export default {
    props: ['propUser'],

    data() {
        return{
            bhouses: [],
            user: {},
            amenities: [],

        }
    },

    methods: {
        loadBhouses(){
            axios.get('/get-landowner-bhouses').then(res=>{
                this.bhouses = res.data;
            })
        },



        initData: function(){
            this.user = JSON.parse(this.propUser);
            console.log(this.user);
        }
    },

    mounted() {
        this.initData();
        this.loadBhouses();
    }
}
</script>


<style scoped>

.bhouse-container{
    display: flex;
    justify-content: center;
}
.card{
    width: 500px;
    margin: 15px;
}

.card-content-title{
    font-weight: bold;
}

.card-w-content{
    margin: 10px 0 0 0;
}

</style>
