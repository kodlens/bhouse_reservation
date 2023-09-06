<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    
                    <div class="box">
                        <div class="box-header has-text-weight-bold mb-1">
                            RENTAL INORMATION
                        </div>

                        <div class="">
                            <!--parent image or the main rental image-->
                            <div class="box-body">
                                <img :src="`/storage/rentals/${rental.rental_img_path}`" alt="">
                            </div>
                            <!--here if naa pa other images, ma view-->
                            <div>

                            </div>

                        </div> <!--img container-->

                        <!-- description and price about the rental-->
                        <div>
                            <div>
                                {{ rental.rental_name }}
                            </div>
                            <div>
                                {{ rental.rental_desc }}
                            </div>
                            <div>
                                {{ rental.province }}
                            </div>

                            <div>
                                &#8369; {{ rental.price | formatDecimalComma }}
                            </div>
                        </div>

                        <div>
                            <b-button class="is-primary is-outlined"
                                label="Reserve Now" @click="reserveNow"></b-button>
                        </div>
                        
                    </div><!--end box-->
                </div><!-- end col-->
            </div><!-- end cols-->

            <div class="columns mt-4 is-centered">
                <div class="column is-8-desktop is-10-tablet">
                    <div class="has-text-weight-bold mb-1">
                        LOCATION
                    </div>
                    <div id="mapid"></div>
                </div>
            </div>
        </div><!--end section-->
    </div><!--root div-->
</template>

<script>

export default{
    props: {
        propRental: {
            type: Object,
            default: {},
        }
    },
    data(){
        return {
            rental : {},
            data: {}
        }
    },

    methods: {
        initData(){
            this.rental = this.propRental
            this.data = this.propRental
            this.loadNavigator()
        },


        reserveNow(){
            axios.post('/rental-reserve-now', this.rental).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        type: 'is-success',
                        title: 'Reserved.',
                        message: 'Room successfully reserved.',
                        onConfirm: ()=>{
                            window.location = '/my-reservations'
                        }
                    });
                }
            }).catch(err=>{
            
            })
        },


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
            var mymap = L.map('mapid').setView([this.data.boarding_house.lat, this.data.boarding_house.long], 17);
            //to call data inside nested function

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZXRpZW5uZXdheW5lIiwiYSI6ImNrcno0N29seTE2bG0yd2szOXl5OXZ0ZWsifQ.xlNi77GcJmddd9UZTz1Hpw', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiZXRpZW5uZXdheW5lIiwiYSI6ImNrcno0N29seTE2bG0yd2szOXl5OXZ0ZWsifQ.xlNi77GcJmddd9UZTz1Hpw'
            }).addTo(mymap);
            //console.log(this.nlat)
            //add route in leaflet
            L.marker([this.data.boarding_house.lat, this.data.boarding_house.long]).addTo(mymap);

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



    },

    mounted(){
        this.initData()
    }
}
</script>

<style scoped>
    #mapid { height: 500px; z-index: 0;}


</style>