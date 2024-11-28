<template>
    <!-- <v-chip class="ma-2" label> Datos de la orden </v-chip> -->
    <v-divider :thickness="7">Datos de la orden de pago</v-divider>
    <v-form class="p-2" @submit.prevent>
        <v-row align="center">
            <v-col cols="2"></v-col>

            <v-col cols="4">
                <v-autocomplete
                    label="Beneficiario"
                    v-model="ordenDePagoElectronico.beneficiario"
                    item-title="descripcion"
                    item-value="descripcion"
                    :items="props.beneficiarios"
                    return-object
                >
                    <template v-slot:item="{ props, item }">
                        <v-list-item
                            v-bind="props"
                            :title="item.raw.descripcion"
                            :text="item.raw.descripcion"
                            :subtitle="
                                item.raw.rif +
                                ' cuenta: ' +
                                item.raw.codigo_cuenta
                            "
                        ></v-list-item>
                    </template>
                </v-autocomplete>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.factura"
                    label="Número de factura"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    type="number"
                    v-model="ordenDePagoElectronico.monto_total"
                    label="Monto total"
                ></v-text-field>
            </v-col>
            <v-col cols="1"></v-col>
        </v-row>
        <v-row>
            <v-col cols="2"></v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.retencion_islr"
                    label="Monto retención ISLR"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.autorizacion"
                    label="Nº Autorización"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark custom-input"
                    v-model="transferencia"
                    label="Monto transferencia"
                    disabled
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="comision_bancaria"
                    label="Comision bancaria"
                    disabled
                ></v-text-field>
            </v-col>
            <v-col cols="2"></v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.concepto"
                    label="Concepto ( opcional )"
                ></v-text-field>
            </v-col>
        </v-row>

        <v-row>
            <v-col
                cols="12"
                class="justify-center items-center p-6 mx-auto flex"
            >
                <!-- <v-btn @click="() => console.log(ordenDePagoElectronico)"> -->
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="primary"
                    type="submit"
                    @click="handleAddToList"
                >
                    +
                </v-btn>
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="success"
                    @click="submit"
                >
                    Procesar
                </v-btn>
            </v-col>
        </v-row>

        <v-row> </v-row>
    </v-form>
</template>
<script setup>
import { computed, onMounted, ref } from "vue";
import "vuetify/styles";
import "vuetify";
import { staticError } from "../alerts/staticMessages";

const emit = defineEmits(["addToList", "submit"]);
const props = defineProps(["validateForm", "beneficiarios"]);
console.log("beneficiarios en las props: ", props.beneficiarios);
var ordenDePagoElectronico = ref({
    //fecha: "", datos ahora fuera del formulario
    //tipo: "",
    //referencia: "",
    beneficiario: "",
    factura: "",
    monto_total: "",
    //
    retencion_islr: "",
    autorizacion: "",
    concepto: "",
});

const id_beneficiario = computed(() => {
    return ordenDePagoElectronico.value.beneficiario.id
})

const transferencia = computed(() => {
    const newValue = parseFloat(
        ordenDePagoElectronico.value.monto_total -
            ordenDePagoElectronico.value.retencion_islr
    );
    return Number(newValue.toFixed(2));
});

const comision_bancaria = computed(() => {
    const newValue = parseFloat(
        0.0025 * ordenDePagoElectronico.value.monto_total.toString()
    );
    return Number(newValue.toFixed(2));
});

const validateForm = (item) => {
    var validationObject = Object.assign({}, item);
    delete validationObject.concepto; //propiedad no validable
    delete validationObject.retencion_islr; //propiedad no validable

    const notEmpty = (x) => {
        return x.length == 0;
    };
    return Object.values(validationObject).some(notEmpty);
};

const resetForm = () => {
    ordenDePagoElectronico.value = {
        beneficiario: "",
        factura: "",
        monto_total: "",
        //
        retencion_islr: "",
        autorizacion: "",
        concepto: "",
    };
};
const handleAddToList = () => {
    if (validateForm(ordenDePagoElectronico.value) && props.validateForm) {
        staticError("Complete el formulario");
    } else {
        console.log(
            "al emitir este es el concepto: ",
            ordenDePagoElectronico.value.concepto
        );
        emit("addToList", {
            ...ordenDePagoElectronico.value,
            transferencia: transferencia.value,
            comision_bancaria: comision_bancaria.value,
            id_beneficiario: id_beneficiario.value
        });
        resetForm();
    }
};

const submit = () => {
    console.log("formualario: ", ordenDePagoElectronico.value);
    emit("submit", { ...ordenDePagoElectronico.value });
};
//autocomplete component

const accProps = (item) => {
    return {
        title: "example of title", // + " - " + item.codigo_cuenta,
        subtitle: "subtitle",
    };
};
const srcs = {
    1: "https://cdn.vuetifyjs.com/images/lists/1.jpg",
    2: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
    3: "https://cdn.vuetifyjs.com/images/lists/3.jpg",
    4: "https://cdn.vuetifyjs.com/images/lists/4.jpg",
    5: "https://cdn.vuetifyjs.com/images/lists/5.jpg",
};
const people = ref([
    { name: "Sandra Adams", group: "Group 1", avatar: srcs[1] },
    { name: "Ali Connors", group: "Group 1", avatar: srcs[2] },
    { name: "Trevor Hansen", group: "Group 1", avatar: srcs[3] },
    { name: "Tucker Smith", group: "Group 1", avatar: srcs[2] },
    // { divider: true },
    // { header: 'Group 2' },
    { name: "Britta Holt", group: "Group 2", avatar: srcs[4] },
    { name: "Jane Smith ", group: "Group 2", avatar: srcs[5] },
    { name: "John Smith", group: "Group 2", avatar: srcs[1] },
    { name: "Sandra Williams", group: "Group 2", avatar: srcs[3] },
]);
</script>

<style scooped>
.custom-option:hover {
    transition: 1s;
    background-color: black;
    opacity: 50;
}
.custom-input:focus {
    background-color: black !important;
}
.custom-dark input {
    color: white !important;
    background-color: #3d3d3d;
}
.custom-dark {
    color: gray !important;
}
.custom-datepicker {
    color: black;
    margin: 20px;
}
.v-autocomplete input {
    --v-input-font-color: rgba(0, 0, 0, 0.87);
    /*--v-input-group-adaptive-elevation: 2px;*/
    background-color: #3d3d3d;
    border-color: inherit;
    border: 0cm;
    margin: 0;
    padding: 0;
    size: 1;
    height: 100%;
    width: 100%;
}
.v-autocomplete div {
    /*background-color:#3CBC8D;*/
    padding: 0px;
}
input {
    background-color: #3cbc8d;
}
#input- {
    background-color: #3cbc8d;
}
</style>
