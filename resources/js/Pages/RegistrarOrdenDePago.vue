<script setup>
import { staticError, staticSucces } from "@/Components/alerts/staticMessages";
import Formulario from "@/Components/ordenes de pago/Formulario.vue";
import ComputedTotalsProveedores from "@/Components/ordenes de pago/ComputedTotalsProveedores.vue";
import { formatedNumber } from "@/helpers/numbers";
import Navbar from "@/Layouts/Navbar.vue";
import axios from "axios";
import { ref, defineProps, computed } from "vue";
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiCheckBold } from "@mdi/js";
import TableHeadsElectronico from "@/Components/ordenes de pago/TableHeadsElectronico.vue";
import ComputedTotalsElectronico from "@/Components/ordenes de pago/ComputedTotalsElectronico.vue";
import TableheadProveedores from "@/Components/ordenes de pago/TableheadProveedores.vue";
import ItemsTableProveedores from "@/Components/ordenes de pago/ItemsTableProveedores.vue";
import ItemsTableElectronico from "@/Components/ordenes de pago/ItemsTableElectronico.vue";

const successIconPath = mdiCheckBold;
const validateForm = ref(true);
const props = defineProps([
    "cuentasNaviarca",
    "cuentasGc",
    "tasas",
    "beneficiarios",
]);
const cuentasBancarias = ref({
    naviarca: props.cuentasNaviarca,
    grancacique: props.cuentasGc,
    //añadir cuentas serviencomiendas!!!
});
//app control
var company = ref("");
var idCounter = ref(0);
var editandoTasa = ref(false);
var cuentasDisponibles = ref([]);
//app control
//items del formulario
var items = ref([]);
var properties = ref({
    fecha: "",
    concepto: "",
    tipo: "",
    tasa: props.tasas.original.usd,
    rif: "",
});

var selectedAccount = ref({
    banco_id: "",
    codigo_cuenta: "",
    moneda_id: "",
    tipo_cuenta: "",
    banco_nombre: "",
});

const computedTotals = computed(() => {
    const totalTransferencia = parseFloat(totalize("transferencia"));
    return {
        montoTotal: totalize("monto_total"),
        transferencia: totalize("transferencia"),
        comisionISLR: totalize("retencion_islr"),
        comisionBancaria: totalize("comision_bancaria"),
        divisas: totalTransferencia / properties.value.tasa,
        numero_personas: totalize("numero_personas"),
    };
});

const showForm = computed(() => {
    if (
        properties.value.fecha &&
        properties.value.tipo &&
        selectedAccount.value.codigo_cuenta !== ""
    ) {
        return true;
    } else {
        return false;
    }
});
const totalize = (key) => {
    let total = 0;
    if (items.value.length > 0) {
        items.value.forEach((x) => {
            total += +x[key];
        });
    }
    return total;
};

const addToList = (newItem) => {
    if (selectedAccount.value.codigo_cuenta.length < 1 && validateForm.value) {
        staticError("Seleccione una cuenta bancaria");
    } else {
        newItem = {
            ...newItem,
            id: idCounter.value++,
        };
        items.value.push(newItem);
    }
};
const deleteItem = (targetId) => {
    items.value = items.value.filter((x) => x.id !== targetId);
};

const resetAccount = () => {
    selectedAccount.value = {
        banco_id: "",
        codigo_cuenta: "",
        moneda_id: "",
        tipo_cuenta: "",
        banco_nombre: "",
    };
};

const resetForm = () => {
    properties.value = {
        fecha: "",
        concepto: "",
        tipo: "",
        tasa: props.tasas.original.usd,
        rif: "",
    };
    company.value = "";
    resetAccount();
};

const accProps = (item) => {
    return {
        title: item.banco_nombre, // + " - " + item.codigo_cuenta,
        subtitle:
            item.banco_id +
            " - " +
            item.tipo_cuenta +
            " - " +
            item.codigo_cuenta,
        value: {
            id: item.id,
            banco_id: item.banco_id,
            codigo_cuenta: item.codigo_cuenta,
            moneda_id: item.moneda_id,
            tipo_cuenta: item.tipo_cuenta,
            banco_nombre: item.banco_nombre,
        },
    };
};

