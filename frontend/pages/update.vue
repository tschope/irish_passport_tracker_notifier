<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 px-4">
        <!-- Título -->
        <h1 class="text-4xl font-bold mb-4 text-center mt-10 sm:mt-0">
            Irish Passport E-mail Notifier
        </h1>
        <!-- sub Título -->
        <h2 class="text-2xl font-bold mb-4 text-center mt-10 sm:mt-0">
            Details Update
        </h2>
        <Logo />
        <!-- Descrição -->
        <p class="text-lg text-gray-700 mb-8 text-center max-w-2xl">
            Use you Application ID and Email to update your notification preferences.
        </p>
        <!-- Mensagem de sucesso ou erro -->
        <div v-if="message.text" :class="messageClass" class="w-full max-w-md text-center p-4 mb-4 rounded-lg">
            {{ message.text }}
        </div>
        <!-- Formulário -->
        <form @submit.prevent="handleSubmit" class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
            <!-- Loading -->
            <div v-if="loading" class="text-blue-500 text-center mb-4">Processing your request...</div>
            <!-- Application ID -->
            <div class="mb-4">
                <label for="applicationId" class="block text-gray-700 font-medium mb-2">
                    Application ID
                </label>
                <input
                    v-model="form.applicationId"
                    type="text"
                    id="applicationId"
                    placeholder="Enter your Application ID"
                    :disabled="loading || getDetails"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200 disabled:bg-gray-200"
                    required
                />
            </div>
            <!-- E-mail -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">
                    E-mail
                </label>
                <input
                    v-model="form.email"
                    type="email"
                    id="email"
                    placeholder="Enter your email"
                    :disabled="loading"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200 disabled:bg-gray-200"
                    required
                />
            </div>
            <!-- Horários -->
            <div class="mb-4" v-if="getDetails">
                <p class="text-gray-700 font-medium mb-2">
                    What time(s) would you like to receive notifications?
                </p>
                <div v-for="(time, index) in times" :key="index" class="mb-2">
                    <input
                        type="checkbox"
                        :value="time"
                        v-model="form.selectedTimes"
                        :disabled="loading || (form.selectedTimes.length >= 2 && !form.selectedTimes.includes(time))"
                        id="time-{{ index }}"
                    />
                    <label :for="'time-' + index" class="ml-2 text-gray-600">
                        {{ time }}
                    </label>
                </div>
                <p v-if="form.selectedTimes.length > 2" class="text-red-500 text-sm mt-1">
                    You can select a maximum of 2 times.
                </p>
            </div>
            <!-- Dias da Semana -->
            <div class="mb-6" v-if="getDetails">
                <p class="text-gray-700 font-medium mb-2">
                    Select the days of the week you'd like to receive notifications:
                </p>
                <div v-for="(day, index) in daysOfWeek" :key="index" class="mb-2">
                    <input
                        type="checkbox"
                        :value="day"
                        v-model="form.selectedDays"
                        :disabled="loading"
                        id="day-{{ index }}"
                    />
                    <label :for="'day-' + index" class="ml-2 text-gray-600">
                        {{ day }}
                    </label>
                </div>
            </div>
            <!-- Receber aos finais de semana -->
            <div class="mb-6" v-if="getDetails">
                <input type="checkbox" v-model="form.weekends" id="weekends" :disabled="loading" />
                <label for="weekends" class="ml-2 text-gray-700">
                    Receive notifications on weekends?
                </label>
            </div>
            <!-- Botão de enviar -->
            <button
                type="submit"
                :disabled="loading"
                class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors disabled:bg-gray-400"
            >
                Submit
            </button>
        </form>
        <FooterLinks :current-route="currentRouteName" />
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useFetch, useRuntimeConfig } from '#app';

definePageMeta({
    name: 'Update your details',
});
const route = useRoute();
const currentRouteName = computed(() => route.name);

const form = ref({
    applicationId: '',
    email: '',
    selectedTimes: [],
    selectedDays: ['Monday', 'Wednesday', 'Friday'],
    weekends: false,
});

