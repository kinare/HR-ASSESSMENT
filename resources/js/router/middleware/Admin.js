import { AuthService } from "../../modules/auth";

export default function admin({ next, router }) {
    if (!AuthService.user.is_admin) {
        return router.push("/");
    }
    return next();
}
