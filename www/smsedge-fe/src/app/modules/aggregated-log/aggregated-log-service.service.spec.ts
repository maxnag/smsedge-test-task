import { TestBed } from '@angular/core/testing';

import { AggregatedLogServiceService } from './aggregated-log-service.service';

describe('AggregatedLogServiceService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: AggregatedLogServiceService = TestBed.get(AggregatedLogServiceService);
    expect(service).toBeTruthy();
  });
});
