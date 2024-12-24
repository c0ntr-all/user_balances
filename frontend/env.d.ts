/// <reference types="vite/client" />
interface ImportMetaEnv {
  readonly VITE_FOOTER_COPYRIGHT: string;
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}
