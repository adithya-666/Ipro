<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Daily_report;
use App\Models\visiting_productivity;
use App\Models\report_detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\employee_activity;
use date;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {

        return view('dashboard.index');
    }


    public function visiting(Request $request)
    {
 
        return view('dashboard.visiting-productivity');
    }



    public function datatable()
    {
        $query = DB::table('daily_reports')
        ->select('daily_reports.report', 'daily_reports.id as dr_id', 'daily_reports.trouble', 'daily_reports.report', 'daily_reports.plan', 'daily_reports.created_at as created_time','employees.*')
        ->leftJoin('employees', 'employees.id', 'daily_reports.employee_id')
        ->where('daily_reports.employee_id', Auth::user()->id)
        ->get();


        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function($row) {
            $btn = '<a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">                                  
            <li><button class="dropdown-item daily-format-report" data-id="'. $row->dr_id .'" data-bs-target="#format-daily-report" data-bs-toggle="modal">Format Daily Report</button></li>
              <li><button class="dropdown-item edit-daily-report"  data-id="'. $row->dr_id .'" data-bs-target="#edit-daily-report-modal" data-bs-toggle="modal">Edit Daily Report</button></li>
              <li><button class="dropdown-item delete-daily-report" data-id="'. $row->dr_id .'" >Delete Daily Report</button></li>
            </ul>';
             return $btn;
      })
        ->rawColumns(['action'])
        ->escapeColumns()
        ->make(true);
    }


    public function createDailyReport(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'report' => 'required',
            'plan' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);

        } else {

             $daily_report  = new Daily_report();
             $daily_report->employee_id = Auth::user()->id ;
             $daily_report->report = $request->report;
             $daily_report->trouble = $request->trouble;
             $daily_report->plan = $request->plan;
             $daily_report->save();


             return response()->json([
                'status' => 200,
                'message' => 'Data Successfully Saved!'
            ]);

        }

  

    }


    public function detailDailyReport($id)
    {
        try {
            $query = DB::table('daily_reports')
                    ->select('daily_reports.report', 'daily_reports.id as dr_id', 'daily_reports.trouble', 'daily_reports.report', 'daily_reports.plan', 'daily_reports.created_at as created_time','employees.*')
                    ->leftJoin('employees', 'employees.id', 'daily_reports.employee_id')
                    ->where('daily_reports.id', $id)
                    ->first();
            // dd($query);

                   return response()->json($query);
               }  catch (\Exception $e) {
                   return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500); 
               }
    }


    public function editDailyReport($id)
    {

            try {
                
                //code...
                $query = DB::table('daily_reports')
                         ->where('id', $id)
                         ->first();

              return response()->json($query);

            } catch (\Exception $e) {
                //throw $th;
                return response()->json(['message' => 'Terjadi Kesalahan :' . $e->getMessage()], 401);
            }
    }

    public function updateDailyReport(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'edit_report' => 'required',
            'edit_plan' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);

        } else {

         Daily_report::where('id', $id)
                ->update([
                    'report' => $request->edit_report,
                    'trouble' => $request->edit_trouble,
                    'plan' => $request->edit_plan
                ]);


             return response()->json([
                'status' => 200,
                'message' => 'Data Successfully Updated!'
            ]);

        }

    }


    public function deleteDailyReport($id)
    {
        try {
            Daily_report::where('id', $id)
            ->delete();

            return response()->json(['message' => 'Successfully Deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi Kesalahan :'. $e->getMessage()], 500);
        }
    }



    public function createVisitingProductivity(Request $request)
    {   
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
            'client_name' => 'required',
            'pic' => 'required',
            'schedule' => 'required',
            'type_working' => 'required'
        ]);

    

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);

        } else {

            $newDate = Carbon::createFromFormat('d/m/Y', $request->schedule);

             $visiting  = new visiting_productivity();
             $visiting->employee_id = $request->pic ;
             $visiting->client_id = $request->client_name;
             $visiting->schedule = $newDate;
             $visiting->working_type = $request->type_working;
             $visiting->save();

             $activity = new employee_activity();
             $activity->employee_id = $request->pic;
             $activity->visiting_productivity_id = $visiting->id;
             $activity->save();

             DB::commit();

             return response()->json([
                'status' => 200,
                'message' => 'Data Successfully Saved!'
            ]);

        }
    } catch (\Exception $e) {
    DB::rollBack();
     return response()->json(['message' => $e->getMessage(), 400]);
    }

    }

    public function datatableProductivity()
    {
        $currentDate = now();

        // Get the 24th day of the current month
        $startDate = $currentDate->copy()->startOfMonth()->addDays(23)->startOfDay();
        
        // Get the 24th day of the next month
        $endDate = $currentDate->copy()->addMonth()->startOfMonth()->addDays(23)->endOfDay();
        
        // Format the dates if needed
        $startDateFormatted = $startDate->toDateTimeString();
        $endDateFormatted = $endDate->toDateTimeString();

        // dd($startDateFormatted, $endDateFormatted);
        
        $query = DB::table('visiting_productivitys')
        ->select('visiting_productivitys.employee_id', 'visiting_productivitys.id as visiting_id', 'visiting_productivitys.schedule', 'visiting_productivitys.working_date' ,'visiting_productivitys.client_id', 'visiting_productivitys.working_type', 'clients.client_name as client_name', 'clients.id as client_id', 'employees.id as employee_id', 'employees.nama_pegawai','employee_activitys.depature_time','employee_activitys.depature_location', 'employee_activitys.checkin_location', 'employee_activitys.location','employee_activitys.maintenance', 'employee_activitys.report_time', 'employee_activitys.checkout')
        ->leftJoin('employees', 'employees.id', 'visiting_productivitys.employee_id')
        ->leftJoin('clients', 'clients.id', 'visiting_productivitys.client_id')
        ->leftJoin('employee_activitys', 'employee_activitys.visiting_productivity_id', 'visiting_productivitys.id');
        // ->whereBetween('schedule', [$startDateFormatted, $endDateFormatted]);
        if(Auth::user()->role != 'manager'){
            $query->where('visiting_productivitys.employee_id', Auth::user()->id);
        }
       $query_visiting  =  $query->get();

        //   echo '<pre>';
        //   print_r($query_visiting );
        //   die;


          return DataTables::of( $query_visiting)
          ->addIndexColumn()
          ->addColumn('action', function($row) {
              $btn = 
              '<a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">';
            if(Auth::user()->role == 'staff'){
                $btn .= 
                '<li><button class="dropdown-item checkin-depature-office" data-id="'. $row->visiting_id .'" >Depature From Office</button></li>                              
                <li><button class="dropdown-item checkin-visiting-productivity" data-id="'. $row->visiting_id .'" >Checkin Location</button></li>                              
                <li><button class="dropdown-item visiting-productivity-report" data-id="'. $row->visiting_id .'" >Report</button></li>
                <li><button class="dropdown-item visiting-productivity-arrived" data-id="'. $row->visiting_id .'" >Arrived To Office</button></li>';
            } else {
                $btn .= '<li><button class="dropdown-item edit-data-modal"  data-id="'. $row->visiting_id .'" data-bs-target="#edit-data-modal" data-bs-toggle="modal">Edit Visiting Productvity</button></li>
                <li><button class="dropdown-item delete-visiting-productivity" data-id="'. $row->visiting_id .'" >Delete Daily Report</button></li>';
            }
            $btn .= '</ul>';

        
               return $btn;
        })
          ->rawColumns(['action'])
          ->escapeColumns()
          ->make(true);
    }


    public function selectClient(Request $request)
    {
        try {

            $search = $request->query('query');
        
            $query = DB::table('clients')->selectRaw('clients.id as client_id, clients.client_name as client_name')
            ->where('clients.client_name', 'like', '%' . $search . '%');
            $data = $query->get();


            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
    public function selectPic(Request $request)
    {
        try {

            $search = $request->query('query');
        
            $query = DB::table('employees')->selectRaw('employees.id as employee_id, employees.nama_pegawai as employee_name')
            ->where('employees.nama_pegawai', 'like', '%' . $search . '%');
            $data = $query->get();


            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    public function workingTypeInformation()
    {
        try {
            
      
        $currentDate = Carbon::now();

        $currentMonth = $currentDate->format('m'); // Ambil bulan saat ini
        $currentYear = $currentDate->format('Y');  // Ambil tahun saat ini

        $monthNow = $currentYear .'-'. $currentMonth .'-'. 24 .' '. '00:00:00' ;

        
        // Subtract one month to get the previous month
        $previousMonth = $currentDate->clone()->subMonth();
        $previousMonthNumber = $previousMonth->format('m'); // Ambil bulan bulan kemarin
        $previousYear = $previousMonth->format('Y'); // Ambil tahun bulan kemarin
        
        $monthYesterday = $previousYear . '-' . $previousMonthNumber . '-'. 24;

        $startDate = Carbon::parse($monthYesterday)->addHours(0)->addMinutes(0)->addSeconds(0)->toDateTimeString();
        $endDate = Carbon::parse($monthNow )->addHours(23)->addMinutes(59)->addSeconds(59)->toDateTimeString();

       $employee_id = Auth::user()->id;

      $maintenance = DB::table('visiting_productivitys')
            ->select('visiting_productivitys.id', 'visiting_productivitys.working_type', 'employee_activitys.visiting_productivity_id', 'employee_activitys.status', 'visiting_productivitys.schedule' )
            ->leftJoin('employee_activitys', 'employee_activitys.visiting_productivity_id', 'visiting_productivitys.id')
            ->where('visiting_productivitys.employee_id', $employee_id)
            ->where('working_type', 'maintenance')
            ->where('status', 'Done')
            // ->where('schedule', '>=', $startDate)
            // ->where('schedule', '<=', $endDate)
            ->count();

      $support = DB::table('visiting_productivitys')
            ->select('visiting_productivitys.id', 'visiting_productivitys.working_type', 'employee_activitys.visiting_productivity_id', 'employee_activitys.status', 'visiting_productivitys.schedule' )
            ->leftJoin('employee_activitys', 'employee_activitys.visiting_productivity_id', 'visiting_productivitys.id')
            ->where('visiting_productivitys.employee_id', $employee_id)
            ->where('working_type', 'support')
            ->where('status', 'Done')
            // ->where('schedule', '>=', $startDate)
            // ->where('schedule', '<=', $endDate)
            ->count();

      $error = DB::table('visiting_productivitys')
            ->select('visiting_productivitys.id', 'visiting_productivitys.working_type', 'employee_activitys.visiting_productivity_id', 'employee_activitys.status', 'visiting_productivitys.schedule' )
            ->leftJoin('employee_activitys', 'employee_activitys.visiting_productivity_id', 'visiting_productivitys.id')
            ->where('visiting_productivitys.employee_id', $employee_id)
            ->where('working_type', 'error')
            ->where('status', 'Done')
            // ->where('schedule', '>=', $startDate)
            // ->where('schedule', '<=', $endDate)
            ->count();

      $maintenanceCount = DB::table('visiting_productivitys')
            ->select('visiting_productivitys.id', 'visiting_productivitys.working_type', 'employee_activitys.visiting_productivity_id', 'employee_activitys.status', 'visiting_productivitys.schedule' )
            ->leftJoin('employee_activitys', 'employee_activitys.visiting_productivity_id', 'visiting_productivitys.id')
            ->where('visiting_productivitys.employee_id', $employee_id)
            ->where('working_type', 'maintenance')
            // ->where('schedule', '>=', $startDate)
            // ->where('schedule', '<=', $endDate)
            ->count();

      $supportCount = DB::table('visiting_productivitys')
            ->select('visiting_productivitys.id', 'visiting_productivitys.working_type', 'employee_activitys.visiting_productivity_id', 'employee_activitys.status', 'visiting_productivitys.schedule' )
            ->leftJoin('employee_activitys', 'employee_activitys.visiting_productivity_id', 'visiting_productivitys.id')
            ->where('visiting_productivitys.employee_id', $employee_id)
            ->where('working_type', 'support')
            // ->where('schedule', '>=', $startDate)
            // ->where('schedule', '<=', $endDate)
            ->count();

      $errorCount = DB::table('visiting_productivitys')
            ->select('visiting_productivitys.id', 'visiting_productivitys.working_type', 'employee_activitys.visiting_productivity_id', 'employee_activitys.status', 'visiting_productivitys.schedule' )
            ->leftJoin('employee_activitys', 'employee_activitys.visiting_productivity_id', 'visiting_productivitys.id')
            ->where('visiting_productivitys.employee_id', $employee_id)
            ->where('working_type', 'error')
            // ->where('schedule', '>=', $startDate)
            // ->where('schedule', '<=', $endDate)
            ->count();

        $data['maintenance'] = $maintenance;
        $data['support'] = $support;
        $data['error'] = $error;
        $data['total_maintenance'] = $maintenanceCount;
        $data['total_support'] = $supportCount;
        $data['total_error'] = $errorCount;
    
    return response()->json($data);

    } catch (\Exception $e) {
       return response()->json(['message' => $e->getMessage(), 400]);
    }

    }

    public function editVisitingProductivity($id)
 {
    try {
  
    $data = visiting_productivity::findOrFail($id);

  
    return response()->json($data);
} catch (\Exception $e) {
    return response()->json(['message' => $e->getMessage()], 400);
}
 }


 public function updateVisitingProductVisiting(Request $request, $id)
 {

    try {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required',
            'pic' => 'required',
            'schedule' => 'required',
            'type_working' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);

        } else {

            $newDate = Carbon::createFromFormat('d/m/Y', $request->schedule);

             visiting_productivity::where('id', $id)
             ->update([
                'employee_id' => $request->pic,
                'client_id' => $request->client_name,
                'schedule' => $newDate,
                'working_type' => $request->type_working
             ]);


             return response()->json([
                'status' => 200,
                'message' => 'Data Updated Successfully!'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 400);
    }  
 }

 public function deleteVisitingProductivity($id)
 {
    $visiting = visiting_productivity::find($id);
    $visiting->delete();

    $employee = employee_activity::where('visiting_productivity_id', $id);
    $employee->delete();


    $report = DB::table('report_detail')->where('visiting_productivity_id')->get();

    foreach ($report as $key => $value) {
        Storage::disk('public')->delete($value->file);
    }

    $report_detail = report_detail::where('visiting_productivity_id', $id);
    $report_detail->delete();


    return response()->json([
        'status' => 200,
        'message' => 'Data deleted Successfully!'
    ]);
 }


 public function scanBarcode($id)
 {
    return view('dashboard.scan-barcode', compact("id"));
 }

 public function scanBarcodeCheckout($id)
 {
   return view('dashboard.scan-barcode-checkout', compact('id'));
 }

 public function processScanBarcode(Request $request, $id)
 {
    try {
     
        $checkExits  = DB::table('clients')->where('id', $request->qr_code)->first();

        if(isset($checkExits)){

            $date = Carbon::now();

            employee_activity::where('visiting_productivity_id', $id)
            ->update([
                'depature_time' => $date,
                'depature_location' => 'Departure from ' .$checkExits->client_name,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Check In Successfully!'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Barcode No Match!'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 400);
    }
 }

 public function processScanBarcodeCheckout(Request $request, $id)
 {
    try {

        if($request->qr_code == 'Test'){

            $date = Carbon::now();

            employee_activity::where('visiting_productivity_id', $id)
            ->update([
                'checkout' => $date
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Check In Successfully!'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Barcode No Match!'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 400);
    }
 }


 public function checkOutScanBarcode()
 {
    return view('dashboard.checkout-scan-barcode');
 }

 public function checkoutProcessScanBarcode(Request $request, $id)
 {
    try {
     
        $checkExits  = DB::table('clients')->where('id', $request->qr_code)->first();


        if(isset($checkExits)){

            $date = Carbon::now();

            employee_activity::where('visiting_productivity_id', $id)
            ->update([
                'checkout' => $date,
                'checkout_location' => 'Arrived at ' .$checkExits->client_name,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Check In Successfully!'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Barcode No Match!'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 400);
    }
 }

    public function checkDepatureFromOffice()
    {      
        try {
            $date = Carbon::now();
        
            $today = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    
          $check  = DB::table('employee_activitys')
          ->where('checkin', 'LIKE', '%'. $today . '%')
          ->where('employee_id', Auth::user()->id)
          ->first();

          if(isset($check)){
            return response()->json(['exits' => true , 'data' => $check]);
          }else {
            return response()->json(['exits' => false ]);
          }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 400]);
        }
    }

    public function checkinLocation($id)
    {
        try {
            $query = DB::table('visiting_productivitys')
            ->select('visiting_productivitys.employee_id', 'visiting_productivitys.id as visiting_id', 'visiting_productivitys.schedule', 'visiting_productivitys.client_id', 'visiting_productivitys.working_type', 'clients.client_name as client_name', 'clients.id as client_id', 'employees.id as employee_id', 'employees.nama_pegawai')
            ->leftJoin('employees', 'employees.id', 'visiting_productivitys.employee_id')
            ->leftJoin('clients', 'clients.id', 'visiting_productivitys.client_id')
            ->where('visiting_productivitys.id', $id)
            ->first();

            $date = Carbon::now();
            $location = 'Check In at '. $query->client_name;

            employee_activity::where('visiting_productivity_id', $id)
            ->update([
                'checkin_location' =>  $date,
                'location' => $location
            ]);

            return response()->json(['message' => 'Successfully Checkin Location']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 400]);
        }
    }


    public function checkReportVisitingProductivity($id)
    {
   
       try {
        $query  =  DB::table('report_detail')
        ->select(DB::raw('count(visiting_activity_id) as total_report '))
        ->where('visiting_activity_id', $id)
        ->first();
 
        return response()->json($query);
       } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage(), 400]);
       }
  
      
     
    }

    public function createVisitingProductivityReport(Request $request)
    {       
          try {

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'report' => 'required',
                'file' => 'image|file',
            ]);
    
            if($validator->fails()){
    
                return response()->json([
                    'status' => 400,
                    'messages' => $validator->getMessageBag()
                ]);
    
            } else {
             
                $report_time = Carbon::now();

                $get_checkin = DB::table('employee_activitys')->where('id', $request->visiting_id)->first();

                $get_checkin->checkin_location;

                $checkin_location = Carbon::parse($get_checkin->checkin_location);
              
                $minutes = $checkin_location->diffInMinutes($report_time);

                employee_activity::where('id', $request->visiting_id)
                                    ->update([
                                        'maintenance' => $minutes,
                                        'report_time' => $report_time,
                                        'status' => 'Done'
                                    ]);

                visiting_productivity::where('id', $request->visiting_id)
                                    ->update([
                                        'working_date' => $report_time
                                    ]);
                                 
                 $report_detail  = new report_detail();
                 $report_detail->visiting_activity_id = $request->visiting_id ;
                 $report_detail->report = $request->report;

                 if($request->file('file') != null){
                  
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $fileName = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extensions = $request->file('file')->getClientOriginalExtension();
                $fileNameSave = $fileName.'-'. time().'.'.$extensions;
   
              
                $path = $request->file('file')->storeAs('/post-files', $fileNameSave);
                     $report_detail->file = $path;
                     $report_detail->file_name = $filenameWithExt;
                 }
                 $report_detail->save();

                 DB::commit();
    
                 return response()->json([
                    'status' => 200,
                    'message' => 'Data Successfully Saved!'
                ]);
    
            }
    
          } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage(), 400]);
          }
    }

    public function detailReport($id)
    {
        return view('dashboard.report-detail', compact('id'));
    }


    public function datatableReport($id)
    {
        $query = DB::table('report_detail')
        ->select('report_detail.id as report_id', 'report_detail.report', 'report_detail.file', 'report_detail.created_at', 'visiting_productivitys.id as visiting_id', 'visiting_productivitys.client_id',  'clients.client_name as client_name')
        ->leftJoin('visiting_productivitys', 'visiting_productivitys.id', 'report_detail.visiting_activity_id')
        ->leftJoin('clients', 'clients.id', 'visiting_productivitys.client_id')
        ->where('visiting_productivitys.id',  $id)
        ->get();

        //   echo '<pre>';
        //   print_r($query);
        //   die;


          return DataTables::of($query)
          ->addIndexColumn()
          ->addColumn('action', function($row) {
              $btn = 
              '<a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">';
            if(Auth::user()->role == 'staff'){
                $btn .= 
                '<li><button class="dropdown-item edit-report" data-id="'. $row->report_id .'" >Edit Report</button></li>                              
                <li><button class="dropdown-item delete-report" data-id="'. $row->report_id .'" >Delete Report</button></li>';
            }   
            $btn .= '</ul>';

        
               return $btn;
        })
          ->rawColumns(['action'])
          ->escapeColumns()
          ->make(true);
    }

    public function editReportDetail($id)
    {
        try {
            $query = DB::table('report_detail')
            ->where('id', $id)
            ->first();

            return response()->json($query);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 400]);
        }

        

    }

    public function updateReportDetail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'edit_report' => 'required',
                'edit_file' => 'image|file',
            ]);
    
            if($validator->fails()){
    
                return response()->json([
                    'status' => 400,
                    'messages' => $validator->getMessageBag()
                ]);
    
            } else {
             
                $update['report'] = $request->edit_report;

                 if($request->file('edit_file') != 'null'){

                    if (Storage::disk('public')->exists($request->edit_file_hidden)) {

                        Storage::disk('public')->delete($request->edit_file_hidden);

                        } else {

                            return response()->json([
                                'status' => 404,
                                'message' => 'Image Delete Not Found'
                            ]);

                        }
                  
                $filenameWithExt = $request->file('edit_file')->getClientOriginalName();
                $fileName = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extensions = $request->file('edit_file')->getClientOriginalExtension();
                $fileNameSave = $fileName.'-'. time().'.'.$extensions;
                $path = $request->file('edit_file')->storeAs('post-files', $fileNameSave);

                $update['file']  = $path;
                $update['file_name'] = $filenameWithExt;
                 }

               
                 report_detail::where('id', $request->edit_visiting_id)
                                ->update($update);  
    
                 return response()->json([
                    'status' => 200,
                    'message' => 'Data Updated Successfully!'
                ]);
    
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 400]);
        }
    }

    public function detailReportInformation($id)
    {
        try {
            $query = DB::table('visiting_productivitys')
            ->select('visiting_productivitys.employee_id', 'visiting_productivitys.id as visiting_id', 'visiting_productivitys.schedule', 'visiting_productivitys.client_id', 'visiting_productivitys.working_type', 'visiting_productivitys.created_at as created_visiting_productivity', 'clients.client_name as client_name', 'clients.id as client_id', 'employees.id as employee_id', 'employees.nama_pegawai','employee_activitys.report_time', 'employee_activitys.checkin_location', 'employee_activitys.maintenance')
            ->leftJoin('employees', 'employees.id', 'visiting_productivitys.employee_id')
            ->leftJoin('employee_activitys', 'employee_activitys.visiting_productivity_id', 'visiting_productivitys.id')
            ->leftJoin('clients', 'clients.id', 'visiting_productivitys.client_id')
            ->where('visiting_productivitys.id', $id)
            ->first();

            return response()->json($query);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 400]);
        }
    }

    public function deleteReportDetail($id)
    {
       $report = DB::table('report_detail')
        ->where('id', $id)
        ->first();

        if (Storage::disk('public')->exists($report->file)) {

            Storage::disk('public')->delete($report->file);

            } else {

                return response()->json([
                    'status' => 404,
                    'message' => 'Image Delete Not Found'
                ]);

            }

        $visiting = report_detail::find($id);
        $visiting->delete();
    
        return response()->json([
            'status' => 200,
            'message' => 'Data deleted Successfully!'
        ]);
    }

    public function recentActivity(Request $request)
    {
        try {
            $parse = Carbon::parse($request->schedule);
            $formatDate = $parse->format('Y-m-d');
        
            // dd($formatDate);
             $query =  DB::table('visiting_productivitys')
                ->select('visiting_productivitys.id','visiting_productivitys.employee_id as visiting_employee_id', 'visiting_productivitys.schedule')
                    ->where('schedule', 'LIKE' , '%'. $formatDate .'%')
                    ->where('visiting_productivitys.employee_id', $request->employee_id)
                    ->get();
        
                $vpId = [];
                    foreach($query as $value){
                        $vpId[] = $value->id;
                    }
        
             $query_employee_activity =  DB::table('employee_activitys')
                ->select('employee_activitys.employee_id', 'employee_activitys.visiting_productivity_id','employee_activitys.depature_time', 'employee_activitys.depature_location', 'employee_activitys.checkin_location', 'employee_activitys.location', 'employee_activitys.maintenance', 'employee_activitys.report_time', 'employee_activitys.checkout', 'employee_activitys.checkout_location')
                    ->whereIn('visiting_productivity_id', $vpId)
                    ->get();

        return response()->json($query_employee_activity);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 400]);
        }
    

  

    }

}
