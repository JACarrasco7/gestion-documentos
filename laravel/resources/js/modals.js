
import { Modal } from 'flowbite';

console.log('entra');

// Modal Conditions

const $targetEl = document.getElementById('modalConditions');

if($targetEl){

// options with default values
const options = {
    placement: 'center',
    backdrop: 'static',
    backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
    closable: true,
    onHide: () => {
        console.log('modal is hidden');
    },
    onShow: () => {
        console.log('modal is shown');
    },
    onToggle: () => {
        console.log('modal has been toggled');
    }
};

const modal = new Modal($targetEl, options);
modal.show();

Livewire.on("closeModalConditions", () => {
    modal.hide();
});

}
