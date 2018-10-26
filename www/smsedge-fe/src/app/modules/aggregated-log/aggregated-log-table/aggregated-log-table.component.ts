import {Component, ElementRef, OnInit, ViewChild} from '@angular/core';
import {AggregatedLogServiceService} from "../aggregated-log-service.service";
import {Country} from "../../../models/country";
import {User} from "../../../models/user";
import {Log} from "../../../models/log";

declare var jQuery: any;

@Component({
    selector: 'app-aggregated-log-table',
    templateUrl: './aggregated-log-table.component.html',
    styleUrls: ['./aggregated-log-table.component.css']
})
export class AggregatedLogTableComponent implements OnInit {

    @ViewChild('dateFrom') dateFromElement: ElementRef;
    @ViewChild('dateTo') dateToElement: ElementRef;
    @ViewChild('countryName') countryNameElement: ElementRef;
    @ViewChild('userName') userNameElement: ElementRef;

    private dateFromValidation: boolean;
    private dateToValidation: boolean;

    private countryCode: string;
    private userId: number;
    private dateFrom: string;
    private dateTo: string;
    private aggregatedLogData: Array<Log>;

    constructor(
        private aggregatedLogServiceService: AggregatedLogServiceService,
    ) {
        this.dateFromValidation = false;
        this.dateToValidation = false;

        this.countryCode = '';
        this.userId = 0;
        this.dateFrom = '';
        this.dateTo = '';
        this.aggregatedLogData = [];
    }

    ngOnInit() {
    }

    ngAfterViewInit() {
        const now = new Date();
        jQuery.datepicker.setDefaults(jQuery.datepicker.regional['en']);

        jQuery(this.dateFromElement.nativeElement).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            maxDate: now,
            yearRange: '-18y' + ':' + now.getFullYear(),
            onSelect: function(date) {
                this.dateFrom = date;
                this.dateFromValidation = true;
            }.bind(this)
        });

        jQuery(this.dateToElement.nativeElement).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            maxDate: now,
            yearRange: '-18y' + ':' + now.getFullYear(),
            onSelect: function(date) {
                this.dateTo = date;
                this.dateToValidation = true;
            }.bind(this)
        });

        jQuery(this.countryNameElement.nativeElement).autocomplete({
            source: function (request, response) {
                this.aggregatedLogServiceService
                    .getCountriesData(request.term)
                    .subscribe(
                        (data: Array<any>) => {
                            const countryData = [];

                            data.forEach((value: Country, index: number) => {
                                countryData[index] = {
                                    id: value.code,
                                    value: value.title,
                                    label: value.title,
                                };
                            });

                            response(countryData);
                        },
                        (error: any) => {
                            this.countryCode = '';

                            response({});
                        }
                    );
            }.bind(this),
            minLength: 2,
            select: function (event, ui) {
                jQuery(this.countryNameElement.nativeElement).val(ui.item.value);
                this.countryCode = ui.item.id;
            }.bind(this)
        });

        jQuery(this.userNameElement.nativeElement).autocomplete({
            source: function (request, response) {
                this.aggregatedLogServiceService
                    .getUsersData(request.term)
                    .subscribe(
                        (data: Array<any>) => {
                            const userData = [];

                            data.forEach((value: User, index: number) => {
                                userData[index] = {
                                    id: value.id,
                                    value: value.name,
                                    label: value.name,
                                };
                            });

                            response(userData);
                        },
                        (error: any) => {
                            this.userId = 0;

                            response({});
                        }
                    );
            }.bind(this),
            minLength: 2,
            select: function (event, ui) {
                jQuery(this.userNameElement.nativeElement).val(ui.item.value);
                this.userId = ui.item.id;
            }.bind(this)
        });
    }

    changeCountry() {
        let countryName = jQuery(this.countryNameElement.nativeElement).val();

        if (!countryName.trim()) {
            this.countryCode = '';
            jQuery(this.countryNameElement.nativeElement).val('')
        }
    }

    changeUserName() {
        let userName = jQuery(this.userNameElement.nativeElement).val();

        if (!userName.trim()) {
            this.userId = 0;
            jQuery(this.userNameElement.nativeElement).val('')
        }
    }

    showAggregatedLogData() {
        this.aggregatedLogServiceService
            .getAggregatedLogsData(this.dateFrom, this.dateTo, this.countryCode, this.userId)
            .subscribe(
                (data: Array<any>) => {
                    this.aggregatedLogData = data
                },
                (error: any) => {
                    this.aggregatedLogData = [];
                }
            );
    }
}
