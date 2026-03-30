<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUser implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */    
    public function collection()
    {
        return User::with(['country', 'state', 'city'])
            ->select(
                'first_name',
                'last_name',
                'email',
                'contact',
                'gender',
                'institute',
                'course',
                'course_fee',
                'additional_comment',
                'country_id',
                'state_id',
                'city_id',
                'zip',
                'wallet_amount',
                'referrer_id',
                'referrer_amount',
                'refer_code',
                'user_image',
                'status',
                'created_at'
            )->get()->map(function ($user) {
                $image = $user->user_image ? asset('uploads/users/' . $user->user_image) : 'N/A';
                $status = $user->status ? 'Active' : 'Inactive';

                return [
                    $user->first_name ?? 'N/A',
                    $user->last_name ?? 'N/A',
                    $user->email ?? 'N/A',
                    $user->contact ?? 'N/A',
                    $user->gender ?? 'N/A',
                    $user->institute ?? 'N/A',
                    $user->course ?? 'N/A',
                    $user->course_fee ?? 'N/A',
                    $user->additional_comment ?? 'N/A',
                    optional($user->country)->country_name ?? 'N/A',
                    optional($user->state)->state_name ?? 'N/A',
                    optional($user->city)->name ?? 'N/A',
                    $user->zip ?? 'N/A',
                    $user->wallet_amount ?? 'N/A',
                    $user->referrer_id ?? 'N/A',
                    $user->referrer_amount ?? 'N/A',
                    $user->refer_code ?? 'N/A',
                    $image !== 'N/A' 
                        ? '=HYPERLINK("' . $image . '", "' . $user->first_name . '_image")' 
                        : 'N/A',
                    $status,
                    $user->created_at ? $user->created_at->format('d-M-Y') : 'N/A',
                ];
            });
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        $headings = [
            'first_name',
            'last_name',
            'email',
            'contact',
            'gender',
            'institute',
            'course',
            'course_fee',
            'additional_comment',
            'country',
            'state',
            'city',
            'zip',
            'Wallet Amount',
            'referrer_id',
            'Referrer Amount',
            'Refer Code',
            'user_image',
            'status',
            'created_at',
        ];

        return array_map(function ($heading) {
            return ucwords(str_replace('_', ' ', $heading));
        }, $headings);
    }
}