const selectAccGroup = (key) => {
    resetAccount();
    company.value = key;
    switch (key) {
        case "naviarca":
            properties.value.rif = "j080056043";
            break;
        case "grancacique":
            properties.value.rif = "j303876056";
            break;
        case "serviencomiendas":
            properties.value.rif = "j293703700";
            break;
    }
    console.log("valor del rif: ", properties.value.rif);
    if (key == "serviencomiendas") {
        cuentasDisponibles.value = [];
    } else {
        cuentasDisponibles.value = cuentasBancarias.value[key].original;
    }
};

const submit = async () => {
    console.log("datos a enviar: ", properties.value.rif);
    try {
        const response = await axios
            .post("/api/registrar_orden_de_pago", {
                items: items.value,
                properties: { ...properties.value, ...selectedAccount.value },
            })
            .then((response) => {
                staticSucces(
                    "Guardado con éxito, Numero de orden: " +
                        response.data.numero_orden_de_pago
                );
                items.value = [];
                resetForm();
            });
    } catch (error) {
        staticError("Codigo de error: " + error.status);
        console.log("ocurrio un error desconocido: ", error);
    }
};
</script>

<template>
    <Navbar>
        <v-row dense class="mt-20 ml-20 mr-20">
            <v-col md="12">
                <v-card
                    class="mx-auto p-6 justify-center text-center mb-4"
                    title="Registrar orden de pago"
                    variant="outlined"
                >
                </v-card>
            </v-col>
        </v-row>
        <v-row dense class="ml-20 mr-20">
            <v-col md="3" align-self="center"
                >Monto total a cancelar:
                {{
                    formatedNumber(computedTotals.transferencia) + " Bs."
                }}</v-col
            >

            <v-col md="3" align-self="center"
                >Equivalente a:
                {{ formatedNumber(computedTotals.divisas) + " $ " }}
            </v-col>
            <v-row v-if="editandoTasa">
                <v-col md="3">
                    <v-text-field
                        class="custom-dark"
                        v-model="properties.tasa"
                    ></v-text-field>
                </v-col>
                <v-col md="3"
                    ><v-btn @click="editandoTasa = !editandoTasa"
                        >guardar</v-btn
                    ></v-col
                >
            </v-row>

            <v-col md="3" align-self="center" v-else>
                Tasa de cambio $:
                {{ properties.tasa.toLocaleString("es-CO") }} Bs.
                <v-btn
                    class="p-2 ml-2"
                    @click="editandoTasa = !editandoTasa"
                    :disabled="items.length > 0"
                >
                    cambiar</v-btn
                ></v-col
            >

            <v-col md="2" align-self="center">
                <v-container>
                    <v-switch
                        v-model="validateForm"
                        label="Validar formulario"
                    ></v-switch
                ></v-container>
            </v-col>
            <v-col md="1" align-self="center">{{
                validateForm ? "validar" : "NO validar"
            }}</v-col>
        </v-row>

        <v-divider :thickness="7">Datos de la Cuenta</v-divider>
        <v-row>
            <v-col cols="2"><SvgIcon
            type="mdi"
            :path="successIconPath"
            size="50"
            v-if="showForm"
        ></SvgIcon>