const message = ref({
    text: '',
    type: '', // 'success' ou 'error'
});

const times = ['8:00', '10:00', '13:00', '16:00', '18:00']; // Opções de horários
const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

const loading = ref(false);
const getDetails = ref(false);

const config = useRuntimeConfig();

const messageClass = computed(() => {
    return message.value.type === 'success'
        ? 'bg-green-100 text-green-700 border border-green-500'
        : 'bg-red-100 text-red-700 border border-red-500';
});

const formatTime = (time) => {
    const [hours, minutes] = time.split(':');
    return `${String(hours).padStart(2, '0')}:${minutes}`;
};

const handleSubmit = async () => {
    if (form.value.selectedTimes.length > 2) {
        message.value = {
            text: 'You can select a maximum of 2 times.',
            type: 'error',
        };
        return;
    }

    loading.value = true;
    message.value.text = '';

    if(getDetails.value) {
        await updateDetails();
    } else {
        await getDetailsFromApi();
    }
};

const getFormattedTime = (time) => {
    const [hour, minute] = time.split(':');
    return `${parseInt(hour)}:${minute}`;
};

const getDetailsFromApi = async () => {
    try {
        const response = await fetch(`${config.public.apiBase}/getDetails`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                applicationId: form.value.applicationId,
                email: form.value.email,
            }),
        });

        console.log(response.ok); // Verifica se a resposta tem status 200-299

        if (!response.ok) {
            const errorData = await response.json();
            message.value = {
                text: errorData.message || 'An unexpected error occurred. Please try again later.',
                type: 'error',
            };
            return;
        }

        // Parse do body da resposta
        const responseData = await response.json();

        resetForm();

        form.value.applicationId = responseData.applicationId;
        form.value.email = responseData.email;

        // Formatando e adicionando os horários válidos
        if (responseData.send_time_1) {
            let formattedTime = getFormattedTime(responseData.send_time_1);
            if (times.includes(formattedTime)) {
                form.value.selectedTimes.push(formattedTime);
            }
        }

        if (responseData.send_time_2 && responseData.send_time_2 !== '00:00') {
            let formattedTime = getFormattedTime(responseData.send_time_2);
            if (times.includes(formattedTime)) {
                form.value.selectedTimes.push(formattedTime);
            }
        }

        if (responseData.notification_days) {
            form.value.selectedDays = responseData.notification_days;
        }
        form.value.weekends = responseData.weekends;

        message.value = {
            text: 'Now you can update your notification preferences.',
            type: 'success',
        };
        getDetails.value = true;

    } catch (err) {
        console.error(err); // Log de erro para depuração
        message.value = {
            text: 'Error. An unexpected error occurred. Please try again later.',
            type: 'error',
        };
    } finally {
        loading.value = false;
    }
}

const updateDetails = async () => {
    try {
        const response = await fetch(`${config.public.apiBase}/application-email/${form.value.applicationId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                email: form.value.email,
                send_time_1: formatTime(form.value.selectedTimes[0] || '00:00'),
                send_time_2: formatTime(form.value.selectedTimes[1] || '00:00'),
                notification_days: form.value.selectedDays,
                weekends: form.value.weekends,
            }),
        });

        if (!response.ok) {
            const errorData = await response.json();
            message.value = {
                text: errorData.message || 'An unexpected error occurred. Please try again later.',
                type: 'error',
            };
            return;
        }

        message.value = {
            text: 'Your notification preferences have been updated successfully.',
            type: 'success',
        };

        resetForm()
        getDetails.value = false;

    } catch (err) {
        message.value = {
            text: 'An unexpected error occurred. Please try again later.',
            type: 'error',
        };
    } finally {
        loading.value = false;
    }
}

const resetForm = () => {
    form.value.applicationId = '';
    form.value.email = '';
    form.value.selectedTimes = [];
    form.value.selectedDays = [];
    form.value.weekends = false;
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
