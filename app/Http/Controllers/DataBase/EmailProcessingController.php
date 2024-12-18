<?php

namespace App\Http\Controllers\DataBase;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Maatwebsite\Excel\Facades\Excel;

class EmailProcessingController extends Controller
{
    public function processEmails(Request $request)
    {
        // Validate the file upload
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Read the Excel file
        $emailsFromFile = Excel::toArray([], $request->file('excel_file'));
        
        // Flatten the array and extract unique emails (assuming emails are in the first column)
        // $emailList = collect($emailsFromFile[0])
        //     ->pluck(0) // Adjust the index if emails are in a different column
        //     ->unique()
        //     ->filter() // Remove empty emails
        //     ->values()
        //     ->toArray();
        //     Log::info(array_values($emailList));
        $emailList = [
            'anjali.upadhyay@flexpay.in',
            'mohammed.asish@flexpay.in',
            'gadde.bhavani@flexpay.in',
            'bhagyarekha.mogilipaka@flexpay.in',
            'ch.anusha@flexpay.in',
            'mohan.babu@flexpay.in',
            'pilaka.geetha@flexpay.in',
            'mohammed.irfan@flexpay.in',
            'm.jithender@flexpay.in',
            'meghraj.biradar@flexpay.in',
            'podishetty.anusha@flexpay.in',
            'prashanth.perumandla@flexpay.in',
            'vislavath.radhika@flexpay.in',
            'rama.shinde@flexpay.in',
            'bhukya.ramya@flexpay.in',
            'rekha.patil@flexpay.in',
            'shaik.shabana@flexpay.in',
            'sharanya.b@flexpay.in',
            'varkala.shivaji@flexpay.in',
            'sundale.susheel@flexpay.in',
            'p.naveen@flexpay.in',
            'manoj.g@flexpay.in',
            'madrala.pooja@flexpay.in',
            'madicharla.harini@flexpay.in',
            'gollapudi.rishitha@flexpay.in',
            'turumella.praveena@flexpay.in',
            'puvvala.tirumala@flexpay.in',
            'Baddam.Akhila@flexpay.in',
            'sunkari.rani@flexpay.in',
            'maskapuri.gouthami@flexpay.in',
            'machidi.sai@flexpay.in',
            'rachabanti.sandhyarani@flexpay.in',
            'perumandla.akhila@flexpay.in',
            'maddireddy.dharani@flexpay.in',
            'naini.rajani@flexpay.in',
            'masunuri.shashikanth@flexpay.in',
            'myathari.anitha@flexpay.in',
            'bollam.navya@flexpay.in',
            'subhrajit.panigrahi@flexpay.in',
            'bulli.shirisha@flexpay.in',
            'talari.swathi@flexpay.in',
            'munnazza.begum@flexpay.in',
            'thogari.sravani@flexpay.in',
            'prem.sagar@flexpay.in',
            'mushtaq.ahmed@flexpay.in',
            'nazmeen.tabassum@flexpay.in',
            'nanded.manoja@flexpay.in',
            'dnyaneshwari.shinde@flexpay.in',
            'gaurav.dubey@flexpay.in',
            'syed.faisal@flexpay.in',
            'awaizahmed.syed@flexpay.in',
            'adithya.mannem@flexpay.in',
            'sofiyanuddin.mohammed@flexpay.in',
            'javeed.pasha@flexpay.in',
            'pooja.tarawale@flexpay.in',];
        // Find existing emails in the database
        $existingEmails = User::whereIn('email', $emailList)
            ->pluck('email')
            ->toArray();
            Log::info($existingEmails);
        // Find missing emails
        $missingEmails = array_diff($emailList, $existingEmails);

        // Prepare the results
        $results = [
            'total_emails' => count($emailList),
            'existing_emails' => $existingEmails,
            'missing_emails' => $missingEmails,
            'existing_count' => count($existingEmails),
            'missing_count' => count($missingEmails)
        ];

        return response()->json($results);
    }

    public function getRecordsForEmails(Request $request)
    {
        // Validate the file upload
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Read the Excel file
        $emailsFromFile = Excel::toArray([], $request->file('excel_file'));
        
        // Flatten the array and extract unique emails
        $emailList = collect($emailsFromFile[0])
            ->pluck(0) // Adjust the index if emails are in a different column
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        // Fetch full records for existing emails
        $userRecords = User::whereIn('email', $emailList)->get();
        $agentIds = $userRecords->pluck('id')->toArray();
            // Define the CSV file path
            $filePath = storage_path('app/agent_ids.csv');

            // Open the file for writing
            $file = fopen($filePath, 'w');

            // Optionally, write a header row (if needed)
            fputcsv($file, ['agent_id']);

            // Write each agent ID as a row
            foreach ($agentIds as $id) {
                fputcsv($file, [$id]);
            }

            // Close the file
            fclose($file);
        return response()->json([
            'total_emails_in_file' => count($emailList),
            'records_found' => $userRecords,
            'records_count' => $userRecords->count(),
        ]);
    }

    public function showUploadForm()
{
    return view('csv-upload');
}
}
