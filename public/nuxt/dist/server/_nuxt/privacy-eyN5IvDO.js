import { mergeProps, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrInterpolate } from "vue/server-renderer";
import "hookable";
import { _ as _export_sfc } from "../server.mjs";
import "ofetch";
import "#internal/nuxt/paths";
import "unctx";
import "h3";
import "unhead";
import "@unhead/shared";
import "vue-router";
import "radix3";
import "defu";
import "ufo";
const lastUpdated = "January 16, 2025";
const _sfc_main = {
  __name: "privacy",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col items-center justify-center min-h-screen bg-gray-100 p-6" }, _attrs))} data-v-76a0f223><div class="bg-white shadow-md rounded-lg max-w-3xl p-8" data-v-76a0f223><h1 class="text-2xl font-bold mb-4 text-center" data-v-76a0f223>Privacy Policy</h1><p class="text-gray-600 mb-4 text-center" data-v-76a0f223> Last updated: <span data-v-76a0f223>${ssrInterpolate(lastUpdated)}</span></p><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223>1. Information We Collect</h2><p class="text-gray-700 mb-2" data-v-76a0f223> We collect the following information when you use our service: </p><ul class="list-disc pl-6 text-gray-700" data-v-76a0f223><li data-v-76a0f223><strong data-v-76a0f223>Email:</strong> Used to send notifications related to your application status. This information is encrypted in our database and only decrypted during the email sending process. </li><li data-v-76a0f223><strong data-v-76a0f223>Application ID:</strong> Required to identify and track the status of your application. </li></ul><p class="text-gray-700 mt-2" data-v-76a0f223><strong data-v-76a0f223>Note:</strong> We do not store records of emails sent, only basic logs for auditing and monitoring purposes. </p></section><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223>2. How We Use Your Information</h2><p class="text-gray-700" data-v-76a0f223> The information collected is exclusively used for the following purposes: </p><ul class="list-disc pl-6 text-gray-700" data-v-76a0f223><li data-v-76a0f223>Sending notifications about your application status.</li><li data-v-76a0f223>Ensuring the proper functionality of the service.</li></ul><p class="text-gray-700 mt-2" data-v-76a0f223><strong data-v-76a0f223>We do not use your information for marketing, sales, or sharing with third parties.</strong></p></section><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223>3. Data Storage and Security</h2><p class="text-gray-700" data-v-76a0f223> - Your data is stored encrypted in our database using a private and restricted encryption key. <br data-v-76a0f223> - Only authorized personnel have access to the encryption key and information required for the service&#39;s functionality. </p></section><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223> 4. Unsubscription and Data Deletion </h2><p class="text-gray-700" data-v-76a0f223> You can unsubscribe at any time. Upon doing so: </p><ul class="list-disc pl-6 text-gray-700" data-v-76a0f223><li data-v-76a0f223>Your email and Application ID will be permanently deleted from our database.</li><li data-v-76a0f223>No records will be retained after deletion.</li></ul></section><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223>5. Traffic Monitoring</h2><p class="text-gray-700" data-v-76a0f223> We use <strong data-v-76a0f223>Google Analytics</strong> to monitor traffic and understand how users interact with our service. This monitoring is conducted anonymously and does not involve the collection of personally identifiable information. </p></section><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223>6. Security</h2><p class="text-gray-700" data-v-76a0f223> We take strict measures to protect your information against unauthorized access, use, or disclosure. However, no data transmission over the internet is entirely secure, and we cannot guarantee absolute security. </p></section><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223>7. Transparency</h2><p class="text-gray-700" data-v-76a0f223> For full transparency, the source code of this website is publicly available. You can review it here: </p><p data-v-76a0f223><a href="https://github.com/tschope/irish_passport_tracker_notifier" target="_blank" class="text-blue-600 underline hover:text-blue-800" data-v-76a0f223> GitHub Repository: Irish Passport Tracker Notifier </a></p></section><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223>8. Changes to This Policy</h2><p class="text-gray-700" data-v-76a0f223> We reserve the right to update this Privacy Policy periodically. Any changes will be notified through our website and will take effect immediately after publication. </p></section><section class="mb-6" data-v-76a0f223><h2 class="text-lg font-semibold mb-2" data-v-76a0f223>9. Contact Us</h2><p class="text-gray-700" data-v-76a0f223> If you have any questions or concerns about this Privacy Policy, please contact us at: <br data-v-76a0f223><a href="mailto:tschope@gmail.com" class="text-blue-600 underline hover:text-blue-800" data-v-76a0f223> tschope@gmail.com </a></p></section></div><div class="mt-4" data-v-76a0f223><p class="text-sm text-gray-600" data-v-76a0f223><a class="text-blue-500 hover:underline cursor-pointer" data-v-76a0f223> Home </a><a class="text-blue-500 hover:underline cursor-pointer" data-v-76a0f223> Unsubscribe </a></p></div></div>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("pages/privacy.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const privacy = /* @__PURE__ */ _export_sfc(_sfc_main, [["__scopeId", "data-v-76a0f223"]]);
export {
  privacy as default
};
//# sourceMappingURL=privacy-eyN5IvDO.js.map
