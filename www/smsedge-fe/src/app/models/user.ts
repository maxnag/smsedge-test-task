import { Common } from './common';

export class User implements Common {

    id: number;
    name: string;
    active: boolean;

    constructor(userInfo: any) {
        this.id = parseInt(userInfo.usr_id, 10) || 0;
        this.name = userInfo.usr_name || '';
        this.active = userInfo.usr_active || true;
    }
}
