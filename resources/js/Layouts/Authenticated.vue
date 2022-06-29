<script setup>
import AppNav from '@/Components/AppNav.vue';

defineProps({
    hideNavItems: Boolean,
});

</script>

<template>
    <div>
        <div class="min-h-screen">            
            <AppNav :hideNavItems="hideNavItems" />
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
