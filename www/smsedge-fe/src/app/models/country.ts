import {Common} from './common';

export class Country implements Common {
    id: number;
    code: string;
    title: string;

    constructor(countryInfo: any) {
        this.id = parseInt(countryInfo.cnt_id, 10) || 0;
        this.code = countryInfo.cnt_code || '';
        this.title = countryInfo.cnt_title || '';
    }
}
