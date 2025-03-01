<?php
namespace App\Http\Traits;
use App\Models\Bank;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Validation\Rule;


trait Calculations{

    /*
        -- some Notes
            - administrative_fees => الرسوم الادارية
            - first batch  الدفعة الأولى
            - last batch الدفعة الأخيرة
            - insurance_percentage => التامين
            - installment => مدة التقسيط بالسنوات
            - benefir =>   الفائدة
            -  advance المقدم
            - firstBatchIncludeAdministrativeFees =>  الدفعة الأولى تشمل الرسوم الإدارية
    */

    public function checkBankOffer($bankId,$sectorId,$brandId){
        $today = Carbon::now()->format('Y-m-d');
        return collect(DB::select("SELECT 
            banks.id as bank_id,
            bank_offers.id as bank_offer_id,
            banks.name_".getLocale()." as bank_name,
            bank_offers.from as period_from,
            bank_offers.to as period_to,
            bank_offer_brand.brand_id as brand_id,
            bank_offer_sector.*

        from banks 
            RIGHT JOIN 
                bank_offers on banks.id = bank_offers.bank_id
            JOIN 
                bank_offer_brand on bank_offer_brand.bank_offer_id = bank_offers.id
            JOIN 
                bank_offer_sector on bank_offer_sector.bank_offer_id = bank_offers.id
            
            WHERE 
                bank_offers.to > '".$today."'
            AND
                bank_offers.from <= '".$today."'
            AND 
                bank_offer_brand.brand_id = ".$brandId."
            AND 
                banks.id = ".$bankId."
            AND
                bank_offer_sector.sector_id = ".$sectorId."

        "))->first();
    }

    public function calculateInstallments($request)
    {
        
        $car = Car::find($request->car_id);
        $bank = Bank::find($request->bank_id);
        $brandId = $car->brand_id;
        
        $sectorBenefit = null;
        $sectorSupport = null;
        $sectorAdministrative_fees = null;
        $sectorInstallment = null;
        $bankOffer = $this->checkBankOffer($request->bank_id,$request->sector_id,$brandId);
        if($bankOffer !=null){
            if($request->transferred)
                $sectorBenefit = $bankOffer->transferred_benefit;
            else
                $sectorBenefit = $bankOffer->non_transferred_benefit;

            $sectorSupport = $bankOffer->support;
            $sectorAdministrative_fees = $bankOffer->administrative_fees;
            $sectorInstallment = $bankOffer->installment;
        }else{
            $sector = $bank->sectors()->find($request->sector_id)->pivot;
            if($request->transferred)
                $sectorBenefit = $sector['transferred_benefit'];
            else
                $sectorBenefit = $sector['non_transferred_benefit'];

            $sectorSupport = $sector['support'];
            $sectorAdministrative_fees = $sector['administrative_fees'];
            $sectorInstallment = $sector['installment'];
        }
        
        
        $price =  $car->getPriceAfterVatAttribute();

        $supportPercentage = $sectorSupport / 100;
        if($sectorSupport > 100){
            $price = ($price * $supportPercentage);
        }

        $last_installment = $price * ($request->last_installment/100);
        $first_installment = $price * ($request->first_installment/100);


        $benefitPercentage = $sectorBenefit / 100;
        $insurancePrice = $price * $request->installment * (settings()->get($request->gender . 's_insurance') / 100);
        $firstBatchIncludeAdministrativeFees = $first_installment + ( $price * ( $sectorAdministrative_fees / 100) );
        $fundingAmount = $price - $firstBatchIncludeAdministrativeFees + ( $price * ( $sectorAdministrative_fees / 100) );

        if ($benefitPercentage == 0)
            $fundingAmountIncludeBenefit =  $fundingAmount - $last_installment + $insurancePrice;
        else
            $fundingAmountIncludeBenefit = ($fundingAmount * $benefitPercentage * $request->installment) + $fundingAmount - $last_installment + $insurancePrice;

        $monthlyInstallment = $fundingAmountIncludeBenefit / $request->installment / 12;


        $banks = $this->calculateInstallmentsAllBanks($request);
        $banks->prepend([
            'bank' => $bank,
            'bank_offer' => $bankOffer ?? null,
            'monthly_installment' => number_format($monthlyInstallment),
            // 'first_installment' => $first_installment,
            // 'last_installment' => $last_installment,
            'administrative_fees' => number_format($price * ( $sectorAdministrative_fees / 100)),
        ]);

        return [
            'banks' => $banks,
            'years' => $request->installment,
            'first_installment' => $first_installment,
            'last_installment' => $last_installment,
        ];

    }

    public function calculateInstallmentsAllBanks($request){
        $car = Car::find($request->car_id);
        $brandId = $car->brand_id;
        $banks = Bank::whereNotIn('id',[$request->bank_id])->get();

        $monthlyInstallments = [];
        foreach($banks as $bank){
            $sectorBenefit = null;
            $sectorSupport = null;
            $sectorAdministrative_fees = null;
            $bankOffer = $this->checkBankOffer($bank->id,$request->sector_id,$brandId);
            
            if($bankOffer !=null){
                if($request->transferred)
                    $sectorBenefit = $bankOffer->transferred_benefit;
                else
                    $sectorBenefit = $bankOffer->non_transferred_benefit;

                $sectorSupport = $bankOffer->support;
                $sectorAdministrative_fees = $bankOffer->administrative_fees;
            }else{
                $sector = $bank->sectors()->find($request->sector_id)->pivot;
                if($request->transferred)
                    $sectorBenefit = $sector['transferred_benefit'];
                else
                    $sectorBenefit = $sector['non_transferred_benefit'];

                $sectorSupport = $sector['support'];
                $sectorAdministrative_fees = $sector['administrative_fees'];
            }

            $supportPercentage = $sectorSupport / 100;
            $price =  $car->getPriceAfterVatAttribute();
            if($sectorSupport > 100){
                $price = ($price * $supportPercentage);
            }
            $last_installment = $price * ($request->last_installment/100);
            $first_installment = $price * ($request->first_installment/100);
            $benefitPercentage = $sectorBenefit / 100;
            $insurancePrice = $price * $request->installment * (settings()->get($request->gender . 's_insurance') / 100);
            $firstBatchIncludeAdministrativeFees = $first_installment + ( $price * ( $sectorAdministrative_fees / 100) );
            $fundingAmount = $price - $firstBatchIncludeAdministrativeFees + ( $price * ( $sectorAdministrative_fees / 100) );

            if ($benefitPercentage == 0)
                $fundingAmountIncludeBenefit =  $fundingAmount - $last_installment + $insurancePrice;
            else
                $fundingAmountIncludeBenefit = ($fundingAmount * $benefitPercentage * $request->installment) + $fundingAmount - $last_installment + $insurancePrice;

            $monthlyInstallment = $fundingAmountIncludeBenefit / $request->installment / 12;
            $monthlyInstallments[]=[
                // 'bank_id' => $bank->id,
                'bank' => $bank,
                'bank_offer' => $bankOffer ?? null,
                'monthly_installment' => number_format($monthlyInstallment),
                // 'first_installment' => $first_installment,
                // 'last_installment' => $last_installment,
                // 'years' => $request->installment,
                'administrative_fees' => number_format($price * ( $sectorAdministrative_fees / 100)),
            ];
        }


        $monthlyInstallments = collect($monthlyInstallments)->sortBy('monthlyInstallment');

        return $monthlyInstallments;
    }

}
