import "./bootstrap";
import $ from "jquery";
import "datatables.net-dt";

window.$ = $;

window.setTheme = function (theme) {
    if (theme == 'system') localStorage.removeItem('theme');
    else localStorage.setItem('theme', theme);

    applyTheme();
}