<template>
    <div class="mt-4 mb-12 sm:mb-2">
        <p class="text-sm text-gray-600">
            <template v-for="item in menuItems">
                <NuxtLink
                    v-if="item.label !== currentRouteName"
                    :key="item.path"
                    :to="{ name: item.label }"
                    class="text-blue-500 hover:underline cursor-pointer mr-6"
                >
                    {{ item.label }}
                </NuxtLink>
            </template>
        </p>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useRoute, useRouter } from 'nuxt/app';

const menuItems = ref([
    {
        label: 'Home',
        path: 'index',
    },
    {
        label: 'Update your details',
        path: 'update',
    },
    {
        label: 'Unsubscribe',
        path: 'unsubscribe',
    },
    {
        label: 'Privacy Policy',
        path: 'privacy',
    },
    {
        label: 'Donate me a pint🍻',
        path: 'donate-to-me',
    }
]);

const route = useRoute();
const router = useRouter();

// Obtemos o nome da rota atual
const currentRouteName = computed(() => route.name);
</script>
