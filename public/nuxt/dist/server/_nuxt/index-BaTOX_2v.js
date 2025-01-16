import { ref, computed, mergeProps, unref, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderAttr, ssrRenderClass, ssrInterpolate, ssrIncludeBooleanAttr, ssrRenderList, ssrLooseContain } from "vue/server-renderer";
import { _ as _imports_0 } from "./logo-CBsPOssQ.js";
import "hookable";
import "destr";
import "klona";
import "defu";
import "#internal/nuxt/paths";
import { _ as _export_sfc } from "../server.mjs";
import "ofetch";
import "unctx";
import "h3";
import "unhead";
import "@unhead/shared";
import "vue-router";
import "radix3";
import "ufo";
const _sfc_main = {
  __name: "index",
  __ssrInlineRender: true,
  setup(__props) {
    const form = ref({
      applicationId: "",
      email: "",
      selectedTimes: [],
      weekends: false
    });
    const message = ref({
      text: "",
      type: ""
      // 'success' ou 'error'
    });
    const times = ["8:00", "10:00", "13:00", "16:00", "18:00"];
    const loading = ref(false);
    const messageClass = computed(() => {
      return message.value.type === "success" ? "bg-green-100 text-green-700 border border-green-500" : "bg-red-100 text-red-700 border border-red-500";
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col items-center justify-center min-h-screen bg-gray-100 px-4" }, _attrs))} data-v-34ea9104><h1 class="text-4xl font-bold mb-4 text-center" data-v-34ea9104> Irish Passport E-mail Notifier </h1><img${ssrRenderAttr("src", _imports_0)} alt="Logo" class="w-[460px] h-[180px] mb-4" data-v-34ea9104><p class="text-lg text-gray-700 mb-8 text-center max-w-2xl" data-v-34ea9104> This website helps you stay updated about your Irish Passport application. Enter your Application ID, Email, choose the times you&#39;d like to receive notifications, and let us keep you informed via email updates. </p>`);
      if (message.value.text) {
        _push(`<div class="${ssrRenderClass([unref(messageClass), "w-full max-w-md text-center p-4 mb-4 rounded-lg"])}" data-v-34ea9104>${ssrInterpolate(message.value.text)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<form class="bg-white shadow-md rounded-lg p-6 w-full max-w-md" data-v-34ea9104>`);
      if (loading.value) {
        _push(`<div class="text-blue-500 text-center mb-4" data-v-34ea9104>Processing your request...</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="mb-4" data-v-34ea9104><label for="applicationId" class="block text-gray-700 font-medium mb-2" data-v-34ea9104> Application ID </label><input${ssrRenderAttr("value", form.value.applicationId)} type="text" id="applicationId" placeholder="Enter your Application ID"${ssrIncludeBooleanAttr(loading.value) ? " disabled" : ""} class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200 disabled:bg-gray-200" required data-v-34ea9104></div><div class="mb-4" data-v-34ea9104><label for="email" class="block text-gray-700 font-medium mb-2" data-v-34ea9104> E-mail </label><input${ssrRenderAttr("value", form.value.email)} type="email" id="email" placeholder="Enter your email"${ssrIncludeBooleanAttr(loading.value) ? " disabled" : ""} class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200 disabled:bg-gray-200" required data-v-34ea9104></div><div class="mb-4" data-v-34ea9104><p class="text-gray-700 font-medium mb-2" data-v-34ea9104> What time(s) would you like to receive notifications? </p><!--[-->`);
      ssrRenderList(times, (time, index2) => {
        _push(`<div class="mb-2" data-v-34ea9104><input type="checkbox"${ssrRenderAttr("value", time)}${ssrIncludeBooleanAttr(Array.isArray(form.value.selectedTimes) ? ssrLooseContain(form.value.selectedTimes, time) : form.value.selectedTimes) ? " checked" : ""}${ssrIncludeBooleanAttr(loading.value || form.value.selectedTimes.length >= 2 && !form.value.selectedTimes.includes(time)) ? " disabled" : ""} id="time-{{ index }}" data-v-34ea9104><label${ssrRenderAttr("for", "time-" + index2)} class="ml-2 text-gray-600" data-v-34ea9104>${ssrInterpolate(time)}</label></div>`);
      });
      _push(`<!--]-->`);
      if (form.value.selectedTimes.length > 2) {
        _push(`<p class="text-red-500 text-sm mt-1" data-v-34ea9104> You can select a maximum of 2 times. </p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="mb-6" data-v-34ea9104><input type="checkbox"${ssrIncludeBooleanAttr(Array.isArray(form.value.weekends) ? ssrLooseContain(form.value.weekends, null) : form.value.weekends) ? " checked" : ""} id="weekends"${ssrIncludeBooleanAttr(loading.value) ? " disabled" : ""} data-v-34ea9104><label for="weekends" class="ml-2 text-gray-700" data-v-34ea9104> Receive notifications on weekends? </label></div><button type="submit"${ssrIncludeBooleanAttr(loading.value) ? " disabled" : ""} class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors disabled:bg-gray-400" data-v-34ea9104> Submit </button></form><div class="mt-4" data-v-34ea9104><p class="text-sm text-gray-600" data-v-34ea9104><a class="text-blue-500 hover:underline cursor-pointer" data-v-34ea9104> Unsubscribe </a><a class="text-blue-500 hover:underline cursor-pointer" data-v-34ea9104> Privacy Policy </a></p></div></div>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("pages/index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const index = /* @__PURE__ */ _export_sfc(_sfc_main, [["__scopeId", "data-v-34ea9104"]]);
export {
  index as default
};
//# sourceMappingURL=index-BaTOX_2v.js.map