</v-col>
            <v-col cols="10"></v-col>

        </v-row>
        
        <v-row class="m-2">
            <v-row align-content="center">
                <v-container fluid>
                    <v-img
                        :width="300"
                        aspect-ratio="16/9"
                        cover
                        :src="'/img/logo_' + company + '.png'"
                    ></v-img>
                </v-container>
            </v-row>
            <v-col cols="2">
                <v-col cols="12" class="text-center p-2">
                    <v-btn
                        @click="selectAccGroup('naviarca')"
                        :class="{ selected: company == 'naviarca' }"
                        :disabled="items.length > 0"
                    >
                        Naviarca
                    </v-btn>
                </v-col>
                <v-col cols="12" class="text-center p-2">
                    <v-btn
                        @click="selectAccGroup('grancacique')"
                        :class="{ selected: company == 'grancacique' }"
                        :disabled="items.length > 0"
                        >Gran cacique</v-btn
                    >
                </v-col>
                <v-col cols="12" class="text-center p-2">
                    <v-btn
                        @click="selectAccGroup('serviencomiendas')"
                        block
                        outline
                        class="w-full"
                        :class="{ selected: company == 'serviencomiendas' }"
                        :disabled="items.length > 0"
                        ><span
                            class="text-wrap"
                            style="width: min-content; margin: auto"
                        >
                            serviencomiendas</span
                        ></v-btn
                    >
                </v-col>
            </v-col>
            <v-row>
                <v-col cols="12" align-self="end">
                    <v-select
                        v-model="selectedAccount"
                        :items="cuentasDisponibles"
                        :item-props="accProps"
                        label="Cuenta bancaria"
                        :disabled="items.length > 0"
                    ></v-select>
                </v-col>

                <v-col cols="6" class="align-bottom justify-end mt-5">
                    <v-select
                        v-model="properties.tipo"
                        :items="['Proveedores', 'Electronico']"
                        label="Tipo de orden"
                        :disabled="items.length > 0"
                    >
                    </v-select>
                </v-col>

                <v-col cols="6" class="">
                    fecha valor
                    <input
                        type="date"
                        class="custom-datepicker m-2 w-full"
                        v-model="properties.fecha"
                        :disabled="items.length > 0"
                    />
                </v-col>
            </v-row>
            <v-col cols="12">
                <v-text-field
                    class="custom-dark"
                    label="Concepto ( opcional )"
                    v-model="properties.concepto"
                ></v-text-field>
            </v-col>

            <!-- <v-col cols="2"></v-col> -->
        </v-row>
        <v-row>
            <v-col cols="3"></v-col>

            <v-col cols="3"></v-col>
        </v-row>

        <Formulario
            @addToList="addToList"
            @submit="submit"
            :validateForm="validateForm"
            :beneficiarios="props.beneficiarios"
            :showForm="showForm"
            :pagoElectronico="properties.tipo == 'Electronico'"
            :canSubmit="items.length > 0"
        />

        <v-table height="300px" fixed-header>
            <thead>
                <tr>
                    <TableHeadsElectronico
                        v-if="properties.tipo == 'Electronico'"
                    />
                    <TableheadProveedores
                        v-if="properties.tipo == 'Proveedores'"
                    />
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.id">
                    <ItemsTableProveedores
                        :item="item"
                        @deleteItem="deleteItem"
                        v-if="properties.tipo == 'Proveedores'"
                    />
                    <ItemsTableElectronico
                        :item="item"
                        @deleteItem="deleteItem"
                        v-if="properties.tipo == 'Electronico'"
                    />
                </tr>

                <tr>
                    <ComputedTotalsProveedores
                        v-if="properties.tipo == 'Proveedores'"
                        :monto_total="computedTotals.montoTotal"
                        :comision-bancaria="computedTotals.comisionBancaria"
                        :comision-i-s-l-r="computedTotals.comisionISLR"
                        :transferencia="computedTotals.transferencia"
                    />
                    <ComputedTotalsElectronico
                        :monto_total="computedTotals.montoTotal"
                        :numero_personas="computedTotals.numero_personas"
                        v-if="properties.tipo == 'Electronico'"
                    />
                    <!--                     <div v-if="properties.tipo == 'Proveedores'">
                        <td class="text-center"><b>totales:</b></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center">
                            {{ formatedNumber(computedTotals.montoTotal) }}
                        </td>
                        <td class="text-center">
                            {{ formatedNumber(computedTotals.comisionISLR) }}
                        </td>
                        <td class="text-center">
                            {{ formatedNumber(computedTotals.transferencia) }}
                        </td>
                        <td class="text-center">
                            {{
                                formatedNumber(computedTotals.comisionBancaria)
                            }}
                        </td>
                    </div> -->
                </tr>
            </tbody>
        </v-table>
    </Navbar>
</template>
<style scooped>
button.v-btn.selected {
    opacity: 1;
    border: 2px solid #add8e6; /* Light blue color */
    transition: all 0.3s ease;
}
.custom-datepicker input {
    background-color: #3d3d3d;
}
</style>
