import js from "@eslint/js";
import vue from "eslint-plugin-vue";
import prettier from "@vue/eslint-config-prettier";

export default [
    {
        ignores: [
            "vendor/**",
            "node_modules/**",
            "public/build/**",
            "storage/**",
            "bootstrap/cache/**",
            "coverage/**",
            ".history/**",
        ],
    },
    js.configs.recommended,
    ...vue.configs["flat/essential"],
    prettier,
    {
        files: ["resources/js/**/*.{js,vue,cjs}"],
        rules: {
            "no-console":
                process.env.NODE_ENV === "production" ? "warn" : "off",
            "no-debugger":
                process.env.NODE_ENV === "production" ? "warn" : "off",
            "vue/multi-word-component-names": "off",
            "no-undef": "off",
        },
    },
];
