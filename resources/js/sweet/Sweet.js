import Swal from "sweetalert2";

// Define the toast setup
export const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

export const SAlert = (data) => {
    Swal.fire({
        title: data.title,
        text: data.text,
        icon: data.icon
    });
}

export default Toast
