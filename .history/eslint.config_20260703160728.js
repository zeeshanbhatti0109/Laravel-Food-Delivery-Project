import js from "@eslint/js";
import vue from "eslint-plugin-vue";
import prettier from "@vue/eslint-config-prettier";

export default [
    {
        ignores: [
            "node_modules/**",
            "vendor/**",
            "storage/**",
            "public/build/**",
            "public/hot/**",
            "bootstrap/cache/**",
            ".history/**",
            "*.log",
            ".eslintrc.cjs",
            "resources/js/.eslintrc.cjs",
        ],
    },
    js.configs.recommended,
    ...vue.configs["flat/essential"],
    prettier,
    {
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
