/* @refresh reload */
import { render } from "solid-js/web";

import "./index.css";
import App from "~/App";

const root = document.getElementById(localize.admin_root_div_id);

if (root) {
    render(() => <App />, root!);
}
