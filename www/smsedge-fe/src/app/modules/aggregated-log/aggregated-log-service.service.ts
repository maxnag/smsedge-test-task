import {Inject, Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable, pipe, throwError} from "rxjs";
import {Country} from "../../models/country";

// Observable operators
import { map, catchError } from 'rxjs/operators';
import {User} from "../../models/user";
import {Log} from "../../models/log";

@Injectable({
  providedIn: 'root'
})
export class AggregatedLogServiceService {

    constructor(
        private http: HttpClient,
        @Inject('API_URL') private apiUrl: string
    ) {

    }

    public getCountriesData(term: string): Observable<any> {
        return this.http.get(this.apiUrl + '/countries/?page[number]=1&page[size]=10&sort=cnt_title&filter[search]=' + term)
            .pipe(
                map((countriesData: any) => {
                    const countriesCollection = [];

                    countriesData.data.forEach((value: any) => {
                        countriesCollection.push(new Country(this.parseResponse({'data': [value]})));
                    });

                    return countriesCollection;
                }),
                catchError(this.handleError.bind(this))
            );
    }

    public getUsersData(term: string): Observable<any> {
        return this.http.get(this.apiUrl + '/users/?page[number]=1&page[size]=10&sort=usr_name&filter[search]=' + term)
            .pipe(
                map((usersData: any) => {
                    const usersCollection = [];

                    usersData.data.forEach((value: any) => {
                        usersCollection.push(new User(this.parseResponse({'data': [value]})));
                    });

                    return usersCollection;
                }),
                catchError(this.handleError.bind(this))
            );
    }

    public getAggregatedLogsData(dateFrom: string, dateTo: string, countryCode: string, userId: number): Observable<any> {

        let uId = userId == 0 ? '' : userId;

        return this.http.get(this.apiUrl + '/logs/?page[number]=1&page[size]=100&filter[date_from]=' + dateFrom + '&filter[date_to]=' + dateTo + '&filter[usr_id]=' + uId+ '&filter[cnt_code]=' + countryCode + '&sort=date-,cnt_code,success-')
            .pipe(
                map((logsData: any) => {
                    const logsCollection = [];

                    logsData.data.forEach((value: any) => {
                        logsCollection.push(new Log(this.parseResponse({'data': [value]})));
                    });

                    return logsCollection;
                }),
                catchError(this.handleError.bind(this))
            );
    }

    /**
     * Parse Response
     *
     * @param {any} response
     * @returns {object}
     */
    private parseResponse(response: any): object {
        const dataInfo = response.data[0].attributes;
        dataInfo.id = response.data[0].id;

        return dataInfo;
    }

    /**
     * Displays the error message
     *
     * @param {Response | any} error
     * @returns {throwError}
     */
    private handleError(error: Response | any) {
        return throwError(error.error);
    }
}
