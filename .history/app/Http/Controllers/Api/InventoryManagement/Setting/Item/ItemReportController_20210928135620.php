<?php

namespace App\Http\Controllers\Api\InventoryManagement\Setting\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use TCPDF;

class ItemReportController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function item_report_all($warehouse_id, $date_from1, $date_to1)
    {

        try {

            $warehouse = $warehouse_id;
            $date_from = Carbon::parse($date_from1)->format('Y-m-d');
            $date_to = Carbon::parse($date_to1)->addDays(1)->format('Y-m-d');

            $date_from_formatted = Carbon::parse($date_from1)->format('F d, Y');
            $date_to_formatted = Carbon::parse($date_to1)->format('F d, Y');

            $warehouse_name = DB::table('warehouses as a')
                ->where('a.id', $warehouse)
                ->select('a.name')
                ->first();

            $items = DB::table('item_details as a')
                ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
                ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
                ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
                ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                ->where('c.id', $warehouse)
                ->select(
                    'a.sku',
                    'a.id',
                    'a.item_code',
                    'a.name',
                    'a.quantity',
                    'b.name as category_name',
                    'b.code as category_code',
                    'g.name as measurement_name',
                    DB::raw('null as count'),
                    DB::raw('null as item_in'),
                )
                ->get();

            foreach ($items as $logs_in) {

                $in = DB::table('item_in_stocks as a')
                    ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                    ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                    ->leftjoin('item_locations as d', 'a.location_id', 'd.id') //location //added by JM
                    ->where('a.item_detail_id', $logs_in->id)
                    ->where('c.id', $warehouse)
                    ->WhereBetween('a.created_at', [$date_from, $date_to])
                    ->select(
                        'a.id',
                        'a.quantity',
                        'a.balance',
                        'a.created_at',
                        'c.name as warehouse',
                        'd.name as location',
                        'b.first_name',
                        'b.last_name',
                        DB::raw('null as count'),
                        DB::raw('null as item_out'),
                    )
                    ->orderBy('a.created_at', 'ASC')
                    ->get();

                $logs_in->item_in = $in;
                $logs_in->count = $in->count();

                foreach ($in as $logs_out) {
                    $out = DB::table('item_out_stocks as a')
                        ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                        ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                        ->where('a.item_in_stock_id', $logs_out->id)
                        ->WhereBetween('a.created_at', [$date_from, $date_to])
                        ->select(
                            'a.quantity as out',
                            'a.user_id',
                            'a.created_at',
                            'c.name as warehouse',
                            'b.first_name',
                            'b.last_name',
                        )
                        ->orderBy('a.created_at', 'ASC')
                        ->get();
                    $logs_out->item_out = $out;
                    $logs_out->count = $out->count();
                }
            }

            //  return response()->json($items, 200);                          
            $view = \View::make('report_forms/Report_Stock_In_Out', ['products' => $items, 'warehouse' => $warehouse_name, 'from' => $date_from_formatted, 'to' => $date_to_formatted]);
            $html_content = $view->render();
            $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetTitle('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetSubject('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            // set margins
            $pdf->SetMargins(3, 1, 3);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
            $pdf->SetAutoPageBreak(TRUE, 1);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            $pdf->SetFont('helvetica', '', 9);
            $pdf->AddPage();
            $pdf->writeHTML($html_content, true, 0, true, 0);
            $pdf->lastPage();

            $root = 'private/temp/';
            $file_path = storage_path('app/' . $root);
            $pdf->Output($file_path . '.pdf', 'F');
            return response()->file($file_path . '.pdf');
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function item_report_in($warehouse_id, $date_from1, $date_to1)
    {

        try {

            $warehouse = $warehouse_id;
            $date_from = Carbon::parse($date_from1)->format('Y-m-d');
            $date_to = Carbon::parse($date_to1)->addDays(1)->format('Y-m-d');

            $date_from_formatted = Carbon::parse($date_from1)->format('F d, Y');
            $date_to_formatted = Carbon::parse($date_to)->format('F d, Y');

            $warehouse_name = DB::table('warehouses as a')
                ->where('a.id', $warehouse)
                ->select('a.name')
                ->first();

            $items = DB::table('item_details as a')
                ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
                ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
                ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
                ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                ->where('c.id', $warehouse)
                ->select(
                    'a.sku',
                    'a.id',
                    'a.item_code',
                    'a.name',
                    'a.quantity',
                    'b.name as category_name',
                    'b.code as category_code',
                    'g.name as measurement_name',
                    DB::raw('null as count'),
                    DB::raw('null as item_in'),
                )
                ->get();

            foreach ($items as $logs_in) {
                $in = DB::table('item_in_stocks as a')
                    ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                    ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                    ->leftjoin('item_locations as d', 'a.location_id', 'd.id') //location //added by JM
                    ->where('a.item_detail_id', $logs_in->id)
                    ->where('c.id', $warehouse)
                    ->WhereBetween('a.created_at', [$date_from, $date_to])
                    ->select(
                        'a.id',
                        'a.quantity',
                        'a.balance',
                        'a.created_at',
                        'c.name as warehouse',
                        'd.name as location',
                        'b.first_name',
                        'b.last_name',
                    )
                    ->orderBy('a.created_at', 'ASC')
                    ->get();
                $logs_in->item_in = $in;
                $logs_in->count = $in->count();
            }
            //  return response()->json($items, 200);    

            $view = \View::make('report_forms/Report_Stock_In', ['products' => $items, 'warehouse' => $warehouse_name, 'from' => $date_from_formatted, 'to' => $date_to_formatted]);
            $html_content = $view->render();
            $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetTitle('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetSubject('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            // set margins
            $pdf->SetMargins(3, 1, 3);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
            $pdf->SetAutoPageBreak(TRUE, 1);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            $pdf->SetFont('helvetica', '', 9);
            $pdf->AddPage();
            $pdf->writeHTML($html_content, true, 0, true, 0);
            $pdf->lastPage();

            $root = 'private/temp/';
            $file_path = storage_path('app/' . $root);
            $pdf->Output($file_path . '.pdf', 'F');
            return response()->file($file_path . '.pdf');
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function item_report_out($warehouse_id, $date_from1, $date_to1)
    {
        try {

            $warehouse = $warehouse_id;
            $date_from = Carbon::parse($date_from1)->format('Y-m-d');
            $date_to = Carbon::parse($date_to1)->addDays(1)->format('Y-m-d');

            $date_from_formatted = Carbon::parse($date_from1)->format('F d, Y');
            $date_to_formatted = Carbon::parse($date_to1)->format('F d, Y');

            $warehouse_name = DB::table('warehouses as a')
                ->where('a.id', $warehouse)
                ->select('a.name')
                ->first();

            $items = DB::table('item_details as a')
                ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
                ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
                ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
                ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                ->where('c.id', $warehouse)
                ->select(
                    'a.sku',
                    'a.id',
                    'a.item_code',
                    'a.name',
                    'a.quantity',
                    'b.name as category_name',
                    'b.code as category_code',
                    'g.name as measurement_name',
                    DB::raw('null as count'),
                    DB::raw('null as item_in'),
                )
                ->get();

            foreach ($items as $logs_in) {
                $in = DB::table('item_in_stocks as a')
                    ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                    ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                    ->leftjoin('item_locations as d', 'a.location_id', 'd.id') //location //added by JM
                    ->where('a.item_detail_id', $logs_in->id)
                    ->where('c.id', $warehouse)
                    ->select('a.id', DB::raw('null as count'), DB::raw('null as item_out'))
                    ->orderBy('a.created_at', 'ASC')
                    ->get();
                $logs_in->item_in = $in;
                foreach ($in as $logs_out) {
                    $out = DB::table('item_out_stocks as a')
                        ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                        ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                        ->where('a.item_in_stock_id', $logs_out->id)
                        ->WhereBetween('a.created_at', [$date_from, $date_to])
                        ->select(
                            'a.quantity as out',
                            'a.user_id',
                            'a.created_at',
                            'c.name as warehouse',
                            'b.first_name',
                            'b.last_name',
                        )
                        ->orderBy('a.created_at', 'ASC')
                        ->get();
                    $logs_out->item_out = $out;
                    // $logs_out->count = $out->count();
                    $logs_in->count = $out->count();
                }
            }
            //   return response()->json($items, 200);  

            $view = \View::make('report_forms/Report_Stock_Out', ['products' => $items, 'warehouse' => $warehouse_name, 'from' => $date_from_formatted, 'to' => $date_to_formatted]);
            $html_content = $view->render();
            $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetTitle('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetSubject('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            // set margins
            $pdf->SetMargins(3, 1, 3);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
            $pdf->SetAutoPageBreak(TRUE, 1);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            $pdf->SetFont('helvetica', '', 9);
            $pdf->AddPage();
            $pdf->writeHTML($html_content, true, 0, true, 0);
            $pdf->lastPage();

            $root = 'private/temp/';
            $file_path = storage_path('app/' . $root);
            $pdf->Output($file_path . '.pdf', 'F');
            return response()->file($file_path . '.pdf');
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function item_report_recieving($warehouse_id, $date_from1, $date_to1)
    {
        try {
            $warehouse = $warehouse_id;
            $date_from = Carbon::parse($date_from1)->format('Y-m-d');
            $date_to = Carbon::parse($date_to1)->addDays(1)->format('Y-m-d');

            $date_from_formatted = Carbon::parse($date_from1)->format('F d, Y');
            $date_to_formatted = Carbon::parse($date_to1)->format('F d, Y');

            $warehouse_name = DB::table('warehouses as a')
                ->where('a.id', $warehouse)
                ->select('a.name')
                ->first();

            $out = DB::table('item_out_stocks as a')
                ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                ->where('c.id', $warehouse)
                ->WhereBetween('a.created_at', [$date_from, $date_to])
                ->select(
                    'a.quantity as out',
                    'a.user_id',
                    'a.created_at',
                    'a.item_in_stock_id',
                    'c.name as warehouse',
                    'b.first_name',
                    'b.last_name',
                    DB::raw('null as from')
                )
                ->orderBy('a.created_at', 'ASC')
                ->get();


            foreach ($out as $logs_in) {
                $in = DB::table('item_in_stocks as a')
                    ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                    ->where('a.id', $logs_in->item_in_stock_id)
                    ->select(
                        'a.id',
                        'c.name as from_warehouse',
                        'a.item_detail_id',
                        DB::raw('null as item_details')
                    )
                    ->orderBy('a.created_at', 'ASC')
                    ->get();
                $logs_in->from = $in;

                foreach ($in as $item_details) {
                    $items = DB::table('item_details as a')
                        ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
                        ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
                        ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
                        ->where('a.id', $item_details->item_detail_id)
                        ->select(
                            'a.id',
                            'a.item_code',
                            'a.name',
                            'a.quantity',
                            'b.name as category_name',
                            'b.code as category_code',
                            'g.name as measurement_name',
                        )
                        ->get();
                    $item_details->item_details = $items;
                }
            }

            // return response()->json($out, 200);

            $view = \View::make('report_forms/Report_Stock_Receiving', ['products' => $out, 'warehouse' => $warehouse_name, 'from' => $date_from_formatted, 'to' => $date_to_formatted]);
            $html_content = $view->render();
            $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetTitle('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetSubject('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            // set margins
            $pdf->SetMargins(3, 1, 3);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
            $pdf->SetAutoPageBreak(TRUE, 1);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            $pdf->SetFont('helvetica', '', 9);
            $pdf->AddPage();
            $pdf->writeHTML($html_content, true, 0, true, 0);
            $pdf->lastPage();

            $root = 'private/temp/';
            $file_path = storage_path('app/' . $root);
            $pdf->Output($file_path . '.pdf', 'F');
            return response()->file($file_path . '.pdf');
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function item_report_releasing($warehouse_id, $date_from1, $date_to1)
    {
        try {
            $warehouse = $warehouse_id;
            $date_from = Carbon::parse($date_from1)->format('Y-m-d');
            $date_to = Carbon::parse($date_to1)->addDays(1)->format('Y-m-d');

            $date_from_formatted = Carbon::parse($date_from1)->format('F d, Y');
            $date_to_formatted = Carbon::parse($date_to1)->format('F d, Y');

            $warehouse_name = DB::table('warehouses as a')
                ->where('a.id', $warehouse)
                ->select('a.name')
                ->first();


            $items = DB::table('item_details as a')
                ->leftjoin('item_category_details as b', 'a.item_category_details_id', 'b.id')
                ->leftjoin('item_locations as f', 'a.item_location_id', 'f.id')
                ->leftjoin('unit_of_measures as g', 'b.unit_id', 'g.id')
                ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                ->where('c.id', $warehouse)
                ->select(
                    'a.sku',
                    'a.id',
                    'a.item_code',
                    'a.name',
                    'a.quantity',
                    'b.name as category_name',
                    'b.code as category_code',
                    'g.name as measurement_name',
                    DB::raw('null as count'),
                    DB::raw('null as item_in'),
                )
                ->get();

            foreach ($items as $logs_in) {
                $in = DB::table('item_in_stocks as a')
                    ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                    ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                    ->leftjoin('item_locations as d', 'a.location_id', 'd.id') //location //added by JM
                    ->where('a.item_detail_id', $logs_in->id)
                    ->where('c.id', $warehouse)
                    ->select('a.id', DB::raw('null as count'), DB::raw('null as item_out'))
                    ->orderBy('a.created_at', 'ASC')
                    ->get();
                $logs_in->item_in = $in;
                foreach ($in as $logs_out) {
                    $out = DB::table('item_out_stocks as a')
                        ->leftjoin('user_profiles as b', 'a.user_id', 'b.user_id')
                        ->leftjoin('warehouses as c', 'a.warehouse_id', 'c.id') //warehouse //added by JM
                        ->where('a.item_in_stock_id', $logs_out->id)
                        ->WhereBetween('a.created_at', [$date_from, $date_to])
                        ->select(
                            'a.quantity as out',
                            'a.user_id',
                            'a.created_at',
                            'c.name as warehouse',
                            'b.first_name',
                            'b.last_name',
                        )
                        ->orderBy('a.created_at', 'ASC')
                        ->get();
                    $logs_out->item_out = $out;
                    // $logs_out->count = $out->count();
                    $logs_in->count = $out->count();
                }
            }

            //  return response()->json($items, 200);

            $view = \View::make('report_forms/Report_Stock_Releasing', ['products' => $items, 'warehouse' => $warehouse_name, 'from' => $date_from_formatted, 'to' => $date_to_formatted]);
            $html_content = $view->render();
            $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetTitle('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            $pdf->SetSubject('SUNWEST GROUP HOLDING COMPANY STOCK IN AND OUT REPORT');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            // set margins
            $pdf->SetMargins(3, 1, 3);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
            $pdf->SetAutoPageBreak(TRUE, 1);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            $pdf->SetFont('helvetica', '', 9);
            $pdf->AddPage();
            $pdf->writeHTML($html_content, true, 0, true, 0);
            $pdf->lastPage();

            $root = 'private/temp/';
            $file_path = storage_path('app/' . $root);
            $pdf->Output($file_path . '.pdf', 'F');
            return response()->file($file_path . '.pdf');
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function pdf(Request $request)
    { }
}
