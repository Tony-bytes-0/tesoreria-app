<template>
    <!-- <v-chip class="ma-2" label> Datos de la orden </v-chip> -->
    <v-divider :thickness="7">Datos de la orden de pago</v-divider>
    <v-form class="p-2" @submit.prevent>
        <v-row align="center">
            <v-col cols="2"
                ><SvgIcon
                    type="mdi"
                    :path="successIconPath"
                    size="50"
                    v-if="
                        validateFormelectronico(formData) &&
                        props.pagoElectronico
                    "
                >
                </SvgIcon>
                <SvgIcon
                    type="mdi"
                    :path="successIconPath"
                    size="50"
                    v-if="
                        validateFormProveedores(formData) &&
                        !props.pagoElectronico
                    "
                >
                </SvgIcon>
            </v-col>
            <v-col cols="4">
                <h1 class="p-2">Beneficiario</h1>
                <v-autocomplete
                    v-model="formData.beneficiario"
                    item-title="descripcion"
                    item-value="descripcion"
                    :items="props.beneficiarios"
                    return-object
                    :disabled="!props.showForm"
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
                <h1 class="p-2">
                    {{
                        !props.pagoElectronico
                            ? "Número de factura"
                            : "Numero de personas"
                    }}
                </h1>
                <v-text-field
                    class="custom-dark"
                    v-model="formData.factura"
                    :disabled="!props.showForm"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <h1 class="p-2">
                    {{
                        props.pagoElectronico ? "Total a pagar" : "Monto total"
                    }}
                </h1>
                <v-text-field
                    class="custom-dark"
                    v-model="formData.monto_total"
                    :disabled="!props.showForm"
                ></v-text-field>
            </v-col>
            <v-col cols="1"></v-col>
        </v-row>
        <v-row>
            <v-col cols="2"></v-col>
            <v-col cols="2">
                <h1 class="p-2" v-if="!props.pagoElectronico">
                    Monto retención ISLR
                </h1>
                <v-text-field
                    v-if="!props.pagoElectronico"
                    class="custom-dark"
                    v-model="formData.retencion_islr"
                    :disabled="!props.showForm"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <h1 class="p-2" v-if="!props.pagoElectronico">
                    Nº Autorización
                </h1>

                <v-text-field
                    v-if="!props.pagoElectronico"
                    class="custom-dark"
                    v-model="formData.autorizacion"
                    :disabled="!props.showForm"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <h1 class="p-2" v-if="!props.pagoElectronico">
                    Monto transferencia
                </h1>
                <v-text-field
                    v-if="!props.pagoElectronico"
                    class="custom-dark custom-input"
                    v-model="formatedTransferencia"
                    disabled
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <h1 class="p-2" v-if="!props.pagoElectronico">
                    Comisión bancaria
                </h1>
                <v-text-field
                    v-if="!props.pagoElectronico"
                    class="custom-dark"
                    v-model="formatedComisionBancaria"
                    disabled
                ></v-text-field>
            </v-col>
            <v-col cols="2"></v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <h1 class="p-2">Concepto</h1>
                <v-text-field
                    class="custom-dark"
                    v-model="formData.concepto"
                ></v-text-field>
            </v-col>
        </v-row>

        <v-row>
            <v-col
                cols="12"
                class="justify-center items-center p-6 mx-auto flex"
            >
                <!-- <v-btn @click="() => console.log(formData)"> -->
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="primary"
                    type="submit"
                    @click="handleAddToList"
                >
                    añadir a la lista
                </v-btn>
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="success"
                    :disabled="!canSubmit"
                    @click="submit"
                >
                    Procesar ordenes
                </v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>
<script setup>
import { computed, onMounted, ref } from "vue";
import { staticError } from "../alerts/staticMessages";
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiCheckBold } from "@mdi/js";
import "vuetify/styles";
import "vuetify";
import { formatedNumber, validateNumbersAndCommas } from "@/helpers/numbers";

const successIconPath = mdiCheckBold;
const emit = defineEmits(["addToList", "submit"]);
const props = defineProps([
    "validateForm",
    "beneficiarios",
    "showForm",
    "pagoElectronico",
    "canSubmit",
]);
var formData = ref({
    beneficiario: "",
    factura: "",
    monto_total: "",
    //
    retencion_islr: "",
    autorizacion: "",
    concepto: "",
});

const beneficiario_id = computed(() => {
    return formData.value.beneficiario.id;
});

const transferencia = computed(() => {
    const newValue = parseFloat(
        formData.value.monto_total - formData.value.retencion_islr
    );
    return Number(newValue);
});

const comision_bancaria = computed(() => {
    const newValue = parseFloat(0.0025 * transferencia.value.toString());
    return Number(newValue);
});
//para la vista
const formatedTransferencia = computed(() => {
    return formatedNumber(transferencia.value);
});

const formatedComisionBancaria = computed(() => {
    return formatedNumber(comision_bancaria.value);
});

const onlyNumbersMonto_total = computed(() => {
    const regex = /^[0-9,]+$/;
    return regex.test(formData.value.monto_total);
});

const onlyNumbersRetencion = computed(() => {
    const regex = /^[0-9,]+$/;
    return regex.test(formData.value.retencion_islr);
});

const validateFormelectronico = (item) => {
    var validationObject = Object.assign({}, item);
    delete validationObject.concepto;
    delete validationObject.retencion_islr;
    delete validationObject.transferencia;
    delete validationObject.autorizacion;
    delete validationObject.comision_bancaria;
    delete validationObject.transferencia;

    const notEmpty = (x) => {
        return x.length == 0;
    };
    const atLeastOneCharacter = !Object.values(validationObject).some(notEmpty); //valida completitud
    if (onlyNumbersMonto_total && atLeastOneCharacter) {
        return true;
    } else return false;
};

const validateFormProveedores = (item) => {
    //console.log('validacion proveedores') // creo que esto jode la validacion
    var validationObject = Object.assign({}, item);
    delete validationObject.concepto;
    delete validationObject.retencion_islr;
    delete validationObject.comision_bancaria;

    const notEmpty = (x) => {
        return x.length == 0;
    };
    const atLeastOneCharacter = !Object.values(validationObject).some(notEmpty); //valida completitud
    const onlyNumbersMonto_total = validateNumbersAndCommas(
        String(item.monto_total)
    );
    const onlyNumbersRetencion = validateNumbersAndCommas(
        String(item.retencion_islr)
    );
    //console.log(onlyNumbersMonto_total, onlyNumbersRetencion) // creo que esto jode la validacion
    if (
        onlyNumbersMonto_total &&
        onlyNumbersRetencion &&
        atLeastOneCharacter &&
        item.monto_total > item.retencion_islr
    ) {
        return true;
    } else return false;
};

const resetForm = () => {
    formData.value = {
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
    if (
        (props.pagoElectronico && validateFormelectronico(formData.value)) ||
        (!props.pagoElectronico && validateFormProveedores(formData.value))
    ) {
        emit("addToList", {
            ...formData.value,
            monto_total: Number(formData.value.monto_total).toFixed(2),
            transferencia: transferencia.value,
            comision_bancaria: comision_bancaria.value,
            beneficiario_id: beneficiario_id.value,
            numero_personas: formData.value.factura,
        });
        resetForm();
    } else {
        staticError("Complete el formulario");
    }
};

const submit = () => {
    emit("submit", { ...formData.value });
};
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
    background-color: #7a7a7a;
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
</style>
