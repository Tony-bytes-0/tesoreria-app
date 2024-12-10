import Swal from "sweetalert2";

export const staticError = (propsText) => {
    Swal.fire({
        title: "Error",
        icon: "error",
        text: propsText,
    });
};

export const staticSucces = (propsText) => {
    Swal.fire({
        icon: "success",
        text: propsText,
        title: "Listo!",
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });
};

export const fastMsg = (propsText) => {
    const toast = Swal.mixin({
        toast: true,
        icon: "info",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        position: "top-end",
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });
    toast.fire({
        icon:"success", title: propsText
    })
}
