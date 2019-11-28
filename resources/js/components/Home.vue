<template>
    <div class="home">
        <img alt="Vue logo" src="https://upload.wikimedia.org/wikipedia/commons/f/f1/Vue.png" />
        <HelloWorld msg="Welcome to Your Vue.js App" />
        <h1>{{ welcome }}</h1>
    </div>
</template>


<script>
    import HelloWorld from './HelloWorld.vue';

    export default {
        components: {
            HelloWorld,
        },
        computed: {
            welcome() {
                return this.$store.getters.welcome;
            }
        }
    };

</script>
