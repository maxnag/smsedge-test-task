import {Common} from './common';
import {User} from './user';
import {Country} from './country';

export class Log implements Common {
    id: number;
    date: string;
    usrId: number;
    usrName: string;
    cntCode: string;
    cntTitle: string;
    success: number;
    fail: number;

    user: User;
    country: Country;

    constructor(logInfo: any) {
        this.id = parseInt(logInfo.id, 10) || 0;
        this.date = logInfo.date || '';
        this.usrId = parseInt(logInfo.breed_id, 10) || 0;
        this.usrName = logInfo.usr_name || '';
        this.cntCode = logInfo.cnt_code || '';
        this.cntTitle = logInfo.cnt_title || '';
        this.success = parseInt(logInfo.success, 10) || 0;
        this.fail = parseInt(logInfo.fail, 10) || 0;
    }

    getUser() {
        if (!this.user) {
            this.user = new User({});
        }

        return this.user;
    }

    setUser(userInfo: User) {
        this.user = userInfo;

        return this;
    }

    getCountry() {
        if (!this.country) {
            this.country = new Country({});
        }

        return this.country;
    }

    setCountry(countryInfo: Country) {
        this.country = countryInfo;

        return this;
    }
}
