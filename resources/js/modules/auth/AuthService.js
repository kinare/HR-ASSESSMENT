import { appName } from "../../environment";

class AuthService {
    constructor() {
        this.token = window.localStorage.getItem(`${appName}_token`);
        this.user = JSON.parse(window.localStorage.getItem(`${appName}_user`));
    }

    check() {
        return !!this.token;
    }

    setUser(user) {
        window.localStorage.removeItem(`${appName}_user`);
        window.localStorage.setItem(`${appName}_user`,JSON.stringify(user));
        this.user = user;
        location.reload();
    }

    login(token, user) {
        window.localStorage.setItem(`${appName}_token`, token);
        window.localStorage.setItem(`${appName}_user`,JSON.stringify(user));

        this.token = token;
        this.user = user;
        this.company = user.company;

        location.reload();
    }

    logout() {
        window.localStorage.removeItem(`${appName}_token`);
        window.localStorage.removeItem(`${appName}_user`);
        window.location.href = "/";
    }
}

export default new AuthService();
