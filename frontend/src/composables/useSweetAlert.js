import Swal from "sweetalert2";

export function useSweetAlert() {

    const questionAlert = async ({ title, confirmButtonText, cancelButtonText, confirmButtonColor }) => {
        const result = await Swal.fire({
            icon: "question",
            title: title || "Deseja continuar?",
            showCancelButton: true,
            confirmButtonText: confirmButtonText || "Sim",
            cancelButtonText: cancelButtonText || "Não",
            confirmButtonColor: confirmButtonColor || "#9b111e",
        });

        return result;
    };

    const successAlert = async ({ title, text }) => {
        await Swal.fire({
            icon: "success",
            title: title || "Sucesso!",
            text: text || "Ação concluída com sucesso.",
            confirmButtonColor: "#198754",
        });
    };

    const errorAlert = async ({ title, text }) => {
        await Swal.fire({
            icon: "error",
            title: title || "Erro!",
            text: text || "Algo deu errado.",
            confirmButtonColor: "#d9534f",
        });
    };

    const infoAlert = async ({ title, text }) => {
        await Swal.fire({
            icon: "info",
            title: title || "Info!",
            text: text || "Algo deu errado.",
            confirmButtonColor: "#d9534f",
        });
    };

    return { questionAlert, successAlert, errorAlert, infoAlert };
}
