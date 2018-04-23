<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oms\Complaint\Manager;
use Illuminate\Support\Facades\Session;

class ComplaintController extends Controller
{

    protected $complaintManager;

    public function __construct(Manager $complaintManager)
    {
        $this->complaintManager = $complaintManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $complaints = $this->complaintManager->all();
        return view('oms.pages.complaints.index')->with('complaints', $complaints);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $complaintDetails = $request->validate([
            'complaint' => 'required'
        ]);
        $this->complaintManager->create($complaintDetails, $request->user());
        Session::flash('notice', 'Successsfully reported Complaint');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $complaint = $this->complaintManager->getDetail($id);
        return view('oms.pages.complaints.show',  compact('complaint'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $complaint = $this->complaintManager->find($id);
        $this->complaintManager->delete($complaint);
        Session::flash('notice', 'Successsfully deleted Complaint');

        return redirect('/complaints');
    }

}
