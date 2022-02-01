import axios from "axios";
import { apiBaseUrl } from "../../../environment";
import { AuthService } from "../../../modules/auth";

const config = {
  baseURL: apiBaseUrl,
};

const client = axios.create(config);

const authInterceptor = (config) => {
  if (AuthService.check()) {
    config.headers.Authorization = `Bearer ${AuthService.token}`;
  }
  config.headers.common.Accept = "Application/json";
  config.headers["Access-Control-Allow-Origin"] = "*";
  return config;
};

client.interceptors.request.use(authInterceptor);

client.interceptors.response.use(
  (response) => Promise.resolve(response),
  (error) => {
    if (error.response.status === 401) AuthService.logout();
    throw error;
  }
);

export default client;
