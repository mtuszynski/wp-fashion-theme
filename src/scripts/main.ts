import { BrowserService } from "./services/browser/browser.service";
export const browserService = new BrowserService();

import header from "../components/header/header";
import projectslider from "../components/projects/projects";
import heroslider from "../components/hero-slider/hero-slider";
const UIkit = require('uikit');
const AOS = require('aos/dist/aos');
window.addEventListener(
    "DOMContentLoaded",
    () => {

        header();
        projectslider();
        heroslider();
        const ui = new UIkit;
        AOS.init();
    },
    { once: true }
);