<template>

    <div>
        <div class="section">
      
            <h1 class="title is-4 has-text-centered">ROOMS</h1>
                <div class="room-container">
                    <div v-for="(item, index) in rooms" :key="index">
                        <div class="card">
                            <div class="card-image">
                                <figure class="image">
                                    <img :src="'/storage/rooms/' + item.room_img_path" alt="Placeholder image">
                                </figure>
                                <img  />
                            </div>
                            <div class="card-content">
                                <div class="room-title">
                                    {{ item.room_no }}
                                </div>
                                <div class="room-desc">
                                    {{ item.room_desc }}
                                </div>
                                <div class="buttons is-centered mt-5">
                                    <button class="button is-link" @click="openBedSpaces(item.room_id, 0)">VIEW BED SPACES</button>
                                </div>
                            </div>
                        </div><!--room loop -->
                    </div>
                </div><!--room-container -->
            </div>

        <hr>

        <div class="section" id="bedspaces">
            <div v-for="(item, index) in bedspaces" :key="index">
                <div class="bedspace-container">
                    
                    <div class="w-card">

                        <div class="w-bed-title">{{ item.bedspace_name }}</div>
                        
                        <div class="bedspace-img">
                            <div v-for="(iImg, index) in item.imgs" :key="index">
                               <img :src="`/storage/bedspaces/${iImg.bedspace_img_path}`" @click="showImageModal(iImg, item)" class="b-img"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <!-- <div class="columns">
                <div class="column">
                    <h1 class="title is-4 has-text-centered">BED SPACES</h1>

                    <div class="bedspace-container" >
                        <div class="bedspace-images-container">
                            <div v-for="(iImg, index) in item.imgs" :key="index" class="bedspace-imgs room-image">
                                <img :src="`/storage/bedspaces/${iImg.bedspace_img_path}`" @click="showImageModal(iImg, item)"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>




        <!--modal create-->
 
        <b-modal v-model="modalZoomImage" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="reserveNow(bedspaceInfo.bedspace_id)">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">{{ bedspaceInfo.name }}</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalZoomImage = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <div style="display: flex; justify-content: center;">
                                        <img :src="`/storage/bedspaces/${bedspaceInfo.img}`" style="margin: 0 auto;"/>
                                    </div>
                                    <div class="bedspace-detail">
                                        <div>
                                            <span style="font-weight: bold;">DESCRIPTION: </span> {{ bedspaceInfo.desc }}
                                        </div>
                                        <div>
                                            <span style="font-weight: bold;">PRICE: </span> {{ bedspaceInfo.price }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="modalZoomImage=false"/>
                        <!-- <button
                            label="Save"
                            class="button is-link">RESERVE</button> -->
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->



    </div> <!-- div root-->



</template>


<script>
export default {

    props: {
        propData:{
            type: String,
            default: '',
        }
    },

    data(){
        return{
            bhouse_id: 0,
            rooms: [],

            bedspaces: [],

            modalZoomImage: false,
            bedspaceInfo: {},


            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },


        }
    },
    methods: {
        loadBhRooms: function(){
            axios.get('/get-client-bh-rooms/' + this.bhouse_id).then(res=>{
                this.rooms = res.data;
            });
        },


        openBedSpaces: function(dataId, flag){
            axios.get('/get-client-bhroom-bedspaces/' + dataId).then(res=>{
                if(flag === 0){
                    if(res.data.length === 0){
                        this.$buefy.toast.open({
                            message: 'No result found.',
                            position: 'is-bottom',
                            type: 'is-danger'
                        })
                    }
                }

                this.bedspaces = res.data;

                var element = document.getElementById("bedspaces");
                element.scrollIntoView({behavior: "smooth", block: "center"});

            });
        },

        showImageModal: function(bedspaceDataImg, bedspaceData){
           

            this.bedspaceInfo.img = bedspaceDataImg.bedspace_img_path;
            this.bedspaceInfo.name = bedspaceData.bedspace_name;
            this.bedspaceInfo.price = bedspaceData.price;
            this.bedspaceInfo.desc = bedspaceData.bedspace_desc;
            this.bedspaceInfo.bedspace_id = bedspaceData.bedspace_id;
            //console.log(bedspaceDataImg)
            this.modalZoomImage = true;

        },

        reserveNow: function(dataId){

            axios.post('/client-bhroom-bedspace-reserve/' + dataId).then(res=>{
                if(res.data.status === 'reserved'){
                    this.$buefy.dialog.alert({
                        title: 'RESERVED',
                        message: 'Thank you for choosing us. The bed space was successfully reserved and the payment will be expected before 24 hours. Please send a proof of transaction using your account. You may contact us for more information.',
                        type: 'is-success',
                        onConfirm: ()=>{
                            this.openBedSpaces(dataId, 1);
                            //set 1 to avoid checking for length of array fetching bedspaces
                            this.modalZoomImage = false;
                        }
                    });
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    if(err.response.data.errors === 'active'){
                        this.$buefy.dialog.alert({
                            message: 'You have an active reservation. Please settle it first. Thank you.',
                            type: 'is-warning',
                            title: 'ACTIVE BOOK DETECTED!'
                        })
                    }
                }
                if(err.response.status === 401){
                    this.$buefy.toast.open({
                        message: 'Sorry you can\'t proceed without an account. Please register and login first.',
                        type: 'is-danger',
                        //title: 'UNAUTHORIZED!'
                    })
                }
            });
        },

        initData: function(){
            this.rooms = JSON.parse(this.propData);
        }
    },

    mounted(){
        this.initData();
    }
}
</script>

<style scoped>

    .card{
        height: auto;
        width: 350px;
        margin: 10px;
    }
    .room-container{
        display: flex;
        justify-content: center;
    }

    .room-title, .bedspace-title{
        font-weight: bold;
    }


    .room-button{
        position: absolute;
        bottom: 10px;
    }


    .room{
        margin: 80px;
        padding: 40px;
        border-radius: 5px;
        height: 400px;
        position: relative;
        background:rgb(7, 79, 151);
        transition: ease-in-out .5s;
    }


   
    .bedspace-title{
        margin-bottom: 15px;
    }





    .bedspace-detail{
        margin: 15px 0;
        color:  solid black;

    }
  
    .room-desc{
        margin-left: 15px;
    }


 


    .bedspace-container{
        display: flex;
        justify-content: center;
        flex-direction: column;
    }

    .w-card{
        display: flex;
        flex-direction: column;
        background-color: white;
        margin-top: 15px;
        justify-content: 15px auto 0 auto;
    }
    .w-bed-title{
        font-weight: bold;
        font-size: 20px;
        margin: 15px;
        border-bottom: 1px solid rgb(0, 14, 138);
        text-align: center;
    }

    .bedspace-img{
        display: flex;
        justify-content: center;
    }

    .b-img{
        width: 250px; 
        object-fit:cover;
        margin: 25px;
    }


    .img-container{
         display: flex;
    }
</style>
