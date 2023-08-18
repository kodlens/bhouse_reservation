<template>
    <div>
        <div class="section">
            <div class="columns">
                <div class="column is-8 is-offset-2">

                    <form @submit.prevent="submit">

                        <div class="panel is-primary">
                            <div class="panel-heading">
                                NEW BOARDING HOUSE
                            </div>
                            <div class="panel-body">

                                <b-field label="BHOUSE NAME"
                                    :type="this.errors.bhouse_name ? 'is-danger':''"
                                    :message="this.errors.bhouse_name ? this.errors.bhouse_name[0] : ''">
                                    <b-input type="text" v-model="fields.bhouse_name" placeholder="Bhouse Name" />
                                </b-field>

                                <b-field label="BHOUSE RULES"
                                    :type="this.errors.rules ? 'is-danger':''"
                                    :message="this.errors.rules ? this.errors.rules[0] : ''">
                                    <b-taginput
                                        v-model="fields.rules"
                                        :data="filteredTagRules"
                                        autocomplete
                                        field="rule"
                                        icon="label"
                                        type="is-info"
                                        placeholder="Add a rule"
                                        @typing="getFilteredTagRules">
                                        <template v-slot="props">
                                            <strong>{{props.option.rule_id}}</strong>: {{props.option.rule}}
                                        </template>
                                        <template #empty>
                                            There are no items
                                        </template>
                                    </b-taginput>
                                </b-field>



                                <b-field label="BHOUSE DESC"
                                    :type="this.errors.bhouse_desc ? 'is-danger':''"
                                    :message="this.errors.bhouse_desc ? this.errors.bhouse_desc[0] : ''">
                                    <b-input type="textarea" v-model="fields.bhouse_desc" placeholder="Bhouse Description" />
                                </b-field>

                                <b-field label="Contact Person"
                                    :type="this.errors.contact_person ? 'is-danger':''"
                                    :message="this.errors.contact_person ? this.errors.contact_person[0] : ''">
                                    <b-input type="text" v-model="fields.contact_person" placeholder="Contact Person" />
                                </b-field>

                                <b-field label="Contact No."
                                    :type="this.errors.contact_no ? 'is-danger':''"
                                    :message="this.errors.contact_no ? this.errors.contact_no[0] : ''">
                                    <b-input type="text" v-model="fields.contact_no" placeholder="Contact No." />
                                </b-field>

                                <b-field label="AMENITIES" class="mb-4">
                                    <b-taginput
                                        v-model="fields.amenities"
                                        :data="filterTags"
                                        autocomplete
                                        field="amenity"
                                        icon="label"
                                        placeholder="Add a tag"
                                        type="is-info"
                                        closable
                                        @close="removeAmenity"
                                        :open-on-focus="true"
                                        @typing="getFilteredTags">
                                        <template v-slot="props">
                                            <strong>{{props.option.amenity_id}}</strong>: {{props.option.amenity}}
                                        </template>
                                        <template #empty>
                                            There are no items
                                        </template>
                                    </b-taginput>
                                </b-field>

                                <!-- <div v-if="global_bhouse_id < 1">
                                    <b-field label="ATTACH BUSINESS PERMIT"
                                            :type="this.errors.business_permit_imgpath ? 'is-danger':''"
                                            :message="this.errors.business_permit_imgpath ? this.errors.business_permit_imgpath[0] : ''">
                                        <b-upload v-model="fields.business_permit_imgpath" class="file-label">
                                            <span class="file-cta">
                                                <b-icon class="file-icon" icon="upload"></b-icon>
                                                <span class="file-label">Click to upload</span>
                                            </span>
                                            <span class="file-name" v-if="fields.business_permit_imgpath">
                                                {{ fields.business_permit_imgpath.name }}
                                            </span>
                                        </b-upload>
                                    </b-field>


                                </div> -->

                                <div class="columns">
                                    <div class="column">
                                        <div v-if="global_bhouse_id > 0">
                                            <img :src="`/storage/bhouses/${fields.bhouse_img_path}`">
                                        </div>
                                        <b-field label="BHOUSE IMAGE"
                                                 :type="this.errors.bhouse_img_path ? 'is-danger':''"
                                                 :message="this.errors.bhouse_img_path ? this.errors.bhouse_img_path[0] : ''">
                                            <b-upload v-model="fields.bhouse_img" class="file-label">
                                            <span class="file-cta">
                                                <b-icon class="file-icon" icon="upload"></b-icon>
                                                <span class="file-label">Click to upload</span>
                                            </span>
                                                <span class="file-name" v-if="fields.bhouse_img">
                                                {{ fields.bhouse_img.name }}
                                            </span>
                                            </b-upload>
                                        </b-field>
                                    </div>
                                </div>


                                <div class="columns">
                                    <div class="column">
                                        <div id="mapid"></div>
                                    </div>
                                </div>

                                <b-field>
                                    <b-field label="LATITUDE"
                                        :type="this.errors.lat ? 'is-danger':''"
                                        :message="this.errors.lat ? this.errors.lat[0] : ''">
                                        <b-input type="text" v-model="fields.lat" placeholder="Latitude"></b-input>
                                    </b-field>
                                    <b-field label="LONGITUDE"
                                        :type="this.errors.long ? 'is-danger':''"
                                        :message="this.errors.long ? this.errors.long[0] : ''">
                                        <b-input type="text" v-model="fields.long" placeholder="Latitude"></b-input>
                                    </b-field>
                                </b-field>



                                <hr>
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Province" label-position="on-border" expanded
                                                :type="this.errors.province ? 'is-danger':''"
                                                :message="this.errors.province ? this.errors.province[0] : ''">
                                            <b-select v-model="fields.province" @input="loadCity" expanded>
                                                <option v-for="(item, index) in provinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="City" label-position="on-border" expanded
                                                :type="this.errors.city ? 'is-danger':''"
                                                :message="this.errors.city ? this.errors.city[0] : ''">
                                            <b-select v-model="fields.city" @input="loadBarangay" expanded>
                                                <option v-for="(item, index) in cities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Barangay" label-position="on-border" expanded
                                                :type="this.errors.barangay ? 'is-danger':''"
                                                :message="this.errors.barangay ? this.errors.barangay[0] : ''">
                                            <b-select v-model="fields.barangay" expanded>
                                                <option v-for="(item, index) in barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Street" label-position="on-border"
                                                :type="this.errors.street ? 'is-danger':''"
                                                :message="this.errors.street ? this.errors.street[0] : ''">
                                            <b-input v-model="fields.street"
                                                    placeholder="Street">
                                            </b-input>
                                        </b-field>
                                    </div>
                                </div>

                            </div><!--panelbody-->

                            <div class="panel-footer">
                                <div class="buttons is-right">
                                    <button class="button is-primary">SAVE</button>
                                </div>
                            </div>
                        </div>

                    </form><!--form-->

                </div> <!--column -->
            </div><!--cols-->
        </div><!--section-->
    </div>
