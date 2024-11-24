const Formatters = {
    VED: {
        format: function (val) {
            return (
                "Bs. " +
                Intl.NumberFormat("es-VE", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2,
                }).format(val)
            );
        },
    },
    USD: Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }),
    EUR: Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "EUR",
    }),
    PTR: {
        format: function (val) {
            return (
                "PTR " +
                Intl.NumberFormat("es-VE", {
                    maximumFractionDigits: 8,
                    minimumFractionDigits: 2,
                }).format(val)
            );
        },
    },
};

export class Currency {
    static format(number, currency) {
        if (typeof Formatters[currency] === "undefined") {
            throw new Error(
                "No existe la moneda de cambio indicada " + currency
            );
        }
        return Formatters[currency].format(number);
    }
}
