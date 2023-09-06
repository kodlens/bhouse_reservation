<template>
    <div>
        <div class="filter">
            <div class="columns m-2 is-centered">
                <div class="column is-8">
                    <div class="has-text-weight-bold mb-2">
                        FILTERS
                    </div>
                    
                    <div class="filter-subtitle">
                        ADDRESS
                    </div>
                    <div class="columns px-4">
                        <div class="column">
                            <b-field label="Province" expanded
                                label-position="on-border"
                                :type="this.errors.province ? 'is-danger' : ''" 
                                :message="this.errors.province ? this.errors.province[0]: ''">
                                <b-select v-model="filter.province" @input="loadCity" expanded>
                                    <option value="">(none)</option>
                                    <option v-for="(item, index) in provinces" 
                                        :key="index" :value="item.provCode">
                                        {{ item.provDesc }}
                                    </option>
                                </b-select>
                            </b-field>
                        </div>

                        <div class="column">
                            <b-field label="City" expanded
                                label-position="on-border"
                                :type="this.errors.city ? 'is-danger' : ''" 
                                :message="this.errors.city ? this.errors.city[0] : ''">
                                <b-select v-model="filter.city" @input="loadBarangay" expanded>
                                    <option value="">(none)</option>
                                    <option v-for="(item, index) in cities" :key="index" :value="item.citymunCode">
                                        {{ item.citymunDesc }}
                                    </option>
                                </b-select>
                            </b-field>
                        </div>
                        <div class="column">
                            <b-field label="Barangay" expanded
                                label-position="on-border"
                                :type="this.errors.barangay ? 'is-danger' : ''" 
                                :message="this.errors.barangay ? this.errors.barangay[0] : ''">
                                <b-select v-model="filter.barangay" expanded>
                                    <option value="">(none)</option>
                                    <option v-for="(item, index) in barangays" 
                                        :key="index" :value="item.brgyCode">
                                        {{ item.brgyDesc }}
                                    </option>
                                </b-select>
                            </b-field>
                        </div>
                    </div>

                    <div class="filter-subtitle">
                        PRICE RANGE
                    </div>
                    <div class="columns px-4">
                        <div class="column">
                            <b-field grouped>
                                <b-field label="Min price" label-position="on-border">
                                    <b-numberinput controls-alignment="right" controls-position="compact"
                                        v-model="filter.min_price"></b-numberinput>
                                </b-field>
                                <b-field label="Max price" label-position="on-border">
                                    <b-numberinput controls-alignment="right" :min="0" controls-position="compact"
                                        v-model="filter.max_price"></b-numberinput>
                                </b-field>
                            </b-field>
                        </div>
                    </div>
                    
                    <div class="filter-subtitle">
                        ROOM TYPE
                    </div>
                    <div class="columns px-4">
                        <div class="column">
                            <b-field label="Private Room">
                                <b-radio type="checkbox" v-model="filter.rental_type" native-value="PRIVATE">
                                    Your own home in a home.
                                </b-radio>
                            </b-field>
                        </div>
                        <div class="column">
                            <b-field label="Shared Room">
                                <b-radio type="checkbox" v-model="filter.rental_type" native-value="SHARED">
                                    A sleeping space and common areas that
                                    may be shared with others.
                                </b-radio>
                            </b-field>
                        </div>

                        <div class="column">
                            <b-field label="Both">
                                <b-radio type="checkbox" v-model="filter.rental_type" native-value="">
                                    Both private and shared
                                </b-radio>
                            </b-field>
                        </div>
                    </div>
        
                    <div class="filter-subtitle">
                        AMENITIES
                    </div>
                    <div class="columns px-4">
                        <div class="column">
                            <div class="
                                is-flex
                                is-flex-wrap-wrap">
                                <div class="mr-5" v-for="(el, ix) in amenities" :key="ix">
                                    <b-checkbox v-model="filter.amenities" 
                                        :native-value="el.amenity_id">
                                            {{ el.amenity }}
                                        </b-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>
                    
        
                    <div class="filter-subtitle">
                        RULES
                    </div>
                    <div class="columns px-4">
                        <div class="column">
                            <div class="
                                is-flex
                                is-flex-wrap-wrap
                                is-justify-content-space-between">
                                <div v-for="(el, ix) in rules" :key="ix">
                                    <b-checkbox v-model="filter.rules" 
                                        :native-value="el.rule_id">
                                        {{ el.rule }}
                                    </b-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="buttons is-right px-4">
                        <b-button class="button is-primary" 
                            @click="loadSearchRentals"
                            icon-left="magnify">SEARCH</b-button>
                    </div>
                
                </div> <!--col-->
            </div><!--cols-->

           
        </div>
        <hr>
        <!-- result here -->
        <div class="search-result">
            <div class="result-rental"
                v-for="(item, ix) in rentals" :key="ix">

                <div class="rental-content">
                    <img :src="`/storage/rentals/${item.rental_img_path}`" 
                        alt="rental images"
                        class="img-cover"
                        srcset="">

                    <div class="result-rental-description">
                        <div class="result-rental-title">
                            {{ item.rental_name }}
                        </div>
                        <div class="result-rental-desc">
                            {{ item.rental_desc }}
                        </div>
                        <div style="margin-top: 10px;">
                            <div style="font-weight: bold; font-size: .8em; color:#b8b8b8; margin-top: 5px;">
                                RENTAL TYPE
                            </div>
                            <div style="margin-left: 15px; font-style: italic;">
                                {{ item.rental_type }}
                            </div>

                            <div style="font-weight: bold; font-size: .8em; color:#b8b8b8; margin-top: 5px;">
                                ADDRESS
                            </div>
                            <div style="margin-left: 15px; font-style: italic;">
                                {{ item.boarding_house.province.provDesc }}, {{ item.boarding_house.city.citymunDesc }}
                                {{ item.boarding_house.barangay.brgyDesc }} {{ item.boarding_house.street }}
                            </div>
                        </div>
 
                        <div>
                            <div class="buttons is-right">
                                <b-button class="button is-info" tag="a" 
                                    :href="`/rental-reserve/${item.rental_id}`" v-if="isAuth === 1">Make Reservation</b-button>
                                <b-button class="button is-info" 
                                    tag="a"
                                    :href="`/login`" v-else>Sign in</b-button>
                            </div>
                        </div>
                    </div>

                    <div class="result-rental-price">
                        <span>&#8369; {{ item.price | formatDecimalComma }}</span> 
                    </div>

                </div>
            </div>
        </div>


        <section>
            <div class="footer" style="margin-top: 30px; background-color: #002b80; color:white;">
                <div class = "columns">
                    <div class="column">
                        <div class="footertwo-logo-wrapper">

                        </div>
                    </div>

                    <div class = "column">
                        <div class="p-5">
                            <div class="footer-component-title">
                               WEB BASE BOARDING HOUSE MANAGEMENT SYSTEM
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="p-5">


                        </div>
                    </div>
                </div>
            </div>
        </section>




    </div> <!--root div-->
