<template>
    <div>
        <Header></Header>
        <div class="container">
            <transition>
                <router-view />
            </transition>
        </div>
    </div>
</template>

<script>
import Header from './Header';

export default {
    components: {
        Header,
    }
}
</script>

