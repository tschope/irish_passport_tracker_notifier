<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 px-4">
        <h1 class="text-4xl font-bold text-center mb-4">
            Unsubscribe from Notifications
        </h1>
        <p class="text-lg text-center mb-8">
            Enter your Application ID and Email to unsubscribe from status notifications.
        </p>
        <Logo />
        <!-- Mensagem de sucesso ou erro -->
        <div v-if="message.text" :class="messageClass" class="w-full max-w-md text-center p-4 mb-4 rounded-lg">
            {{ message.text }}
        </div>
        <form
            class="w-full max-w-md bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
            @submit.prevent="handleUnsubscribe"
        >
            <!-- Loading -->
            <div v-if="loading" class="text-blue-500 text-center mb-4">Processing your request...</div>
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="applicationId"
                >
                    Application ID
                </label>
                <input
                    type="text"
                    id="applicationId"
                    v-model="form.applicationId"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Enter your Application ID"
                    :disabled="loading"
                    required
                />
            </div>

            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="email"
                >
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Enter your Email"
                    :disabled="loading"
                    required
                />
            </div>

            <div class="flex items-center justify-between">
                <button
                    type="submit"
                    :disabled="loading"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                    Unsubscribe
                </button>
            </div>
        </form>
        <FooterLinks :current-route="currentRouteName" />
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useRuntimeConfig } from '#app';

definePageMeta({
    name: 'Unsubscribe',
});
const route = useRoute();
const currentRouteName = computed(() => route.name);

const form = ref({
    applicationId: '',
    email: '',
});

const message = ref({ text: '', type: '' });
const loading = ref(false);

const messageClass = computed(() => {
    return message.value.type === 'success'
        ? 'bg-green-100 text-green-700 border border-green-500'
        : 'bg-red-100 text-red-700 border border-red-500';
});

const config = useRuntimeConfig();

const handleUnsubscribe = async () => {
    loading.value = true;
    try {
        const response = await $fetch(`${config.public.apiBase}/unsubscribe`, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            method: 'POST',
            body: {
                applicationId: form.value.applicationId,
                email: form.value.email,
            },
        });

        if (response.success) {
            message.value = { text: 'You have successfully unsubscribed. Redirecting to the home page...', type: 'success' };

            // Redireciona para a página inicial após 5 segundos
            setTimeout(() => {
                navigateTo('/');
            }, 5000);
        } else {
            throw new Error(response.message || 'Unsubscription failed');
        }
    } catch (error) {
        // Verifica se o erro contém uma resposta estruturada antes de acessar message
        const errorMessage = error?.response?.data?.message || error.message || 'An error occurred while unsubscribing.';
        message.value = { text: errorMessage, type: 'error' };
    } finally {
        loading.value = false;
    }
};

</script>

<style scoped>
form {
    background-color: #f9fafb;
}

button:focus {
    outline: none;
}
</style>
