import { ref, computed, mergeProps, unref, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderAttr, ssrRenderClass, ssrInterpolate, ssrIncludeBooleanAttr } from "vue/server-renderer";
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
  __name: "unsubscribe",
  __ssrInlineRender: true,
  setup(__props) {
    const form = ref({
      applicationId: "",
      email: ""
    });
    const message = ref({ text: "", type: "" });
    const loading = ref(false);
    const messageClass = computed(() => {
      return message.value.type === "success" ? "bg-green-100 text-green-700 border border-green-500" : "bg-red-100 text-red-700 border border-red-500";
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col items-center justify-center min-h-screen bg-gray-100 px-4" }, _attrs))} data-v-d8b90a26><h1 class="text-4xl font-bold text-center mb-4" data-v-d8b90a26> Unsubscribe from Notifications </h1><p class="text-lg text-center mb-8" data-v-d8b90a26> Enter your Application ID and Email to unsubscribe from status notifications. </p><img${ssrRenderAttr("src", _imports_0)} alt="Logo" class="w-[460px] h-[180px] mb-4" data-v-d8b90a26>`);
      if (message.value.text) {
        _push(`<div class="${ssrRenderClass([unref(messageClass), "w-full max-w-md text-center p-4 mb-4 rounded-lg"])}" data-v-d8b90a26>${ssrInterpolate(message.value.text)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<form class="w-full max-w-md bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" data-v-d8b90a26>`);
      if (loading.value) {
        _push(`<div class="text-blue-500 text-center mb-4" data-v-d8b90a26>Processing your request...</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="mb-4" data-v-d8b90a26><label class="block text-gray-700 text-sm font-bold mb-2" for="applicationId" data-v-d8b90a26> Application ID </label><input type="text" id="applicationId"${ssrRenderAttr("value", form.value.applicationId)} class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your Application ID"${ssrIncludeBooleanAttr(loading.value) ? " disabled" : ""} required data-v-d8b90a26></div><div class="mb-4" data-v-d8b90a26><label class="block text-gray-700 text-sm font-bold mb-2" for="email" data-v-d8b90a26> Email </label><input type="email" id="email"${ssrRenderAttr("value", form.value.email)} class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your Email"${ssrIncludeBooleanAttr(loading.value) ? " disabled" : ""} required data-v-d8b90a26></div><div class="flex items-center justify-between" data-v-d8b90a26><button type="submit"${ssrIncludeBooleanAttr(loading.value) ? " disabled" : ""} class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" data-v-d8b90a26> Unsubscribe </button></div></form><div class="mt-4" data-v-d8b90a26><p class="text-sm text-gray-600" data-v-d8b90a26><a class="text-blue-500 hover:underline cursor-pointer" data-v-d8b90a26> Home </a></p></div></div>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("pages/unsubscribe.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const unsubscribe = /* @__PURE__ */ _export_sfc(_sfc_main, [["__scopeId", "data-v-d8b90a26"]]);
export {
  unsubscribe as default
};
//# sourceMappingURL=unsubscribe-Bk4aZA1V.js.map
