<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-6">
        <div class="bg-white shadow-md rounded-lg max-w-3xl p-8">
            <!-- Título -->
            <h1 class="text-4xl font-bold mb-4 text-center">
                Irish Passport E-mail Notifier
            </h1>
            <!-- sub Título -->
            <h2 class="text-2xl font-bold mb-4 text-center mt-10 sm:mt-0">
                Donate me a pint
            </h2>
            <p class="text-gray-600 mb-4 text-center">
                <img
                    src="@/assets/images/revolut_me.jpg"
                    alt="Logo"
                    class="w-[216px] h-[216px] mb-4 sm:w-[216px] sm:h-[216px] sm:ml-auto sm:mr-auto"
                />
                <a href="https://revolut.me/tschope" target="_blank" class="text-blue-500 hover:underline cursor-pointer mr-6">Revolut me</a>
            </p>

        </div>
        <FooterLinks :current-route="currentRouteName" />
    </div>
</template>

<script setup>
import { computed } from "vue";

definePageMeta({
    name: 'Donate me a pint🍻',
});
const route = useRoute();
const currentRouteName = computed(() => route.name);

const lastUpdated = "January 17, 2025";
</script>

<style scoped>
body {
    font-family: Arial, sans-serif;
}
</style>