</template>

<script>

export default {

    props: {
        propIsAuth: {
            type: Number,
            default: 0
        }
    },

    data(){
        return{

            rentals: [],
            itemShow: 3,

            search: {
                category: "",
                key: "",
            },

            isAuth: 0,
            
            errors: {},
            fields: {},
            filter: {
                bhousename: "",
                rules: [],
                rental_type: "",
                min_price: 700,
                max_price: 1500,
                amenities: [],
                province: "",
                city: "",
                barangay: "",
                street: "",
            },

            amenities: [],
            rules:[],
            provinces: [],
            cities: [],
            barangays: [],
            street: '',

        }
    },
    methods: {

        loadSearchRentals: function () {
            this.modalFilter = false;
            const params = [
                `rules=${encodeURIComponent(
                    JSON.stringify(this.filter.rules)
                )}`,
                `min_price=${this.filter.min_price}`,
                `max_price=${this.filter.max_price}`,
                `rental_type=${this.filter.rental_type}`,
                `amenities=${encodeURIComponent(
                    JSON.stringify(this.filter.amenities)
                )}`,
                `province=${this.filter.province}`,
                `city=${this.filter.city}`,
                `barangay=${this.filter.barangay}`,
                `street=${this.filter.street}`,
            ].join("&");

            axios
                .get(`/get-search-rentals?${params}`)
                .then((res) => {
                    this.rentals = res.data;

                    this.loadMap(res.data);
                })
                .catch((err) => { });
        },

        //ADDRESS
        loadProvince: function () {
            axios.get("/load-provinces").then((res) => {
                this.provinces = res.data;
            });
        },
        loadCity: function () {
            axios
                .get("/load-cities?prov=" + this.filter.province)
                .then((res) => {
                    this.cities = res.data;
                });
        },
        loadBarangay: function () {
            axios
                .get(
                    "/load-barangays?prov=" +
                    this.filter.province +
                    "&city_code=" +
                    this.filter.city
                )
                .then((res) => {
                    this.barangays = res.data;
                });
        },

        loadAmenities: function () {
            axios.get(`/load-open-amenities?`).then((res) => {
                this.amenities = res.data;
            });
        },

        loadRules: function () {
            axios.get(`/load-open-rules?`).then((res) => {
                this.rules = res.data;
            });
        },


        initData(){
            this.isAuth = this.propIsAuth
        }

    },

    mounted(){
        this.initData()
        this.loadSearchRentals()
        this.loadProvince()
        this.loadAmenities()
        this.loadRules()
    }
}
</script>


<style scoped src="../../sass/homepage.css">
</style>
