<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApprovalConfigController extends Controller
{
    private $title = 'Approval Config';
    private $approvalConfigRepository;

    function __construct() {
        $this->approvalConfigRepository = new ApprovalConfigRepository();   
    }

    function index()
    {
        return view('approval-config.index');
    }

    function create()
    {
        return view('approval-config.create');
    }
}
