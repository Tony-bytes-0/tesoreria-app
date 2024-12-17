export const formatedNumber = (number) => {
    return new Intl.NumberFormat("es-VE", {
        maximumFractionDigits: 2,
        minimumFractionDigits: 2,
    }).format(number);
};

export const formatedDate = (date) => {
    const today = new Date(date);
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();
    if (dd < 10) dd = "0" + dd;
    if (mm < 10) mm = "0" + mm;

    return dd + "/" + mm + "/" + yyyy;
}

export const totalize = (key) => {
    let total = 0;
    if (items.value.length > 0) {
        items.value.forEach((x) => {
            total += +x[key];
        });
    }
    return total;
};