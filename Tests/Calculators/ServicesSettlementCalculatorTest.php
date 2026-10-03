<?php

declare(strict_types=1);

namespace Calculators;

use PHPUnit\Framework\TestCase;
use app\DTO\ServicesSettlementData;
use app\Support\Calculators\ServicesSettlementCalculator;

final class ServicesSettlementCalculatorTest extends TestCase
{
    /**
     * Reference case #1 — verified against Excel (Case_1.xlsx).
     * Correction is a surcharge (tenant pays more): base + kor%.
     * coldForHotWaterPrice = 0 in this scenario.
     */
    public function test_excel_case_1(): void
    {
        $data = ServicesSettlementData::fromArray([
            // identity / non-numeric — irrelevant to the math, just satisfy fromArray
            'landlordName' => 'x', 'landlordAddress' => 'x', 'accountNumber' => 'x',
            'propertyAddress' => 'x', 'propertyType' => 'x',
            'tenantName' => 'x', 'tenantAddress' => 'x', 'adminName' => 'x',
            'advancedPaymentsDesc' => 'x',
            'pausalniNaklad' => ['Garáže', 'Odpad', 'Úklid', 'Recepce'],

            // periods
            'calcStartDate'  => '2025-01-01', 'calcFinishDate' => '2025-12-31',
            'rentStartDate'  => '2026-01-01', 'rentFinishDate' => '2026-04-20',

            // meters
            'appMeters'    => ['SUV (Studena voda)', 'SUV (Studena voda)', 'TUV (Tepla voda)', 'TUV (Tepla voda)', 'UT (Ustřední topení)'],
            'initialValue' => [22, 15, 1, 25, 2],
            'endValue'     => [36, 25, 25, 65, 34],
            'meterNumber'  => ['1', '2', '3', '4', '5'],
            'coefficientValue' => [0.8, 0.9],
            'servicesCost' => [1500, 1200, 1620, 1500],

            // prices
            'constHotWaterPrice'   => 1250,
            'constHeatingPrice'    => 1300,
            'hotWaterPrice'        => 150,
            'coldWaterPrice'       => 120,
            'coldForHotWaterPrice' => 0,
            'heatingPrice'         => 352,
            'changedHeatingCost'   => 0,
            'heatingYearSum'       => 0,

            // corrections (surcharge %)
            'servicesCostCorrection' => 2.4,
            'hotWaterCorrection'     => 2.6,
            'coldWaterCorrection'    => 4.5,
            'heatingCorrection'      => 3.4,

            'advancedPayments' => 50000,
        ]);

        $result = (new ServicesSettlementCalculator())->calculate($data);

        // --- periods & heating coefficient (Excel-verified) ---
        $this->assertEqualsWithDelta(12.00, $result->calcMonths, 0.01);
        $this->assertEqualsWithDelta(3.67,  $result->rentMonths, 0.01);
        $this->assertEqualsWithDelta(0.72,  $result->finalCoefficient, 0.001);

        // --- meter reading sums (Excel-verified) ---
        $this->assertEqualsWithDelta(64.00,  $result->hotWaterSum,  0.01);
        $this->assertEqualsWithDelta(24.00,  $result->coldWaterSum, 0.01);
        $this->assertEqualsWithDelta(23.04,  $result->heatingSum,   0.01); // 32 × 0.72

        // --- per-meter breakdown table (shown to the tenant as rows) ---
        $this->assertSame([14.0, 10.0, 24.0, 40.0, 32.0], $result->diffMetersValues['noCoeff']);
        $this->assertSame(['-', '-', '-', '-', '0.72'],    $result->diffMetersValues['coeffView']);
        $this->assertEqualsWithDelta(0.72,  $result->diffMetersValues['coeff'][4], 0.001);
        $this->assertEqualsWithDelta(23.04, $result->diffMetersValues['final'][4], 0.01);

        // CONTRACT: sum of UT rows in the table must equal the aggregate heatingSum,
        // otherwise the printed statement contradicts the money total.
        $this->assertEqualsWithDelta($result->heatingSum, $result->diffMetersValues['final'][4], 0.01);

        // --- services costs (Excel-verified) ---
        $this->assertEqualsWithDelta(5820.00, $result->servicesCostTotal['commonCosts'],   0.01);
        $this->assertEqualsWithDelta(485.00,  $result->servicesCostTotal['costsPerPeriod'], 0.01);
        $this->assertFloatArray([125.0, 100.0, 135.0, 125.0],   $result->oneCostPerPeriod);   // year / 12
        $this->assertFloatArray([458.75, 367.0, 495.45, 458.75], $result->oneCostRent);       // month × 3.67
        $this->assertEqualsWithDelta(1779.95, $result->servicesCostRentTotal, 0.01);          // 485 × 3.67

        // --- hot water (TUV) ---
        $this->assertEqualsWithDelta(1250.00, $result->hotWaterConstTotal['commonCosts'],   0.01);
        $this->assertEqualsWithDelta(104.17,  $result->hotWaterConstTotal['costsPerPeriod'], 0.01); // 1250 / 12
        $this->assertEqualsWithDelta(9600.00, $result->hotWaterVarTotal, 0.01);                     // 150 × 64
        $this->assertEqualsWithDelta(382.30,  $result->hotWaterConstRentTotal, 0.01);               // 104.17 × 3.67
        $this->assertEqualsWithDelta(9982.30, $result->hotWaterTotal['commonCosts'], 0.01);         // Excel-verified

        // --- heating (UT) ---
        $this->assertEqualsWithDelta(1300.00, $result->heatingConstTotal['commonCosts'],   0.01);
        $this->assertEqualsWithDelta(108.33,  $result->heatingConstTotal['costsPerPeriod'], 0.01); // 1300 / 12
        $this->assertEqualsWithDelta(352.00,  $result->heatingPrice, 0.01);                         // direct price
        $this->assertEqualsWithDelta(8110.08, $result->heatingVarTotal, 0.01);                      // 352 × 23.04
        $this->assertEqualsWithDelta(397.57,  $result->heatingConstRentTotal, 0.01);                // 108.33 × 3.67
        $this->assertEqualsWithDelta(8507.65, $result->heatingTotal['commonCosts'], 0.01);          // Excel-verified

        // --- cold water (SUV), coldForHotWater = 0 here ---
        $this->assertEqualsWithDelta(2880.00, $result->coldWaterVarTotal, 0.01);       // 120 × 24
        $this->assertEqualsWithDelta(0.00,    $result->coldForHotWaterVarTotal, 0.01); // 120 × 0
        $this->assertEqualsWithDelta(2880.00, $result->coldWaterTotal['commonCosts'], 0.01);

        // --- corrections per category (surcharge: base + kor%) — Excel-verified ---
        $this->assertEqualsWithDelta(1822.67,  $result->servicesCostRentCorrectionTotal['commonCosts'], 0.01);
        $this->assertEqualsWithDelta(10241.84, $result->hotWaterCorrectionTotal['commonCosts'], 0.01);
        $this->assertEqualsWithDelta(3009.60,  $result->coldWaterCorrectionTotal['commonCosts'], 0.01);
        $this->assertEqualsWithDelta(8796.91,  $result->heatingCorrectionTotal['commonCosts'], 0.01);
        $this->assertEqualsWithDelta(23871.02, $result->allCostsCorrectionTotal['commonCosts'], 0.01);

        // --- final settlement (Excel-verified) ---
        $this->assertEqualsWithDelta(26128.98, $result->balance, 0.01); // 50000 − 23871.02
        $this->assertSame('Přeplatek', $result->balanceText);

        // --- per-month presentation figures — NOT in the Excel reference.
        //     Calculator-derived (division by rentMonths = 3.67). Confirm these
        //     against what actually renders in the customer statement before trusting. ---
        $this->assertEqualsWithDelta(2615.80, $result->hotWaterVarTotalPerMonth, 0.01);       // 9600 / 3.67
        $this->assertEqualsWithDelta(2719.97, $result->hotWaterTotal['costsPerPeriod'], 0.01); // 9982.30 / 3.67
        $this->assertEqualsWithDelta(2209.83, $result->heatingVarTotalPerMonth, 0.01);        // 8110.08 / 3.67
        $this->assertEqualsWithDelta(2318.16, $result->heatingTotal['costsPerPeriod'], 0.01);  // 8507.65 / 3.67
        $this->assertEqualsWithDelta(784.74,  $result->coldWaterTotalPerMonth, 0.01);          // 2880 / 3.67
        $this->assertEqualsWithDelta(0.00,    $result->coldForHotWaterTotalPerMonth, 0.01);
    }



