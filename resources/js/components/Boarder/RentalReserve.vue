<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    
                    <div class="box">
                        <div class="box-header">
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
        }
    },

    methods: {
        initData(){
            this.rental = this.propRental
        },


        reserveNow(){
            axios.post('/rental-reserve-now', this.rental).then(res=>{
            
            }).catch(err=>{
            
            })
        }
    },

    mounted(){
        this.initData()
    }
}
</script>