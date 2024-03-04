
import axios from 'axios';
import { responseInterceptor, errorInterceptor } from './interceptors';

//const URL_BASE = process.env.URL_BASE;
const URL_BASE = 'http://localhost:8000/api';
const token = localStorage.getItem('userToken');
const headers = {
  Authorization: `Bearer ${token}`
};

export const Api = () => {
  const api = axios.create({
    baseURL: URL_BASE,
    headers: headers
  });

  api.interceptors.response.use(
    (response) => responseInterceptor(response),
    (error) => errorInterceptor(error),
  );

  return api;
};