import "./bootstrap";
import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
import $ from "jquery";
import "./colorTheme";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import "flowbite";
import "./notifications";
import "./accordion";
import "./modals";
window.Alpine = Alpine;

Alpine.plugin(focus);

import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid.css";

Alpine.start();
