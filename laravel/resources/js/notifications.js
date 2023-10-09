import Swal from "sweetalert2";

// Sweet alerts
Livewire.on("notificationConfirm", (data) => {
    Swal.fire({
        title: "¿Estás seguro?",
        html: data.text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar!",
        cancelButtonText: "No, cancelar!",
        confirmButtonColor: "#3C5485",
        cancelButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emitTo(data.table, data.method, data.id);
        }
    });
});

Livewire.on("notificationAlert", (data) => {

    // Show alert
    Swal.fire(data.title, data.text, data.type);

    // Close modal if Success
    if (data.type == "success") Livewire.emit("closeModal");
});
