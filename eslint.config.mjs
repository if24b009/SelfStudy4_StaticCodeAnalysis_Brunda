import js from "@eslint/js";
import globals from "globals";
import tseslint from "typescript-eslint";
import { defineConfig } from "eslint/config";


export default defineConfig([
  { files: ["**/*.{js,mjs,cjs,ts,mts,cts}"], plugins: { js }, extends: ["js/recommended"] },
  {
    files: ["**/*.{js,mjs,cjs,ts,mts,cts}"], languageOptions: {
      globals: {
        ...globals.browser,
        ...globals.node,
        L: "readonly", //fix for 'L' not defined (5 Errors)
        define: "readonly", //fix for 'define' not defined (2 Error)
      },
      parserOptions: { //fix for module, exports, require (4 Errors)
        sourceType: "module",
      },
    },
  },
  tseslint.configs.recommended,
]);