</template>
<script>

export default {
    props:{
        propDataId: {
            type: String,
             default: '',
        },

        propData: {
            type: String,
            default: '',
        }

    },

    data(){
        return{
            fields: {
                bhouse_name: '',
                lat: 0,
                long: 0,
                province: '', city: '', barangay: '', street: '',
            },





            errors: {},

            global_bhouse_id: 0,

            provinces: [],
            cities: [],
            barangays: [],

            content: '<h2>I am Example</h2>',
            editorOption: {
                // Some Quill options...
            },

            filterTags: [],
            amenities: [],
            tags: [],

            filteredTagRules: [],
            isSelectOnlyRule: false,
            rules: [],
            tagsRule: [],

        }
    },

    methods: {

        loadMap(){
            //init map

            var init_lat = 0, init_long = 0;

            //init coordinates
            //separate init if edit mode..
            if(this.global_bhouse_id > 0){
                //edit mode
                init_lat = this.fields.lat;
                init_long = this.fields.long; 
            }else{
                init_lat = 8.062958238977133;
                init_long = 123.75316500663757;
            }

            var mymap = L.map('mapid').setView([init_lat, init_long], 17);

            //to call data inside nested function


            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZXRpZW5uZXdheW5lIiwiYSI6ImNrcno0N29seTE2bG0yd2szOXl5OXZ0ZWsifQ.xlNi77GcJmddd9UZTz1Hpw', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiZXRpZW5uZXdheW5lIiwiYSI6ImNrcno0N29seTE2bG0yd2szOXl5OXZ0ZWsifQ.xlNi77GcJmddd9UZTz1Hpw'
            }).addTo(mymap);

            var theMarker = {};

            //edit mode, if it has an ID
            if(this.global_bhouse_id > 0){
                theMarker = L.marker([this.fields.lat,this.fields.long]).addTo(mymap);
            }
            var vm = this.fields;

            mymap.on('click', function(e) {

                //this.fields.lat = e.latlng.lat;
                //this.fields.long = e.latlng.lng;
                let lat = e.latlng.lat;
                let long = e.latlng.lng;

                if(theMarker != undefined){
                    mymap.removeLayer(theMarker);
                }

                theMarker = L.marker([lat,long]).addTo(mymap);
                //assign data to vm
                vm.lat = lat;
                vm.long = long;
            });


        },

        submit: function(){
            //console.log(this.global_bhouse_id);
            var formData = new FormData();
            formData.append('bhouse_name', this.fields.bhouse_name);
            formData.append('bhouse_desc', this.fields.bhouse_desc);
            formData.append('contact_person', this.fields.contact_person);
            formData.append('contact_no', this.fields.contact_no);

            //amenities
            for(let i = 0; i < this.fields.amenities.length; i++){
                formData.append('amenities[]', this.fields.amenities[i].amenity_id);
                //console.log(this.fields.amenities[i].amenity_id);
            }

            //for rules
            for(let i = 0; i < this.fields.rules.length; i++){
                formData.append('rules[]', this.fields.rules[i].rule_id);
            }

            formData.append('bhouse_img_path', this.fields.bhouse_img ? this.fields.bhouse_img : '');
            formData.append('lat', this.fields.lat);
            formData.append('long', this.fields.long);

            formData.append('province', this.fields.province);
            formData.append('city', this.fields.city);
            formData.append('barangay', this.fields.barangay);
            formData.append('street', this.fields.street);

            if(this.global_bhouse_id > 0){
                //udpate
                axios.post('/boarding-house-update/' + this.global_bhouse_id, formData).then(res=>{
                     if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'Updated.',
                            message: 'Boarding house successfully updated.',
                            type: 'is-success',
                            onConfirm: ()=>{
                                window.location = '/boarding-house';
                            }
                        });
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }else{
                //insert
                axios.post('/boarding-house', formData).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'Saved.',
                            message: 'Boarding house successfully saved.',
                            type: 'is-success',
                            onConfirm: ()=>{
                                window.location = '/boarding-house';
                            }
                        });
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }

        },



        ///ADDRESS MODULE
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

         initData: function(){
            this.fields = {};
            this.global_bhouse_id = parseInt(this.propDataId);

            if(this.global_bhouse_id > 0){
                this.fields = JSON.parse(this.propData);
                console.log(this.fields);
                this.getData(this.global_bhouse_id);
                //console.log(this.fields)
            }
        },

        getData: function(data_id){
            //this.isModalCreate = true;
            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/boarding-house/' + data_id).then(res=>{
                //this.fields = res.data;
                var tempData = res.data;

                //load city first
                axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                    //load barangay
                    this.cities = res.data;
                    axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                        this.barangays = res.data;
                        this.fields.barangay = tempData.barangay;
                    });
                });
            });
        },



        //for amenities
        getFilteredTags(text) {
            this.filterTags = this.amenities.filter((option) => {
                return option.amenity
                    .toString()
                    .toLowerCase()
                    .indexOf(text.toLowerCase()) >= 0
            })
        },

        getFilteredTagRules(text){
            this.filteredTagRules = this.rules.filter((option) => {
                return option.rule
                    .toString()
                    .toLowerCase()
                    .indexOf(text.toLowerCase()) >= 0
            })
        },

        loadAmenities(){
            axios.get('/load-open-amenities').then(res=>{
                this.amenities = res.data;
            })
        },

        loadRules(){
            axios.get('/load-open-rules').then(res=>{
                this.rules = res.data;
            })
        },

        removeAmenity(){
            console.log("test");
        }

    },
    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill
        }
    },

    created() {
        this.loadAmenities();
        this.loadRules();
    },

    mounted(){

        this.loadProvince();
        this.initData();
        this.loadMap();
    }


}


</script>


<style scoped>
    #mapid {
        height: 500px;
        z-index: 0;
    }
</style>
