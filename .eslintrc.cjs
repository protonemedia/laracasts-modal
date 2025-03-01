/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution');

module.exports = {
    root: true,
    extends: [
        'plugin:vue/vue3-recommended',
        'eslint:recommended',
        '@vue/eslint-config-prettier',
        'plugin:tailwindcss/recommended',
    ],
    parserOptions: {
        ecmaVersion: 'latest',
    },
    rules: {
        'vue/multi-word-component-names': 'off',
        'no-undef': 'off',
        'prettier/prettier': ['error', { usePrettierrc: true }],
        'vue/require-default-prop': 0,
        'vue/no-v-html': 'off',
        'vue/multi-word-component-names': 'off',
        'vue/no-parsing-error': 'warn',
        'tailwindcss/no-custom-classname': 'off',
    },
    parser: 'vue-eslint-parser',
};
