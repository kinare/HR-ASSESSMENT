import AuthLayout from "./views/AuthLayout";
import Login from "./components/Login";

export default [
    {
        path: '/',
        component: AuthLayout,
        children: [
            {
                path: "",
                name: "Login",
                component: Login
            }
        ]
    }
]
