<?php

namespace App\Exports;

use App\Models\TransactionHeader;
use App\Models\TransactionDetail;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class TransactionExport implements 
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    protected $id;
    protected $start_date;
    protected $end_date;

    public function headings(): array
    {
        return [
            'Transaction Id',
            'Cashier Id',
            'Cashier Name',
            'Transaction Date',
            'Total Price'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                    ],
                ]);
            } 
        ];
    }

    function __construct($start_date,$end_date,$id) {
            $this->id = $id;
            $this->start_date = $start_date;
            $this->end_date = $end_date;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $TransData =DB::table('transaction_header')->whereBetween('tr_transaction_date', [$this->start_date, $this->end_date])
                        ->select('transaction_header.id', 'transaction_header.tr_user_id','users.userName' ,'transaction_header.tr_transaction_date',
                                'transaction_header.tr_total_price')
                        ->join('users','transaction_header.tr_user_id','=','users.id')
                        ->get();
        return $TransData;
    }
}
