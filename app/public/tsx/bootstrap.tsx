import { h, render } from "preact";
import { MotionsPanel } from "./MotionsPanel";

import initByClass from "widgety";
import type { WidgetClassBinding } from "widgety";

import { startMessageProcessing } from "danack-message";


let panels: WidgetClassBinding[] = [
    {
        class: 'motions_panel',
        component: MotionsPanel
    }
];

initByClass(panels, h, render);

startMessageProcessing();

console.log("bootstrap finished");



