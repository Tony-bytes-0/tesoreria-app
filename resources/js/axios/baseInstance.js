import axios from "axios";

export const NaviarcaAxios = axios.create({
    //baseURL: process.env.NAVIARCA_API,
    baseURL: "http://ventas-cum.naviarca.com.ve/api/",
    timeout: 10000,
    headers: { "X-Custom-Header": "foobar" },
});

export const GrancaciqueAxios = axios.create({
    baseURL: "https://some-domain.com/api/",
    timeout: 10000,
    headers: { "X-Custom-Header": "foobar" },
});



