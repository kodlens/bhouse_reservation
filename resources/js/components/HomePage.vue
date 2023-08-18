<template>
    <div>
        <section class="hero is-primary is-fullheight-with-navbar">
            <!-- Hero content: will be in the middle -->
            <div class="hero-body">
                <div class="banner-wrapper animate__animated animate__backInLeft">
                    <p class="title banner-text animate__animated animate__backInLeft">
                        WEB-BASED BOARDING HOUSE LOCATOR
                    </p>
                    <p class="subtitle banner-sub-text animate__animated animate__backInRight">
                        A web base boarding house locator.
                    </p>
                    <blockquote>
                        Choose the boarding house that appeals to you the most.
                    </blockquote>
                </div>
            </div>

            <!-- Hero footer: will stick at the bottom -->
            <div class="hero-foot">

            </div>
        </section>

        <section class="section">
            <boarding-house-list></boarding-house-list>
<!--            <search-boarding-houses></search-boarding-houses>-->
        </section>


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


}
</script>


<style scoped>

    .banner-wrapper{

        margin: auto;
        padding: 40px;
        background: rgb(46, 46, 46);
        color:white;
        border-radius: 10px;
        text-align: center;

/*
        position: absolute;
        top: 0; */

    }
    .banner-text{
        font-size: 2em;
    }

     .banner-sub-text{
        font-size: 1em;
    }

    blockquote{
        font-size: .8em;
        font-style: italic;
    }

</style>
