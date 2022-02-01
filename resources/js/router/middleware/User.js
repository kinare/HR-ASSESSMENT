import { AuthService } from "../../modules/auth";

export default function user({ next, router }) {
    if (AuthService.user.account_type !== 'user') {
        return router.push('/');
    }
    return next();
}
