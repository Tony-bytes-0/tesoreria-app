export const formatedNumber = (number) => {
    return new Intl.NumberFormat("es-VE", {
        maximumFractionDigits: 2,
        minimumFractionDigits: 2,
    }).format(number);
};