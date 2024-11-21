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
