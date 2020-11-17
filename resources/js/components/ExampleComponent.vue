<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component. <br>
                        {{ data }}

                        <br>
                        <a @click="test()" id="" class="btn btn-primary" href="#" role="button">Test Pusher</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data:{}
            }
        },
        mounted() {
            Echo.channel(`notify`)
             .listen('Notifications',(e)=>{
               this.data=e
               console.log(e)
             })

        },
        methods: {
            test()
            {
                axios.get('/test/I want to test/Pusher')  
                //CODE
            }
        },

    }
</script>
