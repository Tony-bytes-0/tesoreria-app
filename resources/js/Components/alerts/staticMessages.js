import Swal from "sweetalert2"

export const staticError = (propsText) => {
    Swal.fire({
        title: "Error",
        icon: "error",
        text: propsText,
    });
};