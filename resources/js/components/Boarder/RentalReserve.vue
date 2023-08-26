<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    
                    <div class="box">
                        <div class="box-header">

                        </div>
                        <div class="box-body">
                            <img :src="`/storage/rentals/${rental.rental_img_path}`" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        }
    },

    mounted(){
        this.initData()
    }
}
</script>