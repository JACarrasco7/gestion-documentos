import { Accordion } from "flowbite";
var accordion;
// create an array of objects with the id, trigger element (eg. button), and the content element

// options with default values
const options = {
    alwaysOpen: true,
    activeClasses: "bg-gray-100 [&>svg]:rotate-180 dark:bg-gray-800 text-gray-900 dark:text-white",
    inactiveClasses: "text-gray-500 dark:text-gray-400",
    // onOpen: (item) => {
    //     console.log("accordion item has been shown");
    //     console.log(item);
    // },
    // onClose: (item) => {
    //     console.log("accordion item has been hidden");
    //     console.log(item);
    // },
    onToggle: (item) => {
        console.log("accordion item has been toggled");
        console.log(item);

    },
};

// Event listener to create accordion
Livewire.on("createAccordion", (data) => {
    setTimeout(() => {
        let accordionItems = [];
        for (let index = 0; index < data; index++) {

            accordionItems.push({
                id: "accordion-flush-heading-" + index,
                triggerEl: document.querySelector(
                    "#accordion-flush-heading-" + index
                ),
                targetEl: document.querySelector(
                    "#accordion-flush-body-" + index
                ),
                active: false,
            });
        }
        // if (accordion) accordion.destroy();
        accordion = new Accordion(accordionItems,options);
    }, 1000);
});
