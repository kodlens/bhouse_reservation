<template>
    <div>

        <div class="columns">
            <div class="column is-8 is-offset-2">

                <div class="section">
                    <div class="">
                        <div class="columns">
                            <div class="column">
                                
                                <div class="line-design"></div>
                                <div class="display-bhouse">
                                    <div class="left-item">
                                        <div class="bhouse-image">
                                            <img :src="`/storage/bhouses/${data.bhouse_img_path}`" />
                                        </div>
    
                                        <div class="bhouse-right">
                                            <div class="bhouse-title">
                                                {{data.bhouse_name}}
                                            </div>
                                            <div class="desc"> Amenities: </div>
                                            <div class="bhouse-desc">
                                                <span v-for="(i, ix) in data.amenities" :key="ix">{{ i.amenity }}, </span>
                                            </div>
                                            <div class="desc"> Description: </div>
                                            <div class="bhouse-desc">
                                            {{ data.bhouse_desc }}
                                            </div>
                                            <div class="landname"> Landowner: </div>
                                            <div class="landnames">
                                                {{ data.owner.fname }} {{ data.owner.mname }} {{ data.owner.lname }}
                                            </div>
                                            <div class="conno"> Contact No.: </div>
                                            <div class="connos">
                                            {{ data.owner.contact_no }}
                                            </div>
                                            <div class="loc"> Location: </div>
                                            <div class="locs">
                                                {{ data.street }}, {{ data.barangay.brgyDesc }}, {{ data.city.citymunDesc}}, {{ data.province.provDesc }}
                                            </div>
                                            <div class="loc"> Rules and Regulations in the Boarding House: </div>
                                            <div class="rules-content locs">
                                                <div v-for="(i, ix) in data.rules" :key="ix">
                                                    {{ i.rule }}
                                                </div>
                                            </div>
    
                                            <div class="buttons mt-5 is-centered">
                                                <b-button type="is-link" tag="a" :href="`/client-bh-rooms/${bhouse_id}`">VIEW ROOMS</b-button>
                                            </div>
                                        </div>
                                    </div><!--left-item-->
    
                                    <div class="right-item">
                                        <!-- <div class="location-title">Location</div> -->
                                        <div id="mapid"></div>
                                    </div>
                                </div> <!--display bhouse div-->
                                
                            </div>
                        </div><!--cols-->


                    </div>
                </div><!-- section -->


                


            </div>
        </div>

    </div>
</template>


<script>


export default {

    props: {
        propData:{
            type: String,
            default: '',
        },
        propBhouseId : {
            type: String,
            default: '',
        }
    },
    data() {
        return{
            data: [],
            //position: {},

            nlat: 0,
            nlong: 0,

            bhouse_id: 0,
        }

    },

    methods: {

        loadNavigator(){
            if(navigator.geolocation){
                navigator.permissions.query({ name: 'geolocation' }).then(permission=>{
                    // if(permission.state === 'denied'){
                    //     alert('Please allow us to record your location.');
                    //     return;
                    // }
                    navigator.geolocation.getCurrentPosition(this.getPosition);

                    this.loadMap();
                })

            }else{
                //this.camera = 'off';
                alert('Geolocation is not supported by this browser but still you can continue using the scanner.');
            }
        },

        getPosition(position) {
            //console.log(position.coords.latitude, position.coords.longitude);
            //this.position.lat = position.coords.latitude;
            //this.position.long = position.coords.longitude;
            this.nlat = position.coords.latitude;
            this.nlong = position.coords.longitude;

        },

        loadMap(){
            //init map


            var mymap = L.map('mapid').setView([this.data.lat, this.data.long], 17);
            //to call data inside nested function

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZXRpZW5uZXdheW5lIiwiYSI6ImNrcno0N29seTE2bG0yd2szOXl5OXZ0ZWsifQ.xlNi77GcJmddd9UZTz1Hpw', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiZXRpZW5uZXdheW5lIiwiYSI6ImNrcno0N29seTE2bG0yd2szOXl5OXZ0ZWsifQ.xlNi77GcJmddd9UZTz1Hpw'
            }).addTo(mymap);
            console.log(this.nlat)
            //add route in leaflet
            L.marker([this.data.lat, this.data.long]).addTo(mymap);

            // L.Routing.control({
            //     waypoints: [
            //         L.latLng(this.nlat, this.nlong),//bhouse coordiantes
            //         //L.latLng(this.data.lat, this.data.long)//current location coordinates
            //     ]
            // }).addTo(mymap);


            // var popup = L.popup()
            //     .setLatLng(this.nlat, this.nlong)
            //     .setContent('<p>Hello world!</br>This is a nice popup.</p>')
            //     .openOn(map);


        }, //load map

        loadData(){
            // axios.get('/get-bhouse-detail/' + this.bhouse_id).then(res=>{
            //     this.data = res.data;
            //     console.log(this.data)
            // });
            this.data = JSON.parse(this.propData)[0];

            console.log(this.data);
        },


        initData: function(){
            //this.data = JSON.parse(this.propData);
            this.bhouse_id = parseInt(this.propBhouseId);
            this.loadData();
        }


    },

    created(){
        this.initData();
    },

    mounted() {

       this.loadNavigator();

        //this.loadMap();

    }
}
</script>

<style scoped>


    .bhouse-title{
        font-size: 1.5em;
        font-weight: bold;
        color: blue;
    }
    .desc{
        font-size: 1em;
        margin-top: 5px;
        font-weight: bold;
    }
    .landname{
        font-size: 1em;
        margin-top: 5px;
        font-weight: bold;
    }
    .landnames{
        margin-left: 6em;
    }
    .conno{
        font-size: 1em;
        margin-top: 5px;
        font-weight: bold;
    }
    .connos{
        margin-left: 6em;
    }

    .bhouse-desc{
        font-size: 1em;
        margin-left: 6em;

    }
    .loc{
        font-size: 1em;
        margin-top: 5px;
        font-weight: bold;
    }
    .locs{
        margin-left: 6em;
    }
    .bhouse-loc{
        margin-top: 15px;
        margin-left: 3em;

    }
    .column{
        padding: 2em;
        background: white;


    }

    .title{
    color:blue;
    font-weight: bold;
    padding-left: 4.5em;

    }

    .rules-content{
        list-style-type: circle;
    }

    .buttons mt-5{
        margin-left: 2em;
    }


    .location-title{
        font-weight: bold;
        font-size: 1.3em;
    }
    #mapid { height: 500px; z-index: 0;}


    .display-bhouse{
        display: flex;

    }


    .left-item{
        display: flex;
        flex-direction: column;
        width: 50%;
        padding: 10px;
    }
    .right-item{
        padding: 10px;
        width: 50%;
    }

    .line-design{
        height: 10px;
        width: 100%;
        background-color: rgb(85, 85, 255);
    }


</style>
