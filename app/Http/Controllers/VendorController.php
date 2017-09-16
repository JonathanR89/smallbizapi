<?php

namespace App\Http\Controllers;

use DB;
use App\Package;
use App\PackageMetric;
use App\SubmissionUserSize;
use App\SubmissionIndustry;
use Illuminate\Http\Request;
use App\Http\Traits\Airtable;
use App\SubmissionPriceRange;
use App\ImageUpload as ImageUploadModel;

class VendorController extends Controller
{
    use Airtable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiAirTableVendors()
    {
        $vendorsArray = Package::all();
        // $vendors = collect($vendors);
        // $vendors->take(10);
        // $vendors->all();
        //
        // $vendorsArray = [];
        // foreach ($vendors as $vendor) {
        //     foreach ($vendor as $vendorData) {
        //         $vendorsArray[] = $vendorData->fields;
        //     }
        // }

        return view('vendors.table', compact("vendorsArray"));
    }

    public function index(Request $request)
    {
        $vendorsArray = Package::paginate(10);

        return view('vendors.index', compact("vendorsArray"));
    }

    public function searchVendors(Request $request)
    {
        // dd($request->input('search_term'));
        $searchTerm = $request->input('search_term');
        $vendorsArray = Package::where('name', 'like', $searchTerm)->paginate(10);

        return view('vendors.index', compact("vendorsArray"));
    }

    public function show($id)
    {
        // dd($id);
        $prices = SubmissionPriceRange::all()->pluck('price_range', 'id');
        // dd($prices);
        $industries = SubmissionIndustry::all()->pluck('industry_name', 'id');
        $userSizes = SubmissionUserSize::all()->pluck('user_size', 'id');
        // dd($id);
        $vendor = Package::find($id);
        $imagePath = null;
        if (isset($vendor->image_id)) {
            $image = ImageUploadModel::find($vendor->image_id);
            $imagePath = $image->original_filedir;
        }
        return view('vendors.show', compact("vendor", "prices", "industries", "userSizes", "imagePath"));
    }

    public function vendorShow($id)
    {
        $vendor = Package::find($id);
        $imagePath = null;
        if (isset($vendor->image_id)) {
            $image = ImageUploadModel::find($vendor->image_id);
            // dd($image);
            $imagePath = $image->original_filedir;
        }
        $prices = SubmissionPriceRange::find($vendor->price_id);
        // dd($prices);
        // dd($vendor->id);
        $industries = SubmissionIndustry::find($vendor->industry_id);
        $userSizes = SubmissionUserSize::find($vendor->user_size_id);
        return [
          'image' => url('/').'/'.$imagePath,
          'data' => $vendor,
          "price" => $prices,
          "industry" => $industries,
          "userSize" => $userSizes,

        ];
    }

    public function store(Request $request)
    {
        $data = [];
        if ($request->hasFile('profilePic')) {
            $data =  \Imageupload::upload($request->file('profilePic'));
            $imageId =  ImageUploadModel::create($data->toArray())->id;
        }
        if (isset($imageId)) {
            $requestData = $request->all();
            $requestData['image_id'] = $imageId;
            $vendor = Package::create($requestData);
        } else {
            $vendor = Package::create($request->all());
        }

        return redirect('all-vendors');
    }

    public function create()
    {
        $prices = SubmissionPriceRange::all()->pluck('price_range', 'id');
        $industries = SubmissionIndustry::all()->pluck('industry_name', 'id');
        $userSizes = SubmissionUserSize::all()->pluck('user_size', 'id');

        return view('vendors.create', compact("prices", "industries", "userSizes"));
    }

    public function destroy($id)
    {
        $vendor = Package::where('id', $id)->delete();
        return redirect('all-vendors');
    }

    public function update(Request $request, $id)
    {
        $data = [];
        if ($request->hasFile('profilePic')) {
            $data =  \Imageupload::upload($request->file('profilePic'));
            $imageId =  ImageUploadModel::create($data->toArray())->id;
        }
        if (isset($imageId)) {
            $requestData = $request->except(['_token', '_method', 'profilePic']);
            $requestData['image_id'] = $imageId;
            $vendor = Package::where('id', $id)->update($requestData);
        } else {
            $vendor = Package::where('id', $id)->update($request->except(['_token', '_method', 'profilePic']));
        }

        return redirect('all-vendors');
    }

    public function toggleInterested()
    {
        $packageMetrics = \App\PackageMetric::all();
        $packages = \App\Package::orderBy('name')->paginate(10);
        $metrics = \App\Metric::orderBy('name')->get();
        return view('packages.interested', compact("packageMetrics", "packages", "metrics"));
    }

    public function packageInterested(Request $request)
    {
        $packageID = $request->input('package_id');

        $packageFromDB = DB::table('packages')->where(['id' => $packageID])->get();
        foreach ($packageFromDB as $package) {
            if ($package->interested == 0) {
                DB::table('packages')->where(['id' => $packageID])->update(['interested' => 1]);
            } else {
                DB::table('packages')->where(['id' => $packageID])->update(['interested' => 0]);
            }
        }
    }


    public function searchTable(Request $request)
    {
        $searchTerm = $request->input('search_term');
        $packageMetrics = \App\PackageMetric::all();
        $packages = \App\Package::where('name', 'like', "%$searchTerm%")->paginate(10);
        $metrics = \App\Metric::orderBy('name')->get();
        return view('packages.interested', compact("packageMetrics", "packages", "metrics"));
    }

    public function getTopVendors()
    {
        $popularPackages = DB::table('user_results')->select('package_id', 'package_name', DB::raw('COUNT(package_id) AS occurrences'))
           ->groupBy('package_id')
           ->orderBy('occurrences', 'DESC')
           ->limit(10)
           ->get();
        $packages = [];
        foreach ($popularPackages as $key => $id) {
            $packages[] = Package::where('id', $id->package_id)->first();
            // $packages[] = $package->put('occurrences', $id->occurrences)->toArray();
        }
        $airtable = Airtable::getData();
        $results = [];
        foreach ($packages as  $row) {
            foreach ($airtable->records as $record) {
                if ($record->fields->CRM == $row->name) {
                    $results[] = [
                      "airtableData" => $record->fields,
                      "data" => $row,
                    ];
                }
            }
        }
        return $results;
    }

    public function getAllVendors()
    {
        $packages = \App\Package::all();
        $airtable = Airtable::getData();

        $results = [];
        foreach ($packages as  $row) {
            foreach ($airtable->records as $record) {
                if ($record->fields->CRM == $row->name) {
                    $results[] = $record->fields;
                  //   $results[] = [
                  //   "airtableData" => $record->fields,
                  //   "data" => $row,
                  // ];
                }
            }
        }
        return $results;
    }

    public function getVendorByIndustry(Request $request)
    {
        $airtable = Airtable::getData();
        $industry = $request['industry'];
        $submissionIndustry = SubmissionIndustry::find($industry);

        $matchingIndustries = [];
        foreach ($airtable->records as $record) {
            if (isset($record->fields->Vertical) && strstr($record->fields->Vertical, $submissionIndustry->industry_name)) {
                $matchingIndustries[] = $record;
            }
        }
        return collect($matchingIndustries);
    }
}
