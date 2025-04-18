<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-6">
        <div class="bg-white shadow-md rounded-lg max-w-3xl p-8">
            <!-- Título -->
            <h1 class="text-4xl font-bold mb-4 text-center">
                Irish Passport E-mail Notifier
                Privacy Policy
            </h1>
            <Logo />
            <p class="text-gray-600 mb-4 text-center">
                Last updated: <span>{{ lastUpdated }}</span>
            </p>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">1. Information We Collect</h2>
                <p class="text-gray-700 mb-2">
                    We collect the following information when you use our service:
                </p>
                <ul class="list-disc pl-6 text-gray-700">
                    <li>
                        <strong>Email:</strong> Used to send notifications related to your
                        application status. This information is encrypted in our database
                        and only decrypted during the email sending process.
                    </li>
                    <li>
                        <strong>Application ID:</strong> Required to identify and track the
                        status of your application.
                    </li>
                </ul>
                <p class="text-gray-700 mt-2">
                    <strong>Note:</strong> We do not store records of emails sent, only
                    basic logs for auditing and monitoring purposes.
                </p>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">2. How We Use Your Information</h2>
                <p class="text-gray-700">
                    The information collected is exclusively used for the following
                    purposes:
                </p>
                <ul class="list-disc pl-6 text-gray-700">
                    <li>Sending notifications about your application status.</li>
                    <li>Ensuring the proper functionality of the service.</li>
                </ul>
                <p class="text-gray-700 mt-2">
                    <strong>We do not use your information for marketing, sales, or
                        sharing with third parties.</strong>
                </p>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">3. Data Storage and Security</h2>
                <p class="text-gray-700">
                    - Your data is stored encrypted in our database using a private and
                    restricted encryption key. <br />
                    - Only authorized personnel have access to the encryption key and
                    information required for the service's functionality.
                </p>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">
                    4. Unsubscription and Data Deletion
                </h2>
                <p class="text-gray-700">
                    You can unsubscribe at any time. Upon doing so:
                </p>
                <ul class="list-disc pl-6 text-gray-700">
                    <li>Your email and Application ID will be permanently deleted from
                        our database.</li>
                    <li>No records will be retained after deletion.</li>
                </ul>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">5. Traffic Monitoring</h2>
                <p class="text-gray-700">
                    We use <strong>Google Analytics</strong> to monitor traffic and
                    understand how users interact with our service. This monitoring is
                    conducted anonymously and does not involve the collection of
                    personally identifiable information.
                </p>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">6. Security</h2>
                <p class="text-gray-700">
                    We take strict measures to protect your information against
                    unauthorized access, use, or disclosure. However, no data
                    transmission over the internet is entirely secure, and we cannot
                    guarantee absolute security.
                </p>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">7. Transparency</h2>
                <p class="text-gray-700">
                    For full transparency, the source code of this website is publicly
                    available. You can review it here:
                </p>
                <p>
                    <a
                        href="https://github.com/tschope/irish_passport_tracker_notifier"
                        target="_blank"
                        class="text-blue-600 underline hover:text-blue-800"
                    >
                        GitHub Repository: Irish Passport Tracker Notifier
                    </a>
                </p>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">8. Changes to This Policy</h2>
                <p class="text-gray-700">
                    We reserve the right to update this Privacy Policy periodically. Any
                    changes will be notified through our website and will take effect
                    immediately after publication.
                </p>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-semibold mb-2">9. Contact Us</h2>
                <p class="text-gray-700">
                    If you have any questions or concerns about this Privacy Policy,
                    please contact us at: <br />
                    <a
                        href="mailto:tschope@gmail.com"
                        class="text-blue-600 underline hover:text-blue-800"
                    >
                        tschope@gmail.com
                    </a>
                </p>
            </section>
        </div>
        <FooterLinks :current-route="currentRouteName" />
    </div>
</template>

<script setup>
import { computed } from "vue";

definePageMeta({
    name: 'Privacy Policy',
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