    /**
     * Reference case #2 — verified against Alex's Excel (Case_2.xlsx),
     * recomputed after the date method was rewritten (inclusive both ends,
     * partial month = days / days-in-that-month via DateTime::format('t')).
     * New branches exercised here:
     *   - Nedoplatek (balance < 0)
     *   - no coefficient: coefficientValue = [] -> finalCoefficient = 1, UT not scaled
     *   - partial first rent month (starts on the 10th) -> rentMonths = 10.32
     *   - no hot-water (TUV) meters -> all hot-water figures are 0
     *   - zero corrections on some categories
     */
    public function test_excel_case_2(): void
    {
        $data = ServicesSettlementData::fromArray([
            // identity / non-numeric
            'landlordName' => 'x', 'landlordAddress' => 'x', 'accountNumber' => 'x',
            'propertyAddress' => 'x', 'propertyType' => 'x',
            'tenantName' => 'x', 'tenantAddress' => 'x', 'adminName' => 'x',
            'advancedPaymentsDesc' => 'x',
            'pausalniNaklad' => ['Garáže', 'Odpad', 'Úklid', 'Recepce'],

            // periods — rent starts on the 10th, ends on the 20th (both partial)
            'calcStartDate'  => '2025-01-01', 'calcFinishDate' => '2025-12-31',
            'rentStartDate'  => '2025-02-10', 'rentFinishDate' => '2025-12-20',

            // meters — only SUV and UT, no TUV
            'appMeters'    => ['SUV (Studena voda)', 'UT (Ustřední topení)'],
            'initialValue' => [22, 2],
            'endValue'     => [36, 34],
            'meterNumber'  => ['1', '2'],
            'coefficientValue' => [],              // no coefficient -> finalCoefficient = 1
            'servicesCost' => [1500, 1200, 1620, 1500],

            // prices — no hot water, heating direct
            'constHotWaterPrice'   => 0,
            'constHeatingPrice'    => 1300,
            'hotWaterPrice'        => 0,
            'coldWaterPrice'       => 120,
            'coldForHotWaterPrice' => 0,
            'heatingPrice'         => 352,
            'changedHeatingCost'   => 0,
            'heatingYearSum'       => 0,

            // corrections — only heating has one
            'servicesCostCorrection' => 0,
            'hotWaterCorrection'     => 0,
            'coldWaterCorrection'    => 0,
            'heatingCorrection'      => 2.4,

            'advancedPayments' => 12503,
        ]);

        $result = (new ServicesSettlementCalculator())->calculate($data);

        // --- periods & coefficient (Excel-verified) ---
        $this->assertEqualsWithDelta(12.00, $result->calcMonths, 0.01);
        $this->assertEqualsWithDelta(10.32, $result->rentMonths, 0.01); // 9 + 19/28 + 20/31
        $this->assertEqualsWithDelta(1.00,  $result->finalCoefficient, 0.001); // empty coefficientValue

        // --- meter reading sums (Excel-verified) ---
        $this->assertEqualsWithDelta(0.00,  $result->hotWaterSum,  0.01); // no TUV meters
        $this->assertEqualsWithDelta(14.00, $result->coldWaterSum, 0.01);
        $this->assertEqualsWithDelta(32.00, $result->heatingSum,   0.01); // 32 × 1 (no coefficient)

        // --- per-meter breakdown table ---
        $this->assertSame([14.0, 32.0], $result->diffMetersValues['noCoeff']);
        $this->assertSame([1.0, 1.0],   $result->diffMetersValues['coeff']);
        $this->assertSame(['-', '1'],   $result->diffMetersValues['coeffView']); // UT shows "1" when coeff = 1
        $this->assertSame([14.0, 32.0], $result->diffMetersValues['final']);

        // CONTRACT: UT row(s) in the table must sum to heatingSum
        $this->assertEqualsWithDelta($result->heatingSum, $result->diffMetersValues['final'][1], 0.01);

        // --- services costs (Excel-verified) ---
        $this->assertEqualsWithDelta(5820.00, $result->servicesCostTotal['commonCosts'],   0.01);
        $this->assertEqualsWithDelta(485.00,  $result->servicesCostTotal['costsPerPeriod'], 0.01);
        $this->assertSame([125.0, 100.0, 135.0, 125.0], $result->oneCostPerPeriod);  // year / 12
        $this->assertEqualsWithDelta(1290.00,  $result->oneCostRent[0], 0.01);       // month × 10.32
        $this->assertEqualsWithDelta(1032.00,  $result->oneCostRent[1], 0.01);
        $this->assertEqualsWithDelta(1393.20,  $result->oneCostRent[2], 0.01);
        $this->assertEqualsWithDelta(1290.00,  $result->oneCostRent[3], 0.01);
        $this->assertEqualsWithDelta(5005.20,  $result->servicesCostRentTotal, 0.01); // 485 × 10.32

        // --- hot water (TUV) — all zero, no meters ---
        $this->assertEqualsWithDelta(0.00, $result->hotWaterVarTotal, 0.01);
        $this->assertEqualsWithDelta(0.00, $result->hotWaterConstRentTotal, 0.01);
        $this->assertEqualsWithDelta(0.00, $result->hotWaterTotal['commonCosts'], 0.01);

        // --- heating (UT) ---
        $this->assertEqualsWithDelta(1300.00,  $result->heatingConstTotal['commonCosts'],   0.01);
        $this->assertEqualsWithDelta(108.33,   $result->heatingConstTotal['costsPerPeriod'], 0.01); // 1300 / 12
        $this->assertEqualsWithDelta(352.00,   $result->heatingPrice, 0.01);                         // direct
        $this->assertEqualsWithDelta(11264.00, $result->heatingVarTotal, 0.01);                      // 352 × 32
        $this->assertEqualsWithDelta(1117.97,  $result->heatingConstRentTotal, 0.01);                // 108.33 × 10.32
        $this->assertEqualsWithDelta(12381.97, $result->heatingTotal['commonCosts'], 0.01);          // Excel-verified

        // --- cold water (SUV) ---
        $this->assertEqualsWithDelta(1680.00, $result->coldWaterVarTotal, 0.01);       // 120 × 14
        $this->assertEqualsWithDelta(0.00,    $result->coldForHotWaterVarTotal, 0.01);
        $this->assertEqualsWithDelta(1680.00, $result->coldWaterTotal['commonCosts'], 0.01);

        // --- corrections per category (surcharge: base + kor%) — Excel-verified ---
        $this->assertEqualsWithDelta(5005.20,  $result->servicesCostRentCorrectionTotal['commonCosts'], 0.01); // kor 0
        $this->assertEqualsWithDelta(0.00,     $result->hotWaterCorrectionTotal['commonCosts'], 0.01);         // kor 0
        $this->assertEqualsWithDelta(1680.00,  $result->coldWaterCorrectionTotal['commonCosts'], 0.01);        // kor 0
        $this->assertEqualsWithDelta(12679.14, $result->heatingCorrectionTotal['commonCosts'], 0.01);         // +2.4%
        $this->assertEqualsWithDelta(19364.34, $result->allCostsCorrectionTotal['commonCosts'], 0.01);

        // --- final settlement (Excel-verified) ---
        $this->assertEqualsWithDelta(-6861.34, $result->balance, 0.01); // 12503 − 19364.34
        $this->assertSame('Nedoplatek', $result->balanceText);

        // --- per-month presentation figures — NOT in Excel. Calculator-derived
        //     (division by rentMonths = 10.32). Confirm against the rendered statement. ---
        $this->assertEqualsWithDelta(0.00,    $result->hotWaterVarTotalPerMonth, 0.01);
        $this->assertEqualsWithDelta(1091.47, $result->heatingVarTotalPerMonth, 0.01);        // 11264 / 10.32
        $this->assertEqualsWithDelta(1199.80, $result->heatingTotal['costsPerPeriod'], 0.01);  // 12381.97 / 10.32
        $this->assertEqualsWithDelta(162.79,  $result->coldWaterTotalPerMonth, 0.01);          // 1680 / 10.32
        $this->assertEqualsWithDelta(0.00,    $result->coldForHotWaterTotalPerMonth, 0.01);
    }



    /** Per-element float comparison with tolerance, to avoid rounding-representation flakiness. */
    private function assertFloatArray(array $expected, array $actual, float $delta = 0.01): void
    {
        $this->assertCount(count($expected), $actual);
        foreach ($expected as $i => $exp) {
            $this->assertEqualsWithDelta($exp, $actual[$i], $delta, "index {$i}");
        }
    }
}