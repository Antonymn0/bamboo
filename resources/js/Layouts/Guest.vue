<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div :style="bgColor ? '--theme-color:'+bgColor : ''" class="min-h-screen guest-layout flex flex-col items-center pt-6 sm:pt-0 bg-theme">
        <div>
            <Link href="/">
                <BreezeApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div :class="{'max-w-md':wide}" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<script>

export default {

    props: {
        themeColor:String,
        wide:Boolean,
    },

    data() {
        return {
            bgColor: this.themeColor ? this.themeColor : '',
        }
    },

}
</script>
<style scoped>
.max-w-md{
    max-width: 36rem;
}
</style>
